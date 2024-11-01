<?php

/**
 * Shortcode view [openimmo_objects] & [openimmo_slider]
 * partial elemnt to send email from page
 *
 * @link       #
 * @since      1.5.0
 *
 * @package    Im_Xml
 * @subpackage Im_Xml/public/partials
 */

if (!defined('woodpecker-shortcode')) {
    die('Direct access not permitted');
}
global $wpdb;

$formData = $wpdb->get_row("SELECT default_style, font_color, button_color, button_hover, button_label, privacy_policy_message FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
$fieldsData = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wfw_forms_fields WHERE form_id = 1 ORDER BY id ASC");
?>
<?php
    if ($formData->default_style == "0") {
?>
  <div class="wfw-shortcode">
<?php } else { ?>
  <div class="wfw-shortcode-default">
  <style>
      .wfw-form input[type="submit"].wfw-btn {
          color: <?php _e($formData->font_color); ?>;
          background-color: <?php _e($formData->button_color); ?>;
      }
      .wfw-form input[type="submit"].wfw-btn:hover,
      .wfw-form input[type="submit"].wfw-btn:active {
          background-color: <?php _e($formData->button_hover); ?>;
      }
  </style>
<?php } ?>
    <form id="<?php _e($atts['form_name']); ?>" method="post" class="wfw-form" action="">
      <input name="<?php _e($this->plugin_name); ?>-campaign" type="hidden" value="<?php _e($atts['id']); ?>">
      <input name="<?php _e($this->plugin_name); ?>-form-name" type="hidden" value="<?php _e($atts['form_name']); ?>">
      <?php
        $emailLabel = '';
        $view = '';

        foreach ($fieldsData as $key) {
            $fieldName = strtolower($key->fields_map);
            $fieldType = strtolower($key->fields_map) != 'email' ? 'text' : 'email';
            $className = $key->required == 1 ? "wfw-required" : "wfw-normal";

            if (strpos($fieldName, 'snippet') !== false) {
                $fieldName =  str_replace("_", "", $fieldName);
            }

            $view .= '<div class="wfw-group form-group">
              <label>' . $key->field_label . '</label>
              <div class="' . $className . '">
                <input name="' . $this->plugin_name . '-' . $fieldName . '" type="' . $fieldType . '" class="form-control wfw-control" value="" autocomplete="off">
                <span class="error-text">' . $key->validate_text . '</span>
              </div>
            </div>';
        }
      ?>
      <?php echo $view; ?>
      <div class="wfw-response-container"></div>
      <div class="form-group wfw-group">
        <input value="<?php echo $formData->button_label; ?>" class="btn btn-default wfw-btn wfw-trigger" type="submit" data-sub-id="<?php _e($atts['id']); ?>" data-ajaxurl="<?php _e(admin_url('admin-ajax.php')); ?>">
      </div>
      <div class="form-group wfw-group wfw-privacy_policy">
        <div class="wfw-checkbox">
          <input type="checkbox" name="<?php _e($this->plugin_name); ?>-accept_policy" value="0">
          <span class="custom-checkbox"></span>
        </div>
        <?php _e(stripslashes_deep($formData->privacy_policy_message)); ?>
      </div>
      <input name="<?php _e($this->plugin_name); ?>-tags" value="wordpress" type="hidden">
    </form>
</div>
