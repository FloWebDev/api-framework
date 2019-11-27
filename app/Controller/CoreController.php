<?php

namespace App\Controller;

abstract class CoreController {

    private $varList;
    private $user;

    /**
     * Constructeur du CoreController
     */
    public function __construct() {
        if(!empty($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
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
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
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
        // Variable utilisateur transmise à toutes les views
        $this->assign('user', $this->user);

        // Je boucle sur mes variables à ajouter à la vue
        if(!empty($this->varList)) {
            foreach($this->varList as $key => $value) {
                $$key = $value;
            }
        }

        // Inclusion des vues
        require __DIR__.'/../view/layout/header.php';
        require __DIR__.'/../view/' . $namePage . '.php';
        require __DIR__.'/../view/layout/footer.php';
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
}