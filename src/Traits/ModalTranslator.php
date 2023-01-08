<?php

namespace Phumsoft\Phumpie\Traits;

use Illuminate\Support\Str;

trait ModalTranslator
{
    /**
     * The default key translation
     *
     * @var string
     */
    private string $key = 'phumpie::modal';

    /**
     * Get the controller key.
     *
     * @return array
     */
    protected function getModalKey()
    {
        return trans()->has('vendor/phumpie.modal') ? 'vendor/phumpie.modal' : $this->key;
    }

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
        return ['name' => __($this->getModalKey() . '.' . $this->getName())];
    }
}
