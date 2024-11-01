<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/admin
 */


class Woodpecker_For_Wordpress_Connector_Admin
{

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string $plugin_name The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string $version The current version of this plugin.
   */
  private $version;

  /**
   * The url of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string $url
   */
  private $url;

  /**
   * Initialize the class and set its properties.
   *
   * @param string $plugin_name The name of this plugin.
   * @param string $version The version of this plugin.
   * @since    1.0.0
   */
  public function __construct($plugin_name, $version, $url)
  {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->url = $url;

  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_styles()
  {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Woodpecker_For_Wordpress_Connector_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Woodpecker_For_Wordpress_Connector_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style('wfw-style', plugin_dir_url(__FILE__) . '/lib/styles.24ff8f8ef00500b1d3c0.css', array(), $this->version . rand(), 'all');
  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts()
  {
    wp_enqueue_media();
    wp_enqueue_script('media-upload');
    wp_register_script('wfw-run', plugin_dir_url(__FILE__) . 'lib/runtime.0e49e2b53282f40c8925.js');
    wp_register_script('wfw-poly', plugin_dir_url(__FILE__) . 'lib/polyfills.ef2665d0ca76d8752d83.js');
    wp_register_script('wfw-main', plugin_dir_url(__FILE__) . 'lib/main.9491eec6c76c66879182.js');
    wp_localize_script('wfw-main', 'RestAPI', array(
      'root' => esc_url_raw(rest_url()),
      'nonce' => wp_create_nonce('wp_rest'),
      'current_ID' => get_the_ID()
  ));
    wp_enqueue_script('wfw-run');
    wp_enqueue_script('wfw-poly');
    wp_enqueue_script('wfw-main');
  }

  /**
   * Register the administration menu for this plugin into the WordPress Dashboard menu.
   *
   * @since    1.0.0
   */
  public function add_plugin_admin_menu()
  {
    add_menu_page('Woodpecker', 'Woodpecker', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'), plugin_dir_url(__FILE__) . 'images/woodpecker-co.png', 81);
  }

  /**
   * Render the settings page for this plugin.
   *
   * @since    1.0.0
   */
  public function display_plugin_setup_page()
  {
    echo '<app-plugin></app-plugin>';
  }
}
