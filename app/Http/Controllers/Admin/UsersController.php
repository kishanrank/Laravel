<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Profile;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends ResponserController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')
                ->join('profiles', 'users.id', '=', 'profiles.user_id')
                ->select('users.id', 'users.name', 'users.email', 'users.active', 'users.admin', 'profiles.avatar')
                ->get();

            return DataTables::of($data)
                ->addColumn('avatar', function ($data) {
                    $url = asset($data->avatar);
                    return '<img src="' . $url . '"  width="50" height="50" alt="' . $data->name . '" />';
                })
                ->rawColumns(['avatar'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    public function store(Request $request)
    {
        $error = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all(), 422);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        Profile::create([
            'user_id' => $user->id,
            'avatar' => 'uploads/avatars/admin.jpg'
        ]);

        $user->userActivationCode()->create([
            'code' => Str::random(128)
        ]);

        return $this->successMessageResponse('User created successfully.', 200);
    }

    public function makeadmin($id)
    {
        if ((!$user = User::find($id))) {
            return $this->errorMessageResponse('Unable to change permission right now.', 404);
        }

        if (!$user->active) {
            return $this->errorMessageResponse('User has not activated his/her account yet.', 403);
        }

        $user->admin = User::ADMIN;


        if ($user->save()) {
            return $this->successMessageResponse('Successfully changed user permission.', 200);
        }
        return $this->errorMessageResponse('Unable to change permission right now.', 404);
    }

    public function removeadmin($id)
    {
        if (!($user = User::find($id))) {
            return $this->errorMessageResponse('Unable to change permission right now.', 404);
        }

        $loggedUserId = Auth::user()->id;

        if ($loggedUserId == $id) {
            return $this->errorMessageResponse('You can not change your own premission', 422);
        }

        $user->admin = User::NOT_ADMIN;

        if ($user->save()) {
            return $this->successMessageResponse('Successfully changed user permission.', 200);
        }
        return $this->errorMessageResponse('Unable to change permission right now.', 404);
    }

    public function export(Request $request)
    {
        $this->validate($request, ['date_from' => 'required', 'date_to' => 'required']);
        $start = date("Y-m-d", strtotime($request->date_from));
        $end = date("Y-m-d", strtotime($request->date_to . "+1 day"));
        return Excel::download(new UsersExport($start, $end), 'users.csv');
    }

    public function destroy($id)
    {
        $loggedUserId = Auth::user()->id;

        if ($id == 1) {
            return $this->errorMessageResponse("HAHAHA, You can not delete Super admin, so please don't try it.", 400);
        }

        $user = User::findOrFail($id);
        
        if ($id == $loggedUserId) {
            return $this->errorMessageResponse('You can not delete self account.', 422);
        }

        $user->profile->delete();

        if ($user->delete()) {
            return $this->successMessageResponse('Successfully deleted user account.', 200);
        }
        return $this->errorMessageResponse('Error in deleting user.', 404);
    }
}
