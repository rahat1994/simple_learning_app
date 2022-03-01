<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class CategoryValidator.
 *
 * @package namespace App\Validators;
 */
class CategoryValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'required|string'	=>'	title=>required|string',
		'sometimes|min:10'	=>'	content=>sometimes|min:10',
		'numeric'	=>'	parent=>numeric',
	],
        ValidatorInterface::RULE_UPDATE => [
		'required|string'	=>'	title=>required|string',
		'sometimes|min:10'	=>'	content=>sometimes|min:10',
		'numeric'	=>'	parent=>numeric',
	],
    ];
}
