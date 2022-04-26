<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();

        if ($data) {
            return ApiFormatter::createApi($data);
        } else {
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
                'role_id' => $request->role_id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatarUrl' => $request->avatarUrl,
                'address' => $request->address,
                'gender' => $request->gender,
                'dateofbirth' => $request->dateofbirth,
            ]);

            $token = $users->createToken('auth_token')->plainTextToken;
            // $data = User::where('nip', '=' . $users->nip)->get();
            $data = DB::table('users')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select(
                    'users.nip',
                    'users.name',
                    'users.email',
                    'users.password',
                    'users.avatarUrl',
                    'users.address',
                    'users.gender',
                    'users.dateofbirth',
                    'users.created_at',
                    'users.updated_at',
                    'roles.name_role'
                )
                ->where('nip', '=', $users->nip)
                // ->where('meet_date_time.id_meet','='. $meet->id_meet)
                ->get();
            // var_dump($data); die;
            if ($data) {
                return ApiFormatter::createApiAuth($data, $token, 'Succesfull');
            } else {
                return ApiFormatter::createApiAuth('Data not found', 'Token Cannot Created', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Data Cannot Create', $error);
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
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'role_id' => 'required',
                'password' => 'required|min:5|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = User::find($id);

            $user->name = $request->name;
            $user->role_id = $request->role_id;
            $user->password = $request->password;
            $user->avatarUrl = $request->avatarUrl;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->dateofbirth = $request->dateofbirth;

            $user->save();
            $data = User::where('nip', '=', $id)->get();
            if ($data) {
                return ApiFormatter::createApi($data, 'Succesfull Upadte');
            } else {
                return ApiFormatter::createApi('Data cannot updated', 'Failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi('Data Cannot Update', $error);
        }
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
