<div class="wrap">
  <input type="hidden" name="metabox_noncename" id="metabox_noncename" value="<?php wp_create_nonce( plugin_basename(__FILE__) ) ?>" />
  <div id="meta_inner">
    <p>Add links to remote stores below.  UPC will be used for microfromats on the page template &amp; searching for links in stores you haven't added.</p>
    <p><label for="master_link_upc"><?php _e("UPC") ?></label><input type="text" name="master_link_upc" id="master_link_upc" value="<?php echo $upc; ?>" class="large-text"/></p>
    <p><label for="master_link_default"><?php _e("Default Service") ?></label><select name="master_link_default" id="master_link_default" class="large-text">
      <?php foreach($this->services as $services_service_id => $service) : ?>
        <?php $selected = ($services_service_id == $default_service); ?>
        <option value="<?php echo $services_service_id; ?>"<?php echo $selected ? " SELECTED" : ""; ?>><?php echo $service["name"]; ?></option>
      <?php endforeach; ?>>
    </select></p>
    <span class="add button-primary alignright"><?php _e('Add Link'); ?></span>
    <table class="form-table striped sortable">
      <col width="15%"/>
      <col/>
      <col width="8%"/>
      <col width="10%"/>
      <thead>
        <tr>
          <th><?php _e('Service') ?></th>
          <th><?php _e('ID/Link') ?></th>
          <th><?php _e('Example') ?></th>
          <th><?php _e('Actions') ?></th>
        </tr>
      </thead>
      <tbody id="template" style="display: none">
        <?php $serviceCount = "REPLACETHISID"; include $template_path.'metabox_row.php'; ?>
      </tbody>
      <tbody id="here">
        <?php
        $serviceCount = 0;

        foreach($app_links as $service_id => $value) {
          $validation = $this->services[$service_id]['validation'];
          $validation_error = $this->services[$service_id]['validation-error'];
          include $template_path.'metabox_row.php';
          $serviceCount++;
        }
        ?>
      </tbody>
      <tfoot>
      </tfoot>
    </table>

    <script>
      jQuery(document).ready(function() {
          jQuery(".add").click(function() {
              template = jQuery("#template tr")[0].cloneNode(true)
              elements = jQuery('.master_link_row').length
              template.innerHTML = template.innerHTML.replace(/REPLACETHISID/g,elements);
              jQuery('#here').prepend(template);
              return false;
          });
          jQuery("#here").on('click', ".master_link_row .remove", function() {
              jQuery(this).parent().parent().remove();
          });
      });
    </script>
  </div>
</div>
