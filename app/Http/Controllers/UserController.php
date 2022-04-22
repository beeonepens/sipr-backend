<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();

        if($data){
            return ApiFormatter::createApi($data);
        }
        else{
            return ApiFormatter::createApi('Failed');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nip' => 'required|max:255',
                'name' => 'required|max:255',
                // 'role' => 'required',
                'email' => 'required|email:dns|unique:users',
                'password' => 'required|min:5|max:255',
            ]);

            $users = User::create([
                'nip' => $request->nip,
                'name' => $request->name,
                'role' => 'user',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatarUrl' => $request->avatarUrl,
                'address' => $request->address,
                'gender' => $request->gender,
                'dateofbirth' => $request->dateofbirth,
            ]);

            $token = $users->createToken('auth_token')->plainTextToken;
            $data = User::where('nip','='. $users->nip)->get();
            // var_dump($data); die;
            if($data){
                return ApiFormatter::createApi($data, $token, 'Succesfull');
            }
            else{
                return ApiFormatter::createApi($data, $token, 'failed');
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
