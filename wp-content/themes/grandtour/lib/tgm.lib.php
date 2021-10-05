<?php
require_once get_template_directory() . "/modules/class-tgm-plugin-activation.php";
add_action( 'tgmpa_register', 'grandtour_require_plugins' );
 
function grandtour_require_plugins() {
 
    $plugins = array(
	    array(
	        'name'               => 'Grand Tour Theme Custom Post Type',
	        'slug'      		=> 'grandtour-custom-post',
	        'source'             => 'https://assets.themegoods.com/plugins/grandtour-custom-post/grandtour-custom-post-v2.4.zip',
	        'required'           => true, 
	        'version'            => '2.4',
	    ),
	    array(
	        'name'               => 'One Click Demo Import',
	        'slug'      		 => 'one-click-demo-import',
	        'required'           => true, 
	    ),
	    array(
	        'name'               => 'Revolution Slider',
	        'slug'      		=> 'revslider',
	        'source'             => 'https://assets.themegoods.com/plugins/revslider/revslider-v6.5.7.zip',
	        'required'           => true, 
	        'version'            => '6.5.7',
	    ),
	    array(
	        'name'               => 'Booked',
	        'slug'      		=> 'booked',
	        'source'             => 'https://assets.themegoods.com/plugins/booked/booked-v2.3.5.zip',
	        'required'           => true, 
	        'version'            => '2.3.5',
	    ),
	    array(
	        'name'               => 'Envato Market',
	        'slug'               => 'envato-market',
	        'source'             => get_template_directory() . '/lib/plugins/envato-market.zip',
	        'required'           => true, 
	        'version'            => '2.0.6',
	    ),
	    array(
	        'name'      => 'Meks Easy Photo Feed Widget',
	        'slug'      => 'meks-easy-instagram-widget',
	        'required'  => false, 
	    ),
	    array(
	        'name'      => 'Post Views Counter',
	        'slug'      => 'post-views-counter',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'Categories Images',
	        'slug'      => 'categories-images',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'WP-UserOnline',
	        'slug'      => 'wp-useronline',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'Contact Form 7',
	        'slug'      => 'contact-form-7',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'Contact Form 7 Dynamic Text Extension',
	        'slug'      => 'contact-form-7-dynamic-text-extension',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'MailChimp for WordPress',
	        'slug'      => 'mailchimp-for-wp',
	        'required'  => true, 
	    ),
	    array(
	        'name'      => 'WooCommerce',
	        'slug'      => 'woocommerce',
	        'required'  => true, 
	    ),
	);
	
	//If theme demo site add other plugins
	if(GRANDTOUR_THEMEDEMO)
	{
		$plugins[] = array(
			'name'      => 'Disable Comments',
	        'slug'      => 'disable-comments',
	        'required'  => false, 
		);
		
		$plugins[] = array(
			'name'      => 'Customizer Export/Import',
	        'slug'      => 'customizer-export-import',
	        'required'  => false, 
		);
		
		$plugins[] = array(
			'name'      => 'Display All Image Sizes',
	        'slug'      => 'display-all-image-sizes',
	        'required'  => false, 
		);
		
		$plugins[] = array(
			'name'      => 'Easy Theme and Plugin Upgrades',
	        'slug'      => 'easy-theme-and-plugin-upgrades',
	        'required'  => false, 
		);
		
		$plugins[] = array(
			'name'      => 'Widget Importer & Exporter',
	        'slug'      => 'widget-importer-exporter',
	        'required'  => false, 
		);
		
		$plugins[] = array(
	        'name'      => 'Imsanity',
	        'slug'      => 'imsanity',
	        'required'  => false, 
	    );
		
		$plugins[] = array(
			'name'      => 'Go Live Update URLs',
	        'slug'      => 'go-live-update-urls',
	        'required'  => false, 
		);
		
		$plugins[] = array(
			'name'      => 'Widget Clone',
	        'slug'      => 'widget-clone',
	        'required'  => false, 
		);
	}
	
	$config = array(
		'domain'	=> 'grandtour',
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'install-required-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'          => array(
	        'page_title'                      => esc_html__('Install Required Plugins', 'grandtour' ),
	        'menu_title'                      => esc_html__('Install Plugins', 'grandtour' ),
	        'installing'                      => esc_html__('Installing Plugin: %s', 'grandtour' ),
	        'oops'                            => esc_html__('Something went wrong with the plugin API.', 'grandtour' ),
	        'return'                          => esc_html__('Return to Required Plugins Installer', 'grandtour' ),
	        'plugin_activated'                => esc_html__('Plugin activated successfully.', 'grandtour' ),
	        'complete'                        => esc_html__('All plugins installed and activated successfully. %s', 'grandtour' ),
	        'nag_type'                        => 'update-nag'
	    )
    );
 
    tgmpa( $plugins, $config );
}
?>