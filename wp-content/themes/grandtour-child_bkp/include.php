<?php

function ppb_tour_search_func_custom($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'size' => 'one',
		'slug' => '',
		'url' => '',
		'custom_css' => '',
		'margin_top' => 0,
		'margin_right' => 0,
		'margin_bottom' => 0,
		'margin_left' => 0,
		'builder_id' => '',
	), $atts));
	
	$sec_id = '';
	if(!empty($slug))
	{
		$sec_id = 'id="'.esc_attr($slug).'"';
	}

	$return_html = '';

	//Set main shortcode div content
	$return_html.= '<div '.$sec_id.' class="'.esc_attr($size).' withsmallpadding ppb_tour_search"';
	
	if(!empty($margin_top))
	{
		$custom_css.= 'margin-top:'.esc_attr($margin_top).'px;';
	}
	if(!empty($margin_right))
	{
		$custom_css.= 'margin-right:'.esc_attr($margin_right).'px;';
	}
	if(!empty($margin_bottom))
	{
		$custom_css.= 'margin-bottom:'.esc_attr($margin_bottom).'px;';
	}
	if(!empty($margin_left))
	{
		$custom_css.= 'margin-left:'.esc_attr($margin_left).'px;';
	}
	
	if(!empty($custom_css))
	{
		$return_html.= ' style="'.esc_attr(rawurldecode($custom_css)).'" ';
	}
	
	$return_html.= '>';
	
	//Set begin wrapper div for live builder
	$return_html.= grandtour_live_builder_begin_wrapper($builder_id);
	
	$return_html.= '<div class="standard_wrapper">';
	$return_html.= '<div class="page_content_wrapper"><div class="inner">';
	
	wp_enqueue_script("script-ajax-search", admin_url('admin-ajax.php')."?action=grandtour_ajax_search&id=keyword&form=tour_search_form&result=autocomplete", false, GRANDTOUR_THEMEVERSION, true);
	
	$url=site_url().'/search/';
	//echo "TEST URL=".esc_url($url);
	
	$return_html.= '<form id="tour_search_form" class="tour_search_form" method="get" action="'.esc_url($url).'">';
    $return_html.= '<div class="tour_search_wrapper">
    	<div class="one_fourth themeborder">
    	<input type="hidden" name="holiday" id="holiday1" value="">
        <input type="hidden" name="ski_country" id="ski_country1" value="">
    	<input type="hidden" name="country" id="country1" value="">
    	<select id="holiday_type" multiple="multiple" include>';
			$args = array(  
		       'post_type' => 'holiday_type',
		       'post_status' => 'publish',
		       'posts_per_page' => -1,
		       'post_parent'=>0,
		       'orderby' => 'title',
		       'order' => 'ASC',
		   );
		   $loop = new WP_Query( $args );		     
		   while ( $loop->have_posts() ) : $loop->the_post();
			
		       $return_html.= '<option value="'.get_the_ID() .'" >'. get_the_title() .'</option>';
		    
		   endwhile;
		   wp_reset_postdata();
    $return_html.= '</select></div>';
    	
    $return_html.= '<div class="one_fourth themeborder">';
	
	//Get available destination
    $return_html.= '<select id="destination" name="dest">
	    		<option value="">'.esc_html__('Holiday Area', 'grandtour-custom-post' ).'</option>';
    	$args = array(
	       'post_type' => 'destination',
	       'post_status' => 'publish',
	       'posts_per_page' => -1,
	       'orderby' => 'title',
	       'order' => 'ASC',
	    );
	   $loop = new WP_Query( $args );
	   $country_html = $country_ski = $resorts_html = '';
	  while ( $loop->have_posts() ) : $loop->the_post();
	   		if( get_post_meta( get_the_ID(), 'ski_condition', true ) ){
		   			$country_ski .= '<option value="'.get_the_ID().'" >'. get_the_title() .'</option>';
		   	}else if( wp_get_post_parent_id() == 0 ){
	   			$return_html .= '<option value="'.get_the_ID() .'" >'. get_the_title() .'</option>';	
	   		}else{
	   			
	   			// if( get_post_meta( get_the_ID(), 'ski_condition', true ) ){
		   		// 	$country_ski .= '<option value="'.get_the_ID().'" >'. get_the_title() .'</option>';
		   		// }else{

		   			$country_html .= '<option value="'.get_the_ID().'" style="display:none;" class="destination-id-'. wp_get_post_parent_id() .'" >'. get_the_title() .'</option>';

		   			$resorts_html .= '<option value="'.get_the_ID().'" style="display:none;" class="destination-id-'. wp_get_post_parent_id() .'" >'. get_the_title() .'</option>';
		   		//}
	   		}
	   endwhile;
	   wp_reset_postdata();	
    $return_html.= '</select>';

    //country for Ski
    //$return_html.= '<select id="ski_country" name="ski_country[]" style="display: none;" multiple="multiple">';
    $return_html.= '<select id="ski_country" style="display: none;" multiple="multiple">';
    //$return_html.= '<option value="">'.esc_html__('Country', 'grandtour-custom-post' ).'</option>';
    $return_html.= $country_ski;
    $return_html.= '</select>';

    $return_html.= '</div>
    	<div class="one_fourth themeborder">';

	//Get available country
    $return_html.= '<select id="country" multiple="multiple">';
    $return_html.= '<option value="">'.esc_html__('Country', 'grandtour-custom-post' ).'</option>';
    $return_html.= $country_html;
    $return_html.= '</select>';

	//resorts for Ski
    $return_html.= '<select id="resorts" multiple="multiple" name="resorts[]" style="display: none;">';
    //$return_html.= '<option value="">'.esc_html__('Resorts', 'grandtour-custom-post' ).'</option>';
    $return_html.= $resorts_html;
    $return_html.= '</select>';


    $return_html.= '</div>
    	<div class="one_fourth last themeborder">
    		<input id="tour_search_btn" type="submit" class="button" value="'.esc_html__( 'Search', 'grandtour-custom-post' ).'"/>
    	</div>';
    	
    //Check if enable advanced search
	/*$tg_tour_advanced_search = kirki_get_option('tg_tour_advanced_search');
	
	if(!empty($tg_tour_advanced_search))
	{
	    //Display advanced search fields
	    $return_html.= '<br class="clear"/><div id="tour_advance_search_wrapp" style="display:none;" class="tour_advance_search_wrapp">
	    <div class="one_fourth themeborder">';

	    $return_html.= '<input type="date" name="daterange" id="ski_date" value="'. date( 'Y-m-d' ) .'" >';

	    $return_html.= '</div><div class="one_fourth themeborder">';

	    $return_html.= '<select id="facilities" name="facilities[]" multiple="multiple">';
			$tour_cats_arr = get_terms('facilities', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');	    
			if(!empty($tour_cats_arr)){
				foreach($tour_cats_arr as $key => $tour_cat){
					$return_html.= '<option value="'.esc_attr($tour_cat->term_id).'">'.esc_attr($tour_cat->name).'</option>';
				}
			}
	    $return_html.= '</select>';

	  //   $return_html.= '</div><div class="one_fourth themeborder">';
	  //   $return_html.= '<select id="accommodation_type" name="accommodation_type[]" multiple="multiple">';
			// $tour_cats_arr = get_terms('accommodation_type', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');   
			// if(!empty($tour_cats_arr)){
			// 	foreach($tour_cats_arr as $key => $tour_cat){
			// 		$return_html.= '<option value="'.esc_attr($tour_cat->term_id).'">'.esc_attr($tour_cat->name).'</option>';
			// 	}
			// }
	  //   $return_html.= '</select>';

	  //   $return_html.= '</div><div class="one_fourth themeborder" style="margin-right: 0;" >';
		 //    $return_html.= '<select id="capacity_of_property" name="capacity_of_property[]" multiple="multiple">';
		 //    $return_html.= '<option value="2">2</option>
			// 				<option value="4">4</option>
			// 				<option value="6">6</option>
			// 				<option value="8">8</option>
			// 				<option value="10">10</option>
			// 				<option value="12">12</option>
			// 				<option value="14">14</option>
			// 				<option value="16">16</option>
			// 				<option value="20">20</option>
			// 				<option value="more">More</option>';
			// $return_html.= '</select>';
	    $return_html.= '</div>';
	    
	    $return_html.= '</div>';	    
	    $return_html.= '</div>';	    	
	    //$return_html.= '<div class="tour_advance_search_wrapper_link">';	    
	    //$return_html.= '<a id="tour_advance_search_toggle" href="javascript:;" class="theme_link_color"><span class="icon ti-angle-down"></span>'.esc_html__( 'Advanced Search', 'grandtour-custom-post' ).'</a>';
	    //$return_html.= '</div>';
	}*/
    	
    $return_html.='
    </div>
