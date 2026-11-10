<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WCB {

    public static function activate() {
        if ( ! get_option( 'wcb_settings' ) ) {
            add_option( 'wcb_settings', array(
                'phone'    => '923001234567',
                'message'  => 'Hello! I need help.',
                'position' => 'bottom-right',
                'color'    => '#25D366',
                'enabled'  => '1',
            ) );
        }
    }

    public static function deactivate() {
        // Nothing to clean on deactivation
    }

    public static function get_settings() {
        return wp_parse_args(
            get_option( 'wcb_settings', array() ),
            array(
                'phone'    => '',
                'message'  => 'Hello!',
                'position' => 'bottom-right',
                'color'    => '#25D366',
                'enabled'  => '0',
            )
        );
    }
}