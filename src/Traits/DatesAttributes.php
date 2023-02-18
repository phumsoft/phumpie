<?php

namespace Phumsoft\Phumpie\Traits;

use DateTimeInterface;

trait DatesAttributes
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
