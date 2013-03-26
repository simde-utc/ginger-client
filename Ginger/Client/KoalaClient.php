<?php
namespace Ginger\Client;

class KoalaClient {
  protected $url = "";
  protected $useragent = "KoalaClient/0.1";

  protected function apiCall($endpoint, $params = array(), $method = "GET") {
    // Construction de la chaîne de paramètres
    $paramstring = "";
    if (!empty($params)) {
      foreach ($params as $key => $param) {
        $paramstring .= $key . "=" . $param . "&";
      }
      // On supprimer le dernier &
      $paramstring = substr($paramstring, 0, -1);
    }
    
    // Réglages de cURL
    $settings = array(
      CURLOPT_USERAGENT => $this->useragent,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_CAINFO => __DIR__."/../../TERENA_SSL_CA.pem",
    );
    
    // Construction de l'URL et des postfields
    if($method == "GET"){
      $url = $this->url . $endpoint . "?" . $paramstring;
    }
    else {
      $url = $this->url . $endpoint;
      $settings[CURLOPT_POSTFIELDS] = $params;
    }
    
    // Initialisation de cURL
    $ch = curl_init($url);
    curl_setopt_array($ch, $settings);

    // Éxécution de la requête
    $result = curl_exec($ch);
    
    // Si erreur d'appel de cron
    if (curl_errno($ch) != 0) {
      throw new ApiException(503);
    }
    // Si erreur http, on la renvoie
    else if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
      throw new ApiException(curl_getinfo($ch, CURLINFO_HTTP_CODE));
    }
    // Sinon, on renvoie les infos
    else {
      return json_decode($result);
    }
  }
}

?>
