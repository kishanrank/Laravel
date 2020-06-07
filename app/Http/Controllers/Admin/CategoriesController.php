<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Imports\CategoryImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm mr-3">Edit</button>';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="category_checkbox" class="category_checkbox float-center" value="{{$id}}">')
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        return view('admin.categories.index');
    }

    public function store(Request $request)
    {
        $rules = ['name' => 'required'];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }
        $category_data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ];
        $category = Category::create($category_data);
        if (!$category) {
            return response()->json(['error' => 'Error in Category saving.']);   
        }
        return response()->json(['success' => 'Category added successfully!']);
    }

    public function edit($category)
    {
        if (request()->ajax()) {
            $data = Category::findOrFail($category);
            if ($data == null) {
                return response()->json(['error' => 'No data found for this  category.']);   
            }
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = ['name' => 'required'];
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }
        
        $category_data = [
            'name'    =>  $request->name,
            'slug'     =>  Str::slug($request->name, '-') 
        ];
        $category = Category::whereId($id)->update($category_data);
        if (!$category) {
            return response()->json(['error' => 'Error in updating category.']);
        }
        return response()->json(['success' => 'Category is successfully updated.']);
    }

    public function destroy($id)
    {
        if ($id == null) {
            return response()->json(['error' => 'Invalid id found.']);
        }
        $category = Category::findOrFail($id);
        if (!$category) {
            return response()->json(['error' => 'Category is not deleted.']);
        }
        $category->delete();
        return response()->json(['success' => 'Category is successfully deleted.']);
    }

    public function massDelete(Request $request)
    {
        if ($request->input('id') == null) {
            return response()->json(['error' => 'Please select a valid id.']);
        }
        $categoryIds = $request->input('id');
        $categories = Category::whereIn('id', $categoryIds);
        if ($categories->delete()) {
            return response()->json(['success' => 'Category is successfully deleted.']);
        }
        return response()->json(['error' => 'Please select valid data.']);
    }

    public function saveimport(Request $request)
    {
        request()->validate(['import' => 'required']);
        $import = Excel::import(new CategoryImport, request()->file('import'));
        if($import) {
            return response()->json(['success' => "Data imported successfully"]);
        }
        return response()->json(['error' => "Error in Importing file."]);
    }

    // public function savecsv(Request $request)
    // {
    //     $file = $request->file('import');
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
    //                     "name" => $importData[0],
    //                     "slug" => $importData[1],
    //                 );
    //                 Category::create($insertData);
    //             }
    //             return response()->json(['success' => "Data imported successfully."]);
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
