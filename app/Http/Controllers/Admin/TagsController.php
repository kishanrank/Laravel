<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TagsExport;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponserController;
use App\Imports\TagsImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TagsController extends ResponserController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Tag::latest()->get(['id','tag', 'slug']);
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm mr-3"><i class="fa fa-edit"></i></button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
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
        $error = Validator::make($request->all(), Tag::rules());

        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all(), 422);
        }

        $tags = Tag::all()->pluck('tag')->toArray();

        if (in_array($request->tag, $tags)) {
            return $this->errorMessageResponse('This tag is already available.');
            // return response()->json(['error' => 'This tag is already available.']);
        }

        $tag_data = [
            'tag' => $request->tag,
            'slug' => Str::slug($request->tag, '-'),
            'description' => $request->description
        ];

        $tag = Tag::create($tag_data);

        if (!$tag->id) {
            return $this->errorMessageResponse('Error in saving Tag.', 422);
        }
        return $this->successMessageResponse('Data added successfully.', 200);
    }

    public function edit($tag)
    {
        if (request()->ajax()) {
            $data = Tag::findOrFail($tag)->only('id', 'tag', 'description');

            if ($data == null) {
                return $this->errorMessageResponse('No Tag found for this Id.', 404);
            }

            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, $id)
    {

        $error = Validator::make($request->all(), Tag::rules());

        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all(), 422);
        }

        $tag_data = [
            'tag'    =>  $request->tag,
            'slug'     =>  Str::slug($request->tag, '-'),
            'description' => $request->description
        ];

        $tag = Tag::whereId($id)->update($tag_data);
        if (!$tag) { // here $tag returns 0 or 1
            return $this->errorMessageResponse('Error in updating tag data.', 409);
        }

        return $this->successMessageResponse('Tag is successfully updated', 200);
    }

    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);

        if ($tag->delete()) {
            return $this->successMessageResponse('Tag is successfully deleted', 200);
        }

        return $this->errorMessageResponse('Tag is not deleted.', 422);
    }

    public function massDelete(Request $request)
    {
        if ($request->input('id') == null) {
            return $this->errorMessageResponse('Please select a valid id.', 200);
        }

        $tagIds = $request->input('id');
        $tags = Tag::whereIn('id', $tagIds);

        if ($tags->delete()) {
            return $this->successMessageResponse('Tag is successfully deleted', 200);
        }
        return $this->errorMessageResponse('Tag is not deleted.', 422);
    }

    public function export()
    {
        return Excel::download(new TagsExport, 'tags.xlsx');
    }

    public function saveimport(Request $request)
    {
        $rules = ['import' => 'required'];
        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all());
        }

        $import = Excel::import(new TagsImport, request()->file('import'));
        if ($import) {
            return $this->successMessageResponse('Data imported successfully', 200);
        }
        return $this->errorMessageResponse('Error in Importing file.', 200); //422
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

    // public function csvToArray($filepath)
    // {
    //     $file = fopen($filepath, "r");
    //     $data_arr = [];
    //     $i = 0;
    //     while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
    //         $num = count($filedata);
    //         if ($i == 0) {
    //             $i++;
    //             continue;
    //         }
    //         for ($c = 0; $c < $num; $c++) {
    //             $data_arr[$i][] = $filedata[$c];
    //         }
    //         $i++;
    //     }
    //     fclose($file);
    //     return $data_arr;
    // }
}
