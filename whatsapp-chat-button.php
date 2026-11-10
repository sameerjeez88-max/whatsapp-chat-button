<?php
/**
 * Plugin Name:       WhatsApp Chat Button
 * Plugin URI:        https://github.com/sameerjeez88-max/whatsapp-chat-button
 * Description:       Adds a beautiful floating WhatsApp chat button to your website. Fully customizable phone number, message, position and colors.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Rana Yasir
 * Author URI:        https://ranayasir.unaux.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       whatsapp-chat-button
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'WCB_VERSION', '1.0.0' );
define( 'WCB_PATH', plugin_dir_path( __FILE__ ) );
define( 'WCB_URL', plugin_dir_url( __FILE__ ) );

require_once WCB_PATH . 'includes/class-wcb.php';
require_once WCB_PATH . 'includes/class-wcb-admin.php';
require_once WCB_PATH . 'includes/class-wcb-frontend.php';

function wcb_init() {
    if ( is_admin() ) {
        new WCB_Admin();
    } else {
        new WCB_Frontend();
    }
}
add_action( 'plugins_loaded', 'wcb_init' );

register_activation_hook( __FILE__, array( 'WCB', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WCB', 'deactivate' ) );