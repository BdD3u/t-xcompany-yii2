<?php
namespace common\components;


class TimeHelper
{
    public static function datetimeToTime($value): ?int
    {
        return !is_int($value) && ($res = strtotime($value)) ? $res : null;
    }
}