<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\ResponserController;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class TrashedController extends ResponserController
{
    public function trashed(Request $request)
    {
        if ($request->ajax()) {
            $data = News::onlyTrashed()->get();
            return DataTables::of($data)
                ->addColumn('restore', function ($data) {
                    return '<a class="btn btn-primary btn-sm mr-3"  href="' . route('news.restore', $data->id) . '">Restore</a>';
                })
                ->addColumn('delete', function ($data) {
                    return '<a class="btn btn-danger btn-sm mr-3"  href="' . route('news.kill', $data->id) . '">Permanent Delete</a>';
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '"" />';
                })
                ->rawColumns(['restore', 'delete', 'featured'])
                ->make(true);
        }
        return view('admin.news.trashed');
    }

    public function kill($id) //forcedelete
    {
        $news = News::withTrashed()->whereId($id)->first();
        if (!$news->id) {
            return redirect()->back()->with($this->setNotification('Error in deleting News.', 'error'));
        }

        if (File::exists(public_path($news->featured))) {
            unlink(public_path($news->featured));
        }

        $news->forceDelete();

        return redirect()->back()->with($this->setNotification('Post deleted permanently.', 'success'));
    }

    public function restore($id)
    {
        $news = News::withTrashed()->whereId($id)->first()->restore();

        if ($news == null) {
            return back()->with($this->setNotification('Error in restoring News.', 'error'));
        }
        return redirect()->back()->with($this->setNotification('News Restored successfully.', 'success'));
    }
}
