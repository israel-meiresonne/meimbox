<?php

// rnvs : https://www.php.net/manual/en/function.require-once.php
require_once 'Controller.php';
require_once 'Request.php';
require_once 'View.php';

// rnvs : start
require_once 'Configuration.php';
// rnvs : end

/**
 * Classe de routage des requêtes entrantes.
 * Inspirée du framework PHP de Nathan Davison
 * (https://github.com/ndavison/Nathan-MVC)
 * 
 */
class Router
{

    /**
     * Méthode principale appelée par le contrôleur frontal
     * Examine la requête et exécute l'action appropriée
     * 
     * rnvs : tout se passe ici : c'est la seule méthode invoquée dans index.php
     */
    // public function routerRequest() {    // rnvs : comm (static)
    public static function routerRequest()
    {    // rnvs : ajout (static)
        try {
            // rnvs : on arrive ici depuis index.php, qui ne fait en gros 
            //        qu'invoquer Router::routerRequest()
            //        c'est ici maintenant que commence le traitement 
            //        de la requête du client

            // Fusion des paramètres GET et POST de la requête
            // Permet de gérer uniformément ces deux types de requête HTTP
            // rnvs : https://www.php.net/manual/en/function.array-merge
            $request = new Request(array_merge($_GET, $_POST));
            // rnvs : ctor de Request invoque ctor de Session invoque 
            //        session_start()
            //        argument du ctor de Request : initialise paramètres de 
            //        Request donc les contenus de $_GET et $_POST sont 
            //        stockés dans l'attribut $parameters de $request

            // rnvs : start
            $verboseRequest = Configuration::get("verboseRequest");
            if ($verboseRequest) {
                echo '$_GET : ';
                var_dump($_GET);
                echo '<br/>';
                // Grâce à la redirection, toutes les URL entrantes sont du type :
                // index.php?controller=XXX&action=YYY&id=ZZZ
                // rnvs : redirection : voir webRoot/.htaccess

                echo '$_POST : ';
                var_dump($_POST);
                echo '<br/>';

                echo '$_SESSION : ';
                var_dump($_SESSION);
                echo '<br/>';
                // rnvs : session créée / continuée dans ctor de Session
                //        invoqué dans ctor de Request               

                echo '$request : ';
                var_dump($request);
                echo '<br/>';
            }
            // rnvs : stop

            $action = self::createAction($request);    // rnvs : ajout (static)
            // rnvs : $controller est une instance du contrôleur effectif 
            //        c'est via l'élément de clé 'controller' du tableau
            //        $request que le type effectif du contrôleur est déterminé
            //        sinon, par défaut, c'est ControllerHome
            // $controller = $this->createController($request); // rnvs : comm (static)
            $controller = self::createController($request, $action); // rnvs : ajout (static)

            // rnvs : $action est une chaîne de caractères
            //        c'est via l'élément de clé 'action' du tableau
            //        $request que l'action du contrôleur effectif est 
            //        déterminée
            //        il s'agit d'"index", par défaut
            // $action = $this->createAction($request); // rnvs : comm (static)
            // $action = self::createAction($request);    // rnvs : ajout (static)

            // rnvs : executeAction sert à setter l'action... et à l'exécuter
            //        c.-à-d. à invoquer la méthode du $controller dont le
            //        nom est contenu dans $action
            // rnvs : c'est dans Controller::executeAction que ça se passe
            //        pour le moment, on a instancié le contrôleur effectif
            //        et produit une string qui contient son action
            $controller->executeAction($action);

            // rnvs : ici on retourne à index.php qui termine
            //        donc ici le script ne fait plus rien : la page (réponse)
            //        a été envoyée au client, le traitement de la requête
            //        du client est terminé 

        } catch (Exception $e) {
            // rnvs : on peut arriver ici depuis :
            //          + Router::createController() :
            //            et aussi ensuite dans le ctor du contrôleur
            //            effectif, p. ex. lors de la connexion à la bd
            //            lors de la création du modèle effectif 
            //            (qui dérive de Model)
            //          + Controller::executeAction(), si l'action n'existe
            //            pas ou lors de l'exécution de l'action, p. ex.
            //            lors de la récupération des données du modèle

            // $this->handleError($e);  // rnvs : comm (static)
            self::handleError($e); // rnvs : ajout (static)

            // rnvs : Router::handleError() termine par View::generate()
            //        qui termine par la « fonction » echo qui envoie
            //        la réponse au serveur => on peut retourner à
            //        index.php et terminer le script
        }
    }

