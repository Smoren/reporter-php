<?php


namespace Smoren\Reporter\Structs;


use Smoren\Reporter\Base\BaseMap;

class ReportType extends BaseMap
{
    const ERROR_UNKNOWN = 'error_unknown';

    protected static $map = [
        self::ERROR_UNKNOWN => 'Unknown error',
    ];
}
