<?php
/**
 * Template Function Overrides
 *
 */
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

// Load the plugin stylesheet file
add_action( 'wp_enqueue_scripts', 'sip_sp_public_assets' );
function sip_sp_public_assets() {
	wp_enqueue_style( 'sip_sp_stylesheet', plugins_url('style.css', __FILE__) );
}

/**
 * Checks for settings page to display sales_count on either single product page or shop page
 *
 * @since 1.0.0
 *
 */
if( get_option('display_sales_single_product_page', false) == true ) {
	add_action( 'woocommerce_single_product_summary', 'total_sales_single_product_page', 11 );
}

if( get_option('display_sales_shop_page', false) == true) {
	add_action( 'woocommerce_after_shop_loop_item_title', 'total_sales_shop_page', 11 );
}

function total_sales_single_product_page() {
	if ( class_exists('SIP_Social_Proof_WC_Pro') ) {
		if( sip_sp_settings_get_meta( 'sip_sp_text_display' )){
			echo '<div class="social-proof">' . nl2br(do_shortcode(sip_sp_settings_get_meta( 'sip_sp_text_display' ))) . '</div>';
		} else {
			echo  '<div class="socail-proof">' . nl2br(do_shortcode(get_option( 'show_in_product_page_view_editor' ))) . '</div>';
		}
	} else {
		echo  '<div class="social-proof">' . nl2br(do_shortcode(get_option( 'show_in_product_page_view_editor' ))) . '</div>';
	}
}

function total_sales_shop_page(){
	echo  '<div class="social-proof">' . nl2br(do_shortcode(get_option('show_in_product_in_list_view_editor'))) . '</div>';
}

/**
 * Shortcode: Get total sales count
 *
 * @since 1.0.0
 *
 * @param array $atts        A list of arguments passed to the shortcode.
 * @return int $total_sales  Returns total sales of a product
 */
add_shortcode( 'total_sales', 'get_total_sales' );
function get_total_sales($atts)
{
	global $product;
	extract( shortcode_atts(
		array(
			'animation' => '',
			'singular' 	=> '',
			'plural' 		=> '',
			'id' 				=> '',
		), $atts )
	);

	if( $id == "" ) 
		$id = $product->id;
	
	if($animation == true )
		$animation = 'style="display:none" class="count"';

	$_pf 			= new WC_Product_Factory();  
  $product 	  	= $_pf->get_product($id);
	$total_sales 	= get_post_meta( $id, 'total_sales', true );



	if( $total_sales > 0 ) {
		if( $total_sales == 1 ) {
			return nl2br('<span '. $animation .'>' .$total_sales. '</span> ' . $singular);
		} else {
			return nl2br('<span '. $animation .'>' .$total_sales. '</span> ' . $plural);			
		}
	}
	return nl2br('<span '. $animation .'>0</span> ' . $plural);
}

// Register admin settings
add_action( 'admin_init', 'sip_sp_register_admin_settings' );
function sip_sp_register_admin_settings() { 

	register_setting( 'sip-sp-settings-group', 'display_sales_single_product_page' );
	register_setting( 'sip-sp-settings-group', 'display_sales_shop_page' );
	register_setting( 'sip-sp-settings-group', 'show_in_product_in_list_view_editor' );
	register_setting( 'sip-sp-settings-group', 'show_in_product_page_view_editor' );
}


