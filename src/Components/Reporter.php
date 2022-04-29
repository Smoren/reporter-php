<?php


namespace Smoren\Reporter\Components;


class Reporter extends ReportCollector
{
    /**
     * @var Reporter
     */
    protected static $instance;

    /**
     * @return Reporter
     */
    public static function gi(): self
    {
        if(static::$instance === null) {
            static::$instance = new Reporter();
        }

        return static::$instance;
    }

    /**
     * Reporter constructor.
     */
    protected function __construct()
    {
    }
}