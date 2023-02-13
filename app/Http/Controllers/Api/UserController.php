<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
class UserController extends Controller
{
    
    public function register(Request $request){
        $user = User::create([
          'name' => $request->get('name'),
          'username'=>$request->get('username'),
          'email' => $request->get('email'),
          'password' => bcrypt($request->get('password'))
        ]);

        return response()->json([
            'status'=> 200,
            'message'=> 'User created successfully'
        ]);
    }
    
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function sociallogin(Request $request){
        $provider = $request->get('provider');
        $social_id = $request->get('social_id');
        $name=$request->get('name');
        $username=$request->get('username');
        $email=$request->get('email');
        $password=$request->get('password');
        $avatar=$request->cloudinary()->upload($request->file('avatar')->getRealPath())->getSecurePath();
        $data=[];
        $users=User::where([['social_id',$social_id],['provider',$provider]]);
        if ($users->exists()){
            $user=$users->first();
            $token = auth()->login($user);
            $data=$this->createNewToken($token);
        }
        else{
            $user=User::create([
                'name'=>$name,'username'=>$username,'social_id'=>$social_id,
                'email'=>$email,'auth_provider'=>$provider,'password'=>bcrypt($request->get('password'))
            ]);
            $token = auth()->login($user);
            $data=$this->createNewToken($token);
        }
        return $data;
    }
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    public function getAuthenticatedUser()
    {
        try{
            return auth()->user()->id;
        }
        catch (\Exception $e) {
            return 0;
        }

    }
    public function userinfo(){
        $user=new UserResource(User::find($this->getAuthenticatedUser()));
        return response()->json($user);
    }
    protected function createNewToken($token){
        return response()->json([
            'access' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 120,
        ]);
    }
}
