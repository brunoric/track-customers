<?php
/**
 * @file
 * Class file of GPS\Calculator.
 *
 * @author: Bruno Ricardo Siqueira <brunoric@gmail.com>
 */

namespace brunoric\GPS;

/**
 * Calculator class.
 *
 * The intent of this class is encapsulate the logic of GPS distance
 * calculation.
 */
class Calculator
{
    const OFFICE_LATITUDE = 53.3381985;
    const OFFICE_LONGITUDE = -6.2592576;
    const MEAN_EARTH_RADIUS = 6371000;

    private $pointOne;
    private $pointTwo;

    public function __construct(Point $pointOne, Point $pointTwo)
    {
        $this->pointOne = $pointOne;
        $this->pointTwo = $pointTwo;
    }

    public function setPoints(Point $pointOne, Point $pointTwo)
    {
        $this->pointOne = $pointOne;
        $this->pointTwo = $pointOne;
    }

    public function getPoints()
    {
        return array($this->pointOne, $this->pointTwo);
    }

    /**
     * Calculates the distance between two geographical points using Haversine's formula.
     */
    public static function calculateDistance($pointOne, $pointTwo)
    {
        if (empty($pointOne) || empty($pointTwo)) {
            throw new \Exception('ERROR! Could not calcule the central angle. Missing points.');
        }

        $p1 = $pointOne;
        $p2 = $pointTwo;

        $r = Calculator::MEAN_EARTH_RADIUS;
        $deltaLat = $p2->lat() - $p1->lat();
        $deltaLon = $p2->lon() - $p2->lon();

        $a = pow(sin($deltaLat / 2), 2) + cos($p1->lat()) * cos($p2->lat()) * pow(sin($deltaLon/2), 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $r * $c;
    }

    /**
     * Calculates the distance between the office and a given geographical point.
     */
    public static function calculateDistanceFromOffice($point)
    {
        $office = new Point(self::OFFICE_LATITUDE, self::OFFICE_LONGITUDE);
        return self::calculateDistance($office, $point);
    }
}
