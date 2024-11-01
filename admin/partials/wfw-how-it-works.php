<?php
/**
 * Admin backend for How Its Works
 *
 * @link       #
 * @since      1.0.0
 * @author     Woodpecker Team
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/admin/partials
 */

if (!defined('Woodpecker_For_Wordpress_Connector_Admin')) :
    die('Direct access not permitted');
endif;
?>
<div class="col-container">
  <div class="col-container__margin">
    <div class="how-it-works-content">
      <div class="intro-block">
        <p>
          <?php _e('<strong>Woodpecker for WordPress</strong> plugin allows you to integrate your Woodpecker account with your WordPress website. You&nbsp;can use it to send contact information of the prospects who filled out the form placed on your website directly into your Woodpecker campaign.', $this->plugin_name); ?>
        </p>
        <h3><?php _e('You don’t have the Woodpecker account yet?', $this->plugin_name); ?></h3>
        <p><?php _e('To use Woodpecker for Wordpress plugin you need to have an active Woodpecker account on the Team Pro plan or be an Agency user. You&nbsp;don’t have the Woodpecker account yet?', $this->plugin_name); ?> <a
            href="https://app.woodpecker.co/signup" target="_blank"><?php _e('Sign up now!', $this->plugin_name); ?></a></p>
        <h3><?php _e('How to set it up?', $this->plugin_name); ?></h3>
        <p class="intro-block__p"><?php _e('Before you start, you need to generate your API key in Woodpecker.', $this->plugin_name); ?> <a href="https://help.woodpecker.co/article/116-generating-api-key"
            target="_blank"><?php _e('How to get API key?', $this->plugin_name); ?></a></p>
      </div>

      <ul>
        <li>
          <div class="text-container">
            <?php _e('Open the plugin and paste Woodpecker API Key.', $this->plugin_name); ?><br>
            <?php _e('Go to <strong>Settings → Synchronization →</strong> paste your API KEY. Remember to save changes!', $this->plugin_name); ?>
          </div>
          <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/step_1.png">
        </li>
        <li>
          <div class="text-container"><?php _e('Okay, you’re all set! Move on to the ‘Shortcodes’ tab.', $this->plugin_name); ?></div>
          <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/step_2.png">
        </li>
      </ul>

      <h3><?php _e('How does Woodpecker for WordPress work?', $this->plugin_name); ?></h3>
      <p class="intro-block__p"><?php _e('Adding a form to your WordPress website lets you transfer your contacts data to Woodpecker.', $this->plugin_name); ?></p>
      <ul>
        <li>
          <div class="text-container">
            <?php _e('Go to the ‘Shortcodes’ tab to see a campaigns’ list you have in Woodpecker.', $this->plugin_name); ?><br>
            <?php _e('Check your campaigns’ <strong>status</strong>, the email address you use to send it <strong>from</strong> and a <strong>shortcode</strong> assigned to it.', $this->plugin_name); ?>
          </div>
          <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/step_3.png">
          <div class="text-container">
            <?php _e('Each <strong>shortcode</strong> has its own shortcode. It allows you to send your prospects\' data from WordPress into Woodpecker\'s Prospects database or directly to the campaign of your choice.', $this->plugin_name); ?></div>
          <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/step_4.png">
        </li>
        <li>
          <div class="text-container">
            <?php _e('Copy the shortcode and paste it to the settings in WordPress to make the form visible on any subpage in WordPress. You&nbsp;can place multiple forms on your website and use one shortcode per each form.', $this->plugin_name); ?>
          </div>
          <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/step_5.png">
        </li>
        <li>
          <div class="text-container"><?php _e('Each prospect who fills in the form will appear in Woodpecker Prospects database with the tag #WORDPRESS assigned to it.', $this->plugin_name); ?></div>
          <img src="<?php echo plugin_dir_url( __FILE__ ); ?>../images/step_6.png">
        </li>
      </ul>

      <h3><?php _e('How to modify your form in WordPress?', $this->plugin_name); ?></h3>
      <p><?php _e('Go to the plugin Settings where you can:', $this->plugin_name); ?></p>
      <ul class="standard">
        <li><?php _e('edit form field labels,', $this->plugin_name); ?></li>
        <li><?php _e('hide field labels,', $this->plugin_name); ?></li>
        <li><?php _e('change the colour of the form,', $this->plugin_name); ?></li>
        <li><?php _e('edit statements for success, error, or an existing email address,', $this->plugin_name); ?></li>
        <li><?php _e('add information about Privacy Policy.', $this->plugin_name); ?></li>
      </ul>
      <p><?php _e('The look of your form depends on your WordPress template.', $this->plugin_name); ?></p>
    </div>
  </div>
</div>
