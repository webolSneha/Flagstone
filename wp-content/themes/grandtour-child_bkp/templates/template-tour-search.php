<?php

	global $wpdb;
	$wp_query = grandtour_get_wp_query();
	
	$query_string = 'paged='.$paged;
	$query_string.= grandtour_get_initial_tour_query();
	
	if(!empty($term))
	{
		$ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$custom_tax = $wp_query->query_vars['taxonomy'];
	    $query_string .= '&'.$custom_tax.'='.$term;
	}
	
	parse_str($query_string, $args);
    
    if(isset($_GET['keyword']) && !empty($_GET['keyword']))
    {  
    	/*$args['tax_query'][] = array(
		    array(
		        'taxonomy' => 'tourtag',
		        'field' => 'name',
		        'terms' => $_GET['keyword']
		    )
		);*/
        $args['s'] = $_GET['keyword'];
    }
    
    if(isset($_GET['month']) && !empty($_GET['month']))
    { 
    	$args['meta_query'][] = array(
        	'key' => 'tour_months',
        	'value' => $_GET['month'],
        	'type' => 'CHAR',
        	'compare' => 'LIKE'
        );
    }
    
    if(isset($_GET['tourcat']) && !empty($_GET['tourcat']))
    { 
    	$args['tourcat'] = $_GET['tourcat'];
    }
    
    if(isset($_GET['budget']) && !empty($_GET['budget']))
    {
    	$args['meta_query'][] = array(
        	'key' => 'tour_price',
        	'value' => $_GET['budget'],
        	'type' => 'numeric',
        	'compare' => '<='
        );
    }
    
    if(isset($_GET['destination_id']) && !empty($_GET['destination_id']))
    { 
    	$selected_destination_tours = get_post_meta($_GET['destination_id'], 'destination_tour', true);
    	
    	if(!empty($selected_destination_tours) && is_array($selected_destination_tours))
    	{
	    	$args['post__in'] = $selected_destination_tours;
    	}
    	else
    	{
	    	$args['post__in'] = array(1);
    	}
    }

    $orderby = "DESC";
    if(isset($_GET['sort_by']) && !empty($_GET['sort_by'])){
    	switch($_GET['sort_by']){
	    	case 'date':
	    	default:
	    		$args['orderby'] = 'post_date';
	    		$args['order'] = 'DESC';
	    	break;
	    	
	    	case 'price_low':
	    		// if( @$_GET["holiday"] == 5185 ){
	    		// 	$inc = 0;
			    // 	$inc_query = $wpdb->get_row( "SELECT meta_id FROM {$wpdb->prefix}postmeta WHERE meta_key = 'ski_option_row_". $inc ."_start_date';  " );
			    // 	while ( $inc_query != null ) {
			    // 		$inc++;
			    // 		$inc_query = $wpdb->get_row( "SELECT meta_id FROM {$wpdb->prefix}postmeta WHERE meta_key = 'ski_option_row_". $inc ."_start_date';  " );
			    // 	}

	    		// 	$price_order_by = array();
	    		// 	for ($i=0; $i < $inc; $i++) {
	    		// 		$price_order_by[ 'ski_option_row_'. $i .'_property_ski_price' ]  = 'ASC';
	    		// 	}
	    		// 	$args['orderby'] = $price_order_by;
	    		// }else{
	    		// 	$args['orderby'] = 'meta_value_num';
		    	// 	$args['meta_key'] = 'property_price';
		    	// 	$args['order'] = 'ASC';
	    		// }
	    		$args['orderby'] = 'meta_value_num';
	    		$args['meta_key'] = 'property_price';
	    		$args['order'] = 'ASC';
	    	break;
	    	
	    	case 'price_high':
	    		// if( @$_GET["holiday"] == 5185 ){
	    		// 	$inc = 0;
			    // 	$inc_query = $wpdb->get_row( "SELECT meta_id FROM {$wpdb->prefix}postmeta WHERE meta_key = 'ski_option_row_". $inc ."_start_date';  " );
			    // 	while ( $inc_query != null ) {
			    // 		$inc++;
			    // 		$inc_query = $wpdb->get_row( "SELECT meta_id FROM {$wpdb->prefix}postmeta WHERE meta_key = 'ski_option_row_". $inc ."_start_date';  " );
			    // 	}

	    		// 	$price_order_by = array();
	    		// 	for ($i=0; $i < $inc; $i++) {
	    		// 		$price_order_by[ 'ski_option_row_'. $i .'_property_ski_price' ]  = 'DESC';
	    		// 	}
	    		// 	$args['orderby'] = $price_order_by;
	    		// }else{
		    	// 	$args['orderby'] = 'meta_value_num';
		    	// 	$args['meta_key'] = 'property_price';
		    	// 	$args['order'] = 'DESC';
		    	// }
		    	$args['orderby'] = 'meta_value_num';
	    		$args['meta_key'] = 'property_price';
	    		$args['order'] = 'DESC';
	    	break;
	    	
	    	case 'name':
	    		$args['orderby'] = 'post_title';
	    		$args['order'] = 'ASC';
	    	break;

	    	case 'name_desc':
	    		$args['orderby'] = 'post_title';
	    		$args['order'] = 'DESC';
	    	break;
	    	
	    	case 'popular':
	    		$args['orderby'] = 'post_views';
	    		$args['order'] = 'DESC';
	    	break;
	    	
	    	case 'review':
	    		$args['orderby'] = 'meta_value_num';
	    		$args['meta_key'] = 'average_rating';
	    		$args['order'] = 'DESC';
	    	break;

	    	case 'review_asc':
	    		$args['orderby'] = 'meta_value_num';
	    		$args['meta_key'] = 'average_rating';
	    		$args['order'] = 'ASC';
	    	break;

	    	case 'size':
	    		$args['orderby'] = 'meta_value_num';
	    		$args['meta_key'] = 'capacity_of_property';
	    		$args['order'] = 'ASC';
	    	break;

	    	case 'size_desc':
	    		$args['orderby'] = 'meta_value_num';
	    		$args['meta_key'] = 'capacity_of_property';
	    		$args['order'] = 'DESC';
	    	break;
    	}
    }
    $orderby = $args['order'];

    //custom search meta query
    if(isset($_GET['holiday']) && !empty($_GET['holiday'])){
		$holiday = explode(',',$_GET['holiday']);

		$h_arr = array( 'relation' => 'OR' );
		$i = 0;
		foreach ($holiday as $key => $value) {
			$tmp_array = array(
	        	'key' => 'holiday_types',	        	
	        	'value' => sprintf(':"%s";', $value),	        	
	        	'compare' => 'LIKE'
	        );	    

	        $h_arr[$i] = $tmp_array; 
	        $i++;
		}

		if( count( $holiday ) == 1 ){
			$args['meta_query'][] = array(
	        	'key' => 'holiday_types',	        	
	        	'value' => sprintf(':"%s";', $holiday[0]),	        	
	        	'compare' => 'LIKE'
	        );
		}else{
			$args['meta_query'][] = $h_arr;	        	
		}
    }

    if(isset($_GET['dest']) && !empty($_GET['dest'])){
    	$args['meta_query'][] = array(
        	'key' => 'destinations_area',
        	'value' => $_GET['dest'],
        	'type' => 'numeric',
        	'compare' => '='
        );
    }

    if(isset($_GET['country']) && !empty($_GET['country'])){
		$arrcountry=explode(",",$_GET['country']);
		//print_r($arrcountry);
    	$args['meta_query'][] = array(
        	'key' => 'destinations_country',
        	'value' => $arrcountry,//$_GET['country'],
        	'type' => 'numeric',
        	'compare' => 'IN'
        );
    }

  /*  if(isset($_GET['country']) && !empty($_GET['country'])){
    	$args['meta_query'][] = array(
        	'key' => 'destinations_country',
        	'value' => $_GET['country'],
        	'type' => 'numeric',
        	'compare' => '='
        );
    }*/

    /***
	*Ski Filter
    ***/

    //capacity_of_property
    if(isset($_GET['capacity_of_property']) && !empty($_GET['capacity_of_property'])){
    	$args['meta_query'][] = array(
        	'key' => 'capacity_of_property',
        	'value' => $_GET['capacity_of_property'],
        	'type' => 'numeric',
        	'compare' => 'IN'
        );

        if( in_array( "more", $_GET['capacity_of_property'] ) ){
        	$args['meta_query'][] = array(
        		'relation' => 'AND',
        		array(
		        	'key' => 'capacity_of_property',
		        	'value' => 'More',		        	
		        	'compare' => '='
		        ),
	        	array(
		        	'key' => 'custom_capacity_of_property',
		        	'value' => 20,
		        	'type' => 'numeric',
		        	'compare' => '>'
	        	)
	        );
        }
    }

    //facilities
    if(isset($_GET['facilities']) && !empty($_GET['facilities'])){
		 $arr_facilities=explode(",",$_GET['facilities']);
		//print_r($arr_facilities);
		
		$args = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'facilities',
					'field' => 'term_id',
					'terms' =>$arr_facilities,
					'operator' => 'IN'
				)
			)
		);
    	/*$args['meta_query'][] = array(
        	'key' => 'facilities',
        	'value' =>$arr_facilities, //$_GET['facilities'],
        	'type' => 'numeric',
        	'compare' => 'IN'
        );*/
    }

    //accommodation_type
    if(isset($_GET['accommodation_type']) && !empty($_GET['accommodation_type'])){
    	$args['meta_query'][] = array(
        	'key' => 'accommodation_type',
        	'value' => $_GET['accommodation_type'],
        	'type' => 'numeric',
        	'compare' => 'IN'
        );
    }

    //ski country
    if(isset($_GET['ski_country']) && !empty($_GET['ski_country'])){
        //print_r($_GET['ski_country']);
        $arrski_country=explode(",",$_GET['ski_country']);

        //print_r($arrski_country);
    	$args['meta_query'][] = array(
        	'key' => 'ski_country',
        	'value' => $arrski_country,        	
        	'type' => 'numeric',
        	'compare' => 'IN'
        );
    }

    //ski Resorts
    if(isset($_GET['resorts']) && !empty($_GET['resorts'])){
		//print_r($_GET['resorts']);
    	$args['meta_query'][] = array(
        	'key' => 'ski_resorts',
        	'value' => $_GET['resorts'],        	
        	'type' => 'numeric',
        	'compare' => 'IN'
        );
    }

    
    //daterange
    if(isset($_GET['daterange']) && !empty($_GET['daterange'])){
    	$inc = 0;
    	$inc_query = $wpdb->get_row( "SELECT meta_id FROM {$wpdb->prefix}postmeta WHERE meta_key = 'ski_option_row_". $inc ."_start_date';  " );
    	while ( $inc_query != null ) {
    		$inc++;
    		$inc_query = $wpdb->get_row( "SELECT meta_id FROM {$wpdb->prefix}postmeta WHERE meta_key = 'ski_option_row_". $inc ."_start_date';  " );
    	}

    	$post_ids = array();
    	for ($i=0; $i < $inc; $i++) {
    		$results = $wpdb->get_results( "SELECT fp.post_id as post_id FROM {$wpdb->prefix}postmeta fp JOIN {$wpdb->prefix}postmeta fp2 on fp2.post_id = fp.post_id WHERE 
    			( fp.meta_key = 'ski_option_row_". $i ."_start_date' AND fp.meta_value <= '". str_replace( "-", "", $_GET['daterange'] ) ."' ) AND ( fp2.meta_key = 'ski_option_row_". $i ."_end_date' AND fp2.meta_value >= '". str_replace( "-", "", $_GET['daterange'] ) ."' ) ;  ", ARRAY_A );

    		foreach ($results as $key => $value) {
    			if( !in_array( $value->post_id, $post_ids ) ){
    				$post_ids[] = $value["post_id"];
    			}   			
    		}
    	}

    	$args[ "post__in" ] = $post_ids;
    }

    if( @$_GET['dest'] == 289 ){
    	$args['post_type'] = array("properties", "itinerary" );
    }else{
    	$args['post_type'] = "properties";
    }

    query_posts($args);
    
    if(empty($term))
	{
		wp_enqueue_script("script-ajax-search", admin_url('admin-ajax.php')."?action=grandtour_ajax_search&id=keyword&form=tour_search_form&result=autocomplete", false, GRANDTOUR_THEMEVERSION, true);
		
	if( @$_GET["holiday"] == 5185 ){
		$checkSki = true;
	}else{
		$checkSki = false;
	}
?>
<style type="text/css">
	#tour_search_form input[type=submit] { 
	    width: 100%;
	    border: none;
	}
</style>

<form id="tour_search_form" name="tour_search_form" method="get" action="<?php echo get_the_permalink($id); ?>" style="margin-bottom:45px;">
    <div class="tour_search_wrapper">

    <?php if( !$checkSki ){ ?>
    	<div class="one_fourth themeborder">    <input type="hidden" name="holiday" id="holiday1" value="">  <input type="hidden" name="country" id="country1" value="">
	    	<select id="holiday_type" multiple="multiple">
		    	
		    	<?php
					$args = array(  
				       'post_type' => 'holiday_type',
				       'post_status' => 'publish',
				       'posts_per_page' => -1,
				       'post_parent'=>0,
				       'orderby' => 'title',
				       'order' => 'ASC',
				   );
				   $loop = new WP_Query( $args );				     
				   while ( $loop->have_posts() ) : $loop->the_post(); ?>
				       <option value="<?php echo get_the_ID(); ?>" <?php if(isset($_GET['holiday']) && in_array(get_the_ID(),$holiday)) { ?>selected<?php } ?>><?php echo get_the_title(); ?></option>
				   <?php 
				   endwhile;
				   wp_reset_postdata();
		    	?>
	    	</select>
    	</div>
    <?php }else{ ?>
    	<input type="hidden" name="holiday" value="<?php echo $_GET["holiday"]; ?>" >
    <?php } ?>
    	
    	<div class="<?php if( !$checkSki ){ echo 'one_fourth'; }else{ echo 'one_fourth'; } ?> themeborder">
	    	<?php
		    	//Get available months
		    	$args = array(
			       'post_type' => 'destination',
			       'post_status' => 'publish',
			       'posts_per_page' => -1,
			       'orderby' => 'title',
			       'order' => 'ASC',
			    );
			    $loop = new WP_Query( $args );
	   			$country_html = $country_ski = $resorts_html = '';
		    ?>
    		<select id="destination" name="dest">
	    		<option value=""><?php esc_html_e('Holiday Area', 'grandtour' ); ?></option>
	    		<?php
	   				while ( $loop->have_posts() ) : $loop->the_post();
	   				if( get_post_meta( get_the_ID(), 'ski_condition', true ) ){					
						
		   				$country_ski .= '<option value="'.get_the_ID().'"';	
		   				if(isset($_GET['ski_country']) && in_array(get_the_ID(),$arrski_country)){//$_GET['country']==get_the_ID()) {
			    			$country_ski .=' selected';
			    			//echo "TEST YES";
			    		}	   				
		   				$country_ski.='>'. get_the_title() .'</option>';
		   			}else if( wp_get_post_parent_id() == 0 ){
			    ?>
			    	<option value="<?php echo get_the_ID(); ?>" <?php if(isset($_GET['dest']) && $_GET['dest']==get_the_ID()) { ?>selected<?php } ?>><?php echo get_the_title(); ?></option>
			    <?php	
			    	}else{
			    		$country_html .= '<option value="'.get_the_ID().'" ';
			    		if( wp_get_post_parent_id() != $_GET['dest'] ){
			    			$country_html .=' style="display:none;" ';
			    		}
			    		$country_html .=' class="destination-id-'. wp_get_post_parent_id() .'"';
			    		if(isset($_GET['country']) && in_array(get_the_ID(),$arrcountry)){//$_GET['country']==get_the_ID()) {
			    			$country_html .=' selected ';
			    		}
			    		$country_html .= ' >'. get_the_title() .'</option>';

			    		// if( get_post_meta( get_the_ID(), 'ski_condition', true ) ){
			    		// 	if( get_the_ID() == $_GET['ski_country'] ){
					   	// 		$country_ski .= '<option value="'.get_the_ID().'" selected>'. get_the_title() .'</option>';
					   	// 	}else{
					   	// 		$country_ski .= '<option value="'.get_the_ID().'" >'. get_the_title() .'</option>';
					   	// 	}
				   		// }else{

			   			$resorts_html .= '<option value="'.get_the_ID().'" ';
			   			if( wp_get_post_parent_id() != $_GET['ski_country'] ){
			   				$resorts_html .=' style="display:none;" ';
			   			}
			   			$resorts_html .=' class="destination-id-'. wp_get_post_parent_id() .'"';
			   			if(isset($_GET['resorts']) && in_array(get_the_ID(),$_GET['resorts'])){//$_GET['resorts']==get_the_ID()) {
			    			$resorts_html .=' selected ';
			    		}
			    		$resorts_html .= ' >'. get_the_title() .'</option>';
			    		
				   		//}
			    	}
			    	endwhile;
	   				wp_reset_postdata();
		    	?>
    		</select>

			<input type="hidden" name="ski_country" id="ski_country1" value="">
    		<select id="ski_country" style="display: none;" multiple="multiple">				
				<?php echo $country_ski; ?>
    		</select>
    	</div>
    	<div class="<?php if( !$checkSki ){ echo 'one_fourth'; }else{ echo 'one_fourth'; } ?> themeborder">
    		<?php
		    	//Get available country
		    ?>    		
    		<select id="country" multiple="multiple">    			
	    		<?php echo $country_html; ?>
    		</select>

		    <select id="resorts" multiple="multiple" name="resorts[]" style="display: none;">		    	
		    	<?php echo $resorts_html; ?>		    
		    </select>
    	</div>

		<?php if( $checkSki ){ ?>
	    	<!--<div class="one_fifth themeborder">
				<input type="date" name="daterange" id="ski_date" value="<?php// echo $_GET['daterange']; ?>" >
			</div>-->
	    	<div class="one_fourth themeborder">
				<input type="hidden" name="facilities" id="facilities1" value="">
		    	<select id="facilities"  id="facilities" multiple="multiple">
			    	<?php
				    	//Get tour categories list
						$tour_cats_arr = get_terms('facilities', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');
						if(!empty($tour_cats_arr)){
							foreach($tour_cats_arr as $key => $tour_cat){ ?>
								<option value="<?php echo esc_attr($tour_cat->term_id); ?>" <?php if(isset($_GET['facilities']) && in_array($tour_cat->term_id, $arr_facilities) ) { ?>selected<?php } ?>><?php echo esc_attr($tour_cat->name); ?></option>
					<?php }
						} ?>
		    	</select>
	    	</div>
	    <?php } ?>

    	<div class="<?php if( !$checkSki ){ echo 'one_fourth last'; }else{ echo 'one_fourth last'; } ?> themeborder">
    		<input id="tour_search_btn" type="submit" class="button" value="<?php echo _e( 'Search', 'grandtour' ); ?>"/>
    	</div>
    	
    	<?php
	    	//Check if enable advanced search
	    	$tg_tour_advanced_search = kirki_get_option('tg_tour_advanced_search');
	    	
	    	if(!empty($tg_tour_advanced_search))
	    	{
	    ?>
    	<br class="clear"/>
    	<?php /*
    	<div id="tour_advance_search_wrapp" style="display:none;" class="tour_advance_search_wrapp">
    		<div class="one_fourth themeborder">
    			<input type="date" name="daterange" id="ski_date" value="<?php echo $_GET['daterange']; ?>" >
    		</div>
	    	<div class="one_fourth themeborder">
		    	<select id="facilities" name="facilities[]" multiple="multiple">
			    	<?php
				    	//Get tour categories list
						$tour_cats_arr = get_terms('facilities', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');
						if(!empty($tour_cats_arr)){
							foreach($tour_cats_arr as $key => $tour_cat){ ?>
								<option value="<?php echo esc_attr($tour_cat->term_id); ?>" <?php if(isset($_GET['facilities']) && in_array($tour_cat->term_id, $_GET['facilities']) ) { ?>selected<?php } ?>><?php echo esc_attr($tour_cat->name); ?></option>
					<?php }
						} ?>
		    	</select>
	    	</div>
	    	
	    	<div class="one_fourth themeborder">
		    	<select id="accommodation_type" name="accommodation_type[]" multiple="multiple">	    			
			    	<?php
				    	//Get tour categories list
						$tour_cats_arr = get_terms('accommodation_type', 'hide_empty=0&hierarchical=0&parent=0&orderby=title');
						
						if(!empty($tour_cats_arr)){
							foreach($tour_cats_arr as $key => $tour_cat){ ?>
						<option value="<?php echo esc_attr($tour_cat->term_id); ?>" <?php if(isset($_GET['accommodation_type']) && in_array($tour_cat->term_id, $_GET['accommodation_type']) ) { ?>selected<?php } ?>><?php echo esc_attr($tour_cat->name); ?></option>
					<?php }
						} ?>
		    	</select>
	    	</div>
	    	
	    	<div class="one_fourth themeborder" style="margin-right: 0;">
		    	<select id="capacity_of_property" name="capacity_of_property[]" multiple="multiple">

		    	<?php $arr = array( '2', '4', '6', '8', '10', '12', '14', '16', '18', '20', 'more' );
		    	foreach ($arr as $value) { ?>
		    		<option value="<?php echo $value; ?>" <?php if(isset($_GET['capacity_of_property']) && in_array( $value, $_GET['capacity_of_property']) ){ ?>selected<?php } ?>><?php echo ucfirst( $value ); ?></option>
		    	<?php } ?>
				</select>
	    	</div> 
    	</div> */ ?>
    	<?php /*
    	<div class="tour_advance_search_wrapper_link">
	    	<a id="tour_advance_search_toggle" class="theme_link_color" href="javascript:;"><span class="icon ti-angle-down"></span><?php esc_html_e( 'Advanced Search', 'grandtour' ); ?></a>
    	</div> */ ?>
    	<?php
	    	}
	    ?>
    </div>
</form>

<?php

$selected = null;
$url = $_SERVER['SCRIPT_URI']."?";
if( $_SERVER["QUERY_STRING"] != null ){
	$arr = array('name','name_desc','price_low','price_high','review', 'review_asc', 'size','size_desc', 'date' );
	foreach(explode( "&", $_SERVER["QUERY_STRING"] ) as $key => $value) {
		$temp = explode( "=", $value );		
		if( isset( $_GET[ "sort_by" ] ) && in_array( $temp[1], $arr )){
			$selected = $temp[1];
		}else{
			$url .= $value.'&';			
		}
	}
}


function getsortbyurl( $selected, $link = 0 ){
	$arr = array('name_desc','name','price_high','price_low', 'review_asc','review', 'size','size_desc' );

	$geturl = '';
	if( $link > 0 ){
		for ($i= ($link-1) ; $i < count($arr); $i++) {
			if( $i > $link ){
				break;
			}
			if( $selected == $arr[$i] ){
				if( $i%2 == 0 ){
					$geturl = "sort_by=".$arr[$i+1];
				}else{
					$geturl = "sort_by=".$arr[$i-1];
				}
				break;
			}else{
				$geturl = "sort_by=".$arr[$i];
			}
		}
	}else{
		if( $selected == "date" ){
			$geturl = "";
		}else{
			$geturl = "sort_by=date";
		}
	}	
	return $geturl;
}

function get_sort_by_arrow( $orderby, $selected, $select_1, $select_2 ){
	if( $selected == $select_1 || $selected == $select_2 ){
		if( $orderby == "ASC" ){
			echo'<i class="fa fa-arrow-up" aria-hidden="true"></i>';
		}

		if( $orderby == "DESC" ){
			echo'<i class="fa fa-arrow-down" aria-hidden="true"></i>';
		}
	}else{
		echo'<i class="fa fa-arrow-down" aria-hidden="true"></i>';
	}
}

?>

<style type="text/css">
	#sortResults{
		margin-bottom: 20px;
		margin-top:10px;
	}
	#sortResults button {
	    display: inline-block;
	    border: 3px solid #e0e0e0;
	    padding: 5px 10px;
	    text-transform: uppercase;
	    background: #e0e0e0;
	    cursor: pointer;
	}
	#sortResults button.selected {
	    background: #333;
	    color: #fcfcfc;
	    border-color: #333;
	}
