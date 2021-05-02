<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
   public function index(Request $request){

    if($request->isJson()){
        $users = User::all();
        return response()->json($users, status: 200);
    }

    return response()->json(['error' => 'Unauthorized'], 401, []);

   }

   public function createUser(Request $request){

        if($request->isJson()){
            // TODO: create the user in the DB
            $data = $request->json()->all();

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'api_token' => Str::random(32),
                'password' => Hash::make($data['password'])
            ]);

            return response()->json($user, 201);
        }

        return response()->json(['error' => 'Unauthorized'], 401, []);
   }

   public function getToken(Request $request){

        if($request->isJson()){
            try {
                $data = $request->json()->all();

                $user = User::where('username', $data['username'])->first();

                if($user && Hash::check($data['password'], $user->password)){
                    return response()->json($user, 200);
                } else {
                    return response()->json(['error' => 'No Content'], 406);
                }

            } catch (ModelNotFoundException $e) {
                return response()->json(['error' => 'No Content'], 406);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401, []);

   }

}
