<?php

namespace Phumsoft\Phumpie\Traits;

trait MessageTranslator
{
    /**
     * The default key translation
     *
     * @var string
     */
    private string $key = 'phumpie::message';

    /**
     * Get the message key.
     *
     * @return string
     */
    protected function getMessageKey()
    {
        return trans()->has('vendor/phumpie.message') ? 'vendor/phumpie.message' : $this->key;
    }
}
