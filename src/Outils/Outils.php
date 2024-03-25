<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Outils
 *
 * @author Utilisateur
 */

namespace App\Outils;
use App\Entity\Licencie;
use Symfony\Component\Security\Core\Security;
use App\Repository\CompteRepository;
class Outils {

    public static function GetLicencieByNumLicence(string $num) {
        try{
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:81/licencie/numlicence/' . $num . '/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if($response == null) {
            return null;
        }
         $licencie = json_decode($response);
        return $licencie;
        } catch (Exception) {
          curl_close($curl);
          echo "<h1>Une Erreur est Survenue lors de la recherche du licencié</h1>";
        }
    }
    
    
}
