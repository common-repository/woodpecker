<?php
/**
 * The plugin Woodpecker for WordPress
 *
 * @link              #
 * @since             1.0.0
 * @package           Woodpecker_For_Wordpress_Connector
 *
 * @wordpress-plugin
 * Plugin Name:       Woodpecker
 * Plugin URI:        https://woodpecker.co/plugins/wordpress-leadform/
 * Description:       Add Woodpecker for WordPress to your Wordpress and enjoy automatic transfer of data from the Woodpecker for WordPress into your Woodpecker campaign. Never lose a lead again.
 * Version:           3.0.4
 * Author:            Woodpecker.co
 * Author URI:        https://woodpecker.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wfw
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
  exit;
}

define('WOODPECKER_PLUGIN_NAME_VERSION', '3.0.4');
define('WOODPECKER_PLUGIN_DATABASE_VERSION', '3.0.0');
define('WOODPECKER_PLUGIN_URL', plugin_dir_url(__FILE__));

function activate_woodpecker_for_wordpress()
{
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}

register_activation_hook(__FILE__, 'activate_woodpecker_for_wordpress');

require plugin_dir_path(__FILE__) . 'includes/class-wfw.php';

/**
 * @since    1.0.0
 */
function run_woodpecker_for_wordpress()
{
  $plugin = new Woodpecker_For_Wordpress_Connector();
  $plugin->run();
}

run_woodpecker_for_wordpress();

/**
 * Link to settings
 * @since    1.0.3
 */
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links');

function add_action_links($links)
{
  $settings_link = array(
    '<a href="' . admin_url('admin.php?page=wfw') . '">' . __('Settings', 'wfw') . '</a>',
  );
  return array_merge($links, $settings_link);
}

/**
 * Woodpecker for wordpress api - campaigns list
 * @since    3.0.0
 */
add_action('rest_api_init', 'campaignsListRoutes');

function campaignsListRoutes()
{
  register_rest_route(get_plugin_namespace(), '/campaigns_list', array(
    'methods' => 'GET',
    'callback' => 'getCampaignsList',
    'permission_callback' => '__return_true',
  ));
}

function getCampaignsList()
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  global $wpdb;
  $data = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
  $response = new Woodpecker_For_Wordpress_Connector_Curl('/rest/v1/campaign_list', $data->api_key);
  return $response->getJson();
}

/**
 * Woodpecker for wordpress api - prospects list
 * @since    3.0.0
 */

add_action('rest_api_init', 'prospectsRoutes');

function prospectsRoutes()
{
  register_rest_route(get_plugin_namespace(), '/prospects', array(
    'methods' => 'POST',
    'callback' => 'getProspectsList',
    'permission_callback' => '__return_true',
  ));
}

function getProspectsList($request)
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  global $wpdb;
  $data = json_decode($request->get_body());
  $range = $data->range ?: 10;
  $page = $data->page ?: 10;
  $status = $data->status ?: '';
  $filter = '';

  if ($status) {
    $filter = '&status=' . $status;
  }

  $data = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");

  $response = new Woodpecker_For_Wordpress_Connector_Curl('/rest/v1/prospects?search=tags=wordpress&per_page=' . $range . '&page=' . $page . $filter, $data->api_key);
  return $response->getJson();
}

/**
 * Woodpecker for wordpress api - check api key
 * @since    3.0.0
 */

add_action('rest_api_init', 'apiCheckRoutes');

function apiCheckRoutes()
{
  register_rest_route(get_plugin_namespace(), '/me', array(
    'methods' => 'GET',
    'callback' => 'getApiInfo',
    'permission_callback' => '__return_true',
  ));
}

function getApiInfo()
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  global $wpdb;
  $data = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
  $response = new Woodpecker_For_Wordpress_Connector_Curl('/rest/v1/me', $data->api_key);
  return $response->getDataJson();
}


/**
 * Woodpecker for wordpress api - forms
 * @since    3.0.0
 */

add_action('rest_api_init', 'formsRoutes');

function formsRoutes()
{
  register_rest_route(get_plugin_namespace(), '/forms', array(
    'methods' => 'GET',
    'callback' => 'getForms',
    'permission_callback' => '__return_true',
  ));
}

function getForms()
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }
  header('Cache-Control: no-cache, must-revalidate, max-age=0');
  global $wpdb;
  return $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
}

add_action('rest_api_init', 'saveFormsSettingsRoutes');

function saveFormsSettingsRoutes()
{
  register_rest_route(get_plugin_namespace(), '/save_forms_settings', array(
    'methods' => 'POST',
    'callback' => 'saveFormsSettings',
    'permission_callback' => '__return_true',
  ));
}

function saveFormsSettings($request)
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  $data = json_decode($request->get_body());

  global $wpdb;
  $isOk = $wpdb->update($wpdb->prefix . "wfw_forms", array(
    'success_message' => $data->success_message,
    'error_message' => $data->error_message,
    'already_exist_message' => $data->already_exist_message,
    'privacy_policy_message' => $data->privacy_policy_message,
    'field_required_message' => $data->field_required_message,
    'last_mod_date' => date('Y-m-d H:i:s')
  ), array('id' => 1));

  if ($isOk) {
    return getForms();
  }

  return new WP_Error('rest_custom_error', 'Unable to write forms settings', array('status' => 400));
}


add_action('rest_api_init', 'saveFormsStyleRoutes');

function saveFormsStyleRoutes()
{
  register_rest_route(get_plugin_namespace(), '/save_forms_style', array(
    'methods' => 'POST',
    'callback' => 'saveFormsStyle',
    'permission_callback' => '__return_true',
  ));
}

