<?php

namespace Smoren\Reporter\Tests\Unit\Structs;


class ReportType extends \Smoren\Reporter\Structs\ReportType
{
    const ERROR_TEST = 'error_test';
    const WARNING_TEST = 'warning_test';
    const NOTICE_TEST = 'notice_test';

    protected static $map = [
        self::ERROR_UNKNOWN => 'Unknown error',
        self::ERROR_TEST => 'Test error',
        self::WARNING_TEST => 'Test warning',
        self::NOTICE_TEST => 'Test notice',
    ];
}
