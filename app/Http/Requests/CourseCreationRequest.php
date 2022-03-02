<?php

namespace App\Http\Requests;

use App\Http\Library\RoleHelpers;
use Illuminate\Foundation\Http\FormRequest;

class CourseCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use RoleHelpers;
    public function authorize()
    {
        return $this->isSuperAdmin($this->user()) || $this->isAdmin($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|',
            'description' => 'required|string',
            'category_id' => 'numeric',
            'is_active' => 'boolean',
            'price' => 'required',
            'price' => 'required|numeric',
            'currency' => 'required|string',
        ];
    }
}
