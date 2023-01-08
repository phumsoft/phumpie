<?php

namespace Phumsoft\Phumpie\Traits;

use Illuminate\Support\Str;

trait ModalTranslator
{
    /**
     * Get the modal translation key.
     *
     * @return array
     */
    protected function getModalTransKey()
    {
        return 'modal';
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
     * Getter modal name with translation.
     *
     * @return array
     */
    protected function getNameTrans()
    {
        return ['name' => __($this->getModalTransKey() . '.' . $this->getName())];
    }
}
