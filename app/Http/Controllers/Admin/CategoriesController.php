<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Exports\CategoryExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponserController;
use App\Imports\CategoryImport;
use App\Post;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends ResponserController
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
        if ($request->ajax()) {
            $error = Validator::make($request->all(), Category::rules());

            if ($error->fails()) {
                return $this->errorMessageResponse($error->errors()->all(), 422);
            }

            $category_data = [
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
                'description' => $request->description
            ];

            $category = Category::create($category_data);
            if (!$category->id) { // if id not found ErrorException type 500 try to get id of non object
                return $this->errorMessageResponse('Error in Category saving.', 500);
            }
            return $this->successMessageResponse('Category added successfully!');
        }
    }

    public function edit($category)
    {
        if (request()->ajax()) {
            $data = Category::findOrFail($category)->only('id', 'name', 'description'); // No query result found for model id like 65, code 404
            if (!$data) {
                return $this->errorMessageResponse('No data found for this category.', 404);
            }
            return response()->json(['result' => $data], 200);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            $error = Validator::make($request->all(), Category::rules());

            if ($error->fails()) {
                return $this->errorMessageResponse($error->errors()->all(), 422);
            }

            $category_data = [
                'name'    =>  $request->name,
                'slug'     =>  Str::slug($request->name, '-'),
                'description' => $request->description
            ];

            // No query result found for model id **65** code 404 if id is invalid
            // queryexception if unknown column in array code 500
            // $category returns  0 or 1 if process success
            $category = Category::whereId($id)->update($category_data); 
            if (!$category) {   
                return $this->errorMessageResponse('Error in updating category.', 404);
            }
            return $this->successMessageResponse('Category is successfully updated.', 200);
        }
    }

    public function destroy($id)
    {
        if (request()->ajax()) {
            $category = Category::findOrFail($id);  // No query results for model [App\\Category] 65 code 404

            if (!$category->id) { // if id not found ErrorException code 500 try to get id of non object
                return $this->errorMessageResponse('Category is not found.', 404);
            }
            
            // $posts = ::whereCategoryId($category->id)->get();
            $posts = $category->posts;
            $category->delete();
            foreach($posts as $post) {
                $post->delete();
            }
            return $this->successMessageResponse('Category is successfully deleted.', 200);
        }
    }

    public function massDelete(Request $request)
    {
        if ($request->ajax()) {
            if ($request->id == null) { //unprocessble entity
                return $this->errorMessageResponse('Please select a valid id.', 422);
            }
    
            $categoryIds = $request->input('id');
            $categories = Category::whereIn('id', $categoryIds);
            $posts = Post::whereIn('category_id', $categoryIds);
            if ($categories->delete()) {
                $posts->delete();
                return $this->successMessageResponse('Category is successfully deleted.', 200);
            }
            return $this->errorMessageResponse('Not able to delete selected category.', 404);
        }
    }

    public function export()
    {
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }

    public function saveimport(Request $request)
    {
        $error = Validator::make($request->all(), ['import' => 'required']);

        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all(), 422);
        }

        $import = Excel::import(new CategoryImport, request()->file('import'));
        if ($import) {
            return $this->successMessageResponse('Data imported successfully.', 200);
        }
        return $this->errorMessageResponse('Error in Importing file.', 404);
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
