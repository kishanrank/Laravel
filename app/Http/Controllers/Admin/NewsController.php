<?php

namespace App\Http\Controllers\Admin;

use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends ResponserController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = News::latest()->get();
            return DataTables::of($data)
                ->addColumn('edit', function ($data) {
                    return '<a class="btn btn-primary btn-sm mr-3"  href="' . route('news.edit', $data->id) . '">Edit</a>';
                })
                ->addColumn('delete', function ($data) {
                    return '<a class="btn btn-danger btn-sm mr-3"  href="' . route('news.destroy', $data->id) . '">Delete</a>';
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '" />';
                })
                ->rawColumns(['edit', 'delete', 'featured'])
                ->make(true);
        }
        return view('admin.news.index');
    }

    public function create()
    {
        return view('admin.news.create',);
    }

    public function store(Request $request)
    {
        $this->validateNewsData();

        if ($request->hasFile('featured')) {
            $file = $request->file('featured');
            $filename = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            $maxFileSize = 204800;
            if ($fileSize <= $maxFileSize) {
                $location = 'uploads/news/featured';
                $file_new_name = date("Y_m_d_h_i_s") . $filename;

                if (!$file->move($location, $file_new_name)) {
                    return back()->with('error', 'Error in uploadig in image, Please try after sometime.');
                }

                $featured = 'uploads/news/featured/' . $file_new_name;
            } else {
                return $this->errorMessageResponse('Please upload file less then 200KB.');
            }
        }

        $news = News::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'info' => $request->info,
            'content' => $request->content,
            'featured' => $featured,
            'slug' => Str::slug($request->title, '-')
        ]);
        if (!$news) {
            return back()->with('error', 'Error in News saving.');
        }
        return redirect(route('news.index'))->with('success', 'News added successfully!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        if (!$news->id) {
            return back()->with('error', 'Data not found.');
        }
        return view('admin.news.edit', ['news' => $news]);
    }

    public function update(Request $request, $id)
    {
        $this->validateNewsData();

        $news = News::findOrFail($id);

        if ($request->hasFile('featured')) {
            $featured = $request->featured;
            $path = public_path($news->featured);
            if (File::exists($path)) {
                File::delete($path);
            }
            $featured_new_name = date("Y_m_d_h_i_s")  . $featured->getClientOriginalName();
            $featured->move('uploads/news/featured', $featured_new_name);
            $news->featured = 'uploads/news/featured/' . $featured_new_name;
        }

        $news->user_id = Auth::user()->id;
        $news->title = $request->title;
        $news->content = $request->content;

        if ($news->save()) {
            return redirect()->route('news.index')->with('success', 'News data successfully updated.');
        }
        return back()->with('error', 'Error in updating data, Please try after sometime.');
    }


    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if (!$news->id) {
            return back()->with('error', 'News is not found.');
        }
        $news->delete();
        return redirect()->route('news.index')->with('error', 'News successfully deleted.');
    }

    protected function validateNewsData()
    {
        return request()->validate(
            [
                'title' => 'required',
                'info' => 'required',
                'content' => 'required'
            ]
        );
    }
}
