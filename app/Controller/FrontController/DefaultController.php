<?php

namespace App\Controller\FrontController;

use App\Util\Captcha;
use App\Model\EntityModel;
use App\Util\JwtService;
use App\Controller\CoreController;
use App\Model\CategoryModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class DefaultController extends CoreController {
    /**
     * Permet d'afficher la page d'accueil
     */
    public function homePage() {
        $categoryInstance = new CategoryModel();
        $categories = $categoryInstance->getAll();

        // Récupération et formatage de toutes les listes de catégories
        // afin de l'inscrire dans la documentation
        $formatCategoryList = '';
        if(!empty($categories) && is_array($categories)) {
            foreach($categories as $index => $category) {
                if($index !== (count($categories) - 1)) {
                    $formatCategoryList .= $category->getName() . ', ';
                } else {
                    $formatCategoryList .= $category->getName();
                }
            }
            unset($category);
        }
        
        $this->assign('pageTitle', 'Page d\'accueil de cette API');
        $this->assign('pageDescription', 'Page d\'accueil de cette API');
        $this->assign('h2Title', 'Documentation API');
        $this->assign('categoryList', $formatCategoryList);
        $this->showView('homePage');
    }

    /**
     * Permet d'alimenter la BDD via des appels à différentes API
     */
    public function alimCurl() {        

        ////////////////////
        // Blagues
        ////////////////////

        $url = 'https://bridge.buddyweb.fr/api/blagues/blagues';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $jsonResponse = curl_exec($curl);
        $response = json_decode($jsonResponse, 1);
        curl_close($curl);

        $entitiesToInsert = array();

        foreach($response as $value) {
            $entitiesToInsert[] = $value['blagues'];
        }
        unset($value);

        foreach($entitiesToInsert as $content) {
            $newEntity = new EntityModel();
            $newEntity->setContent($content);
            $newEntity->setCategoryId(1);
            $result = $newEntity->new();
        }
        unset($content);
        unset($entitiesToInsert);

        ////////////////////
        // Chuck Norris Fact
        ////////////////////

        $url = 'https://www.chucknorrisfacts.fr/api/get?data=nb:99';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            // 'Content-type: text/html; charset=UTF-8'
        ));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $jsonResponse = curl_exec($curl);
        $response = json_decode($jsonResponse, 1);
        curl_close($curl);

        $entitiesToInsert = array();
       
        foreach($response as $value) {
            $entitiesToInsert[] =  str_replace('&#039;', '\'', strip_tags((html_entity_decode($value['fact']))));
        }
        unset($value);

        // dd($entitiesToInsert);

        foreach($entitiesToInsert as $content) {
            $newEntity = new EntityModel();
            $newEntity->setContent($content);
            $newEntity->setCategoryId(2);
            $result = $newEntity->new();
        }
        unset($content);
        unset($entitiesToInsert);

        ////////////////////
        // Blagues
        ////////////////////

        $entitiesToInsert = array();

        for($index = 1; $index <= 102; $index++) {
            $url = 'https://blague.xyz/joke/' . $index;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $jsonResponse = curl_exec($curl);
            $response = json_decode($jsonResponse, 1);
            curl_close($curl);

            $entitiesToInsert[] = $response['joke']['question'] . "\n" . $response['joke']['answer'];
        }

        foreach($entitiesToInsert as $content) {
            $newEntity = new EntityModel();
            $newEntity->setContent($content);
            $newEntity->setCategoryId(3);
            $result = $newEntity->new();
        }
        unset($content);
        unset($entitiesToInsert);


        ////////////////////
        // Résultat final
        ////////////////////

        $instance = new EntityModel();
        $result = $instance->getAll();
        dump($result);
        
    }

    /**
     * Permet de tester les JWT via l'en-tête HTTP
     */
    public function jwt() {

        JwtService::checkJWT();

        $array = [
            'code' => 'Bravo !',
            'message' => 'JWT reconnu avec succès !'
        ];

        $this->showJson($array);
    }

    /**
     * Permet d'afficher la page d'accueil
     */
    public function token() {

        if(!empty($_POST)) {
            if(!empty($_POST['email'])) {
                $_SESSION['email'] = $_POST['email'];
            }

            if(empty(trim($_POST['email'])) || empty(trim($_POST['captcha']))) {
                $this->flash('Informations manquantes.<br>Vous devez renseigner votre <strong>adresse email</strong> et <strong>les 4 chiffres affichés dans l\'image</strong>.', 'danger');
                $this->redirect('/token');
            }

            $email = strip_tags(trim($_POST['email']));
            $captcha = intval($_POST['captcha']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->flash('Adresse email invalide.', 'danger');
                $this->redirect('/token');
            }

            if ($captcha !== $_SESSION['captcha']) {
                $this->flash('Les chiffres saisis sont incorrects.', 'danger');
                $this->redirect('/token');
            }

            // On unsette l'email enregistré en $_SESSION car tous les contrôles ont été vérifiés
            unset($_SESSION['email']);
            
            // Génération d'un token JWT
            $payload = [
                'sub' => uniqid(),
                'exp' => date('Y-m-d H:i:s', strtotime('+2 days')),
                'test' => '+/='
            ];

            $jwtService = new JwtService($payload);
            $token = $jwtService->getJwt();

            // Envoi du mail pour communiquer le token
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = CFG_EMAIL_DEBUG;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = CFG_EMAIL_HOST;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = CFG_EMAIL_USERNAME;                     // SMTP username
                $mail->Password   = CFG_EMAIL_PASSWORD;                               // SMTP password
                $mail->SMTPSecure = CFG_EMAIL_ENCRYPTION;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = CFG_EMAIL_PORT;                                    // TCP port to connect to
            
                //Recipients
                $mail->setFrom(CFG_EMAIL_USERNAME, 'Webmaster');
                $mail->addAddress($email, 'User ' . $email);     // Add a recipient
                // $mail->addAddress('ellen@example.com');               // Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');
            
                // Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Votre Json Web Token';
                $mail->Body    = '<p>Bonjour,</p> <p>Voici le token au format JWT que vous avez demandé : <strong>' . $token . '</strong></p><p>Ce token est valable 48 heures et doit être renseigné  dans l\'en-tête d\'autorisation HTTP de vos requêtes lorsque la route utilisée nécessite une autentification.</p><p>Pour plus de détails, reportez-vous à la documentation présente sur le site.</p><p>A bientôt.<br>Florian - FloWebDev</p>';
                $mail->AltBody = 'Bonjour, Voici le token au format JWT que vous avez demandé : ' . $token . ' Ce token est valable 48 heures et doit être renseigné  dans l\'en-tête d\'autorisation HTTP de vos requêtes lorsque la route utilisée nécessite une autentification. Pour plus de détails, reportez-vous à la documentation présente sur le site. A bientôt. Florian - FloWebDev';
            
                $mail->send();

                // echo 'Message has been sent';
                $this->flash('Un email contenant le token demandé vous a été envoyé.', 1);
                $this->redirect('/token');
            } catch (Exception $e) {
                // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $this->flash('L\'email n\'a pas pu être envoyé. Message d\'erreur : ' . $mail->ErrorInfo, 1);
                $this->redirect('/token');
            }
        }

        $captchaService = new Captcha();
        $captcha = $captchaService->createCaptcha();

        $this->assign('pageTitle', 'Générer un token JWT');
        $this->assign('pageDescription', 'Générer un token JWT pour bénéficier de tous les avantages d\'API Entity');
        $this->assign('h2Title', 'Demande d\'un JWT');
        $this->assign('captcha', $captcha);
        $this->showView('token');
    }

    /**
     * Permet d'afficher la page d'accueil
     */
    public function scrapping() {
        $entityArray = array();

        $url = "https://entities-de-papa.com/blagues-courtes/";

        for($page = 1; $page <= 250; $page++) {
            $content = file_get_contents($url);

            preg_match_all("#<blockquote class=\"quotescollection-quote\"><p><b>(.+)</b><br><br />(.+)</p><footer class=\"attribution\">&mdash;&nbsp;<cite class=\"author\">@Entitys de papa</cite>#iU", $content, $result);
    
            foreach($result[1] as $key => $entity) {
                $entity = str_replace('@Entitys de papa', '', strip_tags((html_entity_decode($entity))) . "\n" . strip_tags((html_entity_decode($result[2][$key]))));
    
                if(!in_array($entity, $entityArray)) {
                    $entityArray[] = $entity;
                }
            }
        }

        // dd($entityArray);

        foreach($entityArray as $content) {
            $newEntity = new EntityModel();
            $newEntity->setContent($content);
            $newEntity->setCategoryId('Devinette');
            $result = $newEntity->new();
        }
        
        ////////////////////
        // Résultat final
        ////////////////////

        $instance = new EntityModel();
        $result = $instance->getAll();
        dump($result);

    }
}