<?php
require_once 'framework/View.php';


class ViewEmail extends View
{

    /**
     * Constructor
     * @param Language $language Visitor's language
     */
    public function __construct(Language $language)
    {
        $this->translator = isset($language) ? new Translator($language) : new Translator();
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
        // switch ($mailer) {
        //     case BlueAPI::class:
        $classFile = "model/tools-management/mailers/" . $mailerClass . "/" . $mailerClass . ".php";
        if (!file_exists($classFile)) {
            throw new Exception("This class $mailerClass don't exist, classFile:'$classFile'");
        }
        if (!empty($emailDatasMap->get(Map::templateFile))) {
            $templateFile = $emailDatasMap->get(Map::templateFile);
            $htmlContent = $this->generateFile($templateFile, $emailDatasMap->getMap());
            $emailDatasMap->put($htmlContent, Map::template);
        }
        $mailerAPI = new $mailerClass();
        if (!method_exists($mailerAPI, $mailerFunc)) {
            throw new Exception("This function '$mailerFunc' don't exist in class '$mailerClass'");
        }
        $mailerAPI->$mailerFunc($response, $emailDatasMap);
    }
}
