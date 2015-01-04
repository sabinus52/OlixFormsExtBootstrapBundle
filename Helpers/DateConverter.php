<?php
/**
 * DateConverter pour la conversion des dates au format ICU.
 *
 *
 * @author Carsten Brandt <mail@cebe.cc>
 * @author Enrica Ruedin <e.ruedin@guggach.com>
 * @see https://github.com/yiisoft/yii2/blob/master/framework/helpers/BaseFormatConverter.php
 * 
 * @author Olivier <sabinus52@gmail.com>
 * 
 * @package Olix
 * @subpackage FormsExtBootstrapBundle
 * 
 */

namespace Olix\FormsExtBootstrapBundle\Helpers;

use IntlDateFormatter;
use Locale;


class DateConverter
{

    static private $_icuShortFormats = [
        'short'  => 3, // IntlDateFormatter::SHORT,
        'medium' => 2, // IntlDateFormatter::MEDIUM,
        'long'   => 1, // IntlDateFormatter::LONG,
        'full'   => 0, // IntlDateFormatter::FULL,
    ];


    /**
     * Return a date format pattern from 
     *  - ICU format
     *  - a string 'short', 'medium', 'long', 'full'
     *  - a integer from class IntlDateFormatter::CONST
     *
     * @link [ICU format]: http://userguide.icu-project.org/formatparse/datetime#TOC-Date-Time-Format-Syntax
     *
     * @param string $pattern date format pattern in ICU format.
     * @param string $type 'date', 'time', or 'datetime'.
     * @param string $locale the locale to use for converting ICU short patterns `short`, `medium`, `long` and `full`.
     * If not given, `%locale%` will be used.
     * @return string The date format pattern.
     */
    static public function getPatternDateIcu($pattern, $type = 'date', $locale = null)
    {
        $formatDateIntl = null;
        
        // If from class IntlDateFormatter
        if (is_int($pattern))
            $formatDateIntl = $pattern;
        
        // If from string 'short', 'medium', 'long', 'full'
        if (isset(self::$_icuShortFormats[$pattern]))
            $formatDateIntl = self::$_icuShortFormats[$pattern];
        
        if ($formatDateIntl) {
            if ($locale === null) {
                $locale = Locale::getDefault();
            }
            if ($type === 'date') {
                $formatter = new IntlDateFormatter($locale, $formatDateIntl, IntlDateFormatter::NONE);
            } elseif ($type === 'time') {
                $formatter = new IntlDateFormatter($locale, IntlDateFormatter::NONE, $formatDateIntl);
            } else {
                $formatter = new IntlDateFormatter($locale, $formatDateIntl, $formatDateIntl);
            }
            $pattern = $formatter->getPattern();
        }
        return $pattern;
    }


