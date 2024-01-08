<?php
require_once 'Configuration.php';
require_once 'model/view-management/Translator.php';
require_once 'model/tools-management/Language.php';
require_once 'model/special/Response.php';
require_once 'model/special/Map.php';
require_once 'framework/Configuration.php';
require_once 'model/API/Facebook/Facebook.php';
require_once 'model/API/Google/Google.php';

// View Elements
require_once 'view/view/Touch/Touch.php';
require_once 'view/view/MiniPopUp/MiniPopUp.php';
require_once 'view/view/Tutorial/Tutorial.php';
require_once 'view/view/DropDown/DropDown.php';

/**
 * Class modeling a view.
 * 
 */
class View
{
    /**
     * The translator used to translate every string  
     * + NOTE: it's the only instance of this class in the whole system.
     * 
     * @var Translator
     */
    protected static $translator;

    /**
     * The current user
     * 
     * @var Visitor
     */
    private $person;
    // private static $person;

    /** Name of the file associated with the view */
    private $file;

    /** View title (defined in the view file) */
    private $title;

    /**
     * Holds the page's meta data description
     * @var string
     */
    private $description;

    /**
     * Holds the page's specific meta data description
     * @var string
     */
    private $head;

    /**
     * Holds pixels for Facebook
     * @var Map
     * + $fbPixelsMap[index{int}][Map::type]       {string}    pixel's type ['track' | 'trackCustom']
     * + $fbPixelsMap[index{int}][Map::event]      {string}    pixel's event name
     * + $fbPixelsMap[index{int}][Map::datasMap]   {Map|null}  pixel's datas
     */
    // private $fbPixelsMap;

    /**
     * Holds API maps
     * @var Map
     * + $APIEventsMap[class][index{int}][Map::type]       {string}    event's type ['track' | 'trackCustom']
     *                                                                 + for Facebook 
     * + $APIEventsMap[class][index{int}][Map::event]      {string}    event's name
     * + $APIEventsMap[class][index{int}][Map::datasMap]   {Map|null}  event's datas
     */
    private $APIEventsMap;

    /**
     * Holds the configuration used to determinate wicth header to use in template
     * @var string
     */
    private $header = self::HEADER_CONF_COMMON;

    /**
     * Holds configuration for header
     * @var string
     */
    private const HEADER_CONF_COMMON = "headerCommon.php";
    private const HEADER_CONF_LANDING = "headerLanding.php";
    private const HEADER_CONF_CHECKOUT = "headerCheckout.php";

    /**
     * Holds domain URL + webroot [https://domain.dom/web/root/]
     */
    private static $URL_DOMAIN_WEBROOT;
    /**
     * Holds path to permanant files
     * @var string
     */
    protected static $DIR_STATIC_FILES;
    /**
     * Holds path to products files
     * @var string
     */
    protected static $PATH_PRODUCT;
    /**
     * Holds path to css files
     * @var string
     */
    protected static $PATH_CSS;
    /**
     * Holds path to css files
     * @var string
     */
    protected static $PATH_JS;
    /**
     * Holds path to brand logos
     * @var string
     */
    protected static $PATH_BRAND;
    /**
     * Holds path to email files
     * @var string
     */
    private static $PATH_EMAIL;

    /**
     * Holds tamplate available
     * @var string
     */
    public const TEMPLATE_ERROR = "error.php";

    /**
     * Error type
     */
    private const ER_TYPE_MINIPOP = "minipop";
    private const ER_TYPE_COMMENT = "comment";

    /**
     * Holds configurat for the file orderSummary
     */
    private const CONF_SOMMARY_CHECKOUT = "CONF_SOMMARY_CHECKOUT";
    private const CONF_SOMMARY_SHOPBAG = "CONF_SOMMARY_SHOPBAG";

    /**
     * Holds direction to configure View elements
     * @var string
     */
    protected const DIRECTION_LEFT = "left";
    protected const DIRECTION_RIGHT = "right";
    protected const DIRECTION_TOP = "top";
    protected const DIRECTION_BOTTOM = "bottom";

