<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserJob;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;

class UserController extends Controller
{
    use ApiResponser;

    private $request;

    public $timestamps = false;

    public function __construct(Request $request){
        $this->request = $request;
    }
    
    public function showUsers(){
        $users = User::all();
        return $this -> successResponse(User::all());
    }

    public function showUser($id){
        $user = User::findOrFail($id);
        return $this->successResponse($user);
    }

    public function addUser(Request $request){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0'
        ];

        $validate = $this->validate($request, $rules);

        $user = User::create($request->all());
        $userjob = UserJob::findOrFail($request->jobid);

        return $this->successResponse($user, Response::HTTP_CREATED);
    }   
        
    public function updateUser(Request $request, $id){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0'
        ];

        $validate = $this->validate($request, $rules);

        $userjob = UserJob::findOrFail($request->jobid);

        if ($validate){

            $user = User::findOrFail($id);
            $user->fill($request->all());

            if ($user->isClean()) {
                return $this-> ErrorResponse("At least one value must change.", 
                Response::HTTP_UNPROCESSABLE_ENTITY);
            } else {
                $user->save();
                return $this->successResponse($user);
            }
        }
    }

    public function deleteUser($id){ 
        $user = User::findOrFail($id);
        $user->delete();
        
        return $this -> successResponse('Deleted Successfully!');
    }
}
