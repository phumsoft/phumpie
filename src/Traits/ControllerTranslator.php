<?php

namespace Phumsoft\Phumpie\Traits;

use Illuminate\Support\Str;

trait ControllerTranslator
{
    /**
     * The default key translation
     *
     * @var string
     */
    protected string $key = 'modal';

    /**
     * Getter controller name translation.
     *
     * @return array
     */
    protected function getControllerNameTranslation()
    {
        $tableName = $this->repository->getModel()->getTable();

        return ['name' => __($this->key . '.' . Str::camel($tableName))];
    }
}
