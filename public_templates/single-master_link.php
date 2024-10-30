<?php
  $upc = get_post_meta( $post->ID, 'master_link_upc', true);
  $subtitle = get_post_meta( $post->ID, 'master_link_subtitle', true);
  $default_service = get_post_meta( $post->ID, 'master_link_default', true);
  $default_id = $app_links[$default_service];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php the_title(); ?><?php if(trim($subtitle) != "") : echo $subtitle; endif ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
  <?php wp_head(); ?>
  <?php $wp_master_link->headers(); ?>
  <style type="text/css" media="screen">
  	html { margin-top: 0px !important; }
  	body { margin: 0px 0px 0px 0px !important; }
  </style>
</head>
<body id="master-link" class="h-product">
  <div id="background">
    <img src="<?php echo $post_image;?>" class="u-photo" />
  </div>
  <div id="wrapper">
    <div id="header">
      <div id="cover" style="background-image: url('<?php echo $post_image; ?>')"></div>
      <div class="info">
        <h1 class="p-name">
          <?php echo $post->post_title; ?>
          <?php if(trim($subtitle) != "") : ?>
            <br/><?php echo $subtitle ?>
          <?php endif; ?>
        </h1>
        <p><?php _e("Choose service")?></p>
      </div>
      <div class="pointer"></div>
    </div>
    <div id="service-links">
      <div id="services">
        <?php foreach($app_links as $service => $service_id) {
          include master_link_getDisplayTemplate('service.php');
        }?>
        <?php
          $default_href = sprintf($wp_master_link->services[$default_service]['href'],$default_id);
        ?>
        <div class="default service">
          <a id="master_link_default" target="_blank" href="<?php echo $default_href; ?>">
            <span><?php _e("I don't know") ?></span>
          </a>
        </div>
        <?php if($upc != "") : ?>
        <div id="upc">
          <canvas class="u-identifier" itemprop="upc"><?php echo $upc; ?></canvas>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
