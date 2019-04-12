<?php

include($_SERVER['DOCUMENT_ROOT'] . "simple_html_dom.php");
include($_SERVER['DOCUMENT_ROOT'] . "DiplomskiRadovi.php");
$object = [];

for($i = 2; $i <= 6; $i++){
  $url = "http://stup.ferit.hr/index.php/zavrsni-radovi/page/" . $i . "/";

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


  $result = curl_exec($ch);

  $dom_object = new simple_html_dom();

  $dom_object -> load($result);



  foreach($dom_object -> find('article') as $element) {
      $naziv_rada = $element -> find('div.fusion-post-content.post-content a', 0) -> plaintext;
      $tekst_rada = $element -> find('div.fusion-post-content.post-content p', 0) -> plaintext;
      $link_rada = $element -> find('div.fusion-post-content.post-content a', 0) -> href;
      $oib_tvrtke = $element -> find('img', 0) -> src;

      // echo($naziv_rada . "<br>");
      // echo($tekst_rada . "<br>");
      // echo($link_rada . "<br>");
      // echo($oib_tvrtke . "<br> <br>");

      $oibLength = strlen($oib_tvrtke);
      //echo($oibLength . "<br>");

      $startPosition = $oibLength - 15;
      $oib = substr($oib_tvrtke, $startPosition, 11);

      //echo($oib . "<br> <br>");

      $dataObject = array("naziv_rada" => $naziv_rada, "tekst_rada" => $tekst_rada,
          "link_rada" => $link_rada, "oib_tvrtke" => $oib);

      $oib = null;
      $object[] = new DiplomskiRadovi($dataObject);

      //print_r($object);
      //echo("<br><br>");
      //print_r($dataObject);

  }


  //$object -> read();
  //echo("<br><br>");
  //echo $result;
  curl_close($ch);
}


print_r($object);

?>
