<?php
class MasterLinkSpotifyFinder implements MasterLinkIFinder {
  private static $uri_base = "https://api.spotify.com/v1/search?query=upc:%d&offset=0&limit=1&type=album";

  public function __construct() {
    $spotifyAuthToken = get_option('master_link_plugin_spotify_auth');
    if($spotifyAuthToken == NULL) {
      throw new Exception('Spotify authentication not setup');
    }
  }

  public function find($upc,$name) {
    $searchData = $this->getData($upc);
    if(isset($searchData->albums->items[0])) {
      $return = array();
      $return['id'] = str_replace("https://open.spotify.com/","",$searchData->albums->items[0]->external_urls->spotify);
      $return['cover'] = $searchData->albums->items[0]->images[0]->url;
      return $return;
    } else {
      return null;
    }
  }

  private function searchURI($upc) {
    return sprintf(MasterLinkSpotifyFinder::$uri_base,$upc);
  }

  private function getData($upc) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Authorization: Bearer '.get_option('record_label_spotify_auth'),
      'x-requested-wth: XMLHttpRequest',
      'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36',
    ));
    curl_setopt($ch, CURLOPT_URL, $this->searchURI($upc));
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result);
  }
}
?>
