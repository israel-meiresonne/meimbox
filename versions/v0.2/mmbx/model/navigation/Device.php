<?php
require_once 'model/ModelFunctionality.php';
require_once 'vendor/autoload.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;



class Device extends ModelFunctionality
{
    /**
     * @var string
     */
    private $setDate;

    /**
     * Holds all data detected
     * @var Map all data returned by the DeviceDetector
     */
    private $deviceDatas;

    /**
     * Value returned by SEVER["HTTP_USER_AGENT]
     * @var string
     */
    private $userAgent;

    /**
     * Show if the device is a bot
     * @var boolean Set true if is a bot else false
     */
    private $isBot;

    /**
     * Holds data about the bot
     * @var string
     */
    private $botInfo;

    /**
     * Holds the name of the device's the operating system
     * @var string
     */
    private $osName;

    /**
     * Holds the version of device's operating system
     * @var string
     */
    private $osVersion;

    /**
     * Holds the plateform of the device
     * @var string
     */
    private $osPlateform;

    /**
     * Holds driver type like browser, mediaplayer etc...
     * @var string
     */
    private $driverType;

    /**
     * Holds the name of the driver used like Google Chrome, Safary, FireFox, etc...
     * @var string
     */
    private $driverName;

    /**
     * Holds the version of the driver used
     * @var string
     */
    private $driverVersion;

    /**
     * Holds the engine witch drive the driver
     * @var string
     */
    private $driverEngine;

    /**
     * @var string
     */
    private $driverEngineVersion;

    /**
     * Holds the type of device used like desktop, phone, watch, TV etc...
     * @var string
     */
    private $deviceType;

    /**
     * Holds the brand of the device
     * @var string
     */
    private $deviceBrand;

    /**
     * Holds the model of the device like Iphone, Galaxy 5, Pixel 2.
     * Note that for IOS device it will alway holds "Iphone" as model
     * @var string
     */
    private $deviceModel;

    /**
     * Constructor
     */
    public function __construct()
    {
        AbstractDeviceParser::setVersionTruncation(AbstractDeviceParser::VERSION_TRUNCATION_NONE);
        $this->userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
        $dd = new DeviceDetector($this->userAgent);
        $dd->parse();

        $this->setDate = $this->getDateTime();

        $this->isBot = $dd->isBot();
        if ($this->isBot) {
            // handle bots,spiders,crawlers,...
            $this->botInfo = $dd->getBot();
        } else {
            $os = $dd->getOs();
            $this->osName = strtolower($os["name"]);
            $this->osVersion = strtolower($os["version"]);
            $this->osPlateform = strtolower($os["platform"]);

            $clientInfo = $dd->getClient(); // holds information about browser, feed reader, media player, ...
            $this->driverType = strtolower($clientInfo["type"]);
            $this->driverName = strtolower($clientInfo["name"]);
            $this->driverVersion = strtolower($clientInfo["version"]);
            $this->driverEngine = strtolower($clientInfo["engine"]);
            $this->driverEngineVersion = strtolower($clientInfo["engine_version"]);

            $device = $dd->getDeviceName();
            $this->deviceType = strtolower($device);

            $brand = $dd->getBrandName();
            $this->deviceBrand = strtolower($brand);

            $model = $dd->getModel();
            $this->deviceModel = strtolower($model);

            $this->deviceDatas = new Map();
            $this->deviceDatas->put($os, Map::os);
            $this->deviceDatas->put($clientInfo, Map::clientInfo);
            $this->deviceDatas->put($device, Map::device);
            $this->deviceDatas->put($brand, Map::brand);
            $this->deviceDatas->put($model, Map::model);

            $map = get_object_vars($this);
            foreach ($map as $attribut => $value) {
                $this->{$attribut} = (isset($this->{$attribut}) && ($this->{$attribut} === '')) ? null : $value;
            }
        }
    }

