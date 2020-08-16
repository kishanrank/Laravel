<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\ResponserController;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PublishedController extends ResponserController
{
    public function published(Request $request)
    {
        if ($request->ajax()) {
            $data = News::latest()->wherePublished(1)->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-primary btn-sm mr-3"  href="' . route('news.edit', $data->id) . '"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-sm mr-3"  href="' . route('news.destroy', $data->id) . '"><i class="fa fa-trash"></i></a>';
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '" />';
                })
                ->rawColumns(['action', 'featured'])
                ->make(true);
        }
        return view('admin.news.published');
    }

    public function publishNews($id)
    {
        if (Auth::guard('admin')->user()->id != 1) {
            return redirect()->route('news.index')->with($this->setNotification('You do not have permission to publish news.', 'error'));
        }

        $news = News::findOrFail($id);
        if (!$news->id) {
            return redirect(route('news.index'))->with($this->setNotification('No data found.', 'error'));
        }

        $news->published = News::PUBLISHED;
        $news->published_at = Carbon::now();

        if ($news->save()) {
            return redirect()->route('news.index')->with($this->setNotification('News has been successfully published.', 'success'));
        }
    }

    public function unPublishNews($id)
    {
        if (Auth::guard('admin')->user()->id != 1) {
            return redirect()->route('news.index')->with($this->setNotification('You do not have permission to publish news.', 'error'));
        }

        $news = News::findOrFail($id);
        if (!$news->id) {
            return redirect(route('news.index'))->with($this->setNotification('You do not have permission to publish news.', 'error'));
        }

        $news->published = News::NOT_PUBLISHED;
        $news->published_at = NULL;

        if ($news->save()) {
            return redirect()->route('news.index')->with($this->setNotification('News has been successfully published.', 'success'));
        }
    }
}
