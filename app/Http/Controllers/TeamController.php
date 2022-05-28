<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Validator;
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
        //
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

            $data = Team::where('id_team', '=', $team->id_team)->get();
            if ($data) {
                return ApiFormatter::createApi($data, 'Succes');
            } else {
                return ApiFormatter::createApi('Data Cannot Create', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Data Cannot Create', $error);
        }
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
        } else if (Team::where('id_pembuat', $request->query('idMaster'))->exists()) {
            $data = Team::where('id_pembuat', $request->query('idMaster'))->get();
        } else if (Team::where('name_teams', $request->query('nameTeam'))->exists()) {
            $data = Team::where('name_teams', $request->query('nameTeam'))->get();
        } else if ((!$request->query('idMaster') && !$request->query('id') && !$request->query('nameTeam'))) {
            return ApiFormatter::createApi('Query Not Found', 'Failed');
        }

        if (isset($data)) {
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
        $user = Team::find($id);

        $user->name = $request->name;
        $user->role_id = $request->role_id;

        if (isset($request->password)) {
            $user->password = $request->password;
        }

        $user->avatarUrl = $request->avatarUrl;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->dateofbirth = $request->dateofbirth;

        $user->save();
        $data = Team::where('nip', '=', $id)->get();
        if ($data) {
            return ApiFormatter::createApi($data, 'Succesfull Upadte');
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
    public function destroy(Team $team)
    {
        //
    }
}
