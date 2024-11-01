<?php
/**
 * Admin backend for Settings
 *
 * @link       #
 * @since      2.0.5
 * @author     Woodpecker Team
 * @package    Woodpecker_For_Wordpress_Connector
 * @subpackage Woodpecker_For_Wordpress_Connector/admin/partials
 */

if (!defined('Woodpecker_For_Wordpress_Connector_Admin')) :
    die('Direct access not permitted');
endif;

$isOk = new WfwUpdateDatabase('reinstall');

if ($isOk) {
    echo '<script>if(!alert(\'Woodpecker for Wordpress has been installed!\')){
        window.location.href= \'admin.php?page=wfw&tab=forms\';
    }</script>';
}

?>
