<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' =>['required','min:3',Rule::unique('posts', 'title')->ignore($this->title,'title')],
            'description' => 'required|min:10',
            'photo' => 'required|image|mimes:jpg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is Required',
            'title.min' => 'Title minimum lenght is 3',
            'description.required' => 'Description is Required',
            'description.min' => 'Description minimum lenght is 10',
        ];
    }
}
