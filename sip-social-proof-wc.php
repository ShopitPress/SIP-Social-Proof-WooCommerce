<?php

/**
 *
 * @link              https://shopitpress.com
 * @since             1.0.0
 * @package           sip_social_proof_woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       SIP Social Proof for WooCommerce
 * Plugin URI:        https://shopitpress.com/plugins/sip-social-proof-woocommerce/
 * Description:       Display real time proof of your sales and customers.
 * Version:           1.0.1
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
Last updated on:  12-08-2015
*/

if ( !defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

// Define plugin constants
define( 'SIP_SPWC_PLUGIN_NAME', 'SIP Social Proof for WooCommerce' );
define( 'SIP_SPWC_PLUGIN_SLUG', 'sip-social-proof-woocommerce' );
define( 'SIP_SPWC_PLUGIN_VERSION', '1.0.1' );
define( 'SIP_SPWC_PLUGIN_PURCHASE_URL', 'https://shopitpress.com/plugins/sip-social-proof-woocommerce/' );
define( 'SIP_SPWC_BASENAME', plugin_basename( __FILE__ ) );
define( 'SIP_SPWC_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'SIP_SPWC_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
 
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
	
	require_once( SIP_SPWC_DIR . 'admin/sip-social-proof-admin.php' );

	//add CSS & JS scripts
	add_action( 'wp_enqueue_scripts', 'sip_spwc_scripts' );
	function sip_spwc_scripts() {		
		wp_enqueue_script( 'script-name', plugin_dir_url( __FILE__ ) .  'assets/js/app.js', array(), '1.0.0', true );
		wp_register_style( 'sip-spwc-style', plugin_dir_url( __FILE__ ) .'assets/css/style.css', array(), '1.0.0');
    wp_enqueue_style( 'sip-spwc-style' );
	}
	
	// Check if SIP_Social_Proof_WC class exists or not
	// if exist then load the plugin template page
	if ( ! class_exists( 'SIP_Social_Proof_WC' ) ) {	 

	  load_plugin_textdomain( 'sip-spwc-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		
		/**
		 * Main plugin class.
		 *
		 * @since 1.0.0
		 *
		 * @package sip_social_proof_woocommerce
		 * @author	ShopitPress
		 */
		class SIP_Social_Proof_WC
		{

			public function __construct() {
			
				// called just before the woocommerce template functions are included				
				add_action( 'init', array( &$this, 'sip_spwc_template_functions' ), 20 );
				add_action('admin_notices', array( &$this, 'sip_spwc_admin_notice') );
				add_action('admin_init', array( &$this,  'sip_spwc_nag_ignore') );
				register_deactivation_hook( __FILE__, array( 'SIP_Social_Proof_WC_Admin' , 'sip_spwc_deactivate' ) );
			}

			/**
			 * Display a notice.
			 *
			 * @since 1.0.1
			 */
			public function sip_spwc_admin_notice() {
				global $current_user ;
			  $user_id = $current_user->ID;
			  /* Check that the user hasn't already clicked to ignore the message */
			  if( ! class_exists( 'SIP_Social_Proof_WC_Pro' ) ) {
					if ( ! get_user_meta($user_id, 'sip_spwc_ignore_notice') ) { ?>

						<div class="updated" style="padding: 0; margin: 0; border: none; background: none;">
							<div  class="sip-notification-message">
								<div class="icon">
									<img title="" src="<?php echo SIP_SPWC_URL . "admin/assets/images/icon-social-proof.png" ?>" alt="" />
								</div>						
								<div class="text"><?php
									_e( 'It\'s time to upgrade your', 'sip-social-proof' ); ?> <strong><?php echo $plugin_info['Name']; ?> plugin</strong> <?php _e( 'to', 'sip-social-proof' ); ?> <strong>PRO</strong> <?php _e( 'version!', 'sip-social-proof' ); ?><br />
									<span><?php _e( 'Extend standard plugin functionality with new great options.', 'sip-social-proof' ); ?></span>
									<?php printf(__('| <a href="%1$s">Dismiss this notice</a>'), '?sip_spwc_nag_ignore=0'); ?>							
								</div>
								<div class="button_div">
									<a class="button" target="_blank" href="https://shopitpress.com/plugins/<?php echo SIP_SPWC_PLUGIN_SLUG ; ?>/?utm_source=wordpress.org&amp;utm_medium=SIP-panel&amp;utm_content=v<?php echo SIP_SPWC_PLUGIN_VERSION; ?>&amp;utm_campaign=<?php echo SIP_SPWC_UTM_CAMPAIGN ; ?>"><?php _e( 'Learn More', 'sip-social-proof' ); ?></a>
								</div>
							</div>
						</div>
					
					<?php
					}
				}
			}

			/**
			 * Notice that can be dismissed.
			 *
			 * @since 1.0.1
			 */
			public function sip_spwc_nag_ignore() {
				global $current_user;
		    $user_id = $current_user->ID;
		    /* If user clicks to ignore the notice, add that to their user meta */
		    if ( isset($_GET['sip_spwc_nag_ignore']) && '0' == $_GET['sip_spwc_nag_ignore'] ) {
		        add_user_meta($user_id, 'sip_spwc_ignore_notice', 'true', true);
				}
			}

			// include template functions file	
			public function sip_spwc_template_functions() {
				include( 'template-functions.php' );
			}
			  
		}//END class SIP_Social_Proof_WC

	}  //END if

	// finally instantiate our plugin class and add it to the set of globals
	$GLOBALS['sip_social_proof_wc'] = new SIP_Social_Proof_WC ();
}  //END if