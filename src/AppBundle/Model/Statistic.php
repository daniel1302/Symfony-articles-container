<?php
namespace AppBundle\Model;

class Statistic {
    const   Q1 = 1,
        Q3 = 3;

    const   D1 = 1,
        D2 = 2,
        D3 = 3,
        D4 = 4,
        D5 = 5,
        D6 = 6,
        D7 = 7,
        D8 = 8,
        D9 = 9;

    const   P5  = 1,
        P10 = 2,
        P15 = 3,
        P20 = 4,
        P25 = 5,
        P30 = 6,
        P35 = 7,
        P40 = 8,
        P45 = 9,
        P50 = 10,
        P55 = 11,
        P60 = 12,
        P65 = 13,
        P70 = 14,
        P75 = 15,
        P80 = 16,
        P85 = 17,
        P90 = 18,
        P95 = 19;


    public static function standardDeviation(&$data) {
        $dataCount = count($data);

        if($dataCount > 0) {
            if ((int)$dataCount === 1) {
                return 0;
            }

            $average = array_sum($data)/$dataCount;

            $sum = 0;
            foreach($data as $value) {
                $sum += ($value-$average)*($value-$average);
            }

            return self::magicRound(sqrt($sum/($dataCount-1)));
        }

        return 0;
    }

    public static function median(&$data) {
        return self::calculateStatistic($data);
    }

    public static function decil(&$data, $decil) {
        if ((int)$decil < 1 || (int)$decil > 10) {
            throw new \Exception('Invalid parameter $decil in Statistic');
        }

        return self::calculateStatistic($data, 10, (int)$decil);
    }

    public static function percentile(&$data, $percentil) {
        if ((int)$percentil < 1 || (int)$percentil > 19) {
            throw new \Exception('Invalid parameter $decil in Statistic');
        }

        return self::calculateStatistic($data, 20, (int)$percentil);
    }

    public static function quartil(&$data, $quartil) {
        if ((int)$quartil < 1 || (int)$quartil > 3) {
            throw new \Exception('Invalid parameter $quartil in Statistic');
        }

        return self::calculateStatistic($data, 4, (int)$quartil);
    }

    public static function avg(&$data) {
        if (count($data) < 1) {
            return 0;
        }
        return array_sum($data)/count($data);
    }

    /*
     * data - numeric array
     * median: $divider = 2; $multipler = 1
     * down quartil: $divider = 4; $multipler = 1
     * up quartil: $divider = 4; $multipler = 3
     * down decil: $divider = 10; $multipler = 1
     * up decil: $divider = 10; $multipler = 9
     * percentile 5 $divider = 20; $multiplier = 1
     * percentile 95 $divider = 20; $multiplier = 19
     */
    private static function calculateStatistic(&$data, $divider = 2, $multipler = 1) {
        sort($data);
        $counterData = count($data);
        $halfIndex = ($counterData*$multipler)/(float)$divider;
        $value = 0;

        if($counterData == 0) {
            $value = 0;
        } else {
            if($counterData%$divider == 0) {
                $value = (float)(((float)$data[$halfIndex-1]+(float)$data[$halfIndex])/2.0);
            } else {
                $value = (float)($data[floor($halfIndex)]);
            }
        }

        return $value;
    }

    private static function magicRound($number) {
        return round(round($number, 5), 2);
    }
}
