<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Team::all();

        if ($data) {
            return ApiFormatter::createApi($data, 'Succes');
        } else {
            return ApiFormatter::createApi('Data is empty', 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function rand_sha1($length)
    {
        $max = ceil($length / 40);
        $random = '';
        for ($i = 0; $i < $max; $i++) {
            $random .= sha1(microtime(true) . mt_rand(10000, 90000));
        }
        return substr($random, 0, $length);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_teams' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {

            $team = Team::create([
                'name_teams' => $request->name_teams,
                'description' => $request->description,
                'team_invite_code' => $this->rand_sha1(10),
                'id_pembuat' => $request->user_id,
            ]);

            $teamResult = Team::where('id_team', '=', $team->id_team)->get();
            // return $teamResult;
            $teamMember = TeamMember::create([
                'id_team' => $team->id_team,
                'id_member' => $request->user_id,
            ]);


            if ($teamResult) {
                return ApiFormatter::createApi($teamResult, 'Succes');
            } else {
                return ApiFormatter::createApi('Data Cannot Create', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Data Cannot Create', $error);
        }
    }


    public function join(Request $request)
    {
        //$kode = Team::select('team_invite_code')->where('id_team', '=', $request->query('id_team'))->get();
        $team = Team::where('team_invite_code', '=', (string)$request->kode)->get();
        $cek = TeamMember::where('id_team', '=', $team[0]->id_team)->where('id_member', '=', $request->query('id_member'))->exists();
        $kodeRequest = (string)$request->kode;
        if (!$cek) {
            if ($team[0]->team_invite_code == $kodeRequest) {
                try {
                    $data = TeamMember::create([
                        'id_team' => $team[0]->id_team,
                        'id_member' => $request->query('id_member'),
                    ]);

                    if ($data) {
                        return ApiFormatter::createApi($data, 'Succes');
                    } else {
                        return ApiFormatter::createApi('Data Cannot Create', 'Failed');
                    }
                } catch (Exception $error) {
                    return ApiFormatter::createApi('Data Cannot Create', $error);
                }
            } else {
                return ApiFormatter::createApi('Error Validation', 'Failed');
            }
        } else return ApiFormatter::createApi('User has been added', 'Failed');
    }


    public function deleteMember(Request $request, $id_team, $id_member)
    {
        $cek = DB::table('teams')
            ->join('team_member', 'teams.id_team', '=', 'team_member.id_team')
            ->select('teams.id_pembuat')
            ->where('teams.id_pembuat', $request->id_pembuat)
            ->get();
        // return $cek;
        if ($cek->count() > 0) {
            try {
                if (TeamMember::where('id_team', '=', $id_team)->where('id_member', '=', $id_member)->delete()) {
                    return ApiFormatter::createApi('Data Deleted', 'Succesfull');
                } else {
                    return ApiFormatter::createApi('Failed Delete Data', 'Failed');
                }
            } catch (Exception $error) {
                return ApiFormatter::createApi($error, 'Failed');
            }
        } else return ApiFormatter::createApi('You cannot delete', 'Failed');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (Team::where('id_team', $request->query('id'))->exists()) {
            $data = Team::where('id_team', $request->query('id'))->get();
        } else if (Team::where('id_pembuat', $request->query('idCreator'))->exists()) {
            $data = Team::where('id_pembuat', $request->query('idCreator'))->get();
        } else if (Team::where('name_teams', $request->query('nameTeam'))->exists()) {
            $data = Team::where('name_teams', $request->query('nameTeam'))->get();
        } else if ($request->query('id_member')) {
            //$data = Team::where('name_teams', $request->query('nameTeam'))->get();
            $team =  DB::table('teams')
                ->join('team_member', 'teams.id_team', '=', 'team_member.id_team')
                ->select('teams.id_team', 'teams.name_teams', 'teams.description')
                ->where('team_member.id_member', $request->query('id_member'))
                ->get();
            $i = 0;
            foreach ($team as $teams) {
                $count[$i] = DB::table('teams')
                    ->join('team_member', 'teams.id_team', '=', 'team_member.id_team')
                    ->where('team_member.id_team', $teams->id_team)
                    ->count();
                // $data = new stdClass();
                // $data->$data[$i]->id_team = $teams->id_team;
                // $data->$data[$i]->name_team = $teams->name_team;
                // $data->$data[$i]->description = $teams->description;
                // $data->$data[$i]->member = $teams->member;
                //$data->put('member', $count[$i]);
                $data[$i] = [

                    'id_team' => $teams->id_team,
                    'name_team' => $teams->name_teams,
                    'description' => $teams->description,
                    'member' => $count[$i]

                ];
                $i++;
            }
        } else if ((!$request->query('idCreator') && !$request->query('id') && !$request->query('nameTeam'))) {
            return ApiFormatter::createApi('Query Not Found', 'Failed');
        }

        if (isset($data)) {
            return ApiFormatter::createApi($data, 'Succesfull');
        } else {
            return ApiFormatter::createApi('Data Not Found', 'Failed');
        }
    }

    public function showMember($id)
    {
        $team = Team::where('id_team', $id)->get();
        $member = TeamMember::select('id_member')->where('id_team', $id)->get();
        //pluck('id_member');

        // return $member->count();
        if (isset($team) && ($member->count() > 0)) {
            $data = [
                'id_team' => $team[0]->id_team,
                'name_teams' => $team[0]->name_teams,
                'member' => $member,
                'id_pembuat' => $team[0]->id_pembuat,
            ];
            return ApiFormatter::createApi($data, 'Succesfull');
        } else {
            return ApiFormatter::createApi('Data Not Found', 'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $team = Team::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $team->name_teams = $request->name;
        $team->description = $request->description;
        $team->save();
        $data = Team::where('id_team', '=', $id)->get();
        if ($data) {
            return ApiFormatter::createApi($data, 'Succesfull Update');
        } else {
            return ApiFormatter::createApi('Data cannot updated', 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team, TeamMember $teamMember, $id)
    {
        // $result = $team->find($id);
        try {
            if ($team->where('id_team', '=', $id)->delete()) {
                return ApiFormatter::createApi('Data Deleted', 'Succesfull');
            } else {
                return ApiFormatter::createApi('Failed Delete Data', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi($error, 'Failed');
        }
    }
}
