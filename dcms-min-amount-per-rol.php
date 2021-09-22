<?php
/*
Plugin Name: Minimun Amount Per Rol
Plugin URI: https://decodecms.com
Description: Mínimo monto de pedido para la primera compra para un determinado rol de usuario
Version: 1.0
Author: Jhon Marreros Guzmán
Author URI: https://decodecms.com
Text Domain: dcms-min-amount-per-rol
Domain Path: languages
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

namespace dcms\minamount;

// use dcms\minamount\includes\Plugin;
use dcms\minamount\includes\Submenu;
use dcms\minamount\includes\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin class to handle settings constants and loading files
**/
final class Loader{

	// Define all the constants we need
	public function define_constants(){
		define ('DCMS_MINAMOUNT_VERSION', '1.0');
		define ('DCMS_MINAMOUNT_PATH', plugin_dir_path( __FILE__ ));
		define ('DCMS_MINAMOUNT_URL', plugin_dir_url( __FILE__ ));
		define ('DCMS_MINAMOUNT_BASE_NAME', plugin_basename( __FILE__ ));
		define ('DCMS_MINAMOUNT_SUBMENU', 'tools.php');
	}

	// Load all the files we need
	public function load_includes(){
		// include_once ( DCMS_MINAMOUNT_PATH . '/includes/plugin.php');
		include_once ( DCMS_MINAMOUNT_PATH . '/includes/submenu.php');
		include_once ( DCMS_MINAMOUNT_PATH . '/includes/settings.php');
	}

	// Load tex domain
	public function load_domain(){
		add_action('plugins_loaded', function(){
			$path_languages = dirname(DCMS_MINAMOUNT_BASE_NAME).'/languages/';
			load_plugin_textdomain('dcms-min-amount-per-rol', false, $path_languages );
		});
	}

	// Add link to plugin list
	public function add_link_plugin(){
		add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $links ){
			return array_merge( array(
				'<a href="' . esc_url( admin_url( DCMS_MINAMOUNT_SUBMENU . '?page=dcms-minamount' ) ) . '">' . __( 'Settings', 'dcms-min-amount-per-rol' ) . '</a>'
			), $links );
		} );
	}

	// Initialize all
	public function init(){
		$this->define_constants();
		$this->load_includes();
		$this->load_domain();
		$this->add_link_plugin();
		// new Plugin();
		new SubMenu();
		new Settings();
	}

}

$dcms_minamount_process = new Loader();
$dcms_minamount_process->init();


