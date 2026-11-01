<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;
$o = get_option( 'swcp_settings' );
if ( is_array( $o ) && ! empty( $o['delete_on_uninstall'] ) ) {
	delete_option( 'swcp_settings' );
	delete_option( 'swcp_stats' );
}
