<?php
// namespace Oop\model;
include_once 'library/spyc/Spyc.php';
include_once 'library/device-detector/autoload.php';

use DeviceDetector\DeviceDetector;
use DeviceDetector\Parser\Device\DeviceParserAbstract;


class Device
{
    /**
     * Holds all data detected into json format
     * @var string all data returned by the DeviceDetector into JSON format
     */
    private $ddData;

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
        $this->userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
        $dd = new DeviceDetector($this->userAgent);
        $dd->parse();

        $this->setDate = GeneralCode::getDateTime();

        $this->isBot = $dd->isBot();
        if ($this->isBot) {
            // handle bots,spiders,crawlers,...
            $this->botInfo = $dd->getBot();
        } else {
            $os = $dd->getOs();
            $this->osName = strtolower($os["name"]);
            $this->osVersion = strtolower($os["version"]);
            $this->osPlateform = strtolower($os["plateform"]);

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

            $datasList = [];
            array_push($datasList, ["os" => $os]);
            array_push($datasList, ["clientInfo" => $clientInfo]);
            array_push($datasList, ["device" => $device]);
            array_push($datasList, ["brand" => $brand]);
            array_push($datasList, ["model" => $model]);
            $this->ddData = json_encode($datasList);
        }
    }

    public function __toString()
    {

        Helper::printLabelValue("ddData", $this->ddData);
        Helper::printLabelValue("isBot", $this->isBot);
        Helper::printLabelValue("botInfo", $this->botInfo);
        Helper::printLabelValue("userAgent", $this->userAgent);
        Helper::printLabelValue("osName", $this->osName);
        Helper::printLabelValue("osVersion", $this->osVersion);
        Helper::printLabelValue("osPlateform", $this->osPlateform);
        Helper::printLabelValue("driverType", $this->driverType);
        Helper::printLabelValue("driverName", $this->driverName);
        Helper::printLabelValue("driverVersion", $this->driverVersion);
        Helper::printLabelValue("driverEngine", $this->driverEngine);
        Helper::printLabelValue("driverEngineVersion", $this->driverEngineVersion);
        Helper::printLabelValue("deviceType", $this->deviceType);
        Helper::printLabelValue("deviceBrand", $this->deviceBrand);
        Helper::printLabelValue("deviceModel", $this->deviceModel);
    }
}
