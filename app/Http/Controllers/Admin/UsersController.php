<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Models\Profile;
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
                ->select('users.id', 'users.name', 'users.email', 'users.active', 'profiles.avatar')
                ->get();

            return DataTables::of($data)
                ->addColumn('avatar', function ($data) {
                    $url = asset($data->avatar);
                    return '<img src="' . $url . '"  width="50" height="50" alt="' . $data->name . '" />';
                })
                ->addColumn('delete', function ($data) {
                    return '<button type="button" name="delete-user" id="' . $data->id . '" class="btn btn-danger btn-sm mr-3 delete-user"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['avatar', 'delete'])
                ->make(true);
        }
        return view('admin.peoples.users.index');
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

    public function export(Request $request)
    {
        $this->validate($request, ['date_from' => 'required', 'date_to' => 'required']);
        $start = date("Y-m-d", strtotime($request->date_from));
        $end = date("Y-m-d", strtotime($request->date_to . "+1 day"));
        return Excel::download(new UsersExport($start, $end), 'users.csv');
    }

    public function destroy($id)
    {
        // $loggedUserId = Auth::user()->id;

        // if ($id == 1) {
        //     return $this->errorMessageResponse("HAHAHA, You can not delete Super admin, so please don't try it.", 400);
        // }

        $user = User::findOrFail($id);

        // if ($id == $loggedUserId) {
        //     return $this->errorMessageResponse('You can not delete self account.', 422);
        // }

        $user->profile->delete();

        if ($user->delete()) {
            return $this->successMessageResponse('Successfully deleted user account.', 200);
        }
        return $this->errorMessageResponse('Error in deleting user.', 404);
    }
}
