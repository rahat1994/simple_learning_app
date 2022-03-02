<?php

namespace App\Http\Requests;

use App\Http\Library\RoleHelpers;
use Illuminate\Foundation\Http\FormRequest;

class ModuleCreationRequest extends FormRequest
{
    use RoleHelpers;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'is_active' => 'boolean',
            'course_id' => 'required|numeric|exists:courses,id'
        ];
    }
}