    /**
     * To get Device's setDate
     * @return string Device's setDate
     */
    private function getSetDate()
    {
        return $this->setDate;
    }

    /**
     * To get Device's deviceDatas
     * @return Map Device's deviceDatas
     */
    private function getDeviceDatas()
    {
        return $this->deviceDatas;
    }

    /**
     * To get Device's userAgent
     * @return string Device's userAgent
     */
    private function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * To get Device's isBot
     * @return bool Device's isBot
     */
    private function isBot()
    {
        return $this->isBot;
    }

    /**
     * To get Device's botInfo
     * @return string Device's botInfo
     */
    private function getBotInfo()
    {
        return $this->botInfo;
    }

    /**
     * To get Device's osName
     * @return string Device's osName
     */
    private function getOsName()
    {
        return $this->osName;
    }

    /**
     * To get Device's osVersion
     * @return string Device's osVersion
     */
    private function getOsVersion()
    {
        return $this->osVersion;
    }

    /**
     * To get Device's osPlateform
     * @return string Device's osPlateform
     */
    private function getOsPlateform()
    {
        return $this->osPlateform;
    }

    /**
     * To get Device's driverType
     * @return string Device's driverType
     */
    private function getDriverType()
    {
        return $this->driverType;
    }

    /**
     * To get Device's driverName
     * @return string Device's driverName
     */
    private function getDriverName()
    {
        return $this->driverName;
    }

    /**
     * To get Device's driverVersion
     * @return string Device's driverVersion
     */
    private function getDriverVersion()
    {
        return $this->driverVersion;
    }

    /**
     * To get Device's driverEngine
     * @return string Device's driverEngine
     */
    private function getDriverEngine()
    {
        return $this->driverEngine;
    }

    /**
     * To get Device's driverEngineVersion
     * @return string Device's driverEngineVersion
     */
    private function getDriverEngineVersion()
    {
        return $this->driverEngineVersion;
    }

    /**
     * To get Device's deviceType
     * @return string Device's deviceType
     */
    private function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * To get Device's deviceBrand
     * @return string Device's deviceBrand
     */
    private function getDeviceBrand()
    {
        return $this->deviceBrand;
    }

    /**
     * To get Device's deviceModel
     * @return string Device's deviceModel
     */
    private function getDeviceModel()
    {
        return $this->deviceModel;
    }


    /*—————————————————— SCRUD DOWN —————————————————————————————————————————*/
    /**
     * To insert Device in database
     * @param Response  $response   where to strore results
     * @param string    $userID     Visitor's id
     * @param string    $navDate    creation date of the current Page's Visited
     */
    public function insertDevice(Response $response, $userID, $navDate)
    {
        $bracket = "(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; // regex \[value-[0-9]*\]
        $sql = "INSERT INTO `Devices`(`userId`, `nav_date`, `deviceDate`, `deviceDatas`, `userAgent`, `isBot`, `botInfo`, `osName`, `osVersion`, `osPlateform`, `driverType`, `driverName`, `driverVersion`, `driverEngine`, `driverEngineVersion`, `deviceType`, `deviceBrand`, `deviceModel`)
            VALUES " . $this->buildBracketInsert(1, $bracket);
        $values = [];
        array_push(
            $values,
            $userID,
            $navDate,
            $this->getSetDate(),
            json_encode($this->getDeviceDatas()->getMap()),
            $this->getUserAgent(),
            (int) $this->isBot(),
            json_encode($this->getBotInfo()),
            $this->getOsName(),
            $this->getOsVersion(),
            $this->getOsPlateform(),
            $this->getDriverType(),
            $this->getDriverName(),
            $this->getDriverVersion(),
            $this->getDriverEngine(),
            $this->getDriverEngineVersion(),
            $this->getDeviceType(),
            $this->getDeviceBrand(),
            $this->getDeviceModel()
        );
        $this->insert($response, $sql, $values);
    }
}
