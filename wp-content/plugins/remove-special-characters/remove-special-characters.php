<?php
/*
Plugin Name: Remove Special Characters
Version: 1.0.0
Description: This plugin will help when you upload images with special characters.
Author: CHR Designer
Author URI: http://www.chrdesigner.com
Plugin URI: https://wordpress.org/plugins/remove-special-characters
License: A slug describing license associated with the plugin (usually GPL2)
*/

function chr_remover_acentuacao($chr_filename) {
	$chr_ext = end( explode( '.' , $chr_filename ) );
	$chr_sanitized = preg_replace( '/[^a-zA-Z0-9-_.]/', '', substr( $chr_filename, 0, -( strlen( $chr_ext ) +1 ) ) );
	$chr_sanitized = str_replace( '.', '-', $chr_sanitized );
	return strtolower( $chr_sanitized . '.' . $chr_ext );
}
add_filter('sanitize_file_name', 'chr_remover_acentuacao', 10);

?>