<?php

namespace App\Util;

use App\Controller\ErrorController as Error;

/**
 * Générateur de Captcha
 * 
 * 
 */
class Captcha {

    /**
     * Permet de créer un captcha
     * 
     */
    public function createCaptcha() {
        // Enregistrement du captcha en session
        $captchaCode = mt_rand(1000,9999);
        $_SESSION['captcha'] = $captchaCode;
        
        // Création de l'image
        $img = imagecreatetruecolor(200, 60);
        // Lien vers le fichier font
        $font = __DIR__ . '/../../public/assets/fonts/destroy.ttf';

        // RGB colors
        $bg = imagecolorallocate($img, 115, 190, 130);
        imagefill($img, 0, 0, $bg);
        $textcolor = imagecolorallocate($img, 255, 255, 255);
        $this->imagettftext_cr($img, 20, 0, 100, 24, $textcolor, $font, $captchaCode);

        ob_start();
        imagejpeg($img, NULL, 100);
        $output = ob_get_contents();
        imagedestroy($img); 
        ob_get_clean();

        return base64_encode($output);
    }

    /**
     * Put center-rotated ttf-text into image
     * Same signature as imagettftext();     * 
     * 
     * @link https://www.php.net/manual/fr/function.imagettftext.php#48938
     */
    private function imagettftext_cr($img, $size, $angle, $x, $y, $color, $fontfile, $text) {
        // retrieve boundingbox
        $bbox = imagettfbbox($size, $angle, $fontfile, $text);
        
        // calculate deviation
        $dx = ($bbox[2]-$bbox[0])/2.0 - ($bbox[2]-$bbox[4])/2.0;         // deviation left-right
        $dy = ($bbox[3]-$bbox[1])/2.0 + ($bbox[7]-$bbox[1])/2.0;        // deviation top-bottom
        
        // new pivotpoint
        $px = $x-$dx;
        $py = $y-$dy;
        
        return imagettftext($img, $size, $angle, $px, $py, $color, $fontfile, $text);
    }
}