/*
* After loding this function global page show the admin panel
*/
function sip_sp_settings_page_ui() { ?>

<div class="sip-sp-wrap">
  <div class="sip-sp-settings-header">
  	<div class="sip-sp-header-left">
  		<div class="divider"></div>
  		<h1><?php echo SIP_SP_PLUGIN_NAME ; ?></h1>
  		<h3>Display real time proof of your sales and customers.</h3>
  	</div>
  	<div class="sip-sp-header-right">
  		<img class="sip-sp-header-img" src="<?php echo SIP_SP_URI ?>admin/assets/images/icon-social-proof.png">
  	</div>
  </div>

	<div class="container">
  	<div class="accordion">
    	<h3 class="panel-title">Usage</h3>
    	<div class="panel-content">
				<div style="display: block;"><br>
				  <p style="padding:10px 20px"><strong class="sip-sp-strong">Stats available</strong></p>
				  <table class="toggle-table">
				    <tbody>
				      <tr>
				        <td>Free version</td>
				        <td>Pro version</td>
				      </tr>
				      <tr>
				        <td><strong>[total_sales]</strong> Total sales of a product since the beginning</td>
				        <td>
				          <p><strong>[total_sales]</strong> Total sales of a product since the beginning</p>
				          <p><strong>[month_sales]</strong> Monthly sales of a product</p>
				          <p><strong>[week_sales]</strong> Weekly sales of a product</p>
				          <p><strong>[daily_sales]</strong> Daily sales of a product</p>
				          <p><strong>[hours]:[minutes]</strong> Hours and minutes since last sale of a product (Example: 3 hours and 4 minutes ago)</p>
				          <p><strong>[unique_product_customers]</strong> Number of unique customers who purchased a product (based on email ID)</p>
				        </td>
				      </tr>
				    </tbody>
				  </table>
				  <p style="padding:10px 20px"><strong class="sip-sp-strong">Locations</strong></p>
				  <table class="toggle-table">
				    <tbody>
				      <tr>
				        <td>Free version</td>
				        <td>Pro version</td>
				      </tr>
				      <tr>
				        <td>
				          <p><strong>Shop Base</strong></p>
				          <p><strong>Single Product Page</strong></p>
				        </td>
				        <td>
				          <p><strong>Shop Base</strong></p>
				          <p><strong>Single Product Page</strong></p>
				          <p><strong>Any Page or Post (with Shortcode and&nbsp;Product ID)</strong></p>
				          <p><strong>Customisable output per product</strong></p>
				        </td>
				      </tr>
				    </tbody>
				  </table>
				  <p style="padding:10px 20px"><strong class="sip-sp-strong">Variables</strong></p>
				  <table class="toggle-table">
				    <tbody>
				    <tr>
				      <td>Free version</td>
				      <td>Pro version</td>
				    </tr>
				    <tr>
				      <td><p><strong>Singular/plural.</strong> Example: singular="unit" plural="units"</p></td>
				      <td>
				        <p><strong>Singular/plural.</strong> Example: singular="unit" plural="units"</p>
				        <p><strong>Animated counters.</strong> Example: animation="true" (default&nbsp;animation=“false”)</p>
				      </td>
				    </tr>
				    </tbody>
				  </table>
				  <p style="padding:10px 20px"><strong class="sip-sp-strong">Examples</strong></p>
				  <table class="toggle-table">
				    <tbody>
				      <tr>
				        <td>Free version</td>
				        <td>Pro version</td>
				      </tr>
				      <tr>
				        <td><p>Sales since launch: <strong>[total_sales]</strong><br>
  					This product has been bough <strong>[total_sales singular="time" plural="times"]</strong>.<br>
  					Sold: <strong>[total_sales singular="unit" plural="units"]</strong>. Hurry up, limited stock left!</p>
				        <td>
				          <p>This month: <strong>[monthly_sales singular="sale" plural="sales" animation="true"]</strong><br>
  					The last sale was only <strong>[hours]</strong> hours and <strong>[minutes]</strong> minutes ago, hurry!<br>
  					<strong>[total_sales singular="sale" plural="sales"]</strong> from <strong>[unique_product_customers singular="customer" plural="customers"]</strong> just like you.</p>
				        </td>
				      </tr>
				    </tbody>
				  </table>
				  
  					<p style="text-align: center;">
  					<a class="button sip-sp-button button-primary" target="_blank" href="<?php echo SIP_SP_PLUGIN_PURCHASE_URL; ?>?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v<?php echo SIP_SP_PLUGIN_VERSION ?>&utm_campaign=sip_social_proof"><span>Get Pro version</span></a>
     			</p>
     		</div>
  		</div>

  <form method="post" action="options.php">
  <?php settings_fields( 'sip-sp-settings-group' ); ?>

    <table class="form-table">

      <tr valign="top">
      	<td><label><input type="checkbox" name="display_sales_single_product_page" value="true" <?php echo esc_attr( get_option('display_sales_single_product_page', false))?' checked="checked"':''; ?> /> Enable in Single Product Page	</label></td>
      	<td colspan="3"><label><input type="checkbox" name="display_sales_shop_page" value="true" <?php echo esc_attr( get_option('display_sales_shop_page', false))?' checked="checked"':''; ?> /> Enable in Shop Page </label></td>
      </tr>
	  
		  <tr>
				<td>
				  <div>
					<?php 
						$settings   		= array('teeny' => false, 'tinymce' => true, 'textarea_rows' => 12, 'tabindex' => 1 );
						$editor_id   		= "show_in_product_page_view_editor"; 
						$editor_content = get_option('show_in_product_page_view_editor'); 
						wp_editor( $editor_content, $editor_id, $settings );
					?>
				  </div>
				</td>
				<td>
					<div>
					<?php 
						$settings   		= array('teeny' => false, 'tinymce' => true, 'textarea_rows' => 12, 'tabindex' => 1 );
						$editor_id   		= "show_in_product_in_list_view_editor"; 
						$editor_content = get_option('show_in_product_in_list_view_editor'); 
						wp_editor( $editor_content, $editor_id, $settings );
					?>
					</div>
				</td>
		  </tr>

    </table>
    <?php submit_button(); ?>

	</form>
</div><!-- .wrap -->
</div>
<script type="text/javascript">
	

	// Hiding the panel content. If JS is inactive, content will be displayed
  jQuery( '.panel-content' ).hide();

  // Preparing the DOM
  
  // -- Update the markup of accordion container 
  jQuery( '.accordion' ).attr({
    role: 'tablist',
    multiselectable: 'true'
   });

  // -- Adding ID, aria-labelled-by, role and aria-labelledby attributes to panel content
  jQuery( '.panel-content' ).attr( 'id', function( IDcount ) { 
    return 'panel-' + IDcount; 
  });
  jQuery( '.panel-content' ).attr( 'aria-labelledby', function( IDcount ) { 
    return 'control-panel-' + IDcount; 
  });
  jQuery( '.panel-content' ).attr( 'aria-hidden' , 'true' );
  // ---- Only for accordion, add role tabpanel
  jQuery( '.accordion .panel-content' ).attr( 'role' , 'tabpanel' );
  
  // -- Wrapping panel title content with a <a href="">
  jQuery( '.panel-title' ).each(function(i){
    
    // ---- Need to identify the target, easy it's the immediate brother
    $target = jQuery(this).next( '.panel-content' )[0].id;
    
    // ---- Creating the link with aria and link it to the panel content
    $link = jQuery( '<a>', {
      'href': '#' + $target,
      'aria-expanded': 'false',
      'aria-controls': $target,
      'id' : 'control-' + $target
    });
    
    // ---- Output the link
    jQuery(this).wrapInner($link);  
    
  });

  // Optional : include an icon. Better in JS because without JS it have non-sense.
  jQuery( '.panel-title a' ).append('<span class="icon"><b>+<b></span>');

  // Now we can play with it
  jQuery( '.panel-title a' ).click(function() {
    
    if (jQuery(this).attr( 'aria-expanded' ) == 'false'){ //If aria expanded is false then it's not opened and we want it opened !
      
      // -- Only for accordion effect (2 options) : comment or uncomment the one you want
      
      // ---- Option 1 : close only opened panel in the same accordion
      //      search through the current Accordion container for opened panel and close it, remove class and change aria expanded value
      jQuery(this).parents( '.accordion' ).find( '[aria-expanded=true]' ).attr( 'aria-expanded' , false ).removeClass( 'active' ).parent().next( '.panel-content' ).slideUp(200).attr( 'aria-hidden' , 'true');

      // Option 2 : close all opened panels in all accordion container
      //$('.accordion .panel-title > a').attr('aria-expanded', false).removeClass('active').parent().next('.panel-content').slideUp(200);
      
      // Finally we open the panel, set class active for styling purpos on a and aria-expanded to "true"
      jQuery(this).attr( 'aria-expanded' , true ).addClass( 'active' ).parent().next( '.panel-content' ).slideDown(200).attr( 'aria-hidden' , 'false');

    } else { // The current panel is opened and we want to close it

      jQuery(this).attr( 'aria-expanded' , false ).removeClass( 'active' ).parent().next( '.panel-content' ).slideUp(200).attr( 'aria-hidden' , 'true');;

    }
    // No Boing Boing
    return false;
  });
</script>
<?php 

} 