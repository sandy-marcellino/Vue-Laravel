<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use App\KelolaPesanan;

class AuthController extends Controller
{
    use VerifiesEmails;
    public $successStatus = 200;

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
            //'url' => null
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $registrationData['password'] = bcrypt($request->password);
        
        $user = User::create($registrationData);
        $user->sendApiEmailVerificationNotification();
        $success['message'] = 'link verifikasi telah dikirim ke email anda';
        return response([
            'message' => 'Register Success',
            'user' => $user,
        ],200);
    }

    public function detailUser()
    {
        $user = Auth::user();
        return response([
            'message' => 'Detail',
            'user' => $user
        ]);
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

        if(Auth::attempt($loginData)){
            $user = Auth::user();

            if($user->email_verified_at !== NULL){
                $token = $user->createToken('Authentication Token')->accessToken;
                if($user->status === "admin"){
                    return response([
                        'message' => 'Authenticated',
                        'user' => $user,
                        'token_type' => 'Bearer',
                        'access_token' => $token
                    ]);
                }else {
                    return response([
                        'message' => 'Authenticated',
                        'user' => $user,
                        'token_type' => 'Bearer',
                        'access_token' => $token
                    ]);
                }
            }else{
                return response()->json(['error'=>'Please Verify Email'], 401);
            }
        }    
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
            'url' => 'max:10048'
            // image|mimes:jpeg,png,jpg|
            ]);

            $user->name = $updateData['name'];
            $user->telp = $updateData['telp'];
            $user->alamat = $updateData['alamat'];
            // $user->url = $updateData['url'];
 
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
 
        // if($foto = $request->file('url')){
        //     $fotoUser = time().'.'.$request->url->extension();
        //     $request->url->move(public_path('url'),$fotoUser);
        //     $user->url=$fotoUser;
            if($user->save()){
                return response([
                    'message' => 'Berhasil Mengupdate Profile',
                    'data' => $user,
                ],200);
            }
        // }
        return response([
         'message' => 'Gagal Mengupdate Profile',
         'data' => null,
         ],400);
    }

    public function show(){
        $user = Auth::user();

        return response([
            'message' => 'Show Profile',
            'data' => $user
        ],200);
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

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out' 
        ]);
    }

    public function details(){
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }

    public function user(Request $request){
        return response()->json($request->user());
    }


}
