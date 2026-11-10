<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class WCB_Frontend {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_footer', array( $this, 'render_button' ) );
    }

    public function enqueue_assets() {
        $s = WCB::get_settings();
        if ( '1' !== $s['enabled'] || empty( $s['phone'] ) ) return;

        wp_enqueue_style( 'wcb-frontend', WCB_URL . 'assets/css/frontend.css', array(), WCB_VERSION );
        wp_add_inline_style( 'wcb-frontend', sprintf(
            '.wcb-button{background:%1$s}.wcb-button:hover{background:%2$s}',
            esc_attr( $s['color'] ),
            esc_attr( $this->darken( $s['color'], 20 ) )
        ) );
        wp_enqueue_script( 'wcb-frontend', WCB_URL . 'assets/js/frontend.js', array(), WCB_VERSION, true );
    }

    public function render_button() {
        $s = WCB::get_settings();
        if ( '1' !== $s['enabled'] || empty( $s['phone'] ) ) return;

        $url = 'https://wa.me/' . rawurlencode( $s['phone'] ) . '?text=' . rawurlencode( $s['message'] );
        $position_class = 'wcb-' . $s['position'];
        ?>
        <a href="<?php echo esc_url( $url ); ?>" class="wcb-button <?php echo esc_attr( $position_class ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'whatsapp-chat-button' ); ?>">
            <svg viewBox="0 0 32 32" width="28" height="28" fill="currentColor" aria-hidden="true">
                <path d="M16 0C7.2 0 0 7.2 0 16c0 2.8.7 5.4 2 7.7L0 32l8.5-2.2c2.2 1.2 4.8 1.9 7.5 1.9 8.8 0 16-7.2 16-16S24.8 0 16 0zm0 29.3c-2.4 0-4.6-.6-6.6-1.8l-.5-.3-5 1.3 1.3-4.9-.3-.5C3.7 21.2 3 18.6 3 16 3 8.8 8.8 3 16 3s13 5.8 13 13-5.8 13.3-13 13.3zm7.2-9.7c-.4-.2-2.3-1.1-2.7-1.2-.4-.1-.6-.2-.9.2s-1 1.2-1.2 1.5c-.2.2-.5.3-.9.1-.4-.2-1.6-.6-3.1-2-1.2-1-1.9-2.3-2.2-2.7-.2-.4 0-.6.2-.8.2-.2.4-.5.6-.7.2-.2.2-.4.4-.6.1-.2.1-.5 0-.7-.1-.2-.9-2.1-1.2-2.9-.3-.7-.6-.7-.9-.7h-.7c-.2 0-.6.1-.9.4-.3.3-1.2 1.2-1.2 2.9s1.2 3.3 1.4 3.6c.2.2 2.4 3.6 5.8 5.1.8.4 1.4.6 1.9.7.8.3 1.5.2 2.1.1.6-.1 2.3-.9 2.6-1.8.3-.9.3-1.7.2-1.8-.1-.2-.3-.3-.7-.5z"/>
            </svg>
            <span class="wcb-tooltip"><?php esc_html_e( 'Chat with us', 'whatsapp-chat-button' ); ?></span>
        </a>
        <?php
    }

    private function darken( $hex, $percent ) {
        $hex = ltrim( $hex, '#' );
        if ( strlen( $hex ) !== 6 ) return '#128C7E';
        $rgb = array_map( 'hexdec', str_split( $hex, 2 ) );
        foreach ( $rgb as &$c ) {
            $c = max( 0, min( 255, (int) round( $c * ( 100 - $percent ) / 100 ) ) );
        }
        return sprintf( '#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2] );
    }
}