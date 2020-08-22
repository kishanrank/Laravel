<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Exports\CategoryExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\ResponserController;
use App\Imports\CategoryImport;
use App\Models\Post;
use App\Repositories\Admin\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CategoriesController extends ResponserController
{
    public $categoryRepository;

    public function __construct(CategoryRepositoryInterface $category)
    {
        $this->categoryRepository = $category;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->categoryRepository->all();
            }
            return view('admin.categories.index');
        } catch (\Throwable $e) {
            return redirect(route('admin.home'))->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function store(Request $request)
    {
        try {
            if ($request->ajax()) {
                $error = Validator::make($request->all(), Category::rules());

                if ($error->fails()) {
                    return $this->errorMessageResponse($error->errors()->all(), 422);
                }

                $this->categoryRepository->store($request->all());

                return $this->successMessageResponse('Category added successfully!');
            }
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function edit($category)
    {
        try {
            if (request()->ajax()) {
                $data = $this->categoryRepository->find($category);
                return response()->json(['result' => $data], 200);
            }
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            if ($request->ajax()) {
                $error = Validator::make($request->all(), Category::rules($category->id));

                if ($error->fails()) {
                    return $this->errorMessageResponse($error->errors()->all(), 422);
                }

                $this->categoryRepository->update($category, $request->all());

                return $this->successMessageResponse('Category is successfully updated.', 200);
            }
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if (request()->ajax()) {
                $this->categoryRepository->destroy($id);

                return $this->successMessageResponse('Category is successfully deleted.', 200);
            }
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function massDelete(Request $request)
    {
        try {
            if ($request->ajax()) {
                if ($request->id == null) { //unprocessble entity
                    return $this->errorMessageResponse('Please select a valid id.', 422);
                }
                $categoryIds = $request->input('id');
                $this->categoryRepository->massDelete($categoryIds);

                return $this->successMessageResponse('Category is successfully deleted.', 200);
            }
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function export()
    {
        try {
            return Excel::download(new CategoryExport, 'categories.xlsx');
        } catch (\Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function saveimport(Request $request)
    {
        try {
            $error = Validator::make($request->all(), ['import' => 'required']);

            if ($error->fails()) {
                return $this->errorMessageResponse($error->errors()->all(), 422);
            }

            $import = Excel::import(new CategoryImport, request()->file('import'));
            if ($import) {
                return $this->successMessageResponse('Data imported successfully.', 200);
            }
            return $this->errorMessageResponse('Error in Importing file.', 404);
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }
}
