<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Room::all();

        if ($data) {
            return ApiFormatter::createApi($data, 'Succes');
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
            'name_room' => 'required',
            'description' => 'required|max:255',
            'isOnline' => 'required',
            'isBooked' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {

            $room = Room::create([
                'name_room' => $request->name_room,
                'description' => $request->description,
                'isOnline' => $request->isOnline,
                'isBooked' => $request->isBooked,
                'user_id' => $request->user_id,
            ]);

            $data = Room::where('id_room', '=', $room->id_room)->get();
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
     * @param  \App\Models\Roomm  $roomm
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->query('id')) {
            $data = Room::where('id_room', $request->query('id'))->get();
        } else if ($request->query('user_id')) {
            $data = Room::where('user_id', $request->query('user_id'))->get();
        } else {
            $data = null;
        }

        if (isset($data)) {
            return ApiFormatter::createApi($data, 'Succesfull');
        } else {
            return ApiFormatter::createApi('Data Not Found', 'Failed');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roomm  $roomm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $roomm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roomm  $roomm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $roomm)
    {
        //
    }
}
