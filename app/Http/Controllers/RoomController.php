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

    public function index()
    {
        $data = Room::all();

        if ($data) {
            return ApiFormatter::createApi($data, 'Succes');
        } else {
            return ApiFormatter::createApi('Data is empty', 'Failed');
        }
    }


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


    public function show(Request $request)
    {

        if (Room::where('id_room', $request->query('id'))->exists()) {
            $data = Room::where('id_room', $request->query('id'))->get();
        } else if (Room::where('user_id', $request->query('user_id'))->exists()) {
            $data = Room::where('user_id', $request->query('user_id'))->get();
        } else if ((!$request->query('user_id') && !$request->query('id'))) {
            return ApiFormatter::createApi('Query Not Found', 'Failed');
        }

        if (isset($data)) {
            return ApiFormatter::createApi($data, 'Succesfull');
        } else {
            return ApiFormatter::createApi('Data Not Found', 'Failed');
        }
    }


    public function update(Request $request, $id)
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
            $room = Room::find($id);

            $room->name_room = $request->name_room;
            $room->description = $request->description;
            $room->isOnline = $request->isOnline;
            $room->isBooked = $request->isBooked;
            $room->user_id = $request->user_id;
            $room->save();

            $data = Room::where('id_room', '=', $room->id_room)->get();
            if ($data) {
                return ApiFormatter::createApi($data, 'Succes');
            } else {
                return ApiFormatter::createApi('Data Update Room', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Data Cannot Create', $error);
        }
    }


    public function destroy($id)
    {
        try {
            if (Room::where('id_room', $id)->delete()) {
                return ApiFormatter::createApi(null, 'Succesfull');
            } else {
                return ApiFormatter::createApi('Failed Delete Data', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Cannot Delete', $error);
        }
    }
}
