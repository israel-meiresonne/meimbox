<?php
require_once 'model/tools-management/Address.php';

/**
 * This class represente an address used as delivery address in an order
 */
class AddressDelivery extends Address
{
    public function __construct()
    {
    }
    // /**
    //  * To create and save a new delivery address
    //  * @param Response $response to push in results or accured error
    //  * @param Address $addess Client's delivery address for this order
    //  * @param string $orderID the id of the order for with the BasketOrderd is for
    //  */
    // public function create(Response $response, Address $address, $orderID)
    // {
    //     $this->address = $address->getAddress();
    //     $this->appartement = $address->getAppartement();
    //     $this->province = $address->getProvince();
    //     $this->zipcode = $address->getZipcode();
    //     $this->city = $address->getCity();
    //     $this->country = $address->getCountry();
    //     $this->phone = $address->getPhone();
    //     $this->setDate = $address->getSetDate();
    //     // $response = new Response();
    //     $this->insertDelivery($response, $orderID);
    // }

    // /*———————————————————————————— SCRUD DOWN —————————————————————————————————————————*/

    // /**
    //  * To insert a new address
    //  * @param Response $response to push in result or accured error
    //  * @param string $orderID the id of the order for with the BasketOrderd is for
    //  */
    // private function insertDelivery(Response $response, $orderID)
    // {
    //     $bracket = "(?,?,?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
    //     $sql = "INSERT INTO `Orders-Addresses`(`orderId`, `address`, `zipcode`, `country_`, `appartement`, `province`, `city`, `phoneNumber`, `setDate`)
    //             VALUES " . $this->buildBracketInsert(1, $bracket);
    //     $values = [
    //         $orderID,
    //         $this->getAddress(),
    //         $this->getZipcode(),
    //         $this->getCountry()->getCountryName(),
    //         $this->getAppartement(),
    //         $this->getProvince(),
    //         $this->getCity(),
    //         $this->getPhone(),
    //         $this->getSetDate(),
    //     ];
    //     $this->insert($response, $sql, $values);
    // }
}
