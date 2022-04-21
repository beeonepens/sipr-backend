<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Meet;
use App\Models\DateMeet;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\MeetDate;

class MeetController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
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
                'limit' => $request->limit,
                'isOnline' => $request->isOnline,
                'room_id' => $request->room_id,
                'user_id' => $request->user_id,
            ]);

            // var_dump($meet->user_id);
            // var_dump($request->date);
            // foreach($request->date as $date){
            //     var_dump($meet->id);
            //     var_dump(date($date));
            // }
            // die;


            // $token = $meet->createToken('auth_token')->plainTextToken;
            $data = Meet::where('id_meet','='. $meet->id)->get();
            // $id = Meet::findOrFail()
            // $data1 = Meet::findorFail();
            //var_dump($data->id_meet); die;
            // foreach ($data as $datas) {
            //     var_dump($datas);
            // }
            // die;
            foreach($request->date as $date){
                $datemeet = DateMeet::insert([
                    'id_meet' => $meet->id,
                    'datetime' => $date,
                ]);
            }

            $data2 = DateMeet::where('id','='. $datemeet->id)->get();

            if($data && $data2){
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
        //
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
