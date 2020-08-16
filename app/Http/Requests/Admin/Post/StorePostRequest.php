<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:512|unique:posts,title',
            'featured' => 'required|mimes:jpeg,jpg,png,gif|dimensions:max_width=4096,max_height=4096',
            'info' => 'required|min:25',
            'content' => 'required|min:100',
            'category_id' => 'required',
            'tags' => 'required',
            'images' => 'sometimes',
            'meta_title' => 'required|min:10',
            'meta_description' => 'required|min:10'
        ];
    }
}
