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
 * Classe modélisant une vue.
 * 
 * rnvs : il n'y a qu'une seule classe vue, 
 *        mais à chaque action de chaque vue effective 
 *        correspond un fichier *.php qui est inclus dans 
 *        View::generateFile()
 * 
 * rnvs : pour chaque contrôleur, p. ex. ControllerHome, 
 *        il y a un sous-répertoire dans le dossier view
 *        dont le nom est celui du contrôleur sans Controller, 
 *        p. ex. : view/Home/
 *        j'appelle ce dossier « dossier de la vue effective » et j'y
 *        associe ce que j'appelle « vue effective »
 * rnvs : pour chaque vue effective, il peut exister plusieurs actions
 *        c.-à-d. différents fichiers dans, p. ex. view/Home/ : 
 *        view/Home/index.php, view/Home/show.php, etc.
 * 
 * rnvs : ce fichier d'action de la vue effective est le corps de la page
 *        web à retourner au client. ce corps est inséré dans le modèle
 *        template.php
 * 
 * rnvs : il est possible de créer des vues qui ne sont pas attachées à un
 *        contrôleur effectif, mais juste à une action.
 *        on a alors le fichier view/error.php, p. ex.
 * 
 * rnvs : résumé : 1 contrôleur effectif ←→ 1 vue effective
 *                 1 contrôleur effectif ←→ 1 classe ControllerXXX dérivant
 *                                          de la classe Controller
 *                 1 vue effective ←→ 1 répertoire view/XXX
 * 
 *                 1 contrôleur effectif ←→ plusieurs actions possibles
 *                 1 action du contrôleur effectif ←→ 1 méthode du contrôleur
 *                                                    effectif, p. ex.
 *                                                    ControllerXXX::index()
 * 
 *                 1 vue effective ←→ plusieurs actions possibles
 *                 1 action de la vue effective ←→ 1 fichier dans /view/XXX,
 *                                                 p. ex. view/XXX/index.php
 * 
 *                 c'est le contrôleur effectif qui fixe la vue effective 
 *                 et son action
 * 
 *                 ça se passe dans le ctor de View 
 *                 invoqué dans Controller::generateView elle-même 
 *                 invoquée dans la méthode de l'action du contrôleur effectif
 * 
 *                 l'action de la vue effective est représentée dans la classe
 *                 View sous la forme d'une string stockée dans $file dont
 *                 le contenu est le chemin vers le fichier de l'action de
 *                 la vue effective, p. ex. "view/XXX/index.php"
 */
class View
{
    /**
     * The translator used to translate every string  
     * + NOTE: it's the only instance of this class in the whole system.
     * @var Translator
     */
    protected static $translator;

    /**
     *  the current user
     * @var Visitor
     */
    private $person;

    /** Nom du fichier associé à la vue */
    // rnvs : string qui contient le chemin vers le fichier php qui correspond
    //        à l'action de la vue effective
    // rnvs : attribut construit et setté dans le ctor de View ci-dessous
    private $file;

    /** Titre de la vue (défini dans le fichier vue) */
    // rnvs : cet attribut est setté dans le fichier qui se trouve à 
    //        l'emplacement $file c.-à-d. dans le fichier d'action de 
    //        la vue que l'attribut
    // rnvs : cela se passe dans View::generateFile() 
    //        par le biais du statement require $file; 
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
    private $fbPixelsMap;

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
     * @param string $action Action à laquelle la vue est associée
     * @param string $controller Nom du contrôleur auquel la vue est associée
     * @param Visitor|Client|Administrator $person the current user
     */
    // public function __construct($action, $controller = "", Visitor $person = null)
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
        $this->fbPixelsMap = new Map();
        $this->person = $person;
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
        self::$URL_DOMAIN_WEBROOT = (!isset(self::$URL_DOMAIN_WEBROOT)) ?  Configuration::get(Configuration::URL_DOMAIN) . Configuration::getWebRoot() : self::$URL_DOMAIN_WEBROOT;
        self::$PATH_EMAIL = (!isset(self::$PATH_EMAIL))
            ? self::$URL_DOMAIN_WEBROOT . Configuration::get(Configuration::DIR_EMAIL_FILES)
            : self::$PATH_EMAIL;
    }

    /**
     * To generate the finale view
     * @param array $datas Données nécessaires à la génération de la vue
     */
    // public function generate($datas, $template = 'view/Template/default.php')
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
     * @param string $file Chemin du fichier vue à générer
     * @param array $datas Données nécessaires à la génération de la vue
     * @return string Résultat de la génération de la vue
     * @throws Exception Si le fichier vue est introuvable
     */
    protected function generateFile($file, $datas)
    {
        if (file_exists($file)) {
            // $translator = $this->translator;
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
     * Nettoie une valeur insérée dans une page HTML
     * Doit être utilisée à chaque insertion de données dynamique dans une vue
     * Permet d'éviter les problèmes d'exécution de code indésirable (XSS) dans les vues générées
     * 
     * rnvs : cette méthode peut être (et est) appelée dans les fichiers
     *        inclus dans View::generateFile() lors de require $file
     * 
     * @param string $value Valeur à nettoyer
     * @return string Valeur nettoyée
     */
    private function clean($value)
    {
        // Convertit les caractères spéciaux en entités HTML
        // rnvs : https://www.php.net/manual/en/function.htmlspecialchars.php
        //        Convert special characters to HTML entities
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
     * To get fbPixelsMap
     * @return Map fbPixelsMap
     */
    private function getFbPixelsMap()
    {
        return $this->fbPixelsMap;
    }

    /**
     * To get Facebook's base code for pixel
     * @return string Facebook's base code for pixel
     */
    private function getFbPixelBaseCode()
    {
        // $fbPixelsMap = $this->getFbPixelsMap();
        return Facebook::getBaseCode();
    }

    /**
     * To add a Facebook pixel
     * @param string    $type       type of the Pixel ['tracker' | 'trackerCustom']
     * @param string    $event      the event accured
     * @param string    $datasMap   pixel's datas
     */
    private function addFbPixel(string $type, string $event, Map $datasMap = null)
    {
        $fbPixelsMap = $this->getFbPixelsMap();
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
        $fbPixelsMap = $this->getFbPixelsMap();
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

    /**
     * To get Google's base code
     * @return string Google's base code
     */
    private function getGoogleBaseCode()
    {
        return Google::getBaseCode();
    }
}
