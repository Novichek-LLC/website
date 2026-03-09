<?php

namespace App\Nova;

use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    public static $globallySearchable = true;

    public static function label()
    {
        return __(parent::label());
    }
}
