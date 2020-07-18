<?php

namespace App\Http\Controllers\Admin;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponserController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends ResponserController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = News::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    return '<a class="btn btn-primary btn-sm mr-3"  href="' . route('news.edit', $data->id) . '"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-sm mr-3"  href="' . route('news.destroy', $data->id) . '"><i class="fa fa-trash"></i></a>';
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '" />';
                })
                ->addColumn('upload', function ($data) {
                    if ($data->published == 0) {
                        return '<a class="btn btn-success btn-sm mr-3"  href="' . route('news.make.published', $data->id) . '"><i class="fas fa-share-square"> Publish</i></a>';
                    }
                    return '<a class="btn btn-danger btn-sm mr-3"  href="' . route('news.make.unpublished', $data->id) . '"><i class="fa fa-undo"> Un Publish</i></a>';
                })
                ->rawColumns(['action', 'featured', 'upload'])
                ->make(true);
        }
        return view('admin.news.index');
    }

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

    public function publishNews($id)
    {
        if (Auth::user()->id != 1) {
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
        if (Auth::user()->id != 1) {
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


    public function create()
    {
        return view('admin.news.create',);
    }

    public function store(Request $request)
    {
        $this->validate($request, News::rules(0, ['featured' => 'required|image'])); // 0== id not required

        if ($request->hasFile('featured')) {
            $file = $request->file('featured');
            $filename = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            $maxFileSize = 204800;
            if ($fileSize <= $maxFileSize) {
                $file_new_name = date("Y_m_d_h_i_s") . $filename;

                if (!$file->move(News::NEWS_FEATURED_PATH, $file_new_name)) {
                    return back()->with($this->setNotification('Error in uploadig in image, Please try after sometime.', 'error'));
                }

                $featured = News::NEWS_FEATURED_PATH . $file_new_name;
            } else {
                return back()->with($this->setNotification('Please upload file less then 200KB.', 'error'));
            }
        }

        $news = News::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'info' => $request->info,
            'content' => $request->content,
            'featured' => $featured,
            'slug' => Str::slug($request->title, '-'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description
        ]);

        if (!$news) {
            return redirect()->route('news.create')->with($this->setNotification('Error in News saving.', 'error'));
        }
        return redirect(route('news.index'))->with($this->setNotification('News saved successfully.', 'success'));
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        if (!$news->id) {
            return redirect()->route('news.index')->with($this->setNotification('Data not found.', 'error'));
        }
        return view('admin.news.edit', ['news' => $news]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, News::rules($id));

        $news = News::findOrFail($id);

        if ($request->hasFile('featured')) {
            $featured = $request->featured;
            $path = public_path($news->featured);
            if (File::exists($path)) {
                File::delete($path);
            }
            $featured_new_name = date("Y_m_d_h_i_s")  . $featured->getClientOriginalName();
            $featured->move(News::NEWS_FEATURED_PATH, $featured_new_name);
            $news->featured = News::NEWS_FEATURED_PATH . $featured_new_name;
        }

        $news->user_id = Auth::user()->id;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;

        if ($news->save()) {
            return redirect()->route('news.index')->with($this->setNotification('News data successfully updated.', 'success'));
        }
        return redirect(route('news.index'))->with($this->setNotification('Error in updating data, Please try after sometime.', 'error'));
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if (!$news->id) {
            return redirect(route('news.index'))->with($this->setNotification('News is not found.', 'error'));
        }
        $news->delete();
        return redirect()->route('news.index')->with($this->setNotification('News is successfully deleted.', 'success'));
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

    public function show($id)
    {
    }
}
