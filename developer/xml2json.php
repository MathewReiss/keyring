<?php
  header("Access-Control-Allow-Headers: Content-Type");
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET");
  header("Content-Type: application/json");
  
  if(isset($_GET['url'])){
    $url = $_GET['url'];
  }
  else{
    $array = array(success => false, error => "No URL provided");
    echo json_encode($array, JSON_PRETTY_PRINT);
    exit;
  }
  
  $xml_string = file_get_contents($url);
  $xml = simplexml_load_string($xml_string);
  echo json_encode($xml, JSON_PRETTY_PRINT);
 
?>