</form>';

	$return_html.= '</div></div></div>';
	
	//Set end wrapper div for live builder
	$return_html.= grandtour_live_builder_end_wrapper($builder_id);
	
	$return_html.= '</div>';

	return $return_html;

}

add_shortcode('ppb_tour_search', 'ppb_tour_search_func_custom');

add_action('wp_enqueue_scripts', function(){
	wp_enqueue_style( 'multiple-select-css', get_stylesheet_directory_uri() . '/css/multiple-select.css' );
	wp_enqueue_script( 'multiple-select-js', get_stylesheet_directory_uri() . '/js/multiple-select.js', array( 'jquery' ), '1.0', true );
});


add_action( "wp_footer", function(){ ?>
 <script type="text/javascript">
 	jQuery(document).ready(function($){
		/*$("#holiday_type").attr("multiple","multiple");
		//$("#country").attr("multiple","multiple");
		$("#resorts").attr("multiple","multiple");
		setTimeout(function(){ 
			$("#country").attr("multiple","multiple");
		}, 3000);*/
		/*$(document).on("change","#resorts",function(){
			setTimeout(function(){
			$("#country + .ms-parent").css('display','none');
				}, 3300);
		});*/
 		$(document).on("change","#destination",function(){
 			let val = $(this).val();
				$("#country + .ms-parent .ms-drop ul li").css('display','none');
				$("#country + .ms-parent .ms-drop ul li.destination-id-"+ val).css('display','block');
				$("#country + .ms-parent .ms-drop ul li:first").css('display','block');
				$("#country + .ms-parent .ms-drop ul li:nth-child(2)").removeClass('selected');
				$("#country + .ms-parent .ms-drop ul li:nth-child(2)").removeAttr('checked');
				if(val==""){
				//alert("BLANk");
				//$('#country').multipleSelect('destroy');
				//$('#country').removeAttr('multiple','multiple');
				$("#country + .ms-parent .ms-drop ul li:first").css('display','none');
				}
				$("#country option").hide();
				$("#country option.destination-id-"+ val ).show();
				$('#country option[value=""]').show();
				$('#country option[value=""]').attr('selected', 'selected');
 		});
		$(document).on("change","#country",function(){
			let cval=$(this).val();
			//alert(cval);
			$('#country1').val(cval);
		});
 		$(document).on("change","#ski_country",function(){
 			//let val = $(this).val();
 			$("#resorts + .ms-parent .ms-drop li").hide();
			$('#ski_country :selected').each(function(){
			    let val = $(this).val();
			    $("#resorts + .ms-parent .ms-drop li.destination-id-"+ val ).show();
			});
 			
 			//$("#resorts + .ms-parent .ms-drop li").hide();
 			//$("#resorts + .ms-parent .ms-drop li.destination-id-"+ val ).show();
 			
 			//$('#resorts + .ms-parent .ms-drop li.ms-select-all').show();
 			//$('#resorts option[value=""]').attr('selected', 'selected');
 		});
 		

 		$(document).on('change',"#ski_country", function(){
 			var val = $(this).val();
                        //console.log(val);
                       $('#ski_country1').val(val);        
                 });

 		$(document).on('change',"#holiday_type", function(){
 			let val = $(this).val();
 			
 			$('#holiday1').val(val);        
				
			if(val!==null && val.length!== 0){// having data
				//if(val !==null && val.length===1){
					//alert("one slected")
					if( $.inArray("5185",val) !== -1){								
						$("input[type=checkbox][value=5185]").prop("disabled",false);
						$("input[type=checkbox]:not([value=5185])").prop("disabled",true);
						//for country
						$("input[type=checkbox][data-name=selectItemski_country]").prop("disabled",false);
						$("input[type=checkbox][data-name=selectAllski_country]").prop("disabled",false);								
						// for resorts
						$("input[type=checkbox][data-name=selectItemresorts]").prop("disabled",false);
						$("input[type=checkbox][data-name=selectAllresorts]").prop("disabled",false);
						$('.ms-parent button').removeClass('disabled');					
						//alert("5185 selected");
					}else{
						//alert("5185 not selected");
						$("input[type=checkbox][value=5185]").prop("disabled",true);
						$("input[type=checkbox]:not([value=5185])").prop("disabled",false);
					}
					
				//}
			  }else{						
				  $("input[type=checkbox]").prop("disabled",false);
			  }

 			if( val == 5185 ){
 				$("#tour_advance_search_wrapp").show();
 				$("#ski_country, #resorts").siblings(".ms-parent ").show();
 				$("#ski_country + .ms-parent .ms-drop ul li input[type=checkbox]").prop("disabled",false);
 				$("#resorts + .ms-parent .ms-drop ul li input[type=checkbox]").prop("disabled",false);
 				$("#ski_country, #resorts, #ski_date, #facilities, #accommodation_type, #capacity_of_property").prop('disabled', false);
 				$("#destination,#country").hide();
 				$("#country + .ms-parent").css('display','none');
 				$("#destination, #country").prop('disabled', true);
 			}else{
 				$("#ski_country, #resorts").siblings(".ms-parent ").hide();
 				$("#tour_advance_search_wrapp").hide();
 				$("#ski_country, #resorts, #ski_date, #facilities, #accommodation_type, #capacity_of_property").prop('disabled', true);
 				$("#destination").show();
 				$("#country + .ms-parent").css('display','block');
 				$("#destination, #country").prop('disabled', false);
 			}
 		});

 		$("body.single.single-holiday_type .wpb_single_image.wpb_content_element").each(function( index ) {
 			var that = $(this);
 			var title = that.find("h2.wpb_heading.wpb_singleimage_heading").html()
 			that.find("h2.wpb_heading.wpb_singleimage_heading").remove();
 			that.find("a.vc_single_image-wrapper").append( '<h2 class="wpb_heading wpb_singleimage_heading">'+ title + '</h2>' );
 		});
 		$("body.page.page-destinations .wpb_single_image.wpb_content_element").each(function( index ) {
 			var that = $(this);
 			var title = that.find("h2.wpb_heading.wpb_singleimage_heading").html()
 			that.find("h2.wpb_heading.wpb_singleimage_heading").remove();
 			that.find("a.vc_single_image-wrapper").append( '<h2 class="wpb_heading wpb_singleimage_heading">'+ title + '</h2>' );
 		});
 		$("body.home .wpb_single_image.wpb_content_element").each(function( index ) {
 			var that = $(this);
 			var title = that.find("h2.wpb_heading.wpb_singleimage_heading").html()
 			that.find("h2.wpb_heading.wpb_singleimage_heading").remove();
 			that.find("a.vc_single_image-wrapper").append( '<h2 class="wpb_heading wpb_singleimage_heading">'+ title + '</h2>' );
 		});
 		
 		$('#holiday_type').multipleSelect({
 			selectAllDelimiter : [],
 			selectAll: false,
 			//selectAllText : "Select ALL",
 			placeholder : "Holiday Type",
                        width: '100%'
        });
		setTimeout(function(){
		 $('#country').multipleSelect({
 			selectAllDelimiter : [],
 			//selectAll: false,
 			selectAllText : "Select ALL",
 			placeholder : "Country",
                        width: '100%',
			}); 
			//$("#country + .ms-parent .ms-drop ul li").css('display','none');
			jQuery("#destination").trigger('change')
		}, 3000);
		
 		$('#ski_country').multipleSelect({
 			selectAllDelimiter : [],
 			selectAllText : "Select ALL",
 			placeholder : "Country",
            width: '100%'
        });

        $('#resorts').multipleSelect({
 			selectAllDelimiter : [],
 			selectAllText : "Select ALL",
 			placeholder : "Resorts",
            width: '100%'
        });

 		$('#facilities').multipleSelect({
 			selectAllDelimiter : [],
 			selectAllText : "Select ALL",
 			placeholder : "Facilities",
            width: '100%'
        });

        $('#accommodation_type').multipleSelect({
 			selectAllDelimiter : [],
 			selectAllText : "Select ALL",
 			placeholder : "Accommodation Type",
            width: '100%'
        });

        $('#capacity_of_property').multipleSelect({
 			selectAllDelimiter : [],
 			selectAllText : "Select ALL",
 			placeholder : "Capacity of property",
            width: '100%'
        });

        $("#ski_country, #resorts").siblings(".ms-parent ").hide();
        $("#resorts + .ms-parent .ms-drop li").hide();

        <?php if( @$_GET["holiday"] == 5185 ){ ?>
        	$("#ski_country, #resorts").siblings(".ms-parent ").show();
        	$("#resorts + .ms-parent .ms-drop li").hide();	
        	$("#resorts + .ms-parent .ms-drop li.selected").show();
        	$("#resorts + .ms-parent .ms-drop li.destination-id-<?php echo @$_GET["holiday"]; ?>").show();
        	$("#tour_advance_search_wrapp").show();
			$("#ski_country, #resorts, #ski_date, #facilities, #accommodation_type, #capacity_of_property").prop('disabled', false);
			$("#destination, #country").hide();				
			$("#destination, #country").prop('disabled', true);
			
			setTimeout(function(){		
				$("#country + .ms-parent").hide();
				$("#ski_country").trigger('change')
			}, 3100);
        <?php } ?>
 	});
 </script>
 <?php
},10);


