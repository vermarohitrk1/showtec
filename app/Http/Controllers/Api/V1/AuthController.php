<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Password;
use Mail;
use DataTables;
use Response;

class AuthController extends Controller {
    public $successStatus = 200; 
    
    public function login(Request $request){ 
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            User::where('id',$user->id)->update(['device_token'=>$request->device_token]);
            $response['token'] =  $user->createToken('showtec')-> accessToken; 
            $response['user'] = $user;
            return response()->json(['status'=>'success', 'data' => $response], $this->successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Please check your credencials!'], 401); 
        } 
    }

    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['status'=>'success', 'message' => 'logged out'];
        return response($response, 200);
    }
    
    public function register(Request $request){
     
      $validator = Validator::make($request->all(), [
          'name' => 'required',
            'email' => 'email|unique:users'
        ]);
        if($validator->fails()){ 
            return Response::json($validator->errors());            
        }
 
        $input = $request->all(); 
        $input['name'] = $input['name'];
        $input['password'] = bcrypt($input['password']); 
        
        if($request->has('device_token'))
        $input['device_token']= $input['device_token'];

        $users = User::create($input); 

        
        if(!empty($users)){
            
            $success['name'] = $input['name'];
            $success['token'] = $users->createToken('stemx')->accessToken; 
            $success['email'] = $input['email'];      
            return response()->json(['success'=>$success], $this->successStatus);
        }else{
            return response()->json(['error'=>"Error while registering a user"], 401); 
        }  
        
    } 
    
    public function forgot(Request $request) {
        $messages = array('exists'=>'Email are not correct!');
        $credentials =  Validator::make($request->all(), [
            'email' => 'required|email|exists:users'
        ], $messages);
        if($credentials->fails()){ 
            return Response::json($credentials->errors());            
        }
        Password::sendResetLink($request->all());

        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }
    
    public function reset(Request $request) {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($request->all(), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["msg" => "Invalid token provided"], 400);
        }

        return response()->json(["msg" => "Password has been successfully changed"],200);
    }


    

    
}