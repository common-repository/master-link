<?php
/*
Plugin Name:  Master Link PostType
Plugin URI:   https://ignite.digitalignition.net/code/master-link-wordpress-plugin/
Description:  Create a page that links users to multiple remote services
Author:       Greg Tangey
Author URI:   http://ignite.digitalignition.net/
Version:      0.4.1
*/

/*  Copyright 2015  Greg Tangey  (email : greg@digitalignition.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('MasterLink_Plugin'))
{
  class MasterLink_Plugin
  {
    public $slug = "master";

    public $services = array(
      // Apps
      "ios" => array(
        "href" => "https://itunes.apple.com/app/id%s",
        "uri" => "itms://itunes.apple.com/app/id%s",
        "validation" => "^\d+$",
        "validation-error" => "Must be a number (valid characters [0-9])",
        "name" => "iOS App Store",
        "image" => "app-ios_appstore.svg",
        "verb" => "Download",
        "search" => "https://itunes.apple.com/lookup?upc=%d",
      ),
      "play" => array(
        "href" => "https://play.google.com/store/apps/details?id=%s",
        "uri" => "market://details?id=%s",
        "validation" => "^[a-z][a-z0-9_]*(\.[a-z0-9_]+)+[0-9a-z_]$",
        "validation-error" => "Must be a google package name eg. com.company.product",
        "name" => "Google Play Apps",
        "image" => "app-google_play.svg",
        "verb" => "Download",
        "search" => "https://itunes.apple.com/lookup?upc=%d",
      ),
      "steam" => array(
        "href" => "https://store.steampowered.com/app/%s",
        "uri" => "steam://store/%s",
        "validation" => "^\d+$",
        "validation-error" => "Must be a number (valid characters [0-9])",
        "name" => "Steam",
        "image" => "app-steam.svg",
        "verb" => "Download",
      ),
      "itch.io" => array(
        "href" => "%s",
        "name" => "itch.io",
        "validation" => "^http[s]?:\/\/[\d\w-]*.itch.io\/[\d\w\-]+[\/]*$",
        "validation-error" => "Must be a twitch.io URL eg. http://company.twitch.io/game",
        "image" => "app-itchio.svg",
        "verb" => "Download",
      ),
      "amazon" => array(
        "href" => "http://www.amazon.com/gp/mas/dl/android?asin=%s",
        "uri"  => "amzn://apps/android?asin=%s",
        "validation" => "^B\d{2}[\d\w]{7}$",
        "validation-error" => "Must be in Amazon ASIN format eg. B00XXXXXXX",
        "name" => "Amazon AppStore",
        "verb" => "Download",
      ),
      //Music
      "soundcloud" => array(
        "href" => "http://soundcloud.com/%s",
        "name" => "soundcloud",
        "validation" => "^[\d\w-]+\/[\d\w-]+(?:[\/]*[\d\w-]+[\/]*)?$",
        "validation-error" => "Must be a valid soundcloud path eg. percuss/some-misc-beats",
        "image" => "music-soundcloud.svg",
        "verb" => "Play",
      ),
      "itunes" => array(
        "href" => "https://geo.itunes.apple.com/album/id%s?app=itunes",
        "name" => "iTunes",
        "validation" => "^\d+$",
        "validation-error" => "Must be a number (valid characters [0-9])",
        "image" => "music-itunes.svg",
        "verb" => "Buy",
        "search" => "https://itunes.apple.com/lookup?upc=%d",
      ),
      "applemusic" => array(
        "href" => "https://geo.itunes.apple.com/album/id%s?app=music",
        "validation" => "^\d+$",
        "validation-error" => "Must be a number (valid characters [0-9])",
        "name" => "Apple Music",
        "image" => "music-applemusic.svg",
        "verb" => "Play",
        "search" => "https://itunes.apple.com/lookup?upc=%d",
      ),
      "spotify" => array(
        "href" => "https://play.spotify.com/%s",
        "name" => "Spotify",
        "validation" => "^(?:track|album|playlist){1}\/[\d\w]+[\/]?$",
        "validation-error" => "Valid entries: track/67ZtrOJUwg4nCkhBCOigf0, album/1lkQlHpb6gwUrOZiNrMEpO",
        "image" => "music-spotify.svg",
        "verb" => "Play",
        "search" => "https://api.spotify.com/v1/search?q=upc:%d&type=album"
      ),
      "guvera" => array(
        "href" => "https://www.guvera.com/tracks/%s",
        "name" => "Guvera",
        "validation" => "^\d{32}$",
        "validation-error" => "Must be a 32 chacter number",
        "image" => "music-guvera.svg",
        "verb" => "Play",
      ),
      "deezer" => array(
        "href" => "http://www.deezer.com/album/%s",
        "name" => "Deezer",
        "validation" => "^\d+$",
        "validation-error" => "Must be a number",
        "image" => "music-deezer.svg",
        "verb" => "Play",
        "search" => "http://api.deezer.com/album/upc:%d"
      ),
      "bandcamp" => array(
        "href" => "%s",
        "name" => "bandcamp",
        "validation" => "^http[s]?:\/\/[\d\w-]+.bandcamp.com\/(?:album|track)\/[\d\w-]+[\/]*$",
        "validation-error" => "Must be a bandcamp url to a track or album",
        "image" => "music-bandcamp.svg",
        "verb" => "Play",
      ),
      "unearthed" => array(
        "href" => "%s",
        "name" => "JJJ Unearthed",
        "verb" => "Play",
      ),
      "youtube" => array(
        "href" => "https://www.youtube.com/watch?v=%s",
        "name" => "YouTube",
        "validation" => "^[a-zA-Z0-9_-]{11}$",
        "validation-error" => "Must be a YouTube video ID",
        "image" => "music-youtube.svg",
        "verb" => "Watch",
      ),
      "playmusic" => array(
        "href" => "https://play.google.com/store/music/album?id=%s",
        "name" => "Google Play Music",
        "validation" => "^[\d\w]+$",
        "validation-error" => "Must be a Google Play ID eg. Blduvfldunucxohaj73355i36fa",
        "image" => "music-google_play.svg",
        "verb" => "Buy",
      ),
      "tidal" => array(
        "href" => "https://tidal.com/au/store/%s",
        "name" => "Tidal",
        "validation" => "^\d+$",
        "validation-error" => "Must be a Tidal ID eg. 66437760",
        "image" => "music-tidal.svg",
        "verb" => "Play",
      ),
      "other" => array(
        "href" => "%s",
        "name" => "Other"
      )
    );

    public function __construct()
    {
      // Initialize Settings
      require_once(sprintf("%s/settings.php", dirname(__FILE__)));
      include_once( ABSPATH . 'wp-admin/includes/plugin.php');

      $MasterLink_Plugin_Settings = new MasterLink_Plugin_Settings();
      $this->slug = get_option('master_link_plugin-slug',$this->slug);

      $plugin = plugin_basename(__FILE__);
      add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
      add_action("init", array($this, 'create_post_types'));
      add_action('add_meta_boxes', array($this,'add_custom_meta_boxes'));
      add_action( 'admin_init', array($this,'add_meta_box_js'));
      add_action('save_post', array($this,'save_custom_meta'), 10, 3 );
      add_action( 'wp_enqueue_scripts',array($this,'add_scripts'));
      add_filter( 'single_template', array($this,'master_link_add_template'), 10);
      // if(class_exists(Hum) && is_plugin_active("hum/hum.php")) {
        add_filter('hum_local_types', array($this,'master_link_hum_local_types'));
        add_filter('hum_type_prefix', array($this,'master_link_hum_type_prefix'), 10, 2);
      // }
    }

    function master_link_hum_local_types( $types ) {
      $types[] = 'm';
      return $types;
    }

    function master_link_hum_type_prefix( $prefix, $post_id ) {
      $post = get_post( $post_id );

      if ( $post->post_type == 'master_link' ) {
        $prefix = get_option('master_link_plugin-hum','m');
      }

      return $prefix;
    }

    function master_link_add_template( $single_template )
    {
      $postID = get_the_ID();
      if(get_post_type($postID) != 'master_link') {
        return $single_template;
      }
      if(get_option('master_link_plugin-use_template',1) != 1) {
        return $single_template;
      }
      else {
        global $image_dir, $app_links, $post_image;
        $image_dir = trailingslashit( plugin_dir_url(__FILE__) ).'images/';
        $app_links = $this->master_link_get_links();
        $post_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
        $templateName = "single-master_link.php";
        return master_link_getDisplayTemplate($templateName);
      }
    }

    function headers() {
      $app_links = $this->master_link_get_links();
      foreach($app_links as $service => $service_id) {
        switch($service) {
          case "ios":
            ?><meta name="apple-itunes-app" content="app-id=<?php echo $service_id; ?>"><?php
            break;
          case "play":
            ?><?php
            break;
        }
      }
    }

    function master_link_get_links() {
      global $post;
      $app_links = array();
      $meta = get_post_meta($post->ID);
      foreach($this->services as $service_id => $service) {
        $key = "master_link_plugin-".$service_id."_link_id";
        if($meta[$key] != "") {
          $app_links[$service_id] = $meta[$key][0];
        }
      }
      return $app_links;
    }

    function add_scripts() {
      if(get_option('master_link_plugin-use_template',1) == 1) {
        wp_enqueue_script("jquery");
        wp_enqueue_script('jsbarcode', trailingslashit( plugin_dir_url(__FILE__) ).'JsBarcode.js', false );
        wp_enqueue_script('master_link-scripts', trailingslashit( plugin_dir_url(__FILE__) ).'scripts.js', false );
        wp_enqueue_style('master_link-stylesheets', trailingslashit( plugin_dir_url(__FILE__) ).'stylesheet.css', false );
      }
    }

    function create_post_types() {

      $args = array(
        'labels' => array(
          'name' => __( 'Master Links' ),
          'singular_name' => __( 'Master Link' ),
          'add_new_item' => __( 'Add New Master Link' ),
          'edit_item' => __( 'Edit Master Link' ),
          'new_item' => __( 'New Master Link' ),
          'view_item' => __( 'View Master Link' ),
          'search_items' => __( 'Search Master Links' ),
          'not_found' => __( 'No master links found' ),
          'not_found_in_trash' => __( 'No master links found in Trash' ),
          'parent_item_colon' => __( 'Parent Master Link:' ),
          'all_items' => __( 'All Master Links' ),
          'archives' => __( 'Master Link Archives' ),
          'insert_into_item' => __( 'Insert into master link' ),
          'uploaded_to_this_item' => __( 'Uploaded to this master link' ),
          'featured_image' => __( 'Cover Image' ),
          'set_featured_image' => __( 'Set cover image' ),
          'remove_featured_image' => __( 'Remove cover image' ),
          'use_featured_image' => __( 'Use as cover image' ),
          'filter_items_list' => __( 'Filter master link' ),
          'items_list_navigation' => __( 'Master links list navigation' ),
          'items_list' => __( 'Master links list' ),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title','editor','thumbnail'),
        'rewrite' => array('slug' => $this->slug),
      );

      register_post_type('master_link',$args);
      flush_rewrite_rules();

      add_action( 'edit_form_after_title', array( $this, 'add_subtitle_field' ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'load_custom_wp_admin_style') );
    }

    function load_custom_wp_admin_style($hook) {
      global $post;
      if($post->post_type == "master_link") {
        wp_register_style( 'master_link_admin_css', trailingslashit( plugin_dir_url(__FILE__) ).'admin.css', false, '1.0.0' );
        wp_enqueue_style( 'master_link_admin_css' );
      }
    }

    function add_subtitle_field($post) {
      if($post->post_type == "master_link") {
        $subtitle = get_post_meta($post->ID, "master_link_subtitle", true);
        ?>
        <div id="subtitlediv" class="top">
          <div id="subtitlewrap">
            <input type="text" id="wpsubtitle" name="master_link_subtitle" value="<?php echo $subtitle; ?>" autocomplete="off" placeholder="Enter a subtitle here" />
          </div>
        </div>
        <?php
      }
    }

    function add_custom_meta_boxes() {
        add_meta_box(
            'master_links', // $id
            __('Master Links'), // $title
            array($this,'show_master_link_meta_box'), // $callback
            'master_link', // $page
            'normal', // $context
            'high'); // $priority
    }

    function add_meta_box_js() {
      wp_enqueue_script('master_link-admin-scripts',trailingslashit( plugin_dir_url(__FILE__) ).'admin.js');
    }

    function save_custom_meta( $post_id, $post, $update ) {

        if ( "master_link" != $post->post_type ) {
            return;
        }

        if(isset($_REQUEST['master_link_subtitle'])) {
          update_post_meta($post_id, 'master_link_subtitle', sanitize_text_field($_REQUEST['master_link_subtitle']));
        }

        if(isset($_REQUEST['master_link_default'])) {
          update_post_meta($post_id, 'master_link_default',sanitize_text_field($_REQUEST['master_link_default']));
        }
        if(isset($_REQUEST['master_link_service'])) {
          $services_added = array();
          foreach($_REQUEST['master_link_service'] as $service) {
            $services_added[$service["service"]] = true;
            $key = "master_link_plugin-".$service["service"]."_link_id";
            $val = sanitize_text_field($service['link_id']);
            if($val != "") {
              update_post_meta( $post_id, $key, $val );
            }
          }
          $remove_services = array_diff_key($this->services,$services_added);
          foreach($remove_services as $service => $data) {
            $key = "master_link_plugin-".$service."_link_id";
            delete_post_meta($post_id,$key);
          }
        }

        if(isset($_REQUEST['master_link_upc'])) {
          $key = "master_link_upc";
          $val = sanitize_text_field($_REQUEST['master_link_upc']);
          $title = $post->post_title;
          $subtitle = sanitize_text_field($_REQUEST['master_link_subtitle']);

          $query = $subtitle . " " . $title;

          if($val != "") {
            $this->updateItunesAndAppleMusic($post_id,$val,$query);
            $this->updateSpotify($post_id,$val,$query);
            $this->updateDeezer($post_id,$val,$query);
            $this->updateTidal($post_id,$val,$query);
          }
          update_post_meta( $post_id, $key, $val );
        }
    }


    function getAttachmentIdFromSrc($image_src) {
      global $wpdb;
      $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
      $id = $wpdb->get_var($query);
      return $id;
    }

    function updatePostImageIfImageNotExist($post_id,$url) {
      if(!has_post_thumbnail($post_id)) {
        $image = media_sideload_image($url, $post_id,'','src');
        set_post_thumbnail($post_id,$this->getAttachmentIdFromSrc($image));
      }
    }

    function updateItunesAndAppleMusic($post_id,$upc) {
      if($itunes = $this->findItunes($upc,$query)) {
        update_post_meta($post_id,"master_link_plugin-itunes_link_id",$itunes['id']);
        update_post_meta($post_id,"master_link_plugin-applemusic_link_id",$itunes['id']);
        $this->updatePostImageIfImageNotExist($post_id, $itunes['cover']);
      }
    }

    function updateDeezer($post_id,$upc) {
      if($deezer = $this->findDeezer($upc,$query)) {
        update_post_meta($post_id,"master_link_plugin-deezer_link_id",$deezer['id']);
        $this->updatePostImageIfImageNotExist($post_id, $deezer['cover']);
      }
    }

    function updateSpotify($post_id,$upc) {
      if($spotify = $this->findSpotify($upc,$query)) {
        update_post_meta($post_id,"master_link_plugin-spotify_link_id",$spotify['id']);
        $this->updatePostImageIfImageNotExist($post_id, $spotify['cover']);
      }
    }

    function updateTidal($post_id,$upc,$query) {
      if($tidal = $this->findTidal($upc,$query)) {
        update_post_meta($post_id,"master_link_plugin-tidal_link_id",$tidal['id']);
      }
    }

    function findItunes($upc,$query) {
      require_once "finders/base.php";
      require_once "finders/itunes.php";
      $finder = new MasterLinkiTunesFinder();
      return $finder->find($upc,$query);
    }

    function findDeezer($upc,$query) {
      require_once "finders/base.php";
      require_once "finders/deezer.php";
      $finder = new MasterLinkDeezerFinder();
      return $finder->find($upc,$query);
    }

    function findSpotify($upc,$query) {
      require_once "finders/base.php";
      require_once "finders/spotify.php";
      $finder = new MasterLinkSpotifyFinder();
      return $finder->find($upc,$query);
    }

    function findTidal($upc,$query) {
      require_once "finders/base.php";
      require_once "finders/tidal.php";
      $finder = new MasterLinkTidalFinder();
      return $finder->find($upc,$query);
    }

    function show_master_link_meta_box() {
      global $post;

      $values = get_post_custom( $post->ID );
      $app_links = $this->master_link_get_links();
      $upc = get_post_meta( $post->ID, 'master_link_upc', true);
      $default_service = get_post_meta( $post->ID, 'master_link_default', true);
      $template_path = sprintf("%s/templates/",dirname(__FILE__));

      include $template_path."metabox.php";
    }

    public static function activate() {}

    public static function deactivate() {}

    // Add the settings link to the plugins page
    function plugin_settings_link($links)
    {
      $settings_link = '<a href="options-general.php?page=MasterLink_Plugin">'. __('Master Link Settings') .'</a>';
      array_unshift($links, $settings_link);
      return $links;
    }

    function get_service_link($service_id,$value) {
      if($service_id == "" || $value == "") {
        return "";
      }
      $service = $this->services[$service_id];
      $href = $service['href'];
      $href = sprintf($href,$value);

      return "<a href=\"$href\">$href</a>";
    }

  }
}

if(class_exists('MasterLink_Plugin'))
{
  // Installation and uninstallation hooks
  register_activation_hook(__FILE__, array('MasterLink_Plugin', 'activate'));
  register_deactivation_hook(__FILE__, array('MasterLink_Plugin', 'deactivate'));

  $wp_master_link = new MasterLink_Plugin();
}

function master_link_getDisplayTemplate($file) {
    if (file_exists(TEMPLATEPATH . '/'.$file)) {
        return TEMPLATEPATH . '/'.$file;
    } else {
        return dirname(__FILE__).'/public_templates/'.$file;
    }
}

set_post_thumbnail_size( 320, 320 );
