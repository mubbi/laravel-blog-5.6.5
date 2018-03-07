<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
            'title' => 'bail|required|unique:blogs|max:60',
            'excerpt' => 'required|max:280',
            'description' => 'required',
            'image' => 'required|file|image|max:2048|mimes:jpg,jpeg,bmp,png,gif',
            'categories' => 'required|array',
            'user_id' => 'required|integer|exists:users,id',
            'is_active' => 'required|boolean',
            'allow_comments' => 'required|boolean',
        ];
    }
}