add_action('registered_post_type', 'igy2411_make_posts_hierarchical_213156454332', 10, 2 );

// Runs after each post type is registered
function igy2411_make_posts_hierarchical_213156454332($post_type, $pto){

    // Return, if not post type posts
    if ($post_type != 'destination') return;

    // access $wp_post_types global variable
    global $wp_post_types;

    // Set post type "post" to be hierarchical
    $wp_post_types['destination']->hierarchical = true;

    // Add page attributes to post backend
    // This adds the box to set up parent and menu order on edit posts.
    
    add_post_type_support( 'destination', 'page-attributes' );
}

function curPageURL() {
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
	return $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function my_add_rewrite_rules_1235() {
    $pageURL = curPageURL();

    if (strpos($pageURL, get_home_url().'/luxury-holidays/destinations/') !== false) {
    	$pageURL = str_replace( get_home_url().'/luxury-holidays/destinations/',"",$pageURL );
    	$pageURL = trim( $pageURL, "/" );
    	
    	$nav_depth = explode( '/',  $pageURL );

    	if ( 4 === count( $nav_depth ) ) {
    		$property_name = $nav_depth[3]; 	
	    	
	    	add_rewrite_tag('%properties%', '([^/]+)', 'properties=');
			add_permastruct('properties', '/luxury-holidays/destinations/%properties%', false);
			add_rewrite_rule('^luxury-holidays/destinations/([^/]+)/([^/]+)/?','index.php?properties='. $property_name,'top');
    	} else {
			add_rewrite_tag('%destination%', '([^/]+)', 'destination=');
			add_permastruct('destination', '/luxury-holidays/destinations/%destination%', false);
			add_rewrite_rule('^luxury-holidays/destinations/([^/]+)/([^/]+)/?','index.php?destination='.$pageURL,'top');
    	}
    	
		flush_rewrite_rules();
	}
}
add_action( 'init', 'my_add_rewrite_rules_1235' );

function rewrite_destination_slug( $args, $post_type ) {
	if ( 'destination' === $post_type ) {
		$args['rewrite'] = array( 
			'slug'       => 'luxury-holidays/destinations', 
			'with_front' => false,
			'feeds'      => true, 
		);	
	}
	
	return $args;
}
add_filter( 'register_post_type_args', 'rewrite_destination_slug', 10, 2 );

//ACF select customise
function acf_load_color_field_choices_8743568754( $field ) {
    global $wpdb;

    // reset choices
    $field['choices'] = array();
    $field['choices'][ "" ] = "Choose Area";

    if( get_post_type( get_the_ID() ) == "itinerary" ){	
		$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent = 0 AND post_status = 'publish' AND post_type = 'destination' AND ID = 289 ; " );
    }else{
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent = 0 AND post_status = 'publish' AND post_type = 'destination'; " );
    }

    foreach ($results as $value) {
    	$field['choices'][ $value->ID ] = $value->post_title;    	
    }

    // return the field
    return $field;    
}

add_filter('acf/load_field/name=destinations_area', 'acf_load_color_field_choices_8743568754');


//ACF select customise
function acf_load_color_field_choices_1658465( $field ) {
	global $wpdb;
    
    // reset choices
    $field['choices'] = array();
    $field['choices'][ "" ] = "Choose Country";

    if( get_post_type( get_the_ID() ) == "itinerary" ){
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent <> 0 AND post_status = 'publish' AND post_type = 'destination' AND ID = 289; " );
    }else{
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent <> 0 AND post_status = 'publish' AND post_type = 'destination'; " );
    }

    foreach ($results as $value) {
    	$field['choices'][ $value->ID ] = $value->post_title;    	
    }
    
    // return the field
    return $field;    
}

add_filter('acf/load_field/name=destinations_country', 'acf_load_color_field_choices_1658465');

//ACF select customise
function acf_load_color_field_choices_1658465455323( $field ) {
	global $wpdb;
    
    // reset choices
    $field['choices'] = array();
    $field['choices'][ "" ] = "All";

    if( get_post_type( get_the_ID() ) == "itinerary" ){
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent <> 0 AND post_status = 'publish' AND post_type = 'destination' AND ID = 289; " );
    }else{
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent <> 0 AND post_status = 'publish' AND post_type = 'destination'; " );
    }

    foreach ($results as $value) {
    	if( !get_post_meta( $value->ID, 'ski_condition', true ) ){
    		$field['choices'][ $value->ID ] = $value->post_title;
    	}	
    }
    
    // return the field
    return $field;    
}
add_filter('acf/load_field/name=ski_resorts', 'acf_load_color_field_choices_1658465455323');

function acf_load_color_field_choices_89754534513213( $field ) {
	global $wpdb;
    
    // reset choices
    $field['choices'] = array();
    $field['choices'][ "" ] = "Choose Country";

    if( get_post_type( get_the_ID() ) == "itinerary" ){
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent <> 0 AND post_status = 'publish' AND post_type = 'destination' AND ID = 289; " );
    }else{
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent <> 0 AND post_status = 'publish' AND post_type = 'destination'; " );
    }

    foreach ($results as $value) {
    	if( get_post_meta( $value->ID, 'ski_condition', true ) ){
	    	$field['choices'][ $value->ID ] = $value->post_title;    	
	    }
    }
    
    // return the field
    return $field;    
}
add_filter('acf/load_field/name=ski_country', 'acf_load_color_field_choices_89754534513213');

//ACF select customise
function acf_load_color_field_choices_788455435( $field ) {
	global $wpdb;
    
    // reset choices
    $field['choices'] = array();
    $field['choices'][ "" ] = "Choose Holiday Type";

    $results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent = 0 AND post_status = 'publish' AND post_type = 'holiday_type'; " );

    foreach ($results as $value) {
    	$field['choices'][ $value->ID ] = $value->post_title;    	
    }
    
    // return the field
    return $field;    
}

add_filter('acf/load_field/name=holiday_types', 'acf_load_color_field_choices_788455435');

add_action('admin_head',function(){ ?>
<style type="text/css">
	div[data-name="destinations_country"] select option,
	div[data-name="ski_resorts"] select option{
		display: none;
	}
</style>
<?php	
 });

add_action('admin_footer',function(){
	global $wpdb;
	$arr = $arr_selected = $arr_selected_2 = array();

    $results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent <> 0 AND post_status = 'publish' AND post_type = 'destination'; " );

    foreach ($results as $value) {
    	$arr[ $value->post_parent ][] =	$value->ID;
    }

    if( get_field( 'destinations_area' ) ){
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent = ". get_field( 'destinations_area' ) ." AND post_status = 'publish' AND post_type = 'destination'; " );

    	foreach ($results as $value) {
    		if( $value->post_parent == get_field( 'destinations_area' ) ){
	    		$arr_selected[ $value->post_parent ][] = $value->ID;
	    	}
	    }
    }

    if( get_field( 'ski_country' ) ){
    	$results = $wpdb->get_results( "SELECT ID, post_title, post_parent FROM {$wpdb->prefix}posts WHERE post_parent = ". get_field( 'ski_country' ) ." AND post_status = 'publish' AND post_type = 'destination'; " );

    	foreach ($results as $value) {
    		if( $value->post_parent == get_field( 'ski_country' ) ){
	    		$arr_selected_2[ $value->post_parent ][] = $value->ID;
	    	}
	    }
    }

?>
<script type="text/javascript">
 	jQuery(document).ready(function($){
 		let selContent = $('div[data-name="holiday_types"]');
 		var val = JSON.parse( '<?php echo json_encode($holiday_types_val); ?>' );

	 		if( $.inArray("5185",val) !== -1  ){
				selContent.find("option[value=5185]").prop("disabled",false);
				selContent.find("option:not([value=5185])").prop("disabled",true);
				selContent.find("option:nth-child(1)").prop("disabled",false);

				//ski fields show
				$('div[data-name="ski_country"]').show();
				$('div[data-name="ski_resorts"]').show();
				$('div[data-name="accommodation_type"]').show();
				$('div[data-name="facilities"]').show();				
			}else{
				selContent.find("option[value=5185]").prop("disabled",true);
				selContent.find("option:not([value=5185])").prop("disabled",false);

				//ski fields hide
				$('div[data-name="ski_country"]').hide();
				$('div[data-name="ski_resorts"]').hide();
				$('div[data-name="accommodation_type"]').hide();
				$('div[data-name="facilities"]').hide();
			}

			if( $.inArray("",val) !== -1 || val == null ){
				selContent.find("option").prop("disabled",false);
				//ski fields hide
				$('div[data-name="ski_country"]').hide();
				$('div[data-name="ski_resorts"]').hide();
				$('div[data-name="accommodation_type"]').hide();
				$('div[data-name="facilities"]').hide();
			}


           var holoday_type_val = $("#acf-field_5bf2c94646266").val();


           if(holoday_type_val == '5185'){
             $('div[data-name="ski_country"]').show();
             $('div[data-name="ski_resorts"]').show();
           }else{
           	 $('div[data-name="ski_country"]').hide();
             $('div[data-name="ski_resorts"]').hide();
           }
        
 		$(document).on("change",'div[data-name="holiday_types"] select',function(){
				let val = $(this).val();

				if( $.inArray("5185",val) !== -1){
					$(this).find("option[value=5185]").prop("disabled",false);
				$(this).find("option:not([value=5185])").prop("disabled",true);
				$(this).find('option:nth-child(1)').prop("disabled",false);

				//ski fields show
				$('div[data-name="ski_country"]').show();
				$('div[data-name="ski_resorts"]').show();
				$('div[data-name="accommodation_type"]').show();
				$('div[data-name="facilities"]').show();
				
			}else{
				$(this).find("option[value=5185]").prop("disabled",true);
				$(this).find("option:not([value=5185])").prop("disabled",false);

				//ski fields hide
				$('div[data-name="ski_country"]').hide();
				$('div[data-name="ski_resorts"]').hide();
				$('div[data-name="accommodation_type"]').hide();
				$('div[data-name="facilities"]').hide();
			}

			if( $.inArray("",val) !== -1 || val == null ){
				selContent.find("option").prop("disabled",false);
				//ski fields hide
				$('div[data-name="ski_country"]').hide();
				$('div[data-name="ski_resorts"]').hide();
				$('div[data-name="accommodation_type"]').hide();
				$('div[data-name="facilities"]').hide();
			}		
 		});
 		
 		$(document).on("change",'div[data-name="destinations_area"] select',function(){
 			let val = $(this).val(); 			
 			var data = JSON.parse( '<?php echo json_encode($arr); ?>' );
 			
 			$('div[data-name="destinations_country"] select option').hide();

 			$.each( data, function( key, value ) { 				
 				if( key == val ){ 					
 					var myarr = value.toString().split(",");
 					for (var i = myarr.length - 1; i >= 0; i--) {
 						$('div[data-name="destinations_country"] select option[value="'+ myarr[i] +'"]' ).show();
 					}
 				}
			});
			$('div[data-name="destinations_country"] select option[value=""]').show();
			$('div[data-name="destinations_country"] select option[value=""]').attr('selected', 'selected');
 		});

 		$(document).on("change",'div[data-name="ski_country"] select',function(){
 			let val = $(this).val(); 			
 			var data = JSON.parse( '<?php echo json_encode($arr); ?>' );
 			
 			$('div[data-name="ski_resorts"] select option').hide();

 			$.each( data, function( key, value ) {
 				if( key == val ){ 					
 					var myarr = value.toString().split(",");
 					for (var i = myarr.length - 1; i >= 0; i--) {
 						$('div[data-name="ski_resorts"] select option[value="'+ myarr[i] +'"]' ).show();
 					}
 				}
			});
			$('div[data-name="ski_resorts"] select option[value=""]').show();
			$('div[data-name="ski_resorts"] select option[value=""]').attr('selected', 'selected');
 		});
 	});
 </script>

<?php if( count( $arr_selected ) > 0 ){ ?>
	<script type="text/javascript">
	 	jQuery(document).ready(function($){
	 		var data = JSON.parse( '<?php echo json_encode($arr_selected); ?>' );

	 		$.each( data, function( key, value ) {
	 			var myarr = value.toString().split(",");
				for (var i = myarr.length - 1; i >= 0; i--) {
					$('div[data-name="destinations_country"] select option[value="'+ myarr[i] +'"]' ).show();
				}
	 		});
	 		$('div[data-name="destinations_country"] select option[value=""]').show();
	 	});
	 </script>
<?php } ?>

<?php if( count( $arr_selected_2 ) > 0 ){ ?>
	<script type="text/javascript">
	 	jQuery(document).ready(function($){
	 		var data = JSON.parse( '<?php echo json_encode($arr_selected_2); ?>' );

	 		$.each( data, function( key, value ) {	 			
	 			var myarr = value.toString().split(",");	 			
				for (var i = myarr.length - 1; i >= 0; i--) {
					$('div[data-name="ski_resorts"] select option[value="'+ myarr[i] +'"]' ).show();
				}
	 		});
	 		$('div[data-name="ski_resorts"] select option[value=""]').show();
	 	});
	 </script>
<?php } ?>

<?php });

add_action( 'wp_footer', function(){ ?>
	<script type="text/javascript">
		document.addEventListener( 'wpcf7mailsent', function( event ) {
		   if ( '3601' == event.detail.contactFormId ) { 
		    	location = '<?php echo get_home_url(); ?>/thank-you-for-your-enquiry/';
		   }
		}, false );
	</script>
<?php
});

add_action( 'wp_head', function(){ ?>
<style type="text/css">
	.ms-choice{
		height: 38px;
		line-height: 38px;
	}
	.ms-choice > div {
		height: 38px;
	    background-position: left top 5px;
	}
	.ms-choice > div.open {
		background-position: left top 5px;
	}
        
        
        #holiday_type, #country, #ski_country, #destination{
            height: 37px;
            overflow: hidden; 
        }
</style>
<?php
});

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_topics_hierarchical_taxonomy_156465568782', 0 );
 