function saveFormsStyle($request)
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  $data = json_decode($request->get_body());

  global $wpdb;
  $isOk = $wpdb->update($wpdb->prefix . "wfw_forms", array(
    'button_label' => $data->button_label,
    'default_style' => $data->default_style,
    'font_color' => $data->font_color,
    'button_color' => $data->button_color,
    'button_hover' => $data->button_hover,
    'last_mod_date' => date('Y-m-d H:i:s')
  ), array('id' => 1));

  if ($isOk) {
    return getForms();
  }

  return new WP_Error('rest_custom_error', 'Unable to write forms style', array('status' => 400));
}


/**
 * Woodpecker for wordpress api - forms fields
 * @since    3.0.0
 */

add_action('rest_api_init', 'fieldsRoutes');

function fieldsRoutes()
{
  register_rest_route(get_plugin_namespace(), '/fields', array(
    'methods' => 'GET',
    'callback' => 'getFields',
    'permission_callback' => '__return_true',
  ));
}

function getFields()
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  header('Cache-Control: no-cache, must-revalidate, max-age=0');
  global $wpdb;
  $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wfw_forms_fields ORDER BY id ASC");
  foreach ($results as $row) {
    $row->required = $row->required ? true : false;
  }

  return $results;
}

add_action('rest_api_init', 'saveFieldsRoutes');

function saveFieldsRoutes()
{
  register_rest_route(get_plugin_namespace(), '/save_fields', array(
    'methods' => 'POST',
    'callback' => 'saveFields',
    'permission_callback' => '__return_true',
  ));
}

function saveFields($request)
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }
  global $wpdb;
  $results = $wpdb->query("DELETE FROM " . $wpdb->prefix . "wfw_forms_fields WHERE form_id=1");
  $data = json_decode($request->get_body());

  foreach ($data as $row) {
    $wpdb->insert($wpdb->prefix . "wfw_forms_fields", array(
      'id' => $row->id,
      'field_label' => $row->field_label,
      'fields_map' => $row->fields_map,
      'form_id' => $row->form_id,
      'timestamp' => date('Y-m-d H:i:s'),
      'regex' => '',
      'required' => $row->required,
      'validate_text' => $row->validate_text,
      'slug' => $row->slug,
    ));
  }

  return getFields();
}

/**
 * Woodpecker for wordpress api - api key
 * @since    3.0.0
 */

add_action('rest_api_init', 'apiKeyRoutes');

function apiKeyRoutes()
{
  register_rest_route(get_plugin_namespace(), '/api_key', array(
    'methods' => 'GET',
    'callback' => 'getApiKey',
    'permission_callback' => '__return_true',
  ));
}

function getApiKey()
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  header('Cache-Control: no-cache, must-revalidate, max-age=0');
  global $wpdb;
  $data = $wpdb->get_row("SELECT api_key FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
  return $data->api_key;;
}


add_action('rest_api_init', 'saveApiKeyRoutes');

function saveApiKeyRoutes()
{
  register_rest_route(get_plugin_namespace(), '/save_api_key', array(
    'methods' => 'POST',
    'callback' => 'saveApiKey',
    'permission_callback' => '__return_true',
  ));
}

function saveApiKey($request)
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  $data = json_decode($request->get_body());
  $response = new Woodpecker_For_Wordpress_Connector_Curl('/rest/v1/me', $data->api_key);

  if ($response->getDataJson() !== null) {
    global $wpdb;
    $wpdb->update($wpdb->prefix . "wfw_forms", array('api_key' => $data->api_key), array('id' => 1));
    return new WP_REST_Response(array('message' => 'API key saved', 'status' => 200), 200);
  }

  return new WP_Error('rest_custom_error', 'Unable to write API key', array('status' => 400));
}

/**
 * Woodpecker for wordpress api - troubleshoot
 * @since    3.0.0
 */

add_action('rest_api_init', 'troubleshootRoutes');

function troubleshootRoutes()
{
  register_rest_route(get_plugin_namespace(), '/troubleshoot', array(
    'methods' => 'GET',
    'callback' => 'troubleshoot',
    'permission_callback' => '__return_true',
  ));
}

function troubleshoot()
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  $response = new WFW_Update_Database('reinstall');
  if ($response) {
    return new WP_REST_Response(array('message' => 'Factory settings restored', 'status' => 200), 200);
  } else {
    return new WP_Error('rest_custom_error', 'Unable to restore factory settings', array('status' => 400));
  }
}

/**
 * Woodpecker for wordpress api - update database
 * @since    3.0.0
 */

add_action('rest_api_init', 'updateDbRoutes');

function updateDbRoutes()
{
  register_rest_route(get_plugin_namespace(), '/update_database', array(
    'methods' => 'GET',
    'callback' => 'updateDatabase',
    'permission_callback' => '__return_true',
  ));
}

function updateDatabase()
{
  if (!isNonceVerify()) {
    return new WP_Error('rest_custom_error', 'Forbidden', array('status' => 403));
  }

  $response = new WFW_Update_Database(get_option('wfw_db_version'));
  if ($response) {
    return new WP_REST_Response(null, 200);
  } else {
    return new WP_Error('rest_custom_error', 'The database could not be updated', array('status' => 400));
  }
}

/**
 * Woodpecker for wordpress api - nonce verify
 * @since    3.0.0
 */

function isNonceVerify() {
  return wp_verify_nonce($_SERVER['HTTP_X_WP_NONCE'], 'wp_rest');
}

function get_plugin_namespace() {
  return 'wfw/v1';
}
