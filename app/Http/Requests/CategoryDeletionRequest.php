<?php

namespace App\Http\Requests;

use App\Http\Library\RoleHelpers;
use Illuminate\Foundation\Http\FormRequest;

class CategoryDeletionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use RoleHelpers;
    public function authorize()
    {
        return $this->isSuperAdmin($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
