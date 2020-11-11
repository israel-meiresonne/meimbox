<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/marketing/facebook/Pixel.php';
require_once 'model/special/Map.php';

class Facebook extends ModelFunctionality
{
    /**
     * Key to get catalog's file name from $_GET
     */
    public const GET_CATALOG = "file_catalog";

    /**
     * Génère un fichier vue et renvoie le résultat produit
     * 
     * rnvs : retourne une string dont le contenu est le fichier dont
     *        le chemin d'accès est contenu dans $file, fichier dont
     *        le contenu est garni avec les données du tableau associatif
     *        $datas, tableau éclaté en autant de variables qu'il possède
     *        d'éléments
     * 
     * @param string $file Chemin du fichier vue à générer
     * @param array $datas Données nécessaires à la génération de la vue
     * @return string Résultat de la génération de la vue
     * @throws Exception Si le fichier vue est introuvable
     */
    protected static function generateFile($file, $datas)
    {
        if (file_exists($file)) {
            extract($datas);
            ob_start();
            require $file;
            return ob_get_clean();
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }

    /**
     * To get pixel's base code
     * @return string pixel's base code
     */
    public static function getBaseCode()
    {
        return Pixel::getBaseCode();
    }

    /**
     * To get the Facebook pixel for the event given
     * @param string    $type       type of the Pixel ['tracker' | 'trackerCustom']
     * @param string    $event      the event accured
     * @param string    $datasMap   pixel's datas
     * @return string the Facebook pixel for the event given
     */
    public static function getPixel(string $type, string $event, Map $datasMap = null)
    {
        return Pixel::getPixel($type, $event, $datasMap);
    }

    /**
     * To generate and get a Facebook catalog of the given file
     * @param string    $file       file of the catalog to get
     * @param Language  $language   language for the product
     * @param Country   $country    country where to sell the product
     * @param Currency  $currency   currency of the product
     * @return string Facebook catalog of the given file
     */
    public static function getCatalog(string $file, Language $language, Country $country, Currency $currency)
    {
        // header('content-type: application/json');
        header("Content-type: text/xml");
        $url_domain = Configuration::get(Configuration::URL_DOMAIN);
        $webroot = Configuration::getWebRoot();
        $url_DomainWebroot = $url_domain . $webroot;
        $url_file = $url_DomainWebroot . ControllerWebhook::ACTION_FACEBOOKCATALOG . "?" . self::GET_CATALOG . "=" . $file;
        $products = [];
        array_push($products, (new BoxProduct(1, $language, $country, $currency)));
        array_push($products, (new BoxProduct(2, $language, $country, $currency)));
        array_push($products, (new BoxProduct(3, $language, $country, $currency)));
        array_push($products, (new BoxProduct(4, $language, $country, $currency)));
        array_push($products, (new BoxProduct(5, $language, $country, $currency)));
        $company = new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY));
        $datas = [
            "url_DomainWebroot" => $url_DomainWebroot,
            "url_file" => $url_file,
            "products" => $products,
            "company" => $company
        ];
        $xml = self::generateFile("model/marketing/facebook/files/catalog/$file", $datas);
        return self::cleanXML($xml);
    }

    /**
     * To replace xml's special chart with escape string
     * + i.e: '&' --> '&amp;'
     * @param string $xml the value to clean
     * NOTE: to use on variable not the entire xml file
     * @return string cleaned value
     */
    protected static function cleanXML(string $xml)
    {
        $searchReplace = [
            '&' => '&amp;'
        ];
        return str_replace(array_keys($searchReplace), $searchReplace, $xml);
    }
}