    /**
     * Instancie le contrôleur approprié en fonction de la requête reçue
     * 
     * rnvs : $request est un tableau associatif qui est le résultat de 
     *        le concaténation des tableaus $_GET et $_POST de la requête
     *        http
     * 
     * rnvs : retourne une instance du contrôleur effectif 
     *        le type effectif est renseigné via la valeur de l'élément
     *        de clé 'controller' du tableau $request ou est Home si
     *        pas d'élément de clé 'controller' dans ce tableau
     * 
     * @param Request $request Requête reçue
     * @param string $action the controller's action to perform
     * @return Instance d'un contrôleur
     * @throws Exception Si la création du contrôleur échoue
     */
    // private function createController(Request $request) {    // rnvs : comm (static)
    private static function createController(Request $request, $action)
    {    // rnvs : ajout (static)
        // Grâce à la redirection, toutes les URL entrantes sont du type :
        // index.php?controller=XXX&action=YYY&id=ZZZ
        // rnvs : redirection : voir webRoot/.htaccess

        $controller = "Home";  // Contrôleur par défaut
        if ($request->existingParameter('controller')) {
            // Première lettre en majuscule, les autres en minuscules
            // rnvs : https://www.php.net/manual/en/function.ucfirst.php
            // rnvs : https://www.php.net/manual/en/function.strtolower.php
            $controller = ucfirst(strtolower($request->getParameter('controller')));
            // rnvs : le contenu de la variable $controller est récupéré
            //        des $parameters de la Request $request, qui eux-mêmes 
            //        viennent des données GET et POST de la requête http
        }
        // rnvs : si pas de $_GET['controller'] ni de $_POST['controller']
        //        dans la requête http, alors pas de paramètre 'controller'
        //        dans $request et donc $controller vaut "Home"

        // Création (rnvs : construction) du nom du fichier du contrôleur
        // La convention de nommage des fichiers controllers est : 
        //          controller/Controller<$controller>.php
        // rnvs : construction dynamique du nom de la classe du contrôleur.
        //        ce nom correspond au nom simple (sans extension) 
        //        du fichier du contrôleur.
        // rnvs : par défaut (si pas de 'controller' dans la requête,
        //        $controller vaut "Home", 
        //        donc $classController vaut "ControllerHome"
        $classController = "Controller" . $controller;

        // rnvs : chemin complet vers le fichier où la classe du contrôleur
        //        est implémentée : chemin relatif + nom classe + extension
        $fileController = "controller/" . $classController . ".php";

        if (file_exists($fileController)) {
            // Instanciation du contrôleur adapté à la requête
            // rnvs : inclusion du fichier dont le nom vient d'être 
            //        dynamiquement construit !
            // rnvs : $fileController vaut "controller/ControllerHome.php"
            //        par défaut 
            require_once $fileController;

            // rnvs : instanciation d'un objet du type du contrôleur
            //        dont le nom a été construit dynamiquement sur base
            //        de la requête GET ou POST
            // rnvs : rappel $classController vaut "ControllerHome" par défaut
            $controller = new $classController($action);

            $controller->setRequest($request);

            return $controller;
        } else {
            throw new Exception("Fichier '$fileController' introuvable");

            // rnvs : cette exception est catchée dans Router::routerRequest()
        }
    }

    /**
     * Détermine l'action à exécuter en fonction de la requête reçue
     * 
     * rnvs : $request est un tableau associatif qui est le résultat de 
     *        le concaténation des tableaus $_GET et $_POST de la requête
     *        http
     * 
     * rnvs : retourne une chaîne qui indique l'action attendue
     *        cette action est renseignée via la valeur de l'élément
     *        de clé 'action' du tableau $request ou est "index" si
     *        pas d'élément de clé 'action' dans ce tableau
     * 
     * @param Request $request Requête reçue
     * @return string Action à exécuter
     */
    // private function createAction(Request $request) {    // rnvs : comm (static)
    private static function createAction(Request $request)
    {    // rnvs : ajout (static)
        $action = "index";  // Action par défaut

        if ($request->existingParameter('action')) {
            $action = $request->getParameter('action');
        }
        // rnvs : si $_GET['action'] ou $_POST['action'] existe alors $action
        //        n'est pas "index" (action par défaut)

        return $action;
    }

    /**
     * Gère une erreur d'exécution (exception)
     * 
     * rnvs : utilisé uniquement par routerRequest()
     * 
     * @param Exception $exception Exception qui s'est produite
     */
    private static function handleError(Exception $exception)
    {
        $env = Configuration::getEnvironement();
        // $env = "prod.ini";
        $view = new View('Template/files/message');
        $translator = $view->getTranslator();
        switch ($env) {
            case Configuration::ENV_DEV:
                // throw $exception;
                $datas = [
                    "title" => "dev error occured",
                    "content" => $exception->getMessage() . "<span style=\"display:none;\">" . $exception->__toString() . "</span>",
                    // "content" => $exception->__toString(),
                    "btnText" => "reload",
                    "btnLink" => ".",
                ];
                $view->generate($datas, View::TEMPLATE_ERROR);
                break;

            case Configuration::ENV_PROD:
            default:
                $brand = (new Map(Configuration::getFromJson(Configuration::JSON_KEY_COMPANY)))->get(Map::brand);
                $btnLink = ControllerSecure::extractController(ControllerGrid::class) . "?" . Page::KEY_FROM_ERROR_PAGE . "=" . time();
                $datas = [
                    "title" => $translator->translateStation("US106"),
                    "content" => $translator->translateStation("US107", new Map([Map::brand => strtoupper($brand)])),
                    "btnText" => $translator->translateStation("US105"),
                    "btnLink" => $btnLink,
                ];
                $view->generate($datas, View::TEMPLATE_ERROR);
                $rsp = new Response();
                $rsp->addError($exception->__toString(), MyError::ADMIN_ERROR);
                break;
        }
    }
}
