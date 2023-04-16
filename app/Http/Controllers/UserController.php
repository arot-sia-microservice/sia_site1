<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

Class UserController extends Controller {
    private $request;

    public function __construct(Request $request){
        $this->request = $request;
    }

    public function getUsers(){
        $users = User::all();
        return response()->json(['data' => $users], 200);
    }
/**
* Return the list of users
* @return Illuminate\Http\Response
*/

public function add(Request $request ){
        $rules = [
        'username' => 'required|max:20',
        'password' => 'required|max:20',
        ];

        $this->validate($request,$rules);

        $user = User::create($request->all());
        return response()->json($user, 200);
}
/**
* Obtains and show one user
* @return Illuminate\Http\Response
*/

}