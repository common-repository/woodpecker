<?php
/**
 * Admin backend for Forms
 *
 * @link       #
 * @since      2.0.0
 * @author     Woodpecker Team
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/admin/partials
 */

  if (!defined('Woodpecker_For_Wordpress_Connector_Admin')) {
      die('Direct access not permitted');
  }

  global $wpdb;
  $formData = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
  $fieldsData = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wfw_forms_fields WHERE form_id = 1");
?>
<div class="col-container">
  <div class="col-container__margin">
    <div class="forms-container">
      <div class="forms-container__panel">
        <div class="form-title uppercase"><?php _e("Form settings", $this->plugin_name); ?></div>
        <div class="forms-container__tabs">
          <div class="forms-container__tabs--tab active" data-role="fields"><?php _e("Fields", $this->plugin_name); ?></div>
          <div class="forms-container__tabs--tab" data-role="settings"><?php _e("Field settings", $this->plugin_name); ?></div>
          <div class="forms-container__tabs--tab" data-role="style"><?php _e("Style", $this->plugin_name); ?></div>
        </div>
        <div class="fields-box active">
          <div class="fields-box__panel">
            <div class="draggable disabled">
              <div class="input-title">Email</div>
              <div class="input-field"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">First name</div>
              <div class="input-field" data-rel="FIRST_NAME" data-mapping="FIRST NAME" data-label="First name" data-validation="Invalid first name format." data-required="1" data-mapping-old="FIRST NAME" data-label-old="First name" data-validation-old="Invalid first name format." data-required-old="1"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Last name</div>
              <div class="input-field" data-rel="LAST_NAME" data-mapping="LAST NAME" data-label="Last name" data-validation="Invalid last name format." data-required="0" data-mapping-old="LAST NAME" data-label-old="Last name" data-validation-old="Invalid last name format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Company</div>
              <div class="input-field" data-rel="COMPANY" data-mapping="COMPANY" data-label="Company" data-validation="Invalid company format." data-required="0" data-mapping-old="COMPANY" data-label-old="Company" data-validation-old="Invalid company format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Website</div>
              <div class="input-field" data-rel="WEBSITE" data-mapping="WEBSITE" data-label="Website" data-validation="Invalid www format." data-required="0" data-mapping-old="WEBSITE" data-label-old="Website" data-validation-old="Invalid www format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">LinkedIn URL</div>
              <div class="input-field" data-rel="LINKEDIN_URL" data-mapping="LINKEDIN URL" data-label="Linkedin URL" data-validation="Invalid LinkedIn URL format." data-required="0" data-mapping-old="LINKEDIN URL" data-label-old="Linkedin URL" data-validation-old="Invalid LinkedIn URL format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Title</div>
              <div class="input-field" data-rel="TITLE" data-mapping="TITLE" data-label="Title" data-validation="Invalid title format." data-required="0" data-mapping-old="TITLE" data-label-old="Title" data-validation-old="Invalid title format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Phone</div>
              <div class="input-field" data-rel="PHONE" data-mapping="PHONE" data-label="Phone" data-validation="Invalid phone format." data-required="0" data-mapping-old="PHONE" data-label-old="Phone" data-validation-old="Invalid phone format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Address</div>
              <div class="input-field" data-rel="ADDRESS" data-mapping="ADDRESS" data-label="Address" data-validation="Invalid address format." data-required="0" data-mapping-old="ADDRESS" data-label-old="Address" data-validation-old="Invalid address format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">City</div>
              <div class="input-field" data-rel="CITY" data-mapping="CITY" data-label="City" data-validation="Invalid city format." data-required="0" data-mapping-old="CITY" data-label-old="City" data-validation-old="Invalid city format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">State</div>
              <div class="input-field" data-rel="STATE" data-mapping="STATE" data-label="State" data-validation="Invalid state format." data-required="0" data-mapping-old="STATE" data-label-old="State" data-validation-old="Invalid state format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Country</div>
              <div class="input-field" data-rel="COUNTRY" data-mapping="COUNTRY" data-label="Country" data-validation="Invalid country format." data-required="0" data-mapping-old="COUNTRY" data-label-old="Country" data-validation-old="Invalid country format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Industry</div>
              <div class="input-field" data-rel="INDUSTRY" data-mapping="INDUSTRY" data-label="Industry" data-validation="Invalid industry format." data-required="0" data-mapping-old="INDUSTRY" data-label-old="Industry" data-validation-old="Invalid industry format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 1</div>
              <div class="input-field" data-rel="SNIPPET_1" data-mapping="SNIPPET 1" data-label="Snippet 1" data-validation="Invalid snippet format." data-required="0" data-mapping-old="Snippet 1" data-label-old="Snippet 1" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 2</div>
              <div class="input-field" data-rel="SNIPPET_2" data-mapping="SNIPPET 2" data-label="Snippet 2" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 2" data-label-old="Snippet 2" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 3</div>
              <div class="input-field" data-rel="SNIPPET_3" data-mapping="SNIPPET 3" data-label="Snippet 3" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 3" data-label-old="Snippet 3" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 4</div>
              <div class="input-field" data-rel="SNIPPET_4" data-mapping="SNIPPET 4" data-label="Snippet 4" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 4" data-label-old="Snippet 4" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 5</div>
              <div class="input-field" data-rel="SNIPPET_5" data-mapping="SNIPPET 5" data-label="Snippet 5" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 5" data-label-old="Snippet 5" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 6</div>
              <div class="input-field" data-rel="SNIPPET_6" data-mapping="SNIPPET 6" data-label="Snippet 6" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 6" data-label-old="Snippet 6" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 7</div>
              <div class="input-field" data-rel="SNIPPET_7" data-mapping="SNIPPET 7" data-label="Snippet 7" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 7" data-label-old="Snippet 7" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 8</div>
              <div class="input-field" data-rel="SNIPPET_8" data-mapping="SNIPPET 8" data-label="Snippet 8" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 8" data-label-old="Snippet 8" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 9</div>
              <div class="input-field" data-rel="SNIPPET_9" data-mapping="SNIPPET 9" data-label="Snippet 9" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 9" data-label-old="Snippet 9" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 10</div>
              <div class="input-field" data-rel="SNIPPET_10" data-mapping="SNIPPET 10" data-label="Snippet 10" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 10" data-label-old="Snippet 10" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 11</div>
              <div class="input-field" data-rel="SNIPPET_11" data-mapping="SNIPPET 11" data-label="Snippet 11" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 11" data-label-old="Snippet 11" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 12</div>
              <div class="input-field" data-rel="SNIPPET_12" data-mapping="SNIPPET 12" data-label="Snippet 12" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 12" data-label-old="Snippet 12" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 13</div>
              <div class="input-field" data-rel="SNIPPET_13" data-mapping="SNIPPET 13" data-label="Snippet 13" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 13" data-label-old="Snippet 13" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 14</div>
              <div class="input-field" data-rel="SNIPPET_14" data-mapping="SNIPPET 14" data-label="Snippet 14" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 14" data-label-old="Snippet 14" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
            <div class="draggable drop">
              <div class="input-title">Snippet 15</div>
              <div class="input-field" data-rel="SNIPPET_15" data-mapping="SNIPPET 15" data-label="Snippet 15" data-validation="Invalid snippet format." data-required="0" data-mapping-old="SNIPPET 15" data-label-old="Snippet 15" data-validation-old="Invalid snippet format." data-required-old="0"></div>
            </div>
          </div>
        </div>

        <div class="fields-settings-box">
            <div class="fields-settings-box__panel">
              <div class="row">
                <span class="label"><?php esc_attr_e('Mapping:', $this->plugin_name); ?></span>
                <div class="dropdownWidget">
                  <span class="dropdownWidget__rows wfw-mapping" onclick="openDropdown(this, '1');"></span>
                  <div class="dropdownWidget__rows--block" style="display: none;">
                    <div class="dropdownWidget__scroll">
                      <span class="dropdownWidget__rows--block__value">FIRST NAME</span>
                      <span class="dropdownWidget__rows--block__value">LAST NAME</span>
                      <span class="dropdownWidget__rows--block__value">COMPANY</span>
                      <span class="dropdownWidget__rows--block__value">WEBSITE</span>
                      <span class="dropdownWidget__rows--block__value">LINKEDIN URL</span>
                      <span class="dropdownWidget__rows--block__value">TITLE</span>
                      <span class="dropdownWidget__rows--block__value">PHONE</span>
                      <span class="dropdownWidget__rows--block__value">ADDRESS</span>
                      <span class="dropdownWidget__rows--block__value">CITY</span>
                      <span class="dropdownWidget__rows--block__value">STATE</span>
                      <span class="dropdownWidget__rows--block__value">COUNTRY</span>
                      <span class="dropdownWidget__rows--block__value">INDUSTRY</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 1</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 2</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 3</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 4</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 5</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 6</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 7</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 8</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 9</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 10</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 11</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 12</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 13</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 14</span>
                      <span class="dropdownWidget__rows--block__value">SNIPPET 15</span>
                    </div>
                  </div>
                  <span class="error-text">You already mapped this field.</span>
                </div>
                <input type="text"
                  class="value disabled"
                  placeholder="<?php esc_attr_e('Mapping...', $this->plugin_name); ?>"
                  name="wfw-mapping"
                  value="Email"
                  autocomplete="off" disabled/>
              </div>
              <div class="row">
                <span class="label"><?php esc_attr_e('Label:', $this->plugin_name); ?></span>
                <input type="text"
                    class="value"
                    placeholder="<?php esc_attr_e('Label...', $this->plugin_name); ?>"
                    name="wfw-label"
                    value="<?php _e($formData->button_label); ?>"
                    autocomplete="off"/>
              </div>
              <div class="row">
                <span class="label"><?php esc_attr_e('Validation:', $this->plugin_name); ?></span>
                <input type="text"
                    class="value"
                    placeholder="<?php esc_attr_e('Validation...', $this->plugin_name); ?>"
                    name="wfw-validation"
                    value="<?php _e($formData->button_label); ?>"
                    autocomplete="off"/>
              </div>
              <div class="row required">
                <div class="wfw-checkbox">
                  <input type="checkbox" value="0" name="wfw-required">
                  <span class="custom-checkbox"></span>
                </div>
                <?php _e("Required"); ?>
              </div>
              <div class="btn-link red delete-field"><?php _e("Delete this field", $this->plugin_name); ?></div>
           </div>
           <div class="fields-settings-box__empty active">
             <span class="info"><?php esc_attr_e('Choose a field on the right to change its settings or click & drag it to change order.', $this->plugin_name); ?></span>
           </div>
        </div>

        <div class="style-box style-container">
          <div class="row">
            <span class="label"><?php esc_attr_e('Button label:', $this->plugin_name); ?></span>
            <input type="text"
                class="value"
                placeholder="<?php esc_attr_e('Button...', $this->plugin_name); ?>" id="<?php _e($this->plugin_name); ?>-gform_submit"
                name="wfw-button_label"
                value="<?php _e($formData->button_label); ?>"
                autocomplete="off"/>
          </div>
          <div class="style-container__content">
            <span class="style-container__content--span"><?php esc_attr_e('Custom form style:', $this->plugin_name); ?></span>
            <div class="wfw-switch">
              <div class="switch-widget">
                <div class="sw-cont">
                  <input type="checkbox"
                      id="<?php _e($this->plugin_name); ?>-gform_default_style"
                      name="wfw-default_style"
                      value="1" <?php checked((!isset($formData->default_style) ? 1 : $formData->default_style), 1); ?> />
                  <div class="sw-icon">
                    <div></div>
                  </div>
                  <div class="sw-label" style="display: none;" ></div>
                </div>
              </div>
            </div>
          </div>
          <div id="picker-panel">
            <div id="<?php _e($this->plugin_name); ?>-color_submit-box" class="style-container__content--pickers__box">
              <span class="style-container__content--pickers__span"><?php esc_attr_e('Font color:', $this->plugin_name); ?></span>
                <input type="text"
                    class="<?php _e($this->plugin_name); ?>-color-picker color-field"
                    id="<?php _e($this->plugin_name); ?>-color_submit"
                    name="wfw-font_color"
                    data-default-color="<?php _e($formData->font_color); ?>"
                    value="<?php _e($formData->font_color); ?>" />
            </div>
            <div id="<?php _e($this->plugin_name); ?>-color_submit_bg-box" class="style-container__content--pickers__box">
              <span class="style-container__content--pickers__span"><?php esc_attr_e('Button color:', $this->plugin_name); ?></span>
              <input type="text"
                  class="<?php _e($this->plugin_name); ?>-color-picker color-field"
                  id="<?php _e($this->plugin_name); ?>-color_submit_bg"
                  name="wfw-button_color"
                  data-default-color="<?php _e($formData->button_color); ?>"
                  value="<?php _e($formData->button_color); ?>" />
            </div>
            <div id="<?php _e($this->plugin_name); ?>-color_submit_b_-hover-box" class="style-container__content--pickers__box">
              <span class="style-container__content--pickers__span"><?php esc_attr_e('Button hover:', $this->plugin_name); ?></span>
              <input type="text"
                  class="<?php _e($this->plugin_name); ?>-color-picker color-field"
                  id="<?php _e($this->plugin_name); ?>-color_submit_b_-hover"
                  name="wfw-button_hover"
                  data-default-color="<?php _e($formData->button_hover); ?>"
                  value="<?php _e($formData->button_hover); ?>" />
            </div>
          </div>
        </div>
      </div>
      <div class="forms-container__preview">
        <div class="form-title"><?php _e("Preview", $this->plugin_name); ?></div>
        <div class="sortableList">
        <?php
          foreach ($fieldsData as $key) {
            $fieldMap = str_replace("_", " ",  $key->fields_map);
            echo '<div class="ui-state-default"><div class="input-title">' . $key->field_label . '</div><div class="input-field" data-rel="' . $key->relation . '" data-mapping="' . $fieldMap . '" data-label="' . $key->field_label . '" data-validation="' . $key->validate_text . '" data-required="' . $key->required . '" data-mapping-old="' . $fieldMap . '" data-label-old="' . $key->field_label . '" data-validation-old="' . $key->validate_text . '" data-required-old="' . $key->required . '"></div></div>';
          }
        ?>
        </div>
        <div class="form-group wfw-group">
          <input value="<?php echo $formData->button_label; ?>" class="btn btn-default wfw-btn wfw-trigger" type="submit">
        </div>

        <div class="form-group wfw-group wfw-privacy_policy">
          <div class="wfw-checkbox">
            <input type="checkbox" checked disabled>
            <span class="custom-checkbox"></span>
          </div>
          <?php echo $formData->privacy_policy_message; ?>
        </div>
      </div>
    </div>
    <div class="save-container">
      <div id="sticky-footer" class="save-box fixed">
        <div class="save-box__info"><?php _e('Your changes have been successfully saved.', $this->plugin_name); ?></div>
        <input type="submit" name="wfw-submit" class="button btn-woodpecker save-option" value="<?php _e('Save', $this->plugin_name); ?>">
        <span class="save-box__close"></span>
      </div> 
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php _e(plugin_dir_url( __FILE__ )); ?>../js/wfw-forms.min.js?ver=2.2"></script>
<script type="text/javascript" src="<?php _e(plugin_dir_url( __FILE__ )); ?>../js/slimscroll.min.js"></script>