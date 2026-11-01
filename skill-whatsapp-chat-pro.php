<?php
/**
 * Plugin Name:       Skill WhatsApp Chat Pro
 * Plugin URI:        https://example.com/skill-whatsapp-chat-pro
 * Description:       Professional WhatsApp floating chat & multi-agent support widget. Modern Bootstrap 5.3 dashboard, AJAX settings, live preview, business hours with timezone, page targeting, click analytics, GDPR consent, shortcode & Gutenberg-friendly button.
 * Version:           3.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Skill
 * License:           GPL-2.0-or-later
 * Text Domain:       skill-whatsapp-chat-pro
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SWCP_VERSION', '3.0.0' );
define( 'SWCP_FILE', __FILE__ );
define( 'SWCP_DIR', plugin_dir_path( __FILE__ ) );
define( 'SWCP_URL', plugin_dir_url( __FILE__ ) );
define( 'SWCP_OPTION', 'swcp_settings' );
define( 'SWCP_STATS', 'swcp_stats' );

require_once SWCP_DIR . 'includes/class-swcp-settings.php';
require_once SWCP_DIR . 'includes/class-swcp-analytics.php';
require_once SWCP_DIR . 'includes/class-swcp-admin.php';
require_once SWCP_DIR . 'includes/class-swcp-frontend.php';

register_activation_hook( __FILE__, function () {
	$existing = get_option( SWCP_OPTION );
	if ( false === $existing ) {
		add_option( SWCP_OPTION, SWCP_Settings::defaults() );
	} else {
		update_option( SWCP_OPTION, SWCP_Settings::migrate( (array) $existing ) );
	}
	if ( false === get_option( SWCP_STATS ) ) add_option( SWCP_STATS, array(), '', false );
} );

add_action( 'plugins_loaded', function () {
	load_plugin_textdomain( 'skill-whatsapp-chat-pro', false, dirname( plugin_basename( SWCP_FILE ) ) . '/languages' );
	new SWCP_Analytics();
	if ( is_admin() ) new SWCP_Admin();
	new SWCP_Frontend();
} );

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
	array_unshift( $links, '<a href="' . esc_url( admin_url( 'admin.php?page=swcp' ) ) . '">' . esc_html__( 'Settings', 'skill-whatsapp-chat-pro' ) . '</a>' );
	return $links;
} );
