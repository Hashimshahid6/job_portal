<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.list', compact('users'));    
    }//

    public function edit($id){
        $user = User::findorFail($id);
        return view('admin.users.edit', compact('user'));
    }//

    public function update($id , Request $request){

        $validator = Validator::make($request->all(),
        [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        if($validator->passes()){
            $user = User::findorFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success','User information updated successfully.');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }
        else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }//

    public function destroy(Request $request){
        $id = $request->id;

        $user = User::find($id);

        if ($user == null) {
            session()->flash('error','User not found');
            return response()->json([
                'status' => false,
            ]);
        }
        else{
            if($user->role == 'admin'){
                session()->flash('error', 'You cannot delete Super Admin');
                return response()->json([
                    'status' => false,
                ]);
            }
        }

        $user->delete();
        session()->flash('success','User deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
