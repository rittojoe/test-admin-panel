<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register']]);
    }

    public function registration(){
        return view('register');
    }


    public function addUser(Request  $request){
        //email
        if(!empty($request->input('email'))) {
            $email               =      $request->input('email');
            
        }else{
            //Invalid Request
            return response()->json(array('status' => 400,));
        }
        //name
        if($request->input('name') != null) {
            $name               =      $request->input('name');
        }else{
            //Invalid Request
            return response()->json(array('status' => 400,));
        }        
        if($request->input('password') != null) {
            $password            =       Hash::make($request->input('password'));
 
        }else{
            //Invalid Request
            return response()->json(array('status' => 400,));
        }

        $files=$request->file('filename');
 
        $user               =       User::where('email',$email)-> first();
        if($user != null){
            //user already registered
            return response()->json(['message' => 'User already exists!'], 401);
        }else{            
 
            $result                  =   User::insert(array(
                'name'               =>  $name,
                'email'              =>  $email,
                'password'           =>  $password,
                'resume_link'        =>  $files));            
        }

        return response()->json(array(
            "status"      =>      "200",
            "message"  =>      "User added succesfully"
        ));
    }

    public function getUser(){

        Log::info("Inside Get Users");

        $users  = User::select(array('id','name','email','resume_link'))
                            ->orderBy('id','desc')
                            ->get();

        return response()->json(array(
            "data"  =>      $users
        ));
        
    }


}

?>