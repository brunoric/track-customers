<?php
/**
 * @file
 * Class file of GPS\Customer.
 *
 * @author: Bruno Ricardo Siqueira <brunoric@gmail.com>
 */

namespace brunoric\GPS;

/**
 * Customer class.
 *
 * This class represent a customer.
 */
class Customer
{
    private $userId;
    private $name;
    private $coordinates;
    private $distance;

    public function __construct($userId = null, $name = null, Point $coordinates = null, $distance = null)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->distance = null;
    }

    public function setUserId($userId)
    {
        if (!is_int($userId)) {
            throw new \Exception('ERROR! Could not set the User ID. User ID needs to be an integer.');
        }

        $this->setUserId = $this->userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setCoordinates(Point $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Parses a user from a JSON string.
     */
    public function parseFromJSON($json)
    {
        $userArray = json_decode($json, true);
        if (empty($userArray) ||
            empty($userArray['user_id']) ||
            empty($userArray['name']) ||
            empty($userArray['latitude']) ||
            empty($userArray['longitude'])) {
                return;
        }
        $this->userId = $userArray['user_id'];
        $this->name = $userArray['name'];
        $this->setCoordinates(new Point($userArray['latitude'], $userArray['longitude']));
    }

    /**
     * Parses a user to a JSON string.
     */
    public function parseToJSON()
    {
        $userArray = array(
            'user_id' => $this->userId,
            'name' => $this->name,
            'latitude' => $this->coordinates->lat('degrees'),
            'longitude' => $this->coordinates->lon('degrees'),
        );

        return json_encode($userArray, true);
    }

    public function printCustomerData($full = false)
    {
        echo 'ID: ' . $this->userId . PHP_EOL;
        echo 'Name: ' . $this->name . PHP_EOL;
        if ($full) {
            echo 'Latitude: ' . $this->coordinates->lat('degrees') . ' degrees' . PHP_EOL;
            echo 'Longitude: ' . $this->coordinates->lon('degrees') . ' degrees' . PHP_EOL;
            echo 'Distance from office: ' . $this->distance . ' meters (' . ($this->distance/1000) . ' kilometers)' .PHP_EOL;
        }
        echo '-' . PHP_EOL;
    }
}