    /**
     * Holds datas for head
     * @var string
     */
    protected const FONT_FAM_SPARTAN = '<link href="https://fonts.googleapis.com/css?family=Spartan&display=swap" rel="stylesheet">';
    protected const FONT_FAM_PT = '<link href="https://fonts.googleapis.com/css?family=PT+Serif&display=swap" rel="stylesheet">';
    protected const STYLE_W3SCHOOL = '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';
    protected const META_DEVICE = '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/><meta http-equiv="X-UA-Compatible" content="ie=edge">';
    protected const META_BOT_NO_INDEX = '<meta name="robots" content="noindex"><meta name="googlebot" content="noindex">';

    /**
     * Holds desable time for luncher
     * @var int
     */
    protected const LUNCHER_DESABLE_TIME = 1;
    /**
     * Holds waiting time between each XHR request
     * @var int
     */
    protected const XHR_TIME_OUT = 1;

    /**
     * Constructor
     * @param string $action Action the view is associated with
     * @param string $controller Name of the controller the view is associated with
     * @param Visitor|Client|Administrator $person the current user
     */
    public function __construct()
    {
        $this->setConstants();
        $args = func_get_args();
        switch (func_num_args()) {
            case 1:
                $this->__construct1_3($args[0]);
                break;
            case 2:
                $this->__construct1_3($args[0], $args[1]);
                break;
            case 3:
                $this->__construct1_3($args[0], $args[1], $args[2]);
                break;
        }
    }

    /**
     * Constructor
     * @param string $action Action à laquelle la vue est associée
     * @param string $controller Nom du contrôleur auquel la vue est associée
     * @param Visitor|Client|Administrator $person the current user
     */
    private function __construct1_3($action, $controller = "", Visitor $person = null)
    {
        // $this->fbPixelsMap = new Map();
        // $this->APIEventsMap = new Map();
        $this->person = $person;
        // self::$person = $person;
        $language = (!empty($person)) ? $person->getLanguage() : null;
        // $this->translator = isset($language) ? new Translator($language) : new Translator();
        self::$translator = isset($language) ? new Translator($language) : new Translator();

        $file = "view/";
        if ($controller != "") {
            $file = $file . $controller . "/";
        }
        $this->file = $file . $action . ".php";
    }

    /**
     * To set all $PATH attribut
     */
    private function setConstants()
    {
        self::$DIR_STATIC_FILES = (!isset(self::$DIR_STATIC_FILES)) ? Configuration::get(Configuration::DIR_STATIC_FILES) : self::$DIR_STATIC_FILES;
        self::$PATH_PRODUCT = (!isset(self::$PATH_PRODUCT)) ? Configuration::get(Configuration::PATH_PRODUCT) : self::$PATH_PRODUCT;
        self::$PATH_CSS = (!isset(self::$PATH_CSS)) ? Configuration::get(Configuration::PATH_CSS) : self::$PATH_CSS;
        self::$PATH_JS = (!isset(self::$PATH_JS)) ? Configuration::get(Configuration::PATH_JS) : self::$PATH_JS;
        self::$PATH_BRAND = (!isset(self::$PATH_BRAND)) ? Configuration::get(Configuration::PATH_BRAND) : self::$PATH_BRAND;
        self::$URL_DOMAIN_WEBROOT = (!isset(self::$URL_DOMAIN_WEBROOT)) ? Configuration::get(Configuration::URL_DOMAIN) . Configuration::getWebRoot() : self::$URL_DOMAIN_WEBROOT;
        self::$PATH_EMAIL = (!isset(self::$PATH_EMAIL))
            ? self::$URL_DOMAIN_WEBROOT . Configuration::get(Configuration::DIR_EMAIL_FILES)
            : self::$PATH_EMAIL;
    }

    /**
     * To generate the final view
     * @param array $datas Data needed to generate the view
     */
    public function generate($datas, $template = 'default.php')
    {
        $content = $this->generateFile($this->file, $datas);
        $webRoot = Configuration::get("webRoot", "/");
        $view = $this->generateFile(
            "view/Template/" . $template,
            array(
                'webRoot' => $webRoot,
                'content' => $content,
            )
        );
        echo $view;
    }

