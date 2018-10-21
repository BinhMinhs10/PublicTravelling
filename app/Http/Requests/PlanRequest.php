<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            // 'description' => 'required|string|max:255',
            'description' => 'required|string',
            'member' => 'required|integer|min:1',
            'cover' => 'image|max:5120',
            'routesPlan' => 'required|json|min:1',
        ];
    }

    public function messages()
    {
        return [
            'member.min' => 'Your plan must have at least 1 member!',
            'routesPlan.min' => 'Your plan must have at least 1 route!',
        ];        
    }
}
