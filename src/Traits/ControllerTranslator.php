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
    protected string $transKey = 'modal';

    /**
     * Getter controller name.
     *
     * @return string
     */
    protected function getName()
    {
        $tableName = $this->repository->getModel()->getTable();
        $tableName = Str::singular($tableName);

        return Str::camel($tableName);
    }

    /**
     * Getter controller name with translation.
     *
     * @return array
     */
    protected function getNameTranslation()
    {
        return ['name' => __($this->transKey . '.' . $this->getName())];
    }
}