//create a custom taxonomy name it topics for your posts
 
function create_topics_hierarchical_taxonomy_156465568782() { 
	  $labels = array(
	    'name' => _x( 'Facilities', 'taxonomy general name' ),
	    'singular_name' => _x( 'Facility', 'taxonomy singular name' ),
	    'search_items' =>  __( 'Search Facilities' ),
	    'all_items' => __( 'All Facilities' ),
	    'parent_item' => __( 'Parent Facility' ),
	    'parent_item_colon' => __( 'Parent Facility:' ),
	    'edit_item' => __( 'Edit Facility' ), 
	    'update_item' => __( 'Update Facility' ),
	    'add_new_item' => __( 'Add New Facility' ),
	    'new_item_name' => __( 'New Facility Name' ),
	    'menu_name' => __( 'Facilities' ),
	  );    
	 
	// Now register the taxonomy Facility
	 
	  register_taxonomy('facilities',array('properties'), array(
	    'hierarchical' => true,
	    'labels' => $labels,
	    'show_ui' => true,
	    'show_admin_column' => true,
	    'query_var' => true,
	    'rewrite' => array( 'slug' => 'facility' ),
	  )); 

	//Accommodation type 
	  $labels = array(
	    'name' => _x( 'Accommodation type', 'taxonomy general name' ),
	    'singular_name' => _x( 'Accommodation type', 'taxonomy singular name' ),
	    'search_items' =>  __( 'Search Accommodation type' ),
	    'all_items' => __( 'All Accommodation type' ),
	    'parent_item' => __( 'Parent Accommodation type' ),
	    'parent_item_colon' => __( 'Parent Accommodation type:' ),
	    'edit_item' => __( 'Edit Accommodation type' ), 
	    'update_item' => __( 'Update Accommodation type' ),
	    'add_new_item' => __( 'Add New Accommodation type' ),
	    'new_item_name' => __( 'New Accommodation type Name' ),
	    'menu_name' => __( 'Accommodation type' ),
	  );    
	 
	  register_taxonomy('accommodation_type',array('properties'), array(
	    'hierarchical' => true,
	    'labels' => $labels,
	    'show_ui' => true,
	    'show_admin_column' => true,
	    'query_var' => true,
	    'rewrite' => array( 'slug' => 'accommodation_type' ),
	  )); 
}

