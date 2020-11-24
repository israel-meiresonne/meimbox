<?php
require_once 'model/ModelFunctionality.php';
require_once 'vendor/autoload.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\AbstractDeviceParser;



class Device extends ModelFunctionality
{
    /**
     * Holds all data detected
     * @var Map all data returned by the DeviceDetector
     */
    private $deviceDatas;

    /**
     * @var string
     */
    private $setDate;

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
    private $botInfo = null;

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

    function __construct()
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

            // $datasList = [];
            $this->deviceDatas = new Map();
            $this->deviceDatas->put($os, Map::os);
            $this->deviceDatas->put($clientInfo, Map::clientInfo);
            $this->deviceDatas->put($device, Map::device);
            $this->deviceDatas->put($brand, Map::brand);
            $this->deviceDatas->put($model, Map::model);
        }
        var_dump(get_object_vars($this));
    }
}
