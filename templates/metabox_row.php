<tr class="master_link_row">
  <td scope="row">
    <select name="master_link_service[<?php echo $serviceCount; ?>][service]">
      <?php foreach($this->services as $services_service_id => $service) : ?>
        <?php $selected = ($services_service_id == $service_id); ?>
        <?php $eachValidation = $this->services[$services_service_id]['validation']; ?>
        <?php $eachValidationErr = $this->services[$services_service_id]['validation-error']; ?>
        <option<?php if($eachValidationErr != "")  { echo " data-validation_error=\"$eachValidationErr\""; } ?>
        <?php if($eachValidation != "")  { echo " data-validation=\"$eachValidation\""; } ?> value="<?php echo $services_service_id; ?>"<?php echo $selected ? " SELECTED" : ""; ?>><?php echo $service["name"]; ?></option>
      <?php endforeach; ?>
    </select>
  </td>
  <td>
    <input type="text" name="master_link_service[<?php echo $serviceCount; ?>][link_id]"
    value="<?php echo $value; ?>" class="large-text"<?php
    if($validation != "")  { echo " data-validation=\"$validation\""; }
    if($validation_error != "")  { echo " data-validation_error=\"$validation_error\""; } ?>/>
  </td>
  <td><?php echo $this->get_service_link($service_id,$value); ?></td>
  <td><button class="remove button-secondary"><?php _e('Remove') ?></button></td>
</tr>
