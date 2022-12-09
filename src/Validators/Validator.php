<?php

namespace Phumsoft\Phumpie\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

/**
 * Class Validator.
 */
abstract class Validator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [],
    ];

    /**
     * @return array
     */
    public function additionalRules()
    {
        return [];
    }
}
