<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;

class AuthController extends Controller
{
    public function index(){
        $user = User::all();

        if(count($user) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $user
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }

    public function register(Request $request){
        $registrationData = $request->all();
        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60,dns|unique:users',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'telp' => 'required|numeric|regex:/(0)(8)/|digits_between:10,13',
            'alamat' => 'required',
            // 'url' => null
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $registrationData['password'] = bcrypt($request->password);
        
        $user = User::create($registrationData);
        return response([
            'message' => 'Register Success',
            'user' => $user,
        ],200);
    }

    public function login(Request $request){
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);
    
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
    
        if(!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'],401);
    
        $user = Auth::user();
    
        $token = $user->createToken('Authentication Token')->accessToken;
    
        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        if(is_null($user)){
        return response([
            'message' => 'User Not Found',
            'data' => null
            ],404);
        }
 
        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'telp' => 'required|numeric|regex:/(0)(8)/|digits_between:10,13',
            'alamat' => 'required',
            'url' => ''
            ]);

            $user->name = $updateData['name'];
            $user->telp = $updateData['telp'];
            $user->alamat = $updateData['alamat'];
            $user->url = $updateData['url'];
 
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
 
        
 
        if($user->save()){
             return response([
                 'message' => 'Update Profile Success',
                 'data' => $user,
                 ],200);
        }
 
        return response([
         'message' => 'Updated Profile Failed',
         'data' => null,
         ],400);
    }

    public function show($id){
        $user = User::find($id);

        if(!is_null($user)){
            return response([
                'message' => 'Retrieve Data Success',
                'data' => $user
            ],200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ],404);
    }

    public function upload(Request $request, $id){
        $this->validate($request,[
            'url' => 'image|mimes:jpeg,png,jpg',
        ]);

        $image = request() ->file('url');
        $image_name = $image ->getClientOriginalName();
        $image_name = time().'_'.$image_name;

        $image->move (public_path('/images/'),$image_name);

        $user = new User;
        $user = Auth::user();
        $user->url = '/images/'.$image_name;
        $user->save(); 
 
        if($user->save()){
            return response([
                'message' => 'Update Profile Success',
                'data' => $user,
            ],200);
        }
 
        return response([
         'message' => 'Updated Profile Failed',
         'data' => $directory,
         ],400);
    }


}
