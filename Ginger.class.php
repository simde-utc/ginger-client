<?php


require_once 'KoalaClient.class.php';


class Ginger extends KoalaClient {
  private $key;

  public function __construct($key){
    $this->url = "https://assos.utc.fr/ginger/v1/";
    $this->key = $key;
  }
  
  public function apiCall($endpoint, $params = array(), $method = "GET") {
    // Ajout de la clé aux requêtes et appel du parent
    $params["key"] = $this->key;
    return parent::apiCall($endpoint, $params, $method);
  }
  
  /**
   * Récupérer un utilisateur à partir d'un login ou d'un
   * id de badge (si la clé l'autorise).
   *
   * @param string $ident Identification (login ou badge)
   * @return object Utilisateur
   */
  public function getUser($ident) {
    return $this->apiCall($ident);
  }
  
  public function findPersonne($loginPart) {
    return $this->apiCall("find/$loginPart");
  }
  
  public function getCotisations($login) {
    return $this->apiCall("$login/cotisations");
  }
  
  public function addCotisation($login, $debut, $fin, $montant){
    $params = array(
      "debut" => $debut,
      "fin" => $fin,
      "montant" => $montant,
    );
    return $this->apiCall("$login/cotisations", $params, "POST");
  }
}
?>
