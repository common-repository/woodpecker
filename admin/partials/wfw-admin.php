<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 * @author     Woodpecker Team
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/admin/partials
 */
  global $wpdb;

  $isDbOk = new WfwUpdateDatabase(get_option('wfw_db_version'));
  $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'howitworks';
  $data = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");
  $getconnectcampaign = new Woodpecker_For_Wordpress_Connector_Curl('/rest/v1/me', $data->api_key);
  $getjsoncampaign = $getconnectcampaign->getJson();
  $getstatus = $getjsoncampaign->status;
?>

<div id="woodpecker-options" class="woodpecker-options-wrap">
    <?php
      define('Woodpecker_For_Wordpress_Connector_Admin', TRUE);
    ?>
    <div class="woodpecker-header">
      <div class="woodpecker-header__logo">
        <img src="<?php _e($this->url . 'admin/images/app-logo.svg'); ?>" alt="Woodpecker">
        <div class="woodpecker-header__logo--text">
          <?php _e('Woodpecker for WordPress', $this->plugin_name); ?>
        </div>
      </div>
      <div class="woodpecker-header-content">
        <div class="nav-tab-wrapper">
          <a href="?page=wfw&tab=forms" class="nav-tab <?php echo $active_tab == 'forms' ? 'nav-tab-active' : ''; ?>"><?php _e('Forms', $this->plugin_name); ?></a>
          <?php if ($getstatus->status != 'ERROR' && $data->api_key != '') : ?>
          <a href="?page=wfw&tab=campaigns" class="nav-tab <?php echo $active_tab == 'campaigns' ? 'nav-tab-active' : ''; ?>"><?php _e('Shortcodes', $this->plugin_name); ?></a>
          <a href="?page=wfw&tab=prospects" class="nav-tab <?php echo $active_tab == 'prospects' ? 'nav-tab-active' : ''; ?>"><?php _e('Prospects', $this->plugin_name); ?></a>
          <?php endif; ?>
          <a href="?page=wfw&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Settings', $this->plugin_name); ?></a>
          <a href="?page=wfw&tab=howitworks" class="nav-tab <?php echo $active_tab == 'howitworks' ? 'nav-tab-active' : ''; ?>"><?php _e('How it works', $this->plugin_name); ?></a>
        </div>
      </div>
    </div>
    <?php
      switch ($active_tab) :
        case 'forms':
          include_once( 'wfw-forms.php' );
          break;

        case 'campaigns':
          include_once( 'wfw-shortcodes.php' );
          break;

        case 'prospects':
          include_once( 'wfw-prospects.php' );
          break;

        case 'settings':
          include_once( 'wfw-settings.php' );
          break;

        case 'troubleshoot':
            include_once( 'wfw-troubleshoot.php' );
            break;

        default:
          include_once( 'wfw-how-it-works.php' );
          break;
      endswitch;
    ?>
</div>
