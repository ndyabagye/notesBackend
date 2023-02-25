<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotesUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'color' => ['required'],
        ];
    }
}
