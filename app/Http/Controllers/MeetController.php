<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Meet;
use App\Models\Room;
use App\Models\DateMeet;
use App\Models\Invitation;
use Illuminate\Support\Arr;
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

    public function singleArray($array)
    {
        // var_dump(count($array[0]));
        // die;
        // if (!is_array($array)) {
        //     return FALSE;
        // }
        $result = array();
        // $i = 0;
        // foreach ($array as $values) {
        //     var_dump($values);
        //     $i++;
        // }
        // die;
        $k = 0;
        for ($i = 0; $i < count($array); $i++) {
            for ($j = 0; $j < count($array[$i]); $j++) {
                $result[$k] = $array[$i][$j];
                $k++;
            }
        }
        return $result;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // for ($i = 0; $i < count($request->teams); $i++) {
        //     $participantsFromTeams[$i] = DB::table('teams')
        //         ->join('team_member', 'teams.id_team', '=', 'team_member.id_team')
        //         ->select('team_member.id_member')
        //         ->where('teams.id_team', $request->teams[$i])
        //         ->pluck('id_member');
        // }

        // $resultParticipanTeams = $this->singleArray($participantsFromTeams);
        // return count($resultParticipanTeams);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'isOnline' => 'required',
            'user_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            // 'participants' => 'required',
            // 'teams' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        try {
            // Meet Create Statement
            $meet = Meet::create([
                'name_meeting' => $request->name,
                'description' => $request->description,
                'isOnline' => $request->isOnline,
                'limit' => $request->limit,
                'room_id' => $request->room_id,
                'user_id' => $request->user_id,
            ]);

            // Get Meet Query
            $data = Meet::where('id_meet', '=', $meet->id_meet)->get();

            //DateMeet Create
            for ($i = 0; $i < $request->limit; $i++) {
                DateMeet::create([
                    'start_datetime' => $request->date_start[$i],
                    'end_datetime' => $request->date_end[$i],
                    'id_meet' => $meet->id_meet,
                ]);
            }

            //Room Update Statement
            $room = Room::find($request->room_id);
            $room->isBooked = 1;
            $room->save();

            // $data2 = DateMeet::where('id','='. $datemeet->id)->get();
            // Get datatime query
            $datatime = DB::table('meet')
                ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
                ->select('meet_date_time.start_datetime', 'meet_date_time.end_datetime')
                ->where('meet.id_meet', $meet->id_meet)
                ->get();

            // Invitation Create per Participant
            if ($request->participants !== []) {
                for ($i = 0; $i < count($request->participants); $i++) {
                    Invitation::create([
                        'expiredDateTime' => $request->date_start[0],
                        'id_invitee' => $request->user_id,
                        'id_receiver' => $request->participants[$i],
                        'id_meet' =>  $meet->id_meet,
                    ]);
                }
            }
            // Invitation Create Pert Member Of Teams
            if ($request->teams !== []) {
                for ($i = 0; $i < count($request->teams); $i++) {
                    $participantsFromTeams[$i] = DB::table('teams')
                        ->join('team_member', 'teams.id_team', '=', 'team_member.id_team')
                        ->select('team_member.id_member')
                        ->where('teams.id_team', $request->teams[$i])
                        ->pluck('id_member');
                }

                $resultParticipanTeams = $this->singleArray($participantsFromTeams);
                for ($i = 0; $i < count($resultParticipanTeams); $i++) {
                    Invitation::create([
                        'expiredDateTime' => $request->date_start[0],
                        'id_invitee' => $request->user_id,
                        'id_receiver' => $resultParticipanTeams[$i],
                        'id_meet' =>  $meet->id_meet,
                    ]);
                }
            }
            $dataParticipan = Invitation::select('id_receiver')->where('id_meet', '=', $meet->id_meet)->pluck('id_receiver');

            // var_dump($data); die;
            if ($data && $datatime) {
                $respon = [
                    'meet' => $data,
                    'datetime' => $datatime,
                    'participant' => $dataParticipan
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
            $dataParticipan = Invitation::select('id_receiver')->where('id_meet', '=', $request->query('id'))->pluck('id_receiver');
        } else if (Meet::where('user_id', $request->query('user_id'))->exists()) {
            $data = Meet::where('user_id', $request->query('user_id'))->get();
            $datatime = DB::table('meet')
                ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
                ->select('meet_date_time.id_meet', 'meet_date_time.start_datetime', 'meet_date_time.end_datetime')
                ->where('meet.user_id', $request->query('user_id'))
                ->get();
        } else if (Invitation::where('id_receiver', $request->query('participation_id'))->exists()) {
            //$data = Meet::where('user_id', $request->query('participation_id'))->get();
            $data = DB::table('meet')
                ->join('invitations', 'invitations.id_meet', '=', 'meet.id_meet')
                ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
                ->select('meet.*', 'meet_date_time.id_meet', 'meet_date_time.start_datetime', 'meet_date_time.end_datetime')
                ->where('invitations.id_receiver', $request->query('participation_id'))
                ->get();
            // $datatime = DB::table('meet')
            //     ->join('meet_date_time', 'meet.id_meet', '=', 'meet_date_time.id_meet')
            //     ->select('meet_date_time.id_meet', 'meet_date_time.start_datetime', 'meet_date_time.end_datetime')
            //     ->where('invitations.id_receiver', $request->query('user_id'))
            //     ->get();
        } else if (!$request->query('user_id') && !$request->query('id')) {
            return ApiFormatter::createApi('Query Not Found', 'Failed');
        }

        if (isset($data) && isset($datatime)) {
            if (isset($dataParticipan)) {
                $respon = [
                    'meet' => $data,
                    'datetime' => $datatime,
                    'participant' => $dataParticipan
                ];
            } else {
                $respon = [
                    'meet' => $data,
                    'datetime' => $datatime,
                ];
            }

            return ApiFormatter::createApi($respon, 'Succesfull');
        } else if (isset($data)) {
            return ApiFormatter::createApi($data, 'Succesfull');
        } else {
            return ApiFormatter::createApi($data, 'Failed');
        }
    }


    public function update(Request $request, $id)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:255',
        //     'description' => 'required|max:255',
        //     'isOnline' => 'required',
        //     'limit' => 'required',
        //     'room_id' => 'required',
        //     'user_id' => 'required',
        //     'date_start' => 'required',
        //     'date_end' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

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
