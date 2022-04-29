<?php


namespace Smoren\Reporter\Base;


abstract class BaseMap
{
    protected static $map = [];

    public static function getTitle(string $type): string
    {
        return static::$map[$type];
    }
}
