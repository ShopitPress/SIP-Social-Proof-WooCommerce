<div class="sip-spwc-content">
  <div style="display: block;"><br>
    <p style="padding:10px 20px"><strong class="strong">Stats available</strong></p>
    <table class="table">
      <tbody>
        <tr>
          <td>Free version</td>
          <td>Add On</td>
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
    <p style="padding:10px 20px"><strong class="strong">Locations</strong></p>
    <table class="table">
      <tbody>
        <tr>
          <td>Free version</td>
          <td>Add On</td>
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
    <p style="padding:10px 20px"><strong class="strong">Variables</strong></p>
    <table class="table">
      <tbody>
        <tr>
          <td>Free version</td>
          <td>Add On</td>
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
    <h2 style="padding:0px;">Example usage</h2>
    <p>This month: <strong>[monthly_sales singular="sale" plural="sales" animation="true"]</strong><br>The last sale was only <strong>[hours]</strong>&nbsp;hours and <strong>[minutes]</strong>&nbsp;minutes ago, hurry!<br><strong>[total_sales singular="sale" plural="sales"]</strong> from <strong>[unique_product_customers singular="customer" plural="customers"]</strong> just like you.</p>
    <p style="text-align: center;">
      <a class="button button-primary" target="_blank" href="<?php echo SIP_SPWC_PLUGIN_PURCHASE_URL; ?>?utm_source=wordpress.org&amp;utm_medium=SIP-panel&amp;utm_content=v<?php echo SIP_SPWC_PLUGIN_VERSION ?>&amp;utm_campaign=sip_social_proof"><span>Get Pro version</span></a>
    </p>
  </div>
</div><!-- .sip-spwc-content -->
<div class="sip-version">
  <?php $get_optio_version = get_option( 'sip_version_value' ); echo "SIP Version " . $get_optio_version; ?>
</div> <!-- .sip-version -->