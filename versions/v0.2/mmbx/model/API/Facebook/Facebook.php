<?php
require_once 'model/ModelFunctionality.php';
require_once 'model/API/Facebook/Pixel.php';
require_once 'model/special/Map.php';

class Facebook extends ModelFunctionality
{
    /**
     * Key to get catalog's file name from $_GET
     */
    public const GET_CATALOG = "file_catalog";

    /**
     * Execute file with datas given and return the result
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
        $tab = parent::select("SELECT `prodID`, `product_type` FROM `Products` WHERE `isAvailable`=1;");
        foreach ($tab as $tabLine) {
            $prodID = $tabLine["prodID"];
            $product_type = $tabLine["product_type"];
            switch ($product_type) {
                case BoxProduct::BOX_TYPE:
                    array_push($products, (new BoxProduct($prodID, $language, $country, $currency)));
                    break;
                case BasketProduct::BASKET_TYPE:
                    array_push($products, (new BasketProduct($prodID, $language, $country, $currency)));
                    break;
            }
        }
        $company = new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY));
        $datas = [
            "url_DomainWebroot" => $url_DomainWebroot,
            "url_file" => $url_file,
            "products" => $products,
            "company" => $company
        ];
        $xml = self::generateFile("model/API/Facebook/files/catalog/$file", $datas);
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
            '&' => '&amp;',
            // '<' => '&lt;',
            // '>' => '&gt;'
        ];
        return str_replace(array_keys($searchReplace), $searchReplace, $xml);
    }
}
