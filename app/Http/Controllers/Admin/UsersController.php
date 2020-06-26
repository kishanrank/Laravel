<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
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
        // return view('admin.users.index', ['users' => User::all()]);
    }

    public function store(Request $request)
    {
        $error = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
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
        return response()->json(['success' => 'User created successfully.']);
    }

    public function makeadmin($id)
    {
        if ((!$user = User::find($id))) {
            return response()->json(['error' => 'Unable to change permission right now.']);
        }
        $user->admin = 1;
        if ($user->save()) {
            return response()->json(['success' => 'Successfully changed user permission.']);
        }
        return response()->json(['error' => 'Unable to change permission right now.']);
    }

    public function removeadmin($id)
    {
        if (!($user = User::find($id))) {
            return response()->json(['error' => 'Unable to change permission right now.']);
        }
        $user->admin = 0;
        if ($user->save()) {
            return response()->json(['success' => 'Successfully changed user permission.']);
        }
        return response()->json(['error' => 'Unable to change permission right now.']);
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
            return response()->json(['error' => 'You can not delete Super admin, so plz dont try it.']);
        }

        $user = User::findOrFail($id);
        
        if ($id == $loggedUserId) {
            return response()->json(['error' => 'You can not delete self account.']);
        }

        $user->profile->delete();
        if ($user->delete()) {
            return response()->json(['success' => 'Successfully deleted user account.']);
        }
        return response()->json(['error' => 'Error in deleting user.']);
    }
}