</style>

<div id="sortResults">
    <b>SORT BY</b>
    <a href="<?php echo $url.getsortbyurl( $selected ); ?>"><button type="button" <?php if( $selected == null || $selected == 'date' ){ echo 'class="selected '. $orderby .'"'; } ?> >recommended</button></a>
    <a href="<?php echo $url.getsortbyurl( $selected, 1 ); ?>"><button type="button" <?php if( $selected == 'name' || $selected == 'name_desc' ){ echo 'class="selected '. $orderby .'"'; } ?> >A-Z 
    <?php get_sort_by_arrow( $orderby, $selected, 'name', 'name_desc' ); ?></button></a>
    <a href="<?php echo $url.getsortbyurl( $selected, 7 ); ?>"><button type="button" <?php if( $selected == 'size' || $selected == 'size_desc' ){ echo 'class="selected '. $orderby .'"'; } ?> >Size
    <?php get_sort_by_arrow( $orderby, $selected, 'size', 'size_desc' ); ?></button></a>
    <a href="<?php echo $url.getsortbyurl( $selected, 3 ); ?>"><button type="button" <?php if( $selected == 'price_high' || $selected == 'price_low' ){ echo 'class="selected '. $orderby .'"'; } ?> >Price <?php get_sort_by_arrow( $orderby, $selected, 'price_high', 'price_low' ); ?></button></a>
    <a href="<?php echo $url.getsortbyurl( $selected, 5 ); ?>"><button type="button" <?php if( $selected == 'review_asc' || $selected == 'review' ){ echo 'class="selected '. $orderby .'"'; } ?> >Rating <?php get_sort_by_arrow( $orderby, $selected, 'review_asc', 'review' ); ?></button></a>
</div>

<?php
	}
?>
 
<script type="text/javascript">
 	jQuery(document).ready(function($){
		$(document).on("change","#facilities",function(){
			let fval=$(this).val();
			//alert(cval);
			$('#facilities1').val(fval);
		});
	});
 </script>
<style>
#ski_country, #resorts, #facilities{
  height: 37px;
  overflow: hidden; 

}
</style>