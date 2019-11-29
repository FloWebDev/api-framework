<?php

namespace App\Controller;

class ErrorController extends CoreController {

    /**
     * error404
     * HTTP/1.1 404 Not Found
     * version HTML
     * 
     */
    public function error404Html() {
        header("HTTP/1.1 404 Not Found");

        $params = [
            'h1Title' => '404',
            'h2Title' => 'Erreur 404 - Page introuvable',
            'pageTitle' => 'Erreur 404 - Page introuvable',
            'pageDescription' => 'Erreur 404 - Page introuvable',
            'pageKeywords' => 'erreur 404'
        ];

        // Variables transmises à la vue
        foreach($params as $key => $value) {
            $$key = $value;
        }

        // Récupération de la vue 404 avec Header et Footer spécifiques
        require __DIR__ . '/../views/error/error404.php';
    }
    
    /**
     * error404
     * HTTP/1.1 404 Not Found
     * 
     */
    public static function error404() {
        header('Content-Type: application/json');
        header("HTTP/1.1 404 Not Found");

        $array = [
            'code' => 404,
            'status' => 'HTTP/1.1 404 Not Found',
            'message' => 'Ressource non trouvée.'
        ];

        echo json_encode($array);
        exit;
    }

    /**
     * error401
     * HTTP/1.1 401 Unauthorized
     * 
     */
    public static function error401() {
        header('Content-Type: application/json');
        header("HTTP/1.1 401 Unauthorized");

        $array = [
            'code' => 401,
            'status' => 'HTTP/1.1 401 Unauthorized',
            'message' => 'Accès refusé. Une authentification est nécessaire pour accéder à la ressource.'
        ];

        echo json_encode($array);
        exit;
    }

    /**
     * error403
     * HTTP/1.1 403 Forbidden
     * 
     */
    public static function error403() {
        header('Content-Type: application/json');
        header("HTTP/1.1 403 Forbidden");

        $array = [
            'code' => 403,
            'status' => 'HTTP/1.1 403 Forbidden',
            'message' => 'Accès refusé. Les droits d\'authentification ne permettent pas l\'accès à la ressource.'
        ];

        echo json_encode($array);
        exit;
    }
}