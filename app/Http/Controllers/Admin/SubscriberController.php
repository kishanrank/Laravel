<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SubscriberExport;
use App\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subscriber::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="subscriber_checkbox" class="subscriber_checkbox float-center" value="{{$id}}">')
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        $dateLastMonth = Carbon::today()->subDays(30);
        $dateLastQuater = Carbon::today()->subDays(120);
        $subscriber30 = Subscriber::where('created_at', '>=', $dateLastMonth)->get()->count();
        $subscriber120 = Subscriber::where('created_at', '>=', $dateLastQuater)->get()->count();
        $subscribers = Subscriber::all()->count();
        return view('admin.subscribers.index', compact('subscribers', 'subscriber30', 'subscriber120'));
    }

    public function destroy($id) {
        if($id == null) {
            return response()->json(['error' =>'No Id found.']);
        }
        $subscriber = Subscriber::findOrFail($id);
        if($subscriber->delete()) {
            return response()->json(['success' => "Subscriber deleted successfully."]);
        }
        return response()->json(['error' =>'Error in deleting subscriber.']);
    }

    public function massDelete(Request $request) {
        if($request->input('id') == null) {
            return response()->json(['error' =>'Please select a valid id.']);
        }
        $subscriberIds = $request->input('id');
        $subscriber = Subscriber::whereIn('id', $subscriberIds);
        if($subscriber->delete()) {
            return response()->json(['success' => "Subscriber deleted successfully."]);
        }
        return response()->json(['error' =>'Error in deleting subscriber.']);
    }

    public function export() {
        return Excel::download(new SubscriberExport, 'subscribers.csv');
    }
}
