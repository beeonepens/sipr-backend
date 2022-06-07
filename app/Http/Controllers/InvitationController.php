<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Invitation::all();

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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_invitee' => 'required',
            'id_receiver' => 'required',
            'id_meet' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $d = date("Y-m-d h:i:sa", strtotime("+7 Days"));
            $invite = Invitation::create([
                'expiredDateTime' => $d,
                'id_invitee' => $request->id_invitee,
                'id_receiver' => $request->id_receiver,
                'id_meet' => $request->id_meet,
            ]);

            $data = Invitation::where('id_invitation', '=', $invite->id_invitation)->get();
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
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (Invitation::where('id_invitation', $request->query('id'))->exists()) {
            $data = Invitation::where('id_invitation', $request->query('id'))->get();
        } else if (Invitation::where('id_invitee', $request->query('idInvitee'))->exists()) {
            $data = Invitation::where('id_invitee', $request->query('idInvitee'))->get();
        } else if ((!$request->query('idInvitee') && !$request->query('id'))) {
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
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function edit(Invitation $invitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $invite = Invitation::find($id);
            $invite->isAccepted = $request->isAccepted;
            $invite->reason = $request->reason;
            $invite->save();

            $data = Invitation::where('id_invitation', '=', $invite->id_invitation)->get();
            if ($data) {
                return ApiFormatter::createApi($data, 'Succes');
            } else {
                return ApiFormatter::createApi('Data Update Notification', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Data Cannot Create', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation, $id)
    {
        try {
            if ($invitation->where('id', '=', $id)->delete()) {
                return ApiFormatter::createApi('Data Deleted', 'Succesfull');
            } else {
                return ApiFormatter::createApi('Failed Delete Data', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi($error, 'Failed');
        }
    }
}
