<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TagsExport;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Imports\TagsImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tag::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm mr-3">Edit</button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="tag_checkbox" class="tag_checkbox float-center" value="{{$id}}">')
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('admin.tags.index');
    }

    public function store(Request $request)
    {
        $rules = ['tag' => 'required'];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }
        $tag_data = [
            'tag' => $request->tag,
            'slug' => Str::slug($request->tag, '-')
        ];
        $tag = Tag::create($tag_data);
        if (!$tag) {
            return response()->json(['error' => 'Error in saving Tag.']);
        }
        return response()->json(['success' => 'Data added successfully.']);
    }

    public function edit($tag)
    {
        if (request()->ajax()) {
            $data = Tag::findOrFail($tag);
            if ($data == null) {
                return response()->json(['error' => 'No Tag found for this Id.']);
            }
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = ['tag' => 'required'];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }
        $tag_data = [
            'tag'    =>  $request->tag,
            'slug'     =>  Str::slug($request->tag, '-')
        ];
        $tag = Tag::whereId($id)->update($tag_data);
        if (!$tag) {
            return response()->json(['error' => 'Error in updating tag data.']);
        }
        return response()->json(['success' => 'Tag is successfully updated']);
    }

    public function destroy($id)
    {
        if ($id == null) {
            return response()->json(['error' => 'Invalid id found.']);
        }
        $tag = Tag::findOrFail($id);
        if ($tag->delete()) {
            return response()->json(['success' => 'Tag is successfully deleted.']);
        }
        return response()->json(['error' => 'Tag is not deleted.']);
    }

    public function massDelete(Request $request)
    {
        if ($request->input('id') == null) {
            return response()->json(['error' => 'Please select a valid id.']);
        }
        $tagIds = $request->input('id');
        $tags = Tag::whereIn('id', $tagIds);
        if ($tags->delete()) {
            return response()->json(['success' => 'Tag is successfully deleted.']);
        }
        return response()->json(['error' => 'Please select valid data.']);
    }

    public function export()
    {
        return Excel::download(new TagsExport, 'tags.xlsx');
    }

    public function saveimport(Request $request)
    {
        request()->validate(['import' => 'required']);
        $import = Excel::import(new TagsImport, request()->file('import'));
        if($import) {
            return response()->json(['success' => "Data imported successfully"]);
        }
        return response()->json(['error' => "Error in Importing file."]);
    }

    // public function savecsv(Request $request)
    // {
    //     $file = $request->file('import');
    //     if (!$file) {
    //         return response()->json(['error' => "Please select a file first."]);
    //     }
    //     $filename = $file->getClientOriginalName();
    //     $extension = $file->getClientOriginalExtension();
    //     $fileSize = $file->getSize();

    //     $valid_extension = array('csv');
    //     $maxFileSize = 2097152;

    //     if (in_array(strtolower($extension), $valid_extension)) {
    //         if ($fileSize <= $maxFileSize) {
    //             $location = 'uploads/csv';
    //             $file_new_name = time() . $filename;
    //             $file->move($location, $file_new_name);
    //             $filepath = public_path($location . "/" . $file_new_name);
    //             $data = $this->csvToArray($filepath);
    //             foreach ($data as $importData) {
    //                 $insertData = array(
    //                     "tag" => $importData[0],
    //                     "slug" => $importData[1],
    //                 );
    //                 Tag::create($insertData);
    //             }
    //             return response()->json(['success' => "Data imported successfully"]);
    //         } else {
    //             return response()->json(['error' => "Please upload file less then 2MB."]);
    //         }
    //     } else {
    //         return response()->json(['error' => "Please upload valid CSV file type."]);
    //     }
    // }

    public function csvToArray($filepath)
    {
        $file = fopen($filepath, "r");
        $data_arr = [];
        $i = 0;
        while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($filedata);
            if ($i == 0) {
                $i++;
                continue;
            }
            for ($c = 0; $c < $num; $c++) {
                $data_arr[$i][] = $filedata[$c];
            }
            $i++;
        }
        fclose($file);
        return $data_arr;
    }
}
