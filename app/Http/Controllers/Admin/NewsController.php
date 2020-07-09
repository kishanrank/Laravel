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
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm mr-3">Edit</button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->addColumn('featured', function ($data) {
                    $url = asset($data->featured);
                    return '<img src="' . $url . '"  width="70" height="40" alt="' . $data->title . '" />';
                })
                ->rawColumns(['action', 'featured'])
                ->make(true);
        }
        return view('admin.news.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'info' => 'required',
            'featured' => 'required|image',
            'content' => 'required'
        ];
        
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all());
        }

        $file = $request->file('featured');
        $filename = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $maxFileSize = 204800;
        if ($fileSize <= $maxFileSize) {
            $location = 'uploads/news/featured';
            $file_new_name = date("Y_m_d_h_i_s") . $filename;

            if (!$file->move($location, $file_new_name)) {
                return $this->errorMessageResponse('Error in uploadig in image, Please try after sometime.');
            }

            $featured = 'uploads/news/featured/' . $file_new_name;
        } else {
            return $this->errorMessageResponse('Please upload file less then 200KB.');
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
            return $this->errorMessageResponse('Error in News saving.');
        }
        return $this->successMessageResponse('News added successfully!');
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $news = News::findOrFail($id);
            
            if (!$news->id) {
                return $this->errorMessageResponse('No data found for this id.');
            }
            return response()->json(['result' => $news]);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'info' => 'required',
            'content' => 'required'
        ];

        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all());
        }

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
            return $this->successMessageResponse('News data successfully updated.');
        }
        return $this->errorMessageResponse('Error in updating data, Please try after sometime.');
    }


    public function destroy($id)
    {
        $news = News::findOrFail($id);
        if (!$news->id) {
            return $this->errorMessageResponse('News is not deleted.');
        }
        $news->delete();
        return $this->successMessageResponse('News is successfully deleted.');
    }
}
