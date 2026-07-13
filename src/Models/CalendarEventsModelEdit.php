<?php

namespace DanielGausi\CalendarEditorBundle\Models;

use Contao\CalendarEventsModel;
use Contao\Date;

class CalendarEventsModelEdit extends CalendarEventsModel
{
    public static function findByIdOrAlias($ids, array $options = []): ?CalendarEventsModel
    {
        $t = static::$strTable;
        $arrColumns = !is_numeric($ids) ? ["$t.alias=?"] : ["$t.id=?"];
        $arrValues = [$ids];

        if (!static::isPreviewMode($options)) {
            $time = Date::floorToMinute();
            $arrColumns[] = "($t.start='' OR $t.start<=?) AND ($t.stop='' OR $t.stop>?)";
            $arrValues[] = $time;
            $arrValues[] = $time + 60;
        }

        return static::findOneBy($arrColumns, $arrValues, $options);
    }

}
