<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/includes
 * @author     Woodpecker Team
 */
class Woodpecker_For_Wordpress_Connector
{

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      Woodpecker_For_Wordpress_Connector_Loader $loader Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string $plugin_name The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The url to this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string $plugin_url
   */
  protected $plugin_url;

  /**
   * The current version of the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string $version The current version of the plugin.
   */
  protected $version;

  /**
   * Define the core functionality of the plugin.
   *
   * Set the plugin name and the plugin version that can be used throughout the plugin.
   * Load the dependencies, define the locale, and set the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function __construct()
  {
    $this->version = WOODPECKER_PLUGIN_NAME_VERSION;
    $this->plugin_name = 'wfw';
    $this->plugin_url = WOODPECKER_PLUGIN_URL;

    $this->load_dependencies();
    $this->set_locale();
    $this->define_admin_hooks();
    $this->define_public_hooks();
  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - Woodpecker_For_Wordpress_Connector_Loader. Orchestrates the hooks of the plugin.
   * - Woodpecker_For_Wordpress_Connector_i18n. Defines internationalization functionality.
   * - Woodpecker_For_Wordpress_Connector_Admin. Defines all hooks for the admin area.
   * - Woodpecker_For_Wordpress_Connector_Public. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.1.0
   * @access   private
   */
  private function load_dependencies()
  {
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wfw-loader.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wfw-i18n.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wfw-admin.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wfw-public.php';
    $this->loader = new Woodpecker_For_Wordpress_Connector_Loader();
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wfw-curl.php';
    require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wfw-db.php';
  }


  /**
   * Define the locale for this plugin for internationalization.
   *
   * Uses the Woodpecker_For_Wordpress_Connector_i18n class in order to set the domain and to register the hook
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function set_locale()
  {

    $plugin_i18n = new Woodpecker_For_Wordpress_Connector_i18n();

    $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

  }

  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_admin_hooks()
  {
    $plugin_admin = new Woodpecker_For_Wordpress_Connector_Admin($this->get_plugin_name(), $this->get_version(), $this->plugin_url);

    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
    $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

    // Add menu item
    $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');

    // Save/Update our plugin options
    $this->loader->add_action('wp_ajax_saveFormSettings', $plugin_admin, 'saveFormSettings');
    $this->loader->add_action('wp_ajax_nopriv_saveFormSettings', $plugin_admin, 'saveFormSettings');
    $this->loader->add_action('wp_ajax_saveFormData', $plugin_admin, 'saveFormData');
    $this->loader->add_action('wp_ajax_nopriv_saveFormData', $plugin_admin, 'saveFormData');
  }

  /**
   * Register all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_public_hooks()
  {
    $plugin_public = new Woodpecker_For_Wordpress_Connector_Public($this->get_plugin_name(), $this->get_version(), $this->plugin_url);

    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    $this->loader->add_action('init', $plugin_public, 'register_shortcodes');
    $this->loader->add_action('wp_ajax_add_prospect_to_campaing', $plugin_public, 'add_prospect_to_campaing');
    $this->loader->add_action('wp_ajax_nopriv_add_prospect_to_campaing', $plugin_public, 'add_prospect_to_campaing');
    $this->loader->add_action('wp_ajax_addProspectsToDatabase', $plugin_public, 'addProspectsToDatabase');
    $this->loader->add_action('wp_ajax_nopriv_addProspectsToDatabase', $plugin_public, 'addProspectsToDatabase');
  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since    1.0.0
   */
  public function run()
  {
    $this->loader->run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress and to define internationalization functionality.
   *
   * @return    string    The name of the plugin.
   * @since     1.0.0
   */
  public function get_plugin_name()
  {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @return    Woodpecker_For_Wordpress_Connector_Loader    Orchestrates the hooks of the plugin.
   * @since     1.0.0
   */
  public function get_loader()
  {
    return $this->loader;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @return    string    The version number of the plugin.
   * @since     1.0.0
   */
  public function get_version()
  {
    return $this->version;
  }

}
