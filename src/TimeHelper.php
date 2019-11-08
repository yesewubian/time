<?php

namespace Time\src;

class TimeHelper
{
    /**
     * 获取指定时间戳的当天开始日期和结束日期
     * @param int $day 1524127134 时间戳
     *
     * @return array
     */
    public static function rangeOfDay(int $day = 0)
    {
        if (!$day) {
            $day = time();
        }
        $begin = mktime(0, 0, 0, date('m', $day), date('d', $day), date('Y', $day));
        $end = mktime(23, 59, 59, date('m', $day), date('d', $day), date('Y', $day));
        return [$begin, $end];
    }

    /**
     * 获取指定月份的开始日期和结束日期时间戳
     *
     * @param int $year
     * @param int $month
     *
     * @return array
     */
    public static function rangeOfMonth(int $year, int $month): array
    {
        $begin = mktime(0, 0, 0, $month, 1, $year);
        $end = mktime(23, 59, 59, $month, date('t', $begin), $year);
        return [$begin, $end];
    }

    /**
     * 获取指定年份的开始日期和结束日期时间戳
     *
     * @param int $year
     *
     * @return array
     */
    public static function rangeOfYear(int $year): array
    {
        $begin = mktime(0, 0, 0, 1, 1, $year);
        $end = mktime(23, 59, 59, 12, 31, $year);
        return [$begin, $end];
    }

    /**
     * 两个日期的相差天数
     *
     * @param string $day1 2018-03-01
     * @param string $day2 2018-03-29
     *
     * @return int
     */
    public static function differenceDay(string $day1, string $day2): int
    {
        return (int)ceil((strtotime($day2) - strtotime($day1)) / 86400); #相差天数
    }

    /**
     * 返回当天的开时间戳
     *
     * @param int $time
     *
     * @return false|int
     */
    public static function startTimestampOfDay(int $time = 0)
    {
        if (!$time) {
            $time = time();
        }
        return strtotime(date('Y-m-d', $time));
    }

    /**
     * $time 需要格式化的时间戳
     * return 格式化时间
     * @param $time
     * @return bool|string
     */
    public static function time_tran($time)
    {
        $text = '';
        if (!$time) {
            return $text;
        }
        $current = time();
        $t = $current - $time;
        $retArr = array('刚刚', '秒前', '分钟前', '小时前', '天前', '月前', '年前');
        switch ($t) {
            case $t < 0://时间大于当前时间，返回格式化时间
                $text = date('Y-m-d', $time);
                break;
            case $t == 0://刚刚
                $text = $retArr[0];
                break;
            case $t < 60:// 几秒前
                $text = $t . $retArr[1];
                break;
            case $t < 3600://几分钟前
                $text = floor($t / 60) . $retArr[2];
                break;
            case $t < 86400://几小时前
                $text = floor($t / 3600) . $retArr[3];
                break;
            case $t < 2592000: //几天前
                $text = floor($t / 86400) . $retArr[4];
                break;
            case $t < 31536000: //几个月前
                $text = floor($t / 2592000) . $retArr[5];
                break;
            default : //几年前
                $text = floor($t / 31536000) . $retArr[6];
        }
        return $text;
    }
}