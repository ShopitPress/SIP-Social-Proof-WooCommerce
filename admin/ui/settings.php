<form method="post" action="options.php">
    <?php settings_fields( 'sip-spwc-settings-group' ); ?>
    <table class="form-table">
      <tr valign="top">
        <td><label><input type="checkbox" name="display_sales_single_product_page" value="true" <?php echo esc_attr( get_option('display_sales_single_product_page', false))?' checked="checked"':''; ?> /> Enable in Single Product Page   </label></td>
        <td colspan="3"><label><input type="checkbox" name="display_sales_shop_page" value="true" <?php echo esc_attr( get_option('display_sales_shop_page', false))?' checked="checked"':''; ?> /> Enable in Shop Page </label></td>
      </tr>
          <tr>
                <td>
                  <div>
                    <?php 
                        $settings       = array('teeny' => false, 'tinymce' => true, 'textarea_rows' => 12, 'tabindex' => 1 );
                        $editor_id      = "show_in_product_page_view_editor"; 
                        $editor_content = get_option('show_in_product_page_view_editor'); 
                        wp_editor( $editor_content, $editor_id, $settings );
                    ?>
                  </div>
                </td>
                <td>
                    <div>
                    <?php 
                        $settings       = array('teeny' => false, 'tinymce' => true, 'textarea_rows' => 12, 'tabindex' => 1 );
                        $editor_id      = "show_in_product_in_list_view_editor"; 
                        $editor_content = get_option('show_in_product_in_list_view_editor'); 
                        wp_editor( $editor_content, $editor_id, $settings );
                    ?>
                    </div>
                </td>
          </tr>
    </table>
    <?php submit_button(); ?>
</form>