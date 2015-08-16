<div class="sip-spwc-content">
    <div style="display: block;">
        <h2 style="padding:0px;">Example usage</h2>
        <p>Sales since launch: <strong>[total_sales]</strong><br>This product has been bough <strong>[total_sales singular="time" plural="times"]</strong>.<br>Sold: <strong>[total_sales singular="unit" plural="units"]</strong>. Hurry up, limited stock left!</p>

<?php if( class_exists( 'SIP_Social_Proof_WC_Pro' ) ) { ?>
        <p>This month: <strong>[monthly_sales singular="sale" plural="sales" animation="true"]</strong><br>The last sale was only <strong>[hours]</strong>&nbsp;hours and <strong>[minutes]</strong>&nbsp;minutes ago, hurry!<br><strong>[total_sales singular="sale" plural="sales"]</strong> from <strong>[unique_product_customers singular="customer" plural="customers"]</strong> just like you.</p>
<?php } ?>

        <h2 style="padding:0px;">Questions and support</h2>
        <p>All of our plugins come with free support. We care about your plugin after purchase just as much as you do.</p>
        <p>We want to make your life easier and make you happy about choosing our plugins. We guarantee to respond to every inquiry within 1 business day.
        Please visit our <a href="<?php echo SIP_SPWC_PLUGIN_PURCHASE_URL; ?>?utm_source=wordpress.org&amp;utm_medium=SIP-panel&amp;utm_content=v<?php echo SIP_SPWC_PLUGIN_VERSION ?>&amp;utm_campaign=sip_social_proof" target="_blank">community</a> and ask us anything you need.</p>
    </div>
</div><!-- .wrap -->
<div class="sip-version">
  <?php $get_optio_version = get_option( 'sip_version_value' ); echo "SIP Version " . $get_optio_version; ?>
</div> <!-- .sip-version -->
