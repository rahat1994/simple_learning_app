<?php

namespace App\Http\Requests;

use App\Http\Library\RoleHelpers;
use Illuminate\Foundation\Http\FormRequest;

class UnitDeletionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            //
        ];
    }
}
