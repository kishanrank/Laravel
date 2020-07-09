<?php

namespace App\Http\Controllers\Admin;
use App\Category;
use App\Exports\CategoryExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponserController;
use App\Imports\CategoryImport;
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
        $error = Validator::make($request->all(), ['name' => 'required']);

        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all());
        }

        $category_data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-')
        ];

        $category = Category::create($category_data);

        if (!$category->id) {
            return $this->errorMessageResponse('Error in Category saving.');
        }
        return $this->successMessageResponse('Category added successfully!');
    }

    public function edit($category)
    {
        if (request()->ajax()) {
            $data = Category::findOrFail($category);
            if (!$data->id) {
                return $this->errorMessageResponse('No data found for this  category.');
            }
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request, $id)
    {
        $error = Validator::make($request->all(), ['name' => 'required']);
        
        if ($error->fails()) {
            return response()->json(['error' => $error->errors()->all()]);
        }
        
        $category_data = [
            'name'    =>  $request->name,
            'slug'     =>  Str::slug($request->name, '-') 
        ];

        $category = Category::whereId($id)->update($category_data);  // returns 0 or 1.

        if (!$category) {   // $category is 0 or 1
            return $this->errorMessageResponse('Error in updating category.');
        }
        return $this->successMessageResponse('Category is successfully updated.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if (!$category->id) {
            return $this->errorMessageResponse('Category is not found.');
        }

        $category->delete();
        return $this->successMessageResponse('Category is successfully deleted.');
    }

    public function massDelete(Request $request)
    {
        if ($request->input('id') == null) {
            return $this->errorMessageResponse('Please select a valid id.');
        }

        $categoryIds = $request->input('id');
        $categories = Category::whereIn('id', $categoryIds);

        if ($categories->delete()) {
            return $this->successMessageResponse('Category is successfully deleted.');
        }

        return $this->errorMessageResponse('Please select a valid id.');
    }

    public function export()
    {
        return Excel::download(new CategoryExport , 'categories.xlsx');
    }

    public function saveimport(Request $request)
    {
        $rules = ['import' => 'required'];
        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return $this->errorMessageResponse($error->errors()->all());
        }
        
        $import = Excel::import(new CategoryImport, request()->file('import'));
        if($import) {
            return $this->successMessageResponse('Data imported successfully.');
        }
        return $this->errorMessageResponse('Error in Importing file.');
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
