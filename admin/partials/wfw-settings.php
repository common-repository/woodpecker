<?php
/**
 * Admin backend for Settings
 *
 * @link       #
 * @since      2.0.0
 * @author     Woodpecker Team
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/admin/partials
 */

if (!defined('Woodpecker_For_Wordpress_Connector_Admin')) :
    die('Direct access not permitted');
endif;
?>
<form method="post" name="woodpecker-options">
    <div class="col-container">
        <div class="col-container__margin">
            <?php
              global $wpdb;
              $formData = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
              $getconnectcampaign = new Woodpecker_For_Wordpress_Connector_Curl('/rest/v1/me', $formData->api_key);
              $getjsoncampaign = $getconnectcampaign->getJson();
              $getstatus = $getjsoncampaign->status;
              $error = $getstatus->status == 'ERROR' || $formData->api_key == '';
            ?>
            <div class="settings-container">
                <div class="settings-container__menu">
                    <ul>
                        <li id="synchronization"><?php esc_attr_e('Synchronization', $this->plugin_name); ?></li>
                        <li id="messages"><?php esc_attr_e('Messages', $this->plugin_name); ?></li>
                        <li id="privacy-policy"><?php esc_attr_e('Privacy policy', $this->plugin_name); ?></li>
                    </ul>
                </div>
                <div class="settings-container__content">
                    <div id="synchronization-box" style="display: none;">
                        <div>
                            <label
                                class="settings-container__content--label"><?php esc_attr_e('api key', $this->plugin_name); ?></label>
                            <input type="text"
                                class="settings-container__content--input api <?php _e(($error == true ? "error" : "")); ?>"
                                id="<?php _e($this->plugin_name); ?>-api_key" name="wfw-api_key"
                                placeholder="<?php _e('API key', $this->plugin_name); ?>"
                                value="<?php _e($formData->api_key); ?>" autocomplete="off" />

                            <?php if ($error == true) : ?>
                            <span class="error"><?php esc_attr_e('The API key is incorrect or no longer valid. You can generate a new key in your Woodpecker account in "Settings".', $this->plugin_name); ?></span>
                            <?php else: ?>
                            <span class="info"><?php esc_attr_e('Generate in Woodpecker Settings', $this->plugin_name); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div id="messages-box" style="display: none;">
                        <div>
                            <label
                                class="settings-container__content--label"><?php esc_attr_e('Success message', $this->plugin_name); ?></label>
                            <div class="settings-container__content--scroll">
                                <textarea class="settings-container__content--textarea"
                                    id="<?php _e($this->plugin_name); ?>-message_success" name="wfw-success_message"
                                    autocomplete="off"><?php _e(stripslashes_deep($formData->success_message)); ?></textarea>
                            </div>
                            <label
                                class="settings-container__content--label"><?php esc_attr_e('Error message', $this->plugin_name); ?></label>
                            <div class="settings-container__content--scroll">
                                <textarea class="settings-container__content--textarea"
                                    id="<?php _e($this->plugin_name); ?>-message_error" name="wfw-error_message"
                                    autocomplete="off"><?php _e(stripslashes_deep($formData->error_message)); ?></textarea>
                            </div>
                            <label
                                class="settings-container__content--label"><?php esc_attr_e('\'Email already exist\' message', $this->plugin_name); ?></label>
                            <div class="settings-container__content--scroll">
                                <textarea class="settings-container__content--textarea"
                                    id="<?php _e($this->plugin_name); ?>-message_exist" name="wfw-already_exist_message"
                                    autocomplete="off"><?php _e(stripslashes_deep($formData->already_exist_message)); ?></textarea>
                            </div>
                            <label
                                class="settings-container__content--label"><?php esc_attr_e('Field required message', $this->plugin_name); ?></label>
                            <div class="settings-container__content--scroll">
                                <textarea class="settings-container__content--textarea"
                                    id="<?php _e($this->plugin_name); ?>-field_required_message"
                                    name="wfw-field_required_message"
                                    autocomplete="off"><?php _e(stripslashes_deep($formData->field_required_message)); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="privacy-policy-box" style="display: none;">
                        <div>
                            <label
                                class="settings-container__content--label"><?php esc_attr_e('privacy policy', $this->plugin_name); ?></label>
                            <div class="settings-container__content--scroll">
                                <textarea class="settings-container__content--textarea"
                                    id="<?php _e($this->plugin_name); ?>-privacy_policy"
                                    name="wfw-privacy_policy_message"
                                    autocomplete="off"><?php _e(stripslashes_deep($formData->privacy_policy_message)); ?></textarea>
                            </div>
                            <span
                                class="info"><?php esc_attr_e('You can add a privacy policy link by using HTML attribute', $this->plugin_name); ?></span>
                        </div>
                    </div>
                    <input type="hidden" value="" id="box-name" name="<?php _e($this->plugin_name); ?>[box_name]">
                    <input type="hidden" value="" id="new-fields" name="new-fields">
                    <div class="save-container">
                        <div id="sticky-footer" class="save-box fixed">
                            <div class="save-box__info">
                                <?php _e('Your changes have been successfully saved.', $this->plugin_name); ?></div>
                            <input type="submit" name="wfw-submit" class="button btn-woodpecker save-option"
                                value="<?php _e('Save', $this->plugin_name); ?>">
                            <span class="save-box__close"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="<?php _e(plugin_dir_url( __FILE__ )); ?>../js/wfw-settings.min.js?ver=2.1"></script>
<script type="text/javascript" src="<?php _e(plugin_dir_url( __FILE__ )); ?>../js/slimscroll.min.js"></script>