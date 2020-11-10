<?php
require_once('vendor/autoload.php');

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

require_once 'framework/View.php';
require_once 'model/tools-management/mailers/BlueAPI/BlueAPI.php';

class ViewEmail extends View
{
    /**
     * Used to extract link from html's 'link' tag
     */
    private const RGX_URL = "#(https?:\/\/[\w\-\_\.\~\!\*\'\(\)\;\:\@\&\=\+\$\,\/\?\%\#\[\]]*)#";

    private static $CSS_MAP_ROOT;



    /**
     * Constructor
     * @param Language $language Visitor's language
     */
    public function __construct(Language $language)
    {
        parent::__construct();
        $this->translator = isset($language) ? new Translator($language) : new Translator();
    }

    /**
     * To set $CSS_MAP_ROOT
     */
    private function setCssMapRoot()
    {
        // root->array: 
        // #(--.*): (.*);$# -> ["$1" => "$2",]
        $cssRoot = [
            "--color-shadow" => "#E5E5E7",
            "--color-shadow-08" => "rgba(229, 229, 231, .8)",
            "--color-shadow-05" => "rgba(229, 229, 231, .5)",
            "--color-text" => "#0E2439",
            "--color-text-08" => "rgba(14, 36, 57, 0.8)",
            "--color-text-06" => "rgba(14, 36, 57, 0.6)",
            "--color-text-05" => "rgba(14, 36, 57, 0.5)",
            "--color-link-05" => "rgba(11, 71, 91, .5)",
            "--color-label" => "#C6C6C7",
            "--color-white" => "#ffffff",
            "--color-red" => "#AF3134",
            "--color-green" => "#23CBA7",
            "--color-green-02" => "rgba(35, 203, 167, 0.2)",
            "--color-yellow" => "#FFD300",
            "--color-yellow-07" => "rgba(255, 211, 0, 0.7)",
            "--color-blue" => "#4DA3F5",
            "--main-font-family" => "'Spartan', Verdana, Geneva, sans-serif",
            "--italic-font-family" => "'PT Serif', 'Times New Roman', Times, serif",
            "--box-font-family" => "'Open Sans', sans-serif",
            "--big-font-size" => "2em",
            "--font-size-1_7em" => "1.7em",
            "--font-size-1_6em" => "1.6em",
            "--middle-font-size" => "1.2em",
            "--little-font-size" => ".8em",
            "--micro-font-size" => ".6em",
            "--transition-time" => ".450s",
            "--transition-time-picture" => ".5s",
            "--box-shadow" => "12px 12px 20px var(--color-shadow)",
            "--box-shadow-right" => "12px 0px 20px var(--color-shadow)",
            "--box-shadow-centred" => "0px 12px 20px var(--color-shadow)",
            "--selected-shadow-color" => "var(--color-green-02)",
            "--selected-shadow-opacity" => "10px",
            "--selected-shadow" => "2px 2px var(--selected-shadow-opacity) var(--selected-shadow-color), -2px 2px var(--selected-shadow-opacity) var(--selected-shadow-color), -2px -2px var(--selected-shadow-opacity) var(--selected-shadow-color), 2px -2px var(--selected-shadow-opacity) var(--selected-shadow-color)",
            "--border-float" => "var(--color-shadow) 1px solid",
            "--border-float-radius" => "5px",
            "--big-border-radius" => "20px",
            "--border-radius-selcted-element" => "10px",
            "--z-index-header-fixed" => "100",
            "--z-index-body" => "-5",
            "--body-top-computer" => "145px",
            "--body-top-mobile" => "100px",
            "--body-initial-top-computer" => "-145px",
            "--body-initial-top-mobile" => "-100px",
            "--cartelement-margin-bottom" => "15px",
            "--boxproduct-margin-bottom" => "5px",
        ];

        $search = array_keys($cssRoot);
        $replace = array_values($cssRoot);
        foreach ($search as $key => $const) {
            $search[$key] = "var($const)";
        }

        foreach ($cssRoot as $const => $val) {
            // $val = preg_replace("#var\((--[\w-]*)\)#", '$1', $val);
            $cleanedVal = str_replace($search, $replace, $val);
            $cssRoot[$const] = $cleanedVal;

            $search = array_keys($cssRoot);
            $replace = array_values($cssRoot);
            foreach ($search as $key => $const) {
                $search[$key] = "var($const)";
            }
        }
        self::$CSS_MAP_ROOT = $cssRoot;
    }

