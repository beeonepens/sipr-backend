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

            $room = Team::create([
                'name_teams' => $request->name_teams,
                'description' => $request->description,
                'team_invite_code' => $this->rand_sha1(10),
                'id_pembuat' => $request->user_id,
            ]);

            $data = Team::where('id_team', '=', $room->id_team)->get();
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
    public function show(Team $team)
    {
        //
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
    public function update(Request $request, Team $team)
    {
        //
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
