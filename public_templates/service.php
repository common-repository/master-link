<?php
  if($wp_master_link->services[$service]['uri']) {
    $uri = sprintf($wp_master_link->services[$service]['uri'],$service_id);
  }
  $href = sprintf($wp_master_link->services[$service]['href'],$service_id);
  $verb = "Visit";
  if(isset($wp_master_link->services[$service]['verb'])) {
    $verb = $wp_master_link->services[$service]['verb'];
  }
?>
<div class="service">
  <a id="<?php echo $service; ?>" href="<?php echo $href; ?>" target="_blank" class="u-url">
    <?php
      if(isset($wp_master_link->services[$service]['image'])) { ?>
        <img height="40" src="<?php echo $image_dir."/".$wp_master_link->services[$service]['image']; ?>" alt="<?php echo $wp_master_link->services[$service]['name']; ?>" />
        <?php
      } else {
        echo $wp_master_link->services[$service]["name"];
      }
    ?>
    <span class="btn <?php echo strtolower($verb); ?>"><?php echo $verb; ?></span>
  </a>
</div>
