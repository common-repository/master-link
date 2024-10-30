<?php
class MasterLinkTidalFinder implements MasterLinkIFinder {
  private static $uri_base = "https://api.tidalhifi.com/v1/search?query=%s&limit=3&offset=0&types=ALBUMS&countryCode=AU";

  public function __construct() {
  }

  public function find($upc,$name) {
    $searchData = $this->getData($name);
    if(isset($searchData->albums->items[0])) {
      $item = $searchData->albums->items[0];
      $return = array();
      if($item->upc == $upc) {
        $return['id'] = $item->id;
      }
      return $return;
    }
  }

  private function searchURI($name) {
    return sprintf(MasterLinkTidalFinder::$uri_base,urlencode($name));
  }

  private function getData($name) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'X-Tidal-Token: wdgaB1CilGA-S_s2',
      'x-requested-wth: XMLHttpRequest',
      'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36',
      'Referrer: https://listen.tidal.com/artist',

    ));
    curl_setopt($ch, CURLOPT_URL, $this->searchURI($name));
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result);
  }
}
?>
