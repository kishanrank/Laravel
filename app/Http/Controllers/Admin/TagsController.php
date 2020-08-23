<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TagsExport;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\ResponserController;
use App\Imports\TagsImport;
use App\Repositories\Admin\Tag\TagRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TagsController extends ResponserController
{
    public $tagRepository;

    public function __construct(TagRepositoryInterface $tag)
    {
        $this->tagRepository = $tag;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->tagRepository->all();
            }
            return view('admin.tags.index');
        } catch (\Throwable $e) {
            return redirect(route('admin.home'))->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function store(Request $request)
    {
        try {
            $error = Validator::make($request->all(), Tag::rules());

            if ($error->fails()) {
                return $this->errorMessageResponse($error->errors()->all(), 422);
            }

            $result = $this->tagRepository->store($request->all());

            return $this->successMessageResponse('Data added successfully.', 200);
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function edit($tag)
    {
        try {
            if (request()->ajax()) {
                $data = $this->tagRepository->find($tag);

                return response()->json(['result' => $data]);
            }
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function update(Request $request, Tag $tag)
    {
        try {
            $error = Validator::make($request->all(), Tag::rules());

            if ($error->fails()) {
                return $this->errorMessageResponse($error->errors()->all(), 422);
            }

            $this->tagRepository->update($tag, $request->all());

            return $this->successMessageResponse('Tag is successfully updated', 200);
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->tagRepository->destroy($id);

            return $this->successMessageResponse('Tag is successfully deleted', 200);
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function massDelete(Request $request)
    {
        try {
            if ($request->input('id') == null) {
                return $this->errorMessageResponse('Please select a valid id.', 200);
            }
            $tagIds = $request->input('id');
            $this->tagRepository->massDelete($tagIds);

            return $this->successMessageResponse('Tag is successfully deleted', 200);
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }

    public function export()
    {
        try {
            return Excel::download(new TagsExport, 'tags.xlsx');
        } catch (\Throwable $e) {
            return back()->with($this->setNotification($e->getMessage(), 'error'));
        }
    }

    public function saveimport(Request $request)
    {
        try {
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
        } catch (\Throwable $e) {
            return $this->errorMessageResponse($e->getMessage());
        }
    }
}
