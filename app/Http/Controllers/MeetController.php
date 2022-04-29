<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Meet;
use App\Models\Room;
use App\Models\DateMeet;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MeetController extends Controller
{

    public function index()
    {
        $data = Meet::all();
        $date = DB::table('meet')
            ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
            ->select('meet_date_time.id_meet', 'meet_date_time.start_datetime', 'meet_date_time.end_datetime')
            ->get();

        if ($data) {
            return ApiFormatter::createApi([$data, $date], 'Succes');
        } else {
            return ApiFormatter::createApi('Data is empty', 'Failed');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'isOnline' => 'required',
            'user_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $meet = Meet::create([
                'name_meeting' => $request->name,
                'description' => $request->description,
                'isOnline' => $request->isOnline,
                'limit' => $request->limit,
                'room_id' => $request->room_id,
                'user_id' => $request->user_id,
            ]);

            // $token = $meet->createToken('auth_token')->plainTextToken;
            $data = Meet::where('id_meet', '=', $meet->id_meet)->get();

            for ($i = 0; $i < $request->limit; $i++) {
                DateMeet::create([
                    'start_datetime' => $request->date_start[$i],
                    'end_datetime' => $request->date_end[$i],
                    'id_meet' => $meet->id_meet,
                ]);
            }

            $room = Room::find($request->room_id);
            $room->isBooked = 1;
            $room->save();

            // $data2 = DateMeet::where('id','='. $datemeet->id)->get();
            $datatime = DB::table('meet')
                ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
                ->select('meet_date_time.start_datetime', 'meet_date_time.end_datetime')
                ->where('meet.id_meet', $meet->id_meet)
                ->get();

            // var_dump($data); die;
            if ($data && $datatime) {
                $respon = [
                    'meet' => $data,
                    'datetime' => $datatime
                ];
                return ApiFormatter::createApi($respon, 'Succesfull');
            } else {
                return ApiFormatter::createApi('Data Cannot Create', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Cannot Create On Table', $error);
        }
    }


    public function show(Request $request)
    {
        if (Meet::where('id_meet', $request->query('id'))->exists()) {
            $data = Meet::where('id_meet', $request->query('id'))->get();
            $datatime = DB::table('meet')
                ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
                ->select('meet_date_time.id_meet', 'meet_date_time.start_datetime', 'meet_date_time.end_datetime')
                ->where('meet.id_meet', $request->query('id'))
                ->get();
        } else if (Meet::where('user_id', $request->query('user_id'))->exists()) {
            $data = Meet::where('user_id', $request->query('user_id'))->get();
            $datatime = DB::table('meet')
                ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
                ->select('meet_date_time.id_meet', 'meet_date_time.start_datetime', 'meet_date_time.end_datetime')
                ->where('meet.user_id', $request->query('user_id'))
                ->get();
        } else if (!$request->query('user_id') && !$request->query('id')) {
            return ApiFormatter::createApi('Query Not Found', 'Failed');
        }

        if (isset($data) && isset($datatime)) {
            $respon = [
                'meet' => $data,
                'datetime' => $datatime
            ];
            return ApiFormatter::createApi($respon, 'Succesfull');
        } else {
            return ApiFormatter::createApi('Data Not Found', 'Failed');
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'isOnline' => 'required',
            'limit' => 'required',
            'room_id' => 'required',
            'user_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $old_meet = Meet::find($id);
            $meet = Meet::find($id);
            $meet->name_meeting = $request->name;
            $meet->description = $request->description;
            $meet->isOnline =  $request->isOnline;
            $meet->limit = $request->limit;
            $meet->room_id = $request->room_id;
            $meet->user_id = $request->user_id;
            $meet->save();

            $data = Meet::find($id)->get();
            // var_dump($old_meet);
            // var_dump('------------------------------------------');
            // var_dump($meet);
            // die;

            if ($meet->room_id != $old_meet->room_id) {
                $room_old = Room::find($old_meet->room_id);
                $room_old->isBooked = 0;
                $room_old->save();

                $room_new = Room::find($meet->room_id);
                $room_new->isBooked = 1;
                $room_new->save();
            }

            for ($i = 0; $i < $request->limit; $i++) {
                DateMeet::where('id_meet', $id)
                    ->update([
                        'start_datetime' => $request->date_start[$i],
                        'end_datetime' => $request->date_end[$i],
                    ]);
            }
            $datatime = DB::table('meet')
                ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
                ->select('meet_date_time.start_datetime', 'meet_date_time.end_datetime')
                ->where('meet.id_meet', $meet->id_meet)
                ->get();

            // var_dump($data); die;
            if ($data && $datatime) {
                $respon = [
                    'meet' => $data,
                    'datetime' => $datatime
                ];
                return ApiFormatter::createApi($respon, 'Succesfull');
            } else {
                return ApiFormatter::createApi('Data Cannot Create', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Cannot Update', $error);
        }
    }

    public function destroy($id)
    {
        try {
            if (Meet::where('id_meet', $id)->delete()) {
                return ApiFormatter::createApi(null, 'Succesfull');
            } else {
                return ApiFormatter::createApi('Failed Delete Data', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Cannot Delete', $error);
        }
    }
}
