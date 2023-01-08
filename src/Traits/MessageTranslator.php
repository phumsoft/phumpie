<?php

namespace Phumsoft\Phumpie\Traits;

trait MessageTranslator
{
    /**
     * Get the message key.
     *
     * @return string
     */
    protected function getMessageTransKey()
    {
        return trans()->has('vendor/phumpie.message') ? 'vendor/phumpie.message' : 'phumpie::message';
    }
}