function custom_grandtour_pagination($pages = '', $range = 4)
{
	 $showitems = ($range * 2)+1;
	 
	 $paged = grandtour_get_paged();
	 if(empty($paged)) $paged = 1;
	 
	 if($pages == '')
	 {
	 $wp_query = grandtour_get_wp_query();
	 $pages = $wp_query->max_num_pages;
	 if(!$pages)
	 {
	 $pages = 1;
	 }
	 }

	 $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	 if(1 != $pages)
	 {
	 echo "<div class=\"pagination\">";
	 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".add_query_arg ('paged', 1, $url)."'>&laquo; First</a>";
	 if($paged > 1 && $showitems < $pages) echo "<a href='". add_query_arg ('paged', $paged - 1, $url) ."'>&lsaquo; Previous</a>";
	 
	 for ($i=1; $i <= $pages; $i++)
	 {
	 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
	 {
	 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='". add_query_arg ('paged', $i, $url) ."' class=\"inactive\">".$i."</a>";
	 }
	 }

	 if ($paged < $pages && $showitems < $pages) echo "<a href=\"". add_query_arg ('paged', $paged + 1, $url) ."\">Next &rsaquo;</a>";
	 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='". add_query_arg ('paged',$pages, $url)."'>Last &raquo;</a>";
	 echo "</div>";
	 }
}
?>