<?php
/**
 * @file
 * Class file of GPS\Tracker.
 *
 * @author: Bruno Ricardo Siqueira <brunoric@gmail.com>
 */

namespace brunoric\GPS;

/**
 * Tracker class.
 *
 * This class encapsulates the Tracker logic.
 */
class Tracker
{
    private $customers;

    public function __construct($data, $validJSON = false)
    {
        $this->parseFile($data);
    }

    /**
     * Parses files as the provided schema for the exercise.
     */
    public function parseFile($data)
    {
        $customers = array();
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $data) as $line) {
            if (empty($line)) {
                continue;
            }
            $customer = new Customer();
            $customer->parseFromJSON($line);
            if (!$this->validateParsedCustomer($customer)) {
                continue;
            }
            array_push($customers, $customer);
        }
        $this->customers = $customers;
        $this->howFar();
    }

    /**
     * Validates a parsed customer data.
     */
    public function validateParsedCustomer($customer)
    {
        if (!is_int($customer->getUserId()) ||
            !is_string($customer->getName()) ||
            !is_float($customer->getCoordinates()->lat()) ||
            !is_float($customer->getCoordinates()->lon())) {
                return false;
        }
    }

    /**
     * Calculate customers distances from the office.
     */
    public function howFar()
    {
        foreach ($this->customers as $customer) {
            $customer->setDistance(
                Calculator::calculateDistanceFromOffice($customer->getCoordinates())
            );
        }
    }

    /**
     * Returns customers whithin the given distance from the office.
     */
    public function getCustomersWithin($distance, $print = false)
    {
        $filteredCustomers = array();
        foreach ($this->customers as $customer) {
            if ($customer->getDistance() > $distance) {
                continue;
            }

            array_push($filteredCustomers, $customer);
            $customer->printCustomerData(true);
        }
    }
}
