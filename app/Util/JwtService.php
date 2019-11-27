<?php

namespace App\Util;

use App\Controller\ErrorController as Error;

/**
 * JSON Web Token Service
 * 
 * @link https://jwt.io/
 * @link https://dev.to/robdwaller/how-to-create-a-json-web-token-using-php-3gml
 * 
 */
class JwtService {

    const SECRET = CFG_JWT_SECRET;
    private $header;
    private $payload;
    private $signature;
    private $jwt;

    /**
     * Instanciation de la class JwtService
     * @param array $header
     * @param array $payload
     */
    public function __construct($payload, $header = array()) {

        // Informations saisies par défaut pour le header
        if(empty($header)) {
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS512'
            ];
        }

        $jsonHeader = json_encode($header);
        $jsonPayload = json_encode($payload);

        $this->header = self::base64UrlEncode($jsonHeader);
        $this->payload = self::base64UrlEncode($jsonPayload);
        $this->signature = self::generateSignature($this->header, $this->payload);

        $this->generateToken($this->header, $this->payload, $this->signature);
    }

    /**
     * Permet de générer une signature hash_hmac
     */
    private static function generateSignature($header, $payload) {
        $signature = self::base64UrlEncode((hash_hmac('sha512', $header . "." . $payload, self::SECRET, true)));

        return $signature;
    }

    /**
     * Permet de générer un token au format Json Web Token (JWT)
     * 
     */
    private function generateToken($header, $payload, $signature) {
        $jwt = $header . "." . $payload . "." . $signature;

        $this->jwt = $jwt;
    }

    /**
     * Encode une chaîne Url en MIME base64
     * @link https://www.php.net/manual/fr/function.base64-encode.php#123098
     */
    public static function base64UrlEncode($string) {
        return str_replace(['+','/','='], ['-','_',''], base64_encode($string));
    }

    /**
     * Encode une chaîne Url en MIME base64
     * @link https://www.php.net/manual/fr/function.base64-encode.php#123098
     */
    public static function base64UrlDecode($string) {
        return base64_decode(str_replace(['-','_'], ['+','/'], $string));
    }


    /**
     * Get the value of jwt
     */ 
    public function getJwt()
    {
        return $this->jwt;
    }

    /**
     * Permet de vérifier la validité d'un Json Web Token
     * 
     * @param string @token
     * @param bool @exp (vérification de la date d'expiration par défaut)
     */
    public static function checkJWT($token = null, $exp = true) {

        if(is_null($token)) {
            // Récupération du JWT
            if (isset($_SERVER['HTTP_AUTHORIZATION']) && !empty($_SERVER['HTTP_AUTHORIZATION'])) {
                if (preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
                    $jwt = $matches[1];
                } else {
                    Error::error401();
                }
            } else {
                Error::error401();
            }
        } else {
            $jwt = $token;
        }

        // Explode du JWT
        $jwtExplode = explode('.', $jwt);

        if(!empty($jwtExplode) && is_array($jwtExplode) && count($jwtExplode) === 3) {
            $header = $jwtExplode[0];
            $payload = $jwtExplode[1];
            $signature = $jwtExplode[2];

            $comparativeSignature = self::generateSignature($header, $payload);

            if($comparativeSignature === $signature) {
                // Vérification de la date d'expiration
                if($exp) {
                    $currentDate = date('Y-m-d H:i:s');
                    $payload = json_decode(self::base64UrlDecode($payload), 1);
                    $expDate = $payload['exp'];
    
                    $explodeCurrentDate = explode(' ', $currentDate);
                    $explodeExpDate = explode(' ', $expDate);
    
                    if($explodeExpDate[0] > $explodeCurrentDate[0]) {
                        return true;
                    } elseif ($explodeExpDate[0] == $explodeCurrentDate[0]) {
                        // Si la date du jour correspond à la date d'expiration,
                        // on compare alors l'heure
                        if($explodeExpDate[1] >= $explodeCurrentDate[1]) {
                            return true;
                        } else {
                            Error::error403();
                        }
                    } else {
                        Error::error403();
                    }
                }
                // Pas de vérification de la date d'expiration (uniquement la signature)
                else {
                    return true;
                }

            } else {
                Error::error401();
            }

        } else {
            Error::error401();
        }
    }
}