    /**
     * @param array $datas datas used to generate the view
     * @param Response $response contain results ready and/or prepared or errors
     */
    public function generateJson($datas, Response $response)
    {
        if (!$response->containError()) {
            $files = $response->getFiles();
            if (is_array($files) || is_object($files)) {
                foreach ($files as $key => $file) {
                    $result = $this->generateFile($file, $datas);
                    $response->addResult($key, $result);
                }
            }
            // $response->translateResult($this->translator);
            $response->translateResult(self::$translator);
        } else {
            // $response->translateError($this->translator);
            $response->translateError(self::$translator);
        }
        echo json_encode($response->getAttributs());
    }

    /**
     * Generate a view with a file
     * @param string $file Path of the view file to generate
     * @param array $datas Data needed to generate the view
     * @return string Result of view generation
     * @throws Exception If the vue file is not found
     */
    protected function generateFile($file, $datas)
    {
        if (file_exists($file)) {
            $translator = self::$translator;
            extract($datas);
            ob_start();
            require $file;
            return ob_get_clean();
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }

    /**
     * Cleans up a value inserted into an HTML page
     * Must be used whenever dynamic data is inserted into a view
     * Helps avoid unwanted code execution (XSS) issues in generated views
     * 
     * @param string $value Value to clean
     * @return string Cleaned value
     */
    private function clean($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * To get View's Translator
     * @return Translator View's Translator
     */
    public function getTranslator(): Translator
    {
        // return $this->translator;
        return self::$translator;
    }

    /**
     * To get View's user  account
     * @return Visitor|User View's user  account
     */
    protected function getPerson()
    {
        return $this->person;
    }

    /**
     * To check if a Visitor is a Administractor
     * @return bool true if Visitor is a Administractor else false
     */
    private function isADM()
    {
        return $this->getPerson()->hasCookie(Cookie::COOKIE_ADM, true);
    }

    /**
     * To get code for Administractor account
     * @return string code for Administractor account
     */
    private function getADMCodes()
    {
        $datas = ["isAdm" => $this->isADM()];
        return $this->generateFile('view/view/BasicFiles/admCodes.php', $datas);
    }

    /**
     * To convet unix time into displayable date
     * @return string displayable date
     */
    public static function getDateDisplayable(Translator $translator, int $minTime, int $maxTime = null)
    {
        // $translator = $this->getTranslator();
        $language = $translator->getLanguage();
        switch ($language->getIsoLang()) {
            case Language::ISO_EN:
                $day = date('jS', $minTime);
                $day .= (isset($maxTime)) ? "—" . date('jS', $maxTime) : null;
                break;
            default:
                $day = date('j', $minTime);
                $day .= (isset($maxTime)) ? "—" . date('j', $maxTime) : null;
                break;
        }
        $time = (isset($maxTime)) ? $maxTime : $minTime;
        $month = strtolower(date('F', $time));
        $month = $translator->translateString($month);
        $date = "$day $month";
        return $date;
    }

    /**
     * To set APIEventsMap
     */
    private function setAPIEventsMap()
    {
        $this->APIEventsMap = new Map([
            Facebook::class => new Map(),
            Google::class => new Map()
        ]);
    }

    /**
     * To get a API's event map
     * @return Map|null a API's event map
     */
    private function getAPIEventsMap($class)
    {
        (!isset($this->APIEventsMap)) ? $this->setAPIEventsMap() : null;
        return $this->APIEventsMap->get($class);
    }

    /**
     * To get base code of API tracker
     * @return string base code of API tracker
     */
    private function getAPIBaseCodes(...$classes)
    {
        $baseCodes = $this->getADMCodes();
        if ((!$this->isADM()) && (!empty($classes))) {
            foreach ($classes as $class) {
                switch ($class) {
                    case Facebook::class:
                        $baseCodes .= Facebook::getBaseCode() . "\n";
                        break;
                    case Google::class:
                        $baseCodes .= Google::getBaseCode() . "\n";
                        break;
                }
            }
        }
        return $baseCodes;
    }

    /**
     * To get events of API tracker
     * @param string[] $classes class name of API tracker
     * @return string events of API tracker
     */
    private function generateAPIEvents(...$classes)
    {
        $scripts = "";
        if ((!$this->isADM()) && (!empty($classes))) {
            foreach ($classes as $class) {
                switch ($class) {
                    case Facebook::class:
                        $scripts .= $this->generateFbPixel() . "\n";
                        break;
                    case Google::class:
                        $scripts .= $this->getAPIEventsScript($class) . "\n";
                        break;
                }
            }
        }
        return $scripts;
    }

    /**
     * To add event code to a API
     * @param string    $class      class of the API to add event code in
     * @param string    $event      the event accured
     * @param string    $datasMap   event's datas
     */
    private function addAPIEvents($class, string $event, Map $datasMap = null)
    {
        $APIEventsMap = $this->getAPIEventsMap($class);
        $events = $APIEventsMap->getKeys();
        if (in_array($event, $events)) {
            throw new Exception("This event '$event' already exist in API event map");
        }
        $APIEventsMap->put($event, $event, Map::event);
        $APIEventsMap->put($datasMap, $event, Map::datasMap);
    }

    /**
     * To get script code of a API's events
     * @return string script code of a API's events
     */
    private function getAPIEventsScript($class)
    {
        $APIEventsMap = $this->getAPIEventsMap($class);
        $evts = $APIEventsMap->getKeys();
        $script = null;
        $nb = count($evts);
        if ($nb > 0) {
            $id = ModelFunctionality::encryptString($class);
            $script = "<script id=\"$id\" type=\"text/javascript\">\n";
            foreach ($evts as $evt) {
                $event = $APIEventsMap->get($evt, Map::event);
                $datasMap = $APIEventsMap->get($evt, Map::datasMap);
                $script .= (empty($datasMap)) ? $class::getEvent($event) : $class::getEvent($event, $datasMap);
                $script .= "\n";
            }
            $script .= "</script>";
        }
        return $script;
    }

    /**
     * To add a Facebook pixel
     * @param string    $type       type of the Pixel ['tracker' | 'trackerCustom']
     * @param string    $event      the event accured
     * @param string    $datasMap   pixel's datas
     */
    private function addFbPixel(string $type, string $event, Map $datasMap = null)
    {
        // $fbPixelsMap = $this->getFbPixelsMap();
        $fbPixelsMap = $this->getAPIEventsMap(Facebook::class);
        $indexes = $fbPixelsMap->getKeys();
        $nb = count($indexes);
        if ($nb > 0) {
            foreach ($indexes as $index) {
                $holdType = $fbPixelsMap->get($index, Map::type);
                $holdEvent = $fbPixelsMap->get($index, Map::event);
                if (($holdType == $type) && ($holdEvent == $event)) {
                    throw new Exception("This pixel (type:'$type', event:'$event') already exist in fbPixelsMap");
                }
            }
        }
        $fbPixelsMap->put($type, $nb, Map::type);
        $fbPixelsMap->put($event, $nb, Map::event);
        $fbPixelsMap->put($datasMap, $nb, Map::datasMap);
    }

    /**
     * To generate facebook's pixel stored in fbPixelsMap in script tag
     * @return string|null pixel script
     */
    private function generateFbPixel()
    {
        $fbPixelsMap = $this->getAPIEventsMap(Facebook::class);
        $indexes = $fbPixelsMap->getKeys();
        $script = null;
        $nb = count($indexes);
        if ($nb > 0) {
            $script = "<script id=\"fbpxl\" type=\"text/javascript\">\n";
            foreach ($indexes as $index) {
                $type = $fbPixelsMap->get($index, Map::type);
                $event = $fbPixelsMap->get($index, Map::event);
                $datasMap = $fbPixelsMap->get($index, Map::datasMap);
                $script .= (empty($datasMap)) ? Facebook::getPixel($type, $event) : Facebook::getPixel($type, $event, $datasMap);
                $script .= "\n";
            }
            $script .= "</script>";
        }
        return $script;
    }
}