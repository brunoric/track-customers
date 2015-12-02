<?php
/**
 * @file
 * Class file of GPS\Point.
 *
 * @author: Bruno Ricardo Siqueira <brunoric@gmail.com>
 */

namespace brunoric\GPS;

/**
 * Point class.
 *
 * This class represent an geographical point.
 */
class Point
{
    private $latitude;
    private $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Returns the latitude of the point for a given unit of measure.
     *
     * By default returns the converted value in Radians unless when Degrees is
     * explicity setted.
     */
    public function getLatitude($unit = 'radians')
    {
        if ($unit == 'degrees') {
            return $this->latitude;
        }

        return deg2rad($this->latitude);
    }

    /**
     * Alias to getLatitude just to have a cool API. =P
     */
    public function lat($unit = 'radians')
    {
        return $this->getLatitude($unit);
    }

    /**
     * Returns the longitude of the point for a given unit of measure.
     *
     * By default returns the converted value in Radians unless when Degrees is
     * explicity setted.
     */
    public function getLongitude($unit = 'radians')
    {
        if ($unit == 'degrees') {
            return $this->longitude;
        }

        return deg2rad($this->longitude);
    }

    /**
     * Alias to getLongitude just to have a cool API. =P
     */
    public function lon($unit = 'degrees')
    {
        return $this->getLongitude($unit);
    }
}
