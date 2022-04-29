<?php


namespace Smoren\Reporter\Structs;


use Smoren\Reporter\Base\BaseMap;

class ReportLevel extends BaseMap
{
    const NOTICE = 'notice';
    const WARNING = 'warning';
    const ERROR = 'error';

    protected static $map = [
        self::NOTICE => 'Notices',
        self::WARNING => 'Warnings',
        self::ERROR => 'Errors',
    ];
}