    /**
     * Converts a date format pattern from [ICU format][] to [php date() function format][].
     *
     * The conversion is limited to date patterns that do not use escaped characters.
     * Patterns like `d 'of' MMMM yyyy` which will result in a date like `1 of December 2014` may not be converted correctly
     * because of the use of escaped characters.
     *
     * Pattern constructs that are not supported by the PHP format will be removed.
     *
     * @link [php date() function format]: http://php.net/manual/en/function.date.php
     * @link [ICU format]: http://userguide.icu-project.org/formatparse/datetime#TOC-Date-Time-Format-Syntax
     *
     * @param string $pattern date format pattern in ICU format.
     * @param string $type 'date', 'time', or 'datetime'.
     * @param string $locale the locale to use for converting ICU short patterns `short`, `medium`, `long` and `full`.
     * @return string The converted date format pattern.
     */
    static public function convertDateIcuToPhp($pattern, $type = 'date', $locale = null)
    {
        $pattern = self::getPatternDateIcu($pattern, $type, $locale);
        return strtr($pattern, [
            'G' => '',          // era designator like (Anno Domini)
            'Y' => 'o',         // 4digit year of "Week of Year"
            'y' => 'Y',         // 4digit year e.g. 2014
            'yyyy' => 'Y',      // 4digit year e.g. 2014
            'yy' => 'y',        // 2digit year number eg. 14
            'u' => '',          // extended year e.g. 4601
            'U' => '',          // cyclic year name, as in Chinese lunar calendar
            'r' => '',          // related Gregorian year e.g. 1996
            'Q' => '',          // number of quarter
            'QQ' => '',         // number of quarter '02'
            'QQQ' => '',        // quarter 'Q2'
            'QQQQ' => '',       // quarter '2nd quarter'
            'QQQQQ' => '',      // number of quarter '2'
            'q' => '',          // number of Stand Alone quarter
            'qq' => '',         // number of Stand Alone quarter '02'
            'qqq' => '',        // Stand Alone quarter 'Q2'
            'qqqq' => '',       // Stand Alone quarter '2nd quarter'
            'qqqqq' => '',      // number of Stand Alone quarter '2'
            'M' => 'n',         // Numeric representation of a month, without leading zeros
            'MM' => 'm',        // Numeric representation of a month, with leading zeros
            'MMM' => 'M',       // A short textual representation of a month, three letters
            'MMMM' => 'F',      // A full textual representation of a month, such as January or March
            'MMMMM' => '',      //
            'L' => 'm',         // Stand alone month in year
            'LL' => 'm',        // Stand alone month in year
            'LLL' => 'M',       // Stand alone month in year
            'LLLL' => 'F',      // Stand alone month in year
            'LLLLL' => '',      // Stand alone month in year
            'w' => 'W',         // ISO-8601 week number of year
            'ww' => 'W',        // ISO-8601 week number of year
            'W' => '',          // week of the current month
            'd' => 'j',         // day without leading zeros
            'dd' => 'd',        // day with leading zeros
            'D' => 'z',         // day of the year 0 to 365
            'F' => '',          // Day of Week in Month. eg. 2nd Wednesday in July
            'g' => '',          // Modified Julian day. This is different from the conventional Julian day number in two regards.
            'E' => 'D',         // day of week written in short form eg. Sun
            'EE' => 'D',
            'EEE' => 'D',
            'EEEE' => 'l',      // day of week fully written eg. Sunday
            'EEEEE' => '',
            'EEEEEE' => '',
            'e' => 'N',         // ISO-8601 numeric representation of the day of the week 1=Mon to 7=Sun
            'ee' => 'N',        // php 'w' 0=Sun to 6=Sat isn't supported by ICU -> 'w' means week number of year
            'eee' => 'D',
            'eeee' => 'l',
            'eeeee' => '',
            'eeeeee' => '',
            'c' => 'N',         // ISO-8601 numeric representation of the day of the week 1=Mon to 7=Sun
            'cc' => 'N',        // php 'w' 0=Sun to 6=Sat isn't supported by ICU -> 'w' means week number of year
            'ccc' => 'D',
            'cccc' => 'l',
            'ccccc' => '',
            'cccccc' => '',
            'a' => 'a',         // am/pm marker
            'h' => 'g',         // 12-hour format of an hour without leading zeros 1 to 12h
            'hh' => 'h',        // 12-hour format of an hour with leading zeros, 01 to 12 h
            'H' => 'G',         // 24-hour format of an hour without leading zeros 0 to 23h
            'HH' => 'H',        // 24-hour format of an hour with leading zeros, 00 to 23 h
            'k' => '',          // hour in day (1~24)
            'kk' => '',         // hour in day (1~24)
            'K' => '',          // hour in am/pm (0~11)
            'KK' => '',         // hour in am/pm (0~11)
            'm' => 'i',         // Minutes without leading zeros, not supported by php but we fallback
            'mm' => 'i',        // Minutes with leading zeros
            's' => 's',         // Seconds, without leading zeros, not supported by php but we fallback
            'ss' => 's',        // Seconds, with leading zeros
            'S' => '',          // fractional second
            'SS' => '',         // fractional second
            'SSS' => '',        // fractional second
            'SSSS' => '',       // fractional second
            'A' => '',          // milliseconds in day
            'z' => 'T',         // Timezone abbreviation
            'zz' => 'T',        // Timezone abbreviation
            'zzz' => 'T',       // Timezone abbreviation
            'zzzz' => 'T',      // Timzone full name, not supported by php but we fallback
            'Z' => 'O',         // Difference to Greenwich time (GMT) in hours
            'ZZ' => 'O',        // Difference to Greenwich time (GMT) in hours
            'ZZZ' => 'O',       // Difference to Greenwich time (GMT) in hours
            'ZZZZ' => '\G\M\TP', // Time Zone: long localized GMT (=OOOO) e.g. GMT-08:00
            'ZZZZZ' => '',      //  TIme Zone: ISO8601 extended hms? (=XXXXX)
            'O' => '',          // Time Zone: short localized GMT e.g. GMT-8
            'OOOO' => '\G\M\TP', //  Time Zone: long localized GMT (=ZZZZ) e.g. GMT-08:00
            'v' => '\G\M\TP',   // Time Zone: generic non-location (falls back first to VVVV and then to OOOO) using the ICU defined fallback here
            'vvvv' => '\G\M\TP', // Time Zone: generic non-location (falls back first to VVVV and then to OOOO) using the ICU defined fallback here
            'V' => '',          // Time Zone: short time zone ID
            'VV' => 'e',        // Time Zone: long time zone ID
            'VVV' => '',        // Time Zone: time zone exemplar city
            'VVVV' => '\G\M\TP', // Time Zone: generic location (falls back to OOOO) using the ICU defined fallback here
            'X' => '',          // Time Zone: ISO8601 basic hm?, with Z for 0, e.g. -08, +0530, Z
            'XX' => 'O, \Z',    // Time Zone: ISO8601 basic hm, with Z, e.g. -0800, Z
            'XXX' => 'P, \Z',   // Time Zone: ISO8601 extended hm, with Z, e.g. -08:00, Z
            'XXXX' => '',       // Time Zone: ISO8601 basic hms?, with Z, e.g. -0800, -075258, Z
            'XXXXX' => '',      // Time Zone: ISO8601 extended hms?, with Z, e.g. -08:00, -07:52:58, Z
            'x' => '',          // Time Zone: ISO8601 basic hm?, without Z for 0, e.g. -08, +0530
            'xx' => 'O',        // Time Zone: ISO8601 basic hm, without Z, e.g. -0800
            'xxx' => 'P',       // Time Zone: ISO8601 extended hm, without Z, e.g. -08:00
            'xxxx' => '',       // Time Zone: ISO8601 basic hms?, without Z, e.g. -0800, -075258
            'xxxxx' => '',      // Time Zone: ISO8601 extended hms?, without Z, e.g. -08:00, -07:52:58
        ]);
    }


