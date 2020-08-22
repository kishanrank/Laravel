<?php

namespace App\Traits\Admin\Category\Attribute;

trait CategoryAttributeTrait
{
    public function getActionAttributes($data)
    {
        $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm mr-3"><i class="fa fa-edit"></i></button><button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
        return $button;
    }

    public function getCheckBoxAttribute()
    {
        return '<input type="checkbox" name="category_checkbox" class="category_checkbox float-center" value="{{$id}}">';
    }
}
