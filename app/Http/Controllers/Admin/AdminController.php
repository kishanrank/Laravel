<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResponserController;
use App\Models\Admin;
use App\Models\AdminProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends ResponserController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('admins')
                ->join('admin_profiles', 'admins.id', '=', 'admin_profiles.admin_id')
                ->select('admins.id', 'admins.name', 'admins.email', 'admins.active', 'admin_profiles.avatar')
                ->get();
            return DataTables::of($data)
                ->addColumn('avatar', function ($data) {
                    $url = asset($data->avatar);
                    return '<img src="' . $url . '"  width="50" height="50" alt="' . $data->name . '" />';
                })
                ->addColumn('status', function ($data) {
                    if ($data->active) {
                        return '<label class="badge badge-success">Activated</label>';
                    }
                    return '<label class="badge badge-danger">Not Activated</label>';
                })
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm mr-3"><i class="fa fa-edit"></i></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['avatar', 'status', 'action'])
                ->make(true);
        }
        return view('admin.peoples.admins.index');
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $error = Validator::make($request->all(), Admin::rules(0, ['password' => 'required|min:8']));
            if ($error->fails()) {
                return $this->errorMessageResponse($error->errors()->all(), 422);
            }

            $admin_data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
            $admin = Admin::create($admin_data);

            if (!$admin->id) {
                return $this->errorMessageResponse('Error in Admin saving.', 500);
            }

            $admin->profile()->create([
                'avatar' => 'uploads/avatars/admin.jpg'
            ]);
            $admin->adminActivationCode()->create([
                'code' => Str::random(128)
            ]);

            return $this->successMessageResponse('Admin saved successfully!');
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Admin::findOrFail($id)->only('id', 'name', 'email'); // No query result found for model id like 65, code 404
            if (!$data) {
                return $this->errorMessageResponse('No data found for this admin.', 404);
            }
            return response()->json(['result' => $data], 200);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $error = Validator::make($request->all(), Admin::rules($id));
            if ($error->fails()) {
                return $this->errorMessageResponse($error->errors()->all(), 422);
            }

            $admin = Admin::find($id);

            if (!$admin->id) {
                return $this->errorMessageResponse('Error in updating admin data.', 500);
            }

            $admin->name = $request->name;
            $admin->email = $request->email;

            if ($request->has('password')) {
                $password = trim($request->password);
                if (strlen($password) < 8) {
                    return $this->errorMessageResponse('Password must be minimum 8 characters long.', 422);
                }
                if ($password != null) {
                    $admin->password = bcrypt($password);
                }
            }

            if ($admin->save()) {
                return $this->successMessageResponse('Admin data saved successfully!');
            }
            return $this->errorMessageResponse('Error in updating admin data.', 500);
        }
    }

    public function destroy($id)
    {
        if ($id == 1) {
            return $this->errorMessageResponse("HAHAHA, You can not delete Super admin, so please don't try it.", 400);
        }

        $admin = Admin::find($id);

        if ($admin->delete()) {
            return $this->successMessageResponse('Successfully deleted admin account.', 200);
        }

        return $this->errorMessageResponse('Error in deleting admin.', 404);
    }
}
