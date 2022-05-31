<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Notification::all();

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
            'title' => 'required',
            'notificationType' => 'required',
            'meet_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {

            $notif = Notification::create([
                'title' => $request->title,
                'description' => $request->description,
                'isRead' => false,
                'notificationType' => $request->notificationType,
                'publicationDate' => $request->publicationDate,
                'meet_id' => $request->meet_id,
                'user_id' => $request->user_id,
            ]);

            $data = Notification::where('id', '=', $notif->id)->get();
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
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (Notification::where('id', $request->query('id'))->exists()) {
            $data = Notification::where('id', $request->query('id'))->get();
        } else if (Notification::where('meet_id', $request->query('idMeet'))->exists()) {
            $data = Notification::where('meet_id', $request->query('idMeet'))->get();
        } else if (Notification::where('notificationType', $request->query('notificationType'))->exists()) {
            $data = Notification::where('notificationType', $request->query('notificationType'))->get();
        } else if (Notification::where('isRead', $request->query('isRead'))->exists()) {
            $data = Notification::where('isRead', $request->query('isRead'))->get();
        } else if ((!$request->query('id') && !$request->query('idMeet') && !$request->query('notificationType') && !$request->query('isRead'))) {
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
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $notif = Notification::find($id);

            $notif->isRead = $request->isRead;
            $notif->save();

            $data = Notification::where('id', '=', $notif->id)->get();
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
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification, $id)
    {
        try {
            if ($notification->where('id', '=', $id)->delete()) {
                return ApiFormatter::createApi('Data Deleted', 'Succesfull');
            } else {
                return ApiFormatter::createApi('Failed Delete Data', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi($error, 'Failed');
        }
    }
}
