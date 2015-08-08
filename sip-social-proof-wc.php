<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://shopitpress.com
 * @since             1.0.0
 * @package           sip_social_proof_wc
 *
 * @wordpress-plugin
 * Plugin Name:       SIP Social Proof for WooCommerce
 * Plugin URI:        https://shopitpress.com/plugins/sip-social-proof-woocommerce/
 * Description:       Display real time proof of your sales and customers.
 * Version:           1.0.0
 * Author:            ShopitPress <hello@shopitpress.com>
 * Author URI:        https://shopitpress.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Copyright: 		  © 2015 ShopitPress(email: hello@shopitpress.com)
 * Text Domain:       sip-social-proof
 * Domain Path:       /languages
 */

/*
Requires: PHP5, WooCommerce Plugin
Last updated on:  07-08-2015
*/

if ( !defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

define( 'SIP_SP_PLUGIN_NAME', 'SIP Social Proof for WooCommerce' );
define( 'SIP_SP_PLUGIN_SLUG', 'sip-social-proof-woocommerce' );
define( 'SIP_SP_PLUGIN_VERSION', '1.0.0' );
define( 'SIP_SP_PLUGIN_PURCHASE_URL', 'https://shopitpress.com/plugins/sip-social-proof-woocommerce/' );
define( 'SIP_SP_BASENAME', plugin_basename( __FILE__ ) );
define( 'SIP_SP_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'SIP_SP_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
 
/**
 * Check if woocommerce plugin is installed or not
 *
 * @since 1.0.0
 *	 
 * @return bool true/false  Returns true if woocommerce is installed and active
 */ 
if ( in_array( 
	'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
{
	
	require_once( SIP_SP_DIR . 'admin/sip-social-proof-admin.php' );

	//add CSS & JS scripts
	add_action( 'wp_enqueue_scripts', 'sip_sp_scripts' );
	function sip_sp_scripts() {		
		wp_enqueue_script( 'script-name', plugin_dir_url( __FILE__ ) .  'assets/js/app.js', array(), '1.0.0', true );
		wp_register_style( 'sip-sp-style', plugin_dir_url( __FILE__ ) .'assets/css/style.css', array(), '1.0.0');
    wp_enqueue_style( 'sip-sp-style' );
	}
	
	// Check if SIP_Social_Proof_WC class exists or not, if exist then load the plugin template page
	if ( ! class_exists( 'SIP_Social_Proof_WC' ) ) {	 

	  load_plugin_textdomain( 'sip-sp-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		
		/**
		 * Main plugin class.
		 *
		 * @since 1.0.0
		 *
		 * @package sip-social-proof
		 * @author	ShopitPress
		 */
		class SIP_Social_Proof_WC
		{

			public function __construct() {
			
				// called just before the woocommerce template functions are included				
				add_action( 'init', array( &$this, 'sip_sp_template_functions' ), 20 );
			}

			// include template function	
			public function sip_sp_template_functions() {
				include( 'template-functions.php' );
			}
			  
		}//END class SIP_Social_Proof_WC

	}  //END if


	// finally instantiate our plugin class and add it to the set of globals
	$GLOBALS['sip_social_proof_wc'] = new SIP_Social_Proof_WC ();
}  //END if