<?php

namespace App\Controller;

abstract class CoreController {

    private $namedRoutes;
    private $basePath = CFG_BASE_PATH;
    private $varList;
    private $user;
    private $token;

    /**
     * Constructeur du CoreController
     */
    public function __construct() {

        // Initialisation du CORS
        $this->initCors();

        if(!empty($_SESSION['namedRoutes'])) {
            $this->namedRoutes = $_SESSION['namedRoutes'];
        }

        if(!empty($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
        }

        if(!empty($_SESSION['token'])) {
            $this->token = $_SESSION['token'];
        }
    }

    /**
     * Permet de retourner un résultat au format JSON
     * 
     * @param array $array
     */
    protected function showJson($array)
    {
        // Autorise l'accès à la ressource depuis n'importe quel autre domaine
        // PLUS UTILE DEPUIS CREATION METHODE setCors() dans le __construct
        // header("Access-Control-Allow-Origin: *");
        // header('Access-Control-Allow-Credentials: true');
        // Indique au navigateur que la réponse est au format JSON
        header('Content-Type: application/json');
        // Retourne une réponse au format JSON
        echo json_encode($array);
        exit;
    }

    /**
     * Permet d'afficher une vue, un template
     */
    protected function showView($namePage)
    {
        // Variables transmises à toutes les views
        $this->assign('router', new static()); // Nécessaire pour que la view puisse utliser la méthode generate servant à générer des routes dynamiquement
        $this->assign('user', $this->user);
        $this->assign('token', $this->token);

        // Je boucle sur mes variables à ajouter à la vue
        if(!empty($this->varList)) {
            foreach($this->varList as $key => $value) {
                $$key = $value;
            }
        }

        // Inclusion des vues
        require __DIR__.'/../views/layout/header.php';
        require __DIR__.'/../views/' . $namePage . '.php';
        require __DIR__.'/../views/layout/footer.php';
    }

    /**
     * Permet de transmettre des variables au front
     */
    protected function assign($varName, $varValue)
    {
        $this->varList[$varName] = $varValue;
    }

    /**
     * Permet de créer un message flash (message d'alerte à l'utilisateur)
     * 
     * @param string $message
     * @param string $type
     */
    protected function flash($message, $type = 1)
    {
        // Type de message
        $type = $type === 1 ? 'success' : 'danger';

        // Création du message flash en session
        $_SESSION['flash'] = [
            'message' => $message,
            'type' => $type
        ];
    }

    /**
     * Permet d'effectuer une redirection
     * 
     * @param string $path
     */ 
    public function redirect($path)
    {
        header('Location: ' . $path);
        exit; // Pour stopper toute éventuelle continuation d'exécution de script
    }

    /**
     * Reversed routing / Routing inversé
     *
     * Permet de générer une url en fonction d'une route donnée.
     * Remplace les regex avec les paramètres fournies
     *
     * @param string $routeName Le nom de la route.
     * @param array @params Tableau associatif des paramètres à fournir dans la route.
     * @return string L'URL de la route avec les paramètres si nécessaire.
     * @throws Exception
     */
    public function generate($routeName, array $params = [])
    {

        // Check if named route exists
        if (!isset($this->namedRoutes[$routeName])) {
            throw new RuntimeException("Route '{$routeName}' does not exist.");
        }

        // Replace named parameters
        $route = $this->namedRoutes[$routeName];

        // prepend base path to route url again
        $url = $this->basePath . $route;

        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $index => $match) {
                list($block, $pre, $type, $param, $optional) = $match;

                if ($pre) {
                    $block = substr($block, 1);
                }

                if (isset($params[$param])) {
                    // Part is found, replace for param value
                    $url = str_replace($block, $params[$param], $url);
                } elseif ($optional && $index !== 0) {
                    // Only strip preceding slash if it's not at the base
                    $url = str_replace($pre . $block, '', $url);
                } else {
                    // Strip match block
                    $url = str_replace($block, '', $url);
                }
            }
        }

        return $url;
    }

    /**
     * Permet d'initialiser le «  Cross-origin resource sharing » (CORS) ou « partage des ressources entre origines multiples »
     * @link https://stackoverflow.com/questions/8719276/cross-origin-request-headerscors-with-php-headers
     * 
     * @return void
     */
    private function initCors() {
        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            header('Access-Control-Allow-Credentials: true');
            // Tell client that this pre-flight info is valid for 1 day
            header('Access-Control-Max-Age: 86400');
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
            }

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
                header('Access-Control-Allow-Headers: ' . $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
            }

            exit;
        }
    }
}