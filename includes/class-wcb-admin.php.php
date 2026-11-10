<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WCB_Admin {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    public function add_menu() {
        add_menu_page(
            __( 'WhatsApp Chat Button', 'whatsapp-chat-button' ),
            __( 'WA Button', 'whatsapp-chat-button' ),
            'manage_options',
            'wcb-settings',
            array( $this, 'render_page' ),
            'dashicons-whatsapp',
            80
        );
    }

    public function register_settings() {
        register_setting( 'wcb_settings_group', 'wcb_settings', array(
            'sanitize_callback' => array( $this, 'sanitize' ),
        ) );
    }

    public function sanitize( $input ) {
        return array(
            'phone'    => sanitize_text_field( $input['phone'] ?? '' ),
            'message'  => sanitize_textarea_field( $input['message'] ?? '' ),
            'position' => in_array( $input['position'] ?? '', array( 'bottom-right', 'bottom-left' ), true ) ? $input['position'] : 'bottom-right',
            'color'    => sanitize_hex_color( $input['color'] ?? '#25D366' ),
            'enabled'  => ! empty( $input['enabled'] ) ? '1' : '0',
        );
    }

    public function enqueue_assets( $hook ) {
        if ( 'toplevel_page_wcb-settings' !== $hook ) return;
        wp_enqueue_style( 'wcb-admin', WCB_URL . 'assets/css/admin.css', array(), WCB_VERSION );
        wp_enqueue_script( 'wcb-admin', WCB_URL . 'assets/js/admin.js', array( 'jquery' ), WCB_VERSION, true );
    }

    public function render_page() {
        $s = WCB::get_settings();
        ?>
        <div class="wrap wcb-wrap">
            <h1><?php esc_html_e( 'WhatsApp Chat Button Settings', 'whatsapp-chat-button' ); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'wcb_settings_group' ); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="wcb-enabled"><?php esc_html_e( 'Enable Button', 'whatsapp-chat-button' ); ?></label></th>
                        <td>
                            <input type="checkbox" id="wcb-enabled" name="wcb_settings[enabled]" value="1" <?php checked( $s['enabled'], '1' ); ?> />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wcb-phone"><?php esc_html_e( 'WhatsApp Number', 'whatsapp-chat-button' ); ?></label></th>
                        <td>
                            <input type="text" id="wcb-phone" class="regular-text" name="wcb_settings[phone]" value="<?php echo esc_attr( $s['phone'] ); ?>" placeholder="923001234567" />
                            <p class="description"><?php esc_html_e( 'With country code, no + or spaces. Example: 923001234567', 'whatsapp-chat-button' ); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wcb-message"><?php esc_html_e( 'Pre-filled Message', 'whatsapp-chat-button' ); ?></label></th>
                        <td>
                            <textarea id="wcb-message" class="large-text" rows="3" name="wcb_settings[message]"><?php echo esc_textarea( $s['message'] ); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wcb-position"><?php esc_html_e( 'Position', 'whatsapp-chat-button' ); ?></label></th>
                        <td>
                            <select id="wcb-position" name="wcb_settings[position]">
                                <option value="bottom-right" <?php selected( $s['position'], 'bottom-right' ); ?>><?php esc_html_e( 'Bottom Right', 'whatsapp-chat-button' ); ?></option>
                                <option value="bottom-left" <?php selected( $s['position'], 'bottom-left' ); ?>><?php esc_html_e( 'Bottom Left', 'whatsapp-chat-button' ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="wcb-color"><?php esc_html_e( 'Button Color', 'whatsapp-chat-button' ); ?></label></th>
                        <td>
                            <input type="text" id="wcb-color" class="wcb-color-field" name="wcb_settings[color]" value="<?php echo esc_attr( $s['color'] ); ?>" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}