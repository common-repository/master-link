<div class="wrap">
    <h2><?php _e('Master Link Plugin') ?></h2>

    <form method="post" action="options.php">
        <?php settings_fields( 'master_link_plugin' ); ?>
        <?php do_settings_sections('master_link_plugin'); ?>

        <?php submit_button(); ?>
    </form>
<?php
$client_id = get_option('master_link_plugin_spotify_client_id');
$client_secret= get_option('master_link_plugin_spotify_client_secret');

if(isset($client_id) && isset($client_secret)) {
  echo "<h3>".__("Spotify Authentication Settings","master_link_plugin")."</h3>\n";
  echo '<table class="form-table">';
  $this->spotify_auth_settings();
  do_settings_fields('master_link_plugin','master_link_plugin_spotify_auth_settings');
  echo '</table>';
}
?>
</div>
