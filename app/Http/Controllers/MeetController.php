<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Meet;
use App\Models\DateMeet;
use App\Models\MeetDate;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MeetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DB::table('meet')
        //             ->join('meet_date_time', 'meet.id_meet', '=' ,'meet_date_time.id_meet')
        //             ->select('meet.*','meet_date_time.datetime')
        //             -> get();;
        // return ApiFormatter::createApi($data, null, 'Succesfull');
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
        'date' => 'required',
        ]);

        if($validator->fails()) {
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

            // var_dump($meet->id_meet);die;
            // var_dump($request->date);
            // foreach($request->date as $date){
            //     var_dump($meet->id);
            //     var_dump(date($date));
            // }
            // die;


            // $token = $meet->createToken('auth_token')->plainTextToken;
            $data1 = Meet::where('id_meet','='. $meet->id)->get();
            // $id = Meet::findOrFail()
            // $data1 = Meet::findorFail();
            //var_dump($data->id_meet); die;
            // foreach ($data as $datas) {
            //     var_dump($datas);
            // }
            // die;
            foreach($request->date as $date){
                $datemeet = DateMeet::create([
                    'id_meet' => $meet->id_meet,
                    'datetime' => $date,
                ]);
            }

            $data2 = DateMeet::where('id','='. $datemeet->id)->get();
            $data = DB::table('meet')
                                ->join('meet_date_time', 'meet.id_meet', '=' ,'meet_date_time.id_meet')
                                ->select('meet.*','meet_date_time.datetime')
                                ->where('meet.id_meet', $meet->id_meet)
                                // ->where('meet_date_time.id_meet','='. $meet->id_meet)
                                -> get();

                                // var_dump($data); die;
            if($data){
                return ApiFormatter::createApi($data, null, 'Succesfull');
            }
            else{
                return ApiFormatter::createApi($data, null, 'failed');
            }
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('meet')
                                ->join('meet_date_time', 'meet.id_meet', '=' ,'meet_date_time.id_meet')
                                ->select('meet.*','meet_date_time.datetime')
                                ->where('meet.id_meet', $id)
                                // ->where('meet_date_time.id_meet','='. $meet->id_meet)
                                -> get();

        return ApiFormatter::createApi($data, null, 'Succesfull');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