    /**
     * To send an email
     * @param Response $response used store results or errors occured
     * @param Visitor|User $person the current user
     * @param string $mailerClass class of the mailer to use
     * @param string $mailerFunc function to execute on the mailer to send email
     * @param Map $emailDatasMap datas used to send email
     * + $emailDatasMap[Map::templateFile] => the file to load the template if needed
     */
    public function sendEmail(Response $response, string $mailerClass, string $mailerFunc, Map $emailDatasMap)
    {
        $classFile = "model/tools-management/mailers/" . $mailerClass . "/" . $mailerClass . ".php";
        if (!file_exists($classFile)) {
            throw new Exception("This class $mailerClass don't exist, classFile:'$classFile'");
        }
        if (!empty($emailDatasMap->get(Map::templateFile))) {
            $templateFile = $emailDatasMap->get(Map::templateFile);
            $htmlContent = $this->generateFile($templateFile, $emailDatasMap->getMap());
            $emailDatasMap->put($htmlContent, Map::template);
        }
        $mailerAPI = new $mailerClass($this->translator);
        if (!method_exists($mailerAPI, $mailerFunc)) {
            throw new Exception("This function '$mailerFunc' don't exist in class '$mailerClass'");
        }
        $mailerAPI->$mailerFunc($response, $emailDatasMap);
    }

    /**
     * To preview email
     */
    public function previewEmail(Map $emailDatasMap)
    {
        if (!empty($emailDatasMap->get(Map::templateFile))) {
            $templateFile = $emailDatasMap->get(Map::templateFile);
            $htmlContent = $this->generateFile($templateFile, $emailDatasMap->getMap());
            echo $htmlContent;
        }
    }

    /**
     * To get $CSS_MAP_ROOT
     * @return string[] $CSS_MAP_ROOT
     */
    private function getCssMapRoot()
    {
        (!isset(self::$CSS_MAP_ROOT)) ? $this->setCssMapRoot() : null;
        return self::$CSS_MAP_ROOT;
    }

    /**
     * To extract the link from a html link tag
     * + i.e.: <link href="https://fonts.googleapis.com/css?family=PT+Serif&display=swap" rel="stylesheet">
     * + return: https://fonts.googleapis.com/css?family=PT+Serif&display=swap
     * @param $tag html tag
     * @return string the link extracted
     */
    public function extractLink(string $tag)
    {
        preg_match(self::RGX_URL, $tag, $matchs);
        $link = $matchs[1];
        return $link;
    }

    /**
     * To replce variable used with their declared value
     * @param string $style content of a css file
     * @return string content given with variable eplaced with their declared value
     */
    public function replaceCssVar(string $style)
    {
        // root->array: 
        // #(--.*): (.*);$# -> ["$1" => "$2",]
        $cssRoot = $this->getCssMapRoot();
        $search = array_keys($cssRoot);
        $replace = array_values($cssRoot);
        foreach ($search as $key => $const) {
            $search[$key] = "var($const)";
        }
        return str_replace($search, $replace, $style);
    }

    /**
     * Make a html file readable as mail by adding style from css file directly
     *  on html tag with the style attribut
     * @param string $html content of a html file
     * @param string $css content of a css file
     * @return string html email
     */
    public function htmlToEmail($html, $css)
    {
        $cssToInlineStyles = new CssToInlineStyles();
        $mailContent = $cssToInlineStyles->convert(
            $html,
            $css
        );
        return $mailContent;
    }
}