    /**
     * Converts a date format pattern from [ICU format][] to [Widget "bootstrap-datetimepicker" date format][].
     *
     * @link [Widget date format]: http://www.malot.fr/bootstrap-datetimepicker/
     * @link [ICU format]: http://userguide.icu-project.org/formatparse/datetime#TOC-Date-Time-Format-Syntax
     *
     * @param string $pattern date format pattern in ICU format.
     * @param string $type 'date', 'time', or 'datetime'.
     * @param string $locale the locale to use for converting ICU short patterns `short`, `medium`, `long` and `full`.
     * @return string The converted date format pattern.
     */
    public static function convertDateIcuToWdgtBootstapDatetimePicker($pattern, $type = 'date', $locale = null)
    {
        $pattern = self::getPatternDateIcu($pattern, $type, $locale);
        return strtr($pattern, [
            'G' => '',          // era designator like (Anno Domini)
            'Y' => '',          // 4digit year of "Week of Year"
            'y' => 'yyyy',      // 4digit year e.g. 2014
            'yyyy' => 'yyyy',   // 4digit year e.g. 2014
            'yy' => 'y',        // 2digit year number eg. 14
            'u' => '',          // extended year e.g. 4601
            'U' => '',          // cyclic year name, as in Chinese lunar calendar
            'r' => '',          // related Gregorian year e.g. 1996
            'Q' => '',          // number of quarter
            'QQ' => '',         // number of quarter '02'
            'QQQ' => '',        // quarter 'Q2'
            'QQQQ' => '',       // quarter '2nd quarter'
            'QQQQQ' => '',      // number of quarter '2'
            'q' => '',          // number of Stand Alone quarter
            'qq' => '',         // number of Stand Alone quarter '02'
            'qqq' => '',        // Stand Alone quarter 'Q2'
            'qqqq' => '',       // Stand Alone quarter '2nd quarter'
            'qqqqq' => '',      // number of Stand Alone quarter '2'
            'M' => 'm',         // Numeric representation of a month, without leading zeros
            'MM' => 'mm',       // Numeric representation of a month, with leading zeros
            'MMM' => 'M',       // A short textual representation of a month, three letters
            'MMMM' => 'MM',     // A full textual representation of a month, such as January or March
            'MMMMM' => '',      //
            'L' => 'mm',        // Stand alone month in year
            'LL' => 'mm',       // Stand alone month in year
            'LLL' => 'M',       // Stand alone month in year
            'LLLL' => 'MM',     // Stand alone month in year
            'LLLLL' => '',      // Stand alone month in year
            'w' => '',          // ISO-8601 week number of year
            'ww' => '',         // ISO-8601 week number of year
            'W' => '',          // week of the current month
            'd' => 'd',         // day without leading zeros
            'dd' => 'dd',       // day with leading zeros
            'D' => '',          // day of the year 0 to 365
            'F' => '',          // Day of Week in Month. eg. 2nd Wednesday in July
            'g' => '',          // Modified Julian day. This is different from the conventional Julian day number in two regards.
            'E' => '',          // day of week written in short form eg. Sun
            'EE' => '',
            'EEE' => '',
            'EEEE' => '',       // day of week fully written eg. Sunday
            'EEEEE' => '',
            'EEEEEE' => '',
            'e' => '',          // ISO-8601 numeric representation of the day of the week 1=Mon to 7=Sun
            'ee' => '',         // php 'w' 0=Sun to 6=Sat isn't supported by ICU -> 'w' means week number of year
            'eee' => '',
            'eeee' => '',
            'eeeee' => '',
            'eeeeee' => '',
            'c' => '',          // ISO-8601 numeric representation of the day of the week 1=Mon to 7=Sun
            'cc' => '',         // php 'w' 0=Sun to 6=Sat isn't supported by ICU -> 'w' means week number of year
            'ccc' => '',
            'cccc' => '',
            'ccccc' => '',
            'cccccc' => '',
            'a' => 'p',         // am/pm marker
            'h' => 'H',         // 12-hour format of an hour without leading zeros 1 to 12h
            'hh' => 'HH',       // 12-hour format of an hour with leading zeros, 01 to 12 h
            'H' => 'h',         // 24-hour format of an hour without leading zeros 0 to 23h
            'HH' => 'hh',       // 24-hour format of an hour with leading zeros, 00 to 23 h
            'k' => '',          // hour in day (1~24)
            'kk' => '',         // hour in day (1~24)
            'K' => '',          // hour in am/pm (0~11)
            'KK' => '',         // hour in am/pm (0~11)
            'm' => 'i',         // Minutes without leading zeros, not supported by php but we fallback
            'mm' => 'ii',       // Minutes with leading zeros
            's' => 's',         // Seconds, without leading zeros, not supported by php but we fallback
            'ss' => 'ss',       // Seconds, with leading zeros
            'S' => '',          // fractional second
            'SS' => '',         // fractional second
            'SSS' => '',        // fractional second
            'SSSS' => '',       // fractional second
            'A' => '',          // milliseconds in day
            'z' => '',          // Timezone abbreviation
            'zz' => '',         // Timezone abbreviation
            'zzz' => '',        // Timezone abbreviation
            'zzzz' => '',       // Timzone full name, not supported by php but we fallback
            'Z' => '',          // Difference to Greenwich time (GMT) in hours
            'ZZ' => '',         // Difference to Greenwich time (GMT) in hours
            'ZZZ' => '',        // Difference to Greenwich time (GMT) in hours
            'ZZZZ' => '',       // Time Zone: long localized GMT (=OOOO) e.g. GMT-08:00
            'ZZZZZ' => '',      //  TIme Zone: ISO8601 extended hms? (=XXXXX)
            'O' => '',          // Time Zone: short localized GMT e.g. GMT-8
            'OOOO' => '',       //  Time Zone: long localized GMT (=ZZZZ) e.g. GMT-08:00
            'v' => '',          // Time Zone: generic non-location (falls back first to VVVV and then to OOOO) using the ICU defined fallback here
            'vvvv' => '',       // Time Zone: generic non-location (falls back first to VVVV and then to OOOO) using the ICU defined fallback here
            'V' => '',          // Time Zone: short time zone ID
            'VV' => '',         // Time Zone: long time zone ID
            'VVV' => '',        // Time Zone: time zone exemplar city
            'VVVV' => '',       // Time Zone: generic location (falls back to OOOO) using the ICU defined fallback here
            'X' => '',          // Time Zone: ISO8601 basic hm?, with Z for 0, e.g. -08, +0530, Z
            'XX' => '',         // Time Zone: ISO8601 basic hm, with Z, e.g. -0800, Z
            'XXX' => '',        // Time Zone: ISO8601 extended hm, with Z, e.g. -08:00, Z
            'XXXX' => '',       // Time Zone: ISO8601 basic hms?, with Z, e.g. -0800, -075258, Z
            'XXXXX' => '',      // Time Zone: ISO8601 extended hms?, with Z, e.g. -08:00, -07:52:58, Z
            'x' => '',          // Time Zone: ISO8601 basic hm?, without Z for 0, e.g. -08, +0530
            'xx' => '',         // Time Zone: ISO8601 basic hm, without Z, e.g. -0800
            'xxx' => '',        // Time Zone: ISO8601 extended hm, without Z, e.g. -08:00
            'xxxx' => '',       // Time Zone: ISO8601 basic hms?, without Z, e.g. -0800, -075258
            'xxxxx' => '',      // Time Zone: ISO8601 extended hms?, without Z, e.g. -08:00, -07:52:58
        ]);
    }

}