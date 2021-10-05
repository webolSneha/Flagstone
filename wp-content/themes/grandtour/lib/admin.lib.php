<?php
//grandtour_themegoods_action();

$is_verified_envato_purchase_code = grandtour_is_registered();

//Layout styling
$customizer_styling_arr = array( 
	array('id'	=>	'styling1', 'title' => 'Left Align Menu'),
	array('id'	=>	'styling2', 'title' => 'Center Align Menu'),
	array('id'	=>	'styling3', 'title' => 'Center Logo With 2 Menus'),
	array('id'	=>	'styling4', 'title' => 'Fullscreen Menu'),
	array('id'	=>	'styling5', 'title' => 'Side Menu'),
	array('id'	=>	'styling6', 'title' => 'Frame'),
	array('id'	=>	'styling7', 'title' => 'Boxed'),
	array('id'	=>	'styling8', 'title' => 'With Top Bar'),
	array('id'	=>	'demo2', 	'title' => 'Demo 2'),
);

$customizer_styling_html = '';

//if verified envato purchase code
if($is_verified_envato_purchase_code)
{
	$customizer_styling_html.= '
		<div class="tg_notice">
			<span class="dashicons dashicons-warning"></span>
			Activating demo styling will replace all current theme customizer options.
		</div><br style="clear:both;"/>
		<ul id="get_styling_content" class="demo_list">';
		
	foreach($customizer_styling_arr as $customizer_styling)
	{
		$customizer_styling_html.= '
				<li data-styling="'.$customizer_styling['id'].'">
					<div class="item_content_wrapper">
						<div class="item_content">
					    	<div class="item_thumb"><img src="'.get_template_directory_uri().'/cache/demos/customizer/screenshots/'.$customizer_styling['id'].'.jpg" alt=""/></div>
					    	<div class="item_content">
							    <div class="title"><strong>'.$customizer_styling['title'].'</strong></div>
								<div class="import">
								    <input data-styling="'.$customizer_styling['id'].'" type="button" value="Activate" class="pp_get_styling_button button-primary"/>
								</div>
							</div>
						</div>
					</div>
			    </li>';
	}
	
	$customizer_styling_html.= '</ul>
	<div class="styling_message"><div class="import_message_success"><span class="tg_loading dashicons dashicons-update"></span>Data is being imported please be patient, don\'t navigate away from this page</div></div>';
}
else
{
	$customizer_styling_html.= '
		<div class="tg_notice">
			<span class="dashicons dashicons-warning" style="color:#FF3B30"></span> 
			<span style="color:#FF3B30">'.GRANDTOUR_THEMENAME.' Demos can only be imported with a valid Envato Token</span><br/><br/>
			Please visit <a href="javascript:jQuery(\'#pp_panel_registration_a\').trigger(\'click\');">Product Registration page</a> and enter a valid Envato Token to import the full '.GRANDTOUR_THEMENAME.' demos and single pages through Content Builder.
		</div>';
}

$customizer_styling_color_html = '';

//if verified envato purchase code
if($is_verified_envato_purchase_code)
{
	$customizer_styling_color_arr = array( 
		array('id'	=>	'red', 'title' => 'Red', 'code' => '#FF4A52'),
		array('id'	=>	'orange', 'title' => 'Orange', 'code' => '#FF9500'),
		array('id'	=>	'yellow', 'title' => 'Yellow', 'code' => '#FFCC00'),
		array('id'	=>	'green', 'title' => 'Green', 'code' => '#4CD964'),
		array('id'	=>	'teal_blue', 'title' => 'Teal Blue', 'code' => '#5AC8FA'),
		array('id'	=>	'blue', 'title' => 'Blue', 'code' => '#007AFF'),
		array('id'	=>	'purple', 'title' => 'Purple', 'code' => '#5856D6'),
		array('id'	=>	'pink', 'title' => 'Pink', 'code' => '#FF2D55'),
	);
	
	$customizer_styling_color_html.= '<ul id="get_styling_color_content" class="demo_color_list">';
	
	foreach($customizer_styling_color_arr as $customizer_styling_color)
	{
		$customizer_styling_color_html.= '
			<li data-styling="'.$customizer_styling_color['id'].'">
				<div class="item_content_wrapper">
					<div class="item_content">
				    	<div class="item_thumb" style="background:'.$customizer_styling_color['code'].'"></div>
				    	<div class="item_content">
						    <div class="title"><strong>'.$customizer_styling_color['title'].'</strong></div>
						</div>
					</div>
				</div>
		    </li>';
	}
	
	$customizer_styling_color_html.= '</ul>';
}

//Check if Instagram plugin is installed	
if( !function_exists('is_plugin_active') ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$instagram_widget_settings_notice = '';
$meks_easy_instagram_widget = 'meks-easy-instagram-widget/meks-easy-instagram-widget.php';
$meks_easy_instagram_widget_activated = is_plugin_active($meks_easy_instagram_widget);

if(!$meks_easy_instagram_widget_activated)
{
	$instagram_widget_settings_notice = 'Required plugin "Meks Easy Photo Feed Widget" is required. <a href="'.admin_url("themes.php?page=install-required-plugins").'">Please install the plugin here</a>. or read more detailed instruction about <a href="http://themes.themegoods.com/grandtour/doc/instagram-photostream-issue/" target="_blank">How to setup the plugin here</a>';
}
else
{
	//Verify Instagram API aurthorization
	$instagram_widget_settings = get_option('meks_instagram_settings');
	
	if(empty($instagram_widget_settings))
	{
		$instagram_widget_settings_notice = 'Please authorize with your Instagram account <a href="'.admin_url("options-general.php?page=meks-instagram").'">here</a>';
	}
	else
	{
		$instagram_widget_settings_notice = esc_html__('Authorized', 'grandtour');
	}
}

/*
	Begin creating admin options
*/

$getting_started_html = '<div class="one_half">
		<div class="step_icon">
			<a href="'.admin_url("themes.php?page=install-required-plugins").'">
				<i class="fa fa-plug"></i>
				<div class="step_title">Install Plugins</div>
			</a>
		</div>
		<div class="step_info">
			Theme has required and recommended plugins in order to build your website using layouts you saw on our demo site. We recommend you to install all plugins first.
		</div>
	</div>';

//Check if Grand grandtour plugin is installed	
$grandtour_custom_post = 'grandtour-custom-post/grandtour-custom-post.php';

if( !function_exists('is_plugin_active') ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

$grandtour_custom_post_activated = is_plugin_active($grandtour_custom_post);
if($grandtour_custom_post_activated)
{
	$getting_started_html.= '<div class="one_half last">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=tour").'">
				<i class="fa fa-file-text-o"></i>
				<div class="step_title">Create Tour</div>
			</a>
		</div>
		<div class="step_info">
			'.GRANDTOUR_THEMENAME.' provide advanced tour option. You can create tour information with various of booking option including contact form7, woocommerce.
		</div>
	</div>
	
	<br style="clear:both;"/>
	
	<div class="one_half">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=destination").'">
				<i class="fa fa-globe"></i>
				<div class="step_title">Create Destination</div>
			</a>
		</div>
		<div class="step_info">
			'.GRANDTOUR_THEMENAME.' provide advanced destination option. Destination is using for travel informations about certain places for example London, Paris.
		</div>
	</div>';
}
	
$getting_started_html.='<div class="one_half last">
		<div class="step_icon">
			<a href="'.admin_url("post-new.php?post_type=page").'">
				<i class="fa fa-file-text-o"></i>
				<div class="step_title">Create Page</div>
			</a>
		</div>
		<div class="step_info">
			'.GRANDTOUR_THEMENAME.' support standard WordPress page option. You can also use our live content builder to create and organise page contents.
		</div>
	</div>
	
	<div class="one_half">
		<div class="step_icon">
			<a href="'.admin_url("customize.php").'">
				<i class="fa fa-sliders"></i>
				<div class="step_title">Customize Theme</div>
			</a>
		</div>
		<div class="step_info">
			Start customize theme\'s layouts, typography, elements colors using WordPress customize and see your changes in live preview instantly.
		</div>
	</div>
	
	<div class="one_half last">
		<div class="step_icon">
			<a href="javascript:;" onclick="jQuery(\'#pp_panel_demo-content_a\').trigger(\'click\');">
				<i class="fa fa-database"></i>
				<div class="step_title">Import Demo</div>
			</a>
		</div>
		<div class="step_info">
			Upload demo content from our demo site. We recommend you to install all recommended plugins before importing demo contents.
		</div>
	</div>
	
	<br style="clear:both;"/>
	
	<div style="height:30px"></div>
	
	<h1>Support</h1>
	<div class="getting_started_desc">To access our support portal. You first must find your purchased code. <a href="https://ticksy.com/app/_theme/Ticksy_3.0/frontend/images/purchase_code_screen.png" target="_blank">See how to find it here</a>.</div>
	<div style="height:40px"></div>
	<div class="one_half nomargin">
		<div class="step_icon">
			<a href="https://themegoods.ticksy.com/submit/" target="_blank">
				<i class="fa fa-commenting-o"></i>
				<div class="step_title">Submit a Ticket</div>
			</a>
		</div>
		<div class="step_info">
			We offer excellent support through our ticket system. Please make sure you prepare your purchased code first to access our services.
		</div>
	</div>
	
	<div class="one_half last nomargin">
		<div class="step_icon">
			<a href="http://themes.themegoods.com/grandtour/doc" target="_blank">
				<i class="fa fa-book"></i>
				<div class="step_title">Theme Document</div>
			</a>
		</div>
		<div class="step_info">
			This is the place to go find all reference aspects of theme functionalities. Our online documentation is resource for you to start using theme.
		</div>
	</div>
';


//Get product registration

//if verified envato purchase code
$check_icon = '';
$verification_desc = 'Thank you for choosing '.GRANDTOUR_THEMENAME.'. Your product must be registered to receive many advantage features ex. demos import and support. We are sorry about this extra step but we built the activation system to prevent mass piracy of our themes. This will help us to better serve our paying customers.';

//Check if have any purchase code verification error
$response_html = '';
$purchase_code = '';
$register_button_html = '<input type="submit" name="submit" id="themegoods-envato-code-submit" class="button button-primary button-large" value="Register"/>';

//If already registered
if(!empty($is_verified_envato_purchase_code))
{
	$response_html.= '<br style="clear:both;"/><div class="tg_valid"><span class="dashicons dashicons-yes"></span>Your product is registered.</div>';
	$register_button_html = '<input type="submit" name="submit" id="themegoods-envato-code-unregister" class="button button-primary button-large" value="Unregister"/>';
	$purchase_code = $is_verified_envato_purchase_code;
}

//Displays purchase code verification response
if(isset($_GET['response']) && !empty($_GET['response'])) {
	$response_arr = json_decode(stripcslashes($_GET['response']));
	$purchase_code = '';
	if(isset($_GET['purchase_code']) && !empty($_GET['purchase_code'])) {
		$purchase_code = $_GET['purchase_code'];
	}
	
	if(isset($response_arr->response_code)) {
		if(!$response_arr->response_code) {
			$response_html.= '<br style="clear:both;"/><div class="tg_error"><span class="dashicons dashicons-warning"></span>'.$response_arr->response.'</div>';
		}
	}
	else {
		$response_html.= '<br style="clear:both;"/><div class="tg_error"><span class="dashicons dashicons-warning"></span> We can\'t verify your purchase of '.GRANDTOUR_THEMENAME.' theme. Please make sure you enter correct purchase code. If you are sure you enter correct one. <a href="https://themegoods.ticksy.com" target="_blank">Please open a ticket</a> to us so our support staff can help you. Thank you very much.</div>';
	}
}

$product_registration_html ='
		<h1>Product Registration</h1>
		<div class="getting_started_desc">'.$verification_desc.'</div>
		<br style="clear:both;"/>
		
		<div style="height:10px"></div>
		
		<label for="pp_envato_personal_token">'.$check_icon.'Purchase Code</label>
		<small class="description">Please enter your Purchase Code.</small>';
$product_registration_html.= $register_button_html;

$purchase_code_input_class = '';
if(!empty($is_verified_envato_purchase_code)) {
	$purchase_code_input_class = 'themegoods-verified';
}

$product_registration_html.= '<input name="pp_envato_personal_token" id="pp_envato_personal_token" type="text" value="'.esc_attr($purchase_code).'" class="'.esc_attr($purchase_code_input_class).'"/>
		<input name="themegoods-site-domain" id="themegoods-site-domain" type="hidden" value="'.esc_attr(grandtour_get_site_domain()).'"/>
	';
	
	$product_registration_html.= $response_html;
	
if(isset($_GET['action']) && $_GET['action'] == 'invalid-purchase')
{
	$product_registration_html.='<br style="clear:both;"/><div style="height:20px"></div><div class="tg_error"><span class="dashicons dashicons-warning"></span> We can\'t find your purchase of '.GRANDTOUR_THEMENAME.' theme. Please make sure you enter correct Envato Token. If you are sure you enter correct one. <a href="https://themegoods.ticksy.com" target="_blank">Please open a ticket</a> to us so our support staff can help you. Thank you very much.</div>
	
	<br style="clear:both;"/>
	
	<div style="height:10px"></div>';
}

if(!$is_verified_envato_purchase_code)
{
	$product_registration_html.='
	<br style="clear:both;"/>
	<div style="height:30px"></div>
	<h1>How to get Purchase Code</h1>
	<div style="height:5px"></div>
	<ol>
	 <li>You must be logged into the same Envato account that purchased '.GRANDTOUR_THEMENAME.' theme.</li>
	 <li>Hover the mouse over your username at the top right corner of the screen.</li>
							<li>Click "Downloads" from the drop-down menu.</li>
							<li>Find '.GRANDTOUR_THEMENAME.' theme your downloads list</li>
							<li>Click "Download" button and click "License certificate & purchase code" (available as PDF or text file).</li>
	</ol>
	<strong>You can see detailed article and video screencast about "how to find your purchase code" <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">here</a>.</strong>
';
}

//If already registered and add a link to license manager
if(!empty($is_verified_envato_purchase_code))
{
	$product_registration_html.='<br style="clear:both;"/><div style="height:20px"></div>
	<h1>Manage Your License</h1>
	<div class="getting_started_desc">To manage all your purchase code. Please open an account or login on <a href="https://license.themegoods.com/manager/" target="_blank">ThemeGoods License Manager</a>.
	</div>
	';
}

//Check if Envato Market plugin is installed	
$envato_market_activated = function_exists('envato_market');

if($is_verified_envato_purchase_code && !$envato_market_activated)
{
	$product_registration_html.='<br style="clear:both;"/><div style="height:40px"></div>
	<h1>Auto Update</h1>
	<div class="getting_started_desc">To enable auto update feature. You first must <a href="'.admin_url('themes.php?page=install-required-plugins').'">install Envato Market plugin</a> and enter your purchase code there. <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">Find your purchase code</a></div>
	<br style="clear:both;"/>
	
	<div style="height:10px"></div>
	';
}

//Get system info
$has_red_status = false;

//Get memory_limit
$memory_limit = ini_get('memory_limit');
$memory_limit_class = 'tg_valid';
$memory_limit_text = '';
if(intval($memory_limit) < 128)
{
    $memory_limit_class = 'tg_error';
    $has_error = 1;
    $memory_limit_text = '*RECOMMENDED 128M';
    
    $has_red_status = true;
}

$memory_limit_text = '<div class="'.$memory_limit_class.'">'.$memory_limit.' '.$memory_limit_text.'</div>';

//Get post_max_size
$post_max_size = ini_get('post_max_size');
$post_max_size_class = 'tg_valid';
$post_max_size_text = '';
if(intval($post_max_size) < 32)
{
    $post_max_size_class = 'tg_error';
    $has_error = 1;
    $post_max_size_text = '*RECOMMENDED 32M';
    
    $has_red_status = true;
}
$post_max_size_text = '<div class="'.$post_max_size_class.'">'.$post_max_size.' '.$post_max_size_text.'</div>';

//Get max_execution_time
$max_execution_time = ini_get('max_execution_time');
$max_execution_time_class = 'tg_valid';
$max_execution_time_text = '';
if($max_execution_time < 180)
{
    $max_execution_time_class = 'tg_error';
    $has_error = 1;
    $max_execution_time_text = '*RECOMMENDED 180';
    
    $has_red_status = true;
}
$max_execution_time_text = '<div class="'.$max_execution_time_class.'">'.$max_execution_time.' '.$max_execution_time_text.'</div>';

//Get max_input_vars
$max_input_vars = ini_get('max_input_vars');
$max_input_vars_class = 'tg_valid';
$max_input_vars_text = '';
if(intval($max_input_vars) < 2000)
{
    $max_input_vars_class = 'tg_error';
    $has_error = 1;
    $max_input_vars_text = '*RECOMMENDED 2000';
    
    $has_red_status = true;
}
$max_input_vars_text = '<div class="'.$max_input_vars_class.'">'.$max_input_vars.' '.$max_input_vars_text.'</div>';

//Get upload_max_filesize
$upload_max_filesize = ini_get('upload_max_filesize');
$upload_max_filesize_class = 'tg_valid';
$upload_max_filesize_text = '';
if(intval($upload_max_filesize) < 32)
{
    $upload_max_filesize_class = 'tg_error';
    $has_error = 1;
    $upload_max_filesize_text = '*RECOMMENDED 32M';
    
    $has_red_status = true;
}
$upload_max_filesize_text = '<div class="'.$upload_max_filesize_class.'">'.$upload_max_filesize.' '.$upload_max_filesize_text.'</div>';

//Get GD library version
$php_gd_arr = gd_info();

$system_info_html = '';
if(!$is_verified_envato_purchase_code)
{
	$system_info_html = '<div style="height:20px"></div>
	<div class="tg_notice">
					<span class="dashicons dashicons-warning" style="color:#FF3B30"></span> 
					<span style="color:#FF3B30">'.GRANDTOUR_THEMENAME.' Demos can only be imported with a valid Envato Token</span><br/><br/>
					Please visit <a href="javascript:jQuery(\'#pp_panel_registration_a\').trigger(\'click\');">Product Registration page</a> and enter a valid Envato Token to import the full '.GRANDTOUR_THEMENAME.' demos and single pages through Elementor.
				</div>
		
		<div style="height:40px"></div>
		';
}
else
{
	$system_info_html = '<table class="widefat" cellspacing="0">
			<thead>
				<tr>
					<th colspan="3">Server Environment</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="title">PHP Version:</td>
					<td class="help"><a href="javascript" title="The version of PHP installed on your hosting server." class="tooltipster">[?]</a></td>
					<td class="value">'.phpversion().'</td>
				</tr>
				<tr>
					<td class="title">WP Memory Limit:</td>
					<td class="help"><a href="javascript" title="The maximum amount of memory (RAM) that your site can use at one time." class="tooltipster">[?]</a></td>
					<td class="value">'.$memory_limit_text.'</td>
				</tr>
				<tr>
					<td class="title">PHP Post Max Size:</td>
					<td class="help"><a href="javascript" title="The largest file size that can be contained in one post." class="tooltipster">[?]</a></td>
					<td class="value">'.$post_max_size_text.'</td>
				</tr>
				<tr>
					<td class="title">PHP Time Limit:</td>
					<td class="help"><a href="javascript" title="The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)" class="tooltipster">[?]</a></td>
					<td class="value">'.$max_execution_time_text.'</td>
				</tr>
				<tr>
					<td class="title">PHP Max Input Vars:</td>
					<td class="help"><a href="javascript" title="The maximum number of variables your server can use for a single function to avoid overloads." class="tooltipster">[?]</a></td>
					<td class="value">'.$max_input_vars_text.'</td>
				</tr>
				<tr>
					<td class="title">Max Upload Size:</td>
					<td class="help"><a href="javascript" title="The largest filesize that can be uploaded to your WordPress installation." class="tooltipster">[?]</a></td>
					<td class="value">'.$upload_max_filesize_text.'</td>
				</tr>
				<tr>
					<td class="title">GD Library:</td>
					<td class="help"><a href="javascript" title="This library help resizing images and improve site loading speed" class="tooltipster">[?]</a></td>
					<td class="value">'.$php_gd_arr['GD Version'].'</td>
				</tr>
			</tbody>
		</table>
		
		<div style="height:20px"></div>';
		
		//Check if required plugins is installed
		$grandtour_custom_post_activated = function_exists('grandtour_load_textdomain');
		$revslider_activated = class_exists('RevSlider');
		$ocdi_activated = class_exists('OCDI_Plugin');
		
		if($grandtour_custom_post_activated && $ocdi_activated && $revslider_activated)
		{
			if($has_red_status)
			{
				$system_info_html.= '<div style="height:20px"></div>
			<div class="tg_notice">
				<span class="dashicons dashicons-warning" style="color:#FF3B30"></span> 
				<span>There are some settings which are below theme recommendation values and it might causes issue importing demo contents.</span>
			</div>';
			
				$import_demo_button_label = 'I understand and want to process demo importing process';
			}
			else
			{
				$import_demo_button_label = 'Begin importing demo process';
			}
			
			$system_info_html.= '<div class="tg_begin_import"><a href="'.admin_url('themes.php?page=tg-one-click-demo-import').'" class="button button-primary button-large">'.$import_demo_button_label.'</a></div>';
		}
		else
		{
			$system_info_html.= '<div style="height:20px"></div>
			<div class="tg_notice">
				<span class="dashicons dashicons-warning" style="color:#FF3B30"></span> 
				<span style="color:#FF3B30">One Click Demo Import, Revolution Slider and '.GRANDTOUR_THEMENAME.' Custom Post Type plugins required</span><br/><br/>
				Please <a href="'.admin_url("themes.php?page=install-required-plugins").'">install and activate these required plugins.</a> first so demo contents can be imported properly.
			</div>';
		}
}

$api_url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

$grandtour_options = grandtour_get_options();

$grandtour_options = array (
 
//Begin admin header
array( 
		"name" => GRANDTOUR_THEMENAME." Options",
		"type" => "title"
),
//End admin header


//Begin second tab "Home"
array( 	"name" => "Home",
		"type" => "section",
		"icon" => "dashicons-admin-home",
),
array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => GRANDTOUR_SHORTNAME."_home",
	"type" => "html",
	"html" => '
	<h1>Getting Started</h1>
	<div class="getting_started_desc">Welcome to '.GRANDTOUR_THEMENAME.' theme. '.GRANDTOUR_THEMENAME.' is now installed and ready to use! Read below for additional informations. We hope you enjoy using the theme!</div>
	<div style="height:40px"></div>
	'.$getting_started_html.'
	',
),

array( "type" => "close"),
//End second tab "Home"


//Begin second tab "Registration"
array( 	"name" => "Registration",
		"type" => "section",
		"icon" => "dashicons-admin-network",	
),
array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => GRANDTOUR_SHORTNAME."_registration",
	"type" => "html",
	"html" => $product_registration_html,
),

array( "type" => "close"),
//End second tab "Registration"


//Begin second tab "General"
array( 	"name" => "General",
		"type" => "section",
		"icon" => "dashicons-admin-generic",		
),
array( "type" => "open"),

array( "name" => "<h2>Google Maps Setting</h2>API Key",
	"desc" => "Enter Google Maps API Key <a href=\"https://themegoods.ticksy.com/article/7785/\" target=\"_blank\">How to get API Key</a>",
	"id" => GRANDTOUR_SHORTNAME."_googlemap_api_key",
	"type" => "text",
	"std" => ""
),

array( "name" => "Custom Google Maps Style",
	"desc" => "Enter javascript style array of map. You can get sample one from <a href=\"https://snazzymaps.com\" target=\"_blank\">Snazzy Maps</a>",
	"id" => GRANDTOUR_SHORTNAME."_googlemap_style",
	"type" => "textarea",
	"std" => ""
),

array( "name" => "<h2>Custom Sidebar Settings</h2>Add a new sidebar",
	"desc" => "Enter sidebar name",
	"id" => GRANDTOUR_SHORTNAME."_sidebar0",
	"type" => "text",
	"validation" => "text",
	"std" => "",
),

array( "name" => "<h2>Custom Permalink Settings</h2>Gallery Page Slug",
	"desc" => "Enter custom permalink slug for gallery page",
	"id" => GRANDTOUR_SHORTNAME."_permalink_galleries",
	"type" => "text",
	"std" => "galleries"
),

array( "name" => "Gallery Category Page Slug",
	"desc" => "Enter custom permalink slug for gallery category page",
	"id" => GRANDTOUR_SHORTNAME."_permalink_gallerycat",
	"type" => "text",
	"std" => "gallerycat"
),

array( "name" => "Tour Page Slug",
	"desc" => "Enter custom permalink slug for tour page",
	"id" => GRANDTOUR_SHORTNAME."_permalink_tour",
	"type" => "text",
	"std" => "tour"
),

array( "name" => "Tour Category Page Slug",
	"desc" => "Enter custom permalink slug for tour category page",
	"id" => GRANDTOUR_SHORTNAME."_permalink_tourcat",
	"type" => "text",
	"std" => "tourcat"
),

array( "name" => "Destination Page Slug",
	"desc" => "Enter custom permalink slug for destination page",
	"id" => GRANDTOUR_SHORTNAME."_permalink_destination",
	"type" => "text",
	"std" => "destination"
),

array( "name" => "Destination Category Page Slug",
	"desc" => "Enter custom permalink slug for destination category page",
	"id" => GRANDTOUR_SHORTNAME."_permalink_destinationcat",
	"type" => "text",
	"std" => "destinationcat"
),

array( "type" => "close"),
//End second tab "General"


//Begin second tab "Styling"
array( "name" => "Styling",
	"type" => "section",
	"icon" => "dashicons-art",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => GRANDTOUR_SHORTNAME."_get_styling_button",
	"type" => "html",
	"html" => $customizer_styling_html,
),

array( "name" => "",
	"desc" => "",
	"id" => GRANDTOUR_SHORTNAME."_get_styling_color_button",
	"type" => "html",
	"html" => $customizer_styling_color_html,
),
 
array( "type" => "close"),


//Begin fifth tab "Social Profiles"
array( 	"name" => "Social-Profiles",
		"type" => "section",
		"icon" => "dashicons-facebook",
),
array( "type" => "open"),

array( "name" => "<h2>Facebook Settings</h2>Facebook OpenGraph Tags",
	"desc" => "Please disable this option if you want to use 3rd party plugin for Facebook OpenGraph Meta Tags",
	"id" => GRANDTOUR_SHORTNAME."_opengraph_tags",
	"type" => "iphone_checkboxes",
	"std" => 1,
),
	
array( "name" => "<h2>Accounts Settings</h2>Facebook page URL",
	"desc" => "Enter full Facebook page URL",
	"id" => GRANDTOUR_SHORTNAME."_facebook_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Twitter Username",
	"desc" => "Enter Twitter username",
	"id" => GRANDTOUR_SHORTNAME."_twitter_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Google Plus URL",
	"desc" => "Enter Google Plus URL",
	"id" => GRANDTOUR_SHORTNAME."_google_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Flickr Username",
	"desc" => "Enter Flickr username",
	"id" => GRANDTOUR_SHORTNAME."_flickr_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Youtube Profile URL",
	"desc" => "Enter Youtube Profile URL",
	"id" => GRANDTOUR_SHORTNAME."_youtube_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Vimeo Username",
	"desc" => "Enter Vimeo username",
	"id" => GRANDTOUR_SHORTNAME."_vimeo_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Tumblr Username",
	"desc" => "Enter Tumblr username",
	"id" => GRANDTOUR_SHORTNAME."_tumblr_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Dribbble Username",
	"desc" => "Enter Dribbble username",
	"id" => GRANDTOUR_SHORTNAME."_dribbble_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Linkedin URL",
	"desc" => "Enter full Linkedin URL",
	"id" => GRANDTOUR_SHORTNAME."_linkedin_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Pinterest Username",
	"desc" => "Enter Pinterest username",
	"id" => GRANDTOUR_SHORTNAME."_pinterest_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Instagram Username",
	"desc" => "Enter Instagram username",
	"id" => GRANDTOUR_SHORTNAME."_instagram_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Behance Username",
	"desc" => "Enter Behance username",
	"id" => GRANDTOUR_SHORTNAME."_behance_username",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "500px Profile URL",
	"desc" => "Enter 500px Profile URL",
	"id" => GRANDTOUR_SHORTNAME."_500px_url",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "name" => "Tripadvisor URL",
	"desc" => "Enter full Tripadvisor URL",
	"id" => GRANDTOUR_SHORTNAME."_tripadvisor_url",
	"type" => "text",
	"std" => ""
),
array( "name" => "Yelp URL",
	"desc" => "Enter full Yelp URL",
	"id" => GRANDTOUR_SHORTNAME."_yelp_url",
	"type" => "text",
	"std" => ""
),
array( "name" => "<h2>Photo Stream</h2>Photostream Source",
	"desc" => "Select photo stream photo source. It displays before footer area",
	"id" => GRANDTOUR_SHORTNAME."_photostream",
	"type" => "select",
	"options" => array(
		'' => 'Disable Photo Stream',
		'instagram' => 'Instagram',
		'flickr' => 'Flickr',
	),
	"std" => ''
),
/*array( "name" => "Instagram Access Token",
	"desc" => "Enter Instagram Access Token. <a href=\"https://instagram.com/oauth/authorize/?client_id=3a81a9fa2a064751b8c31385b91cc25c&scope=basic+public_content&redirect_uri=https://smashballoon.com/instagram-feed/instagram-token-plugin/?return_uri=".admin_url("themes.php?page=functions.php")."&response_type=token\" >Find you Access Token here</a>",
	"id" => GRANDTOUR_SHORTNAME."_instagram_access_token",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),*/
array( "name" => "Connect with your Instagram account",
	"desc" => "",
	"id" => GRANDTOUR_SHORTNAME."_instagram_account_notice",
	"type" => "html",
	"html" => "<div class='html_inline_wrapper'>".$instagram_widget_settings_notice."</div>",
),
array( "name" => "Flickr ID",
	"desc" => "Enter Flickr ID. <a href=\"http://idgettr.com/\" target=\"_blank\">Find your Flickr ID here</a>",
	"id" => GRANDTOUR_SHORTNAME."_flickr_id",
	"type" => "text",
	"std" => "",
	"validation" => "text",
),
array( "type" => "close"),

//End fifth tab "Social Profiles"


//Begin second tab "Script"
array( "name" => "Script",
	"type" => "section",
	"icon" => "dashicons-format-aside",
),

array( "type" => "open"),

array( "name" => "<h2>CSS Settings</h2>Custom CSS for desktop",
	"desc" => "You can add your custom CSS here",
	"id" => GRANDTOUR_SHORTNAME."_custom_css",
	"type" => "css",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for<br/>iPad Portrait View",
	"desc" => "You can add your custom CSS here",
	"id" => GRANDTOUR_SHORTNAME."_custom_css_tablet_portrait",
	"type" => "css",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for<br/>iPhone Landscape View",
	"desc" => "You can add your custom CSS here",
	"id" => GRANDTOUR_SHORTNAME."_custom_css_mobile_landscape",
	"type" => "css",
	"std" => "",
	'validation' => '',
),

array( "name" => "Custom CSS for<br/>iPhone Portrait View",
	"desc" => "You can add your custom CSS here",
	"id" => GRANDTOUR_SHORTNAME."_custom_css_mobile_portrait",
	"type" => "css",
	"std" => "",
	'validation' => '',
),
 
array( "type" => "close"),

//Begin second tab "Demo"
array( "name" => "Demo-Content",
	"type" => "section",
	"icon" => "dashicons-download",
),

array( "type" => "open"),

array( "name" => "",
	"desc" => "",
	"id" => GRANDTOUR_THEMENAME."_import_demo_notice",
	"type" => "html",
	"html" => '<h1>Checklist before Importing Demo</h1><br/><strong>IMPORTANT</strong>: Demo importer can vary in time. The included required plugins need to be installed and activated before you import demo. Please check the Server Environment below to ensure your server meets all requirements for a successful import. <strong>Settings that need attention will be listed in red</strong>.
	',
),
array( "name" => "",
	"desc" => "",
	"id" => GRANDTOUR_THEMENAME."_import_demo_content",
	"type" => "html",
	"html" => $system_info_html,
),
 
array( "type" => "close"),

array( 	"name" => "Buy-Another-License",
"type" => "section",
"icon" => "",		
),
array( "type" => "open"),

array( "type" => "close"),

);
 
$grandtour_options[] = array( "type" => "close");

grandtour_set_options($grandtour_options);
?>