<?php

namespace App\Utility;

use DateInterval;
use DatePeriod;

class DateUtils
{
    public static function dateToISO8601($date, $dateFormat = 'Y-m-d')
    {
        if (empty($date)) {
            return;
        }
        if ($date instanceof \DateTime) {
            $result = $date->format(\DateTime::ISO8601);
        } else {
            $dateNew = \DateTime::createFromFormat($dateFormat, $date);
            if ($dateNew && $dateNew->format($dateFormat) == $date) {
                $result = $dateNew->format(\DateTime::ISO8601);
            } else {
                $result = $date;
            }
        }
        if ($result === '0000-00-00' or $result === '0000-00-00 00:00:00') {
            return;
        }

        return $result;
    }

    public static function convertStringToDateTime($date, $format = 'Y-m-d')
    {
        if (!empty($date)) {
            if ($date instanceof \DateTime) {
                return $date;
            }
            $dateNew = \DateTime::createFromFormat($format, $date);
            if ($dateNew && $dateNew->format($format) == $date) {
                return $dateNew;
            }

            return $date;
        }

        return;
    }

    public static function convertDateTimeToString($date, $format = 'Y-m-d')
    {
        if ($date instanceof \DateTime) {
            return $date->format($format);
        }

        return $date;
    }

    public static function timeString($time, $format = 'Y-m-d')
    {
        return (new \DateTime($time))->format($format);
    }
}
