<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait Responser {

    public function successDataResponse($data, $code=200) {
        return response()->json($data, $code);
    }

    public function successMessageResponse($data, $code=200) {
        return response()->json(['success' => $data, 'code' => $code], $code);
    }

    public function errorMessageResponse($data, $code=400) {
        return response()->json(['error' => $data, 'code' => $code], $code);
    }

    public function showAll(Collection $collection, $code){
        return $this->successDataResponse(['data' => $collection], $code);
    }

    public function showOne(Model $model, $code) {
        return $this->successDataResponse(['data' => $model], $code);
    }
}