<?php
class Ginger extends KoalaClient {
  private $key;

  public function __construct($key){
    $this->url = "http://assos.utc.fr/ginger/v1/";
    $this->key = $key;
  }
  
  public function apiCall($endpoint, $params = array(), $method = "GET") {
    // Ajout de la clé aux requêtes et appel du parent
    $params = array_merge($params, array("key" => $this->key));
    return parent::apiCall($endpoint, $params, $method);
  }
  
  public function getLogin($login) {
    return $this->apiCall($login);
  }
  
  public function getCotisations($login) {
    return $this->apiCall("$login/cotisations");
  }
  
  public function addCotisation($login, $debut, $fin){
    $params = array(
      "debut" => $debut,
      "fin" => $fin
    );
    return $this->apiCall("$login/cotisations", $params, "POST");
  }
}
?>
