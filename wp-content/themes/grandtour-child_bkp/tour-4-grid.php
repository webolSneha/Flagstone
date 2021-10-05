<?php
/**
 * Template Name: Tour 4 Columns Grid
 * The main template file for display tour page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
if(!is_null($post))
{
	$page_obj = get_page($post->ID);
}

$current_page_id = '';

/**
*	Get current page id
**/

if(!is_null($post) && isset($page_obj->ID))
{
    $current_page_id = $page_obj->ID;
}

$grandtour_homepage_style = grandtour_get_homepage_style();

get_header();

$grandtour_page_content_class = grandtour_get_page_content_class();

//Include custom header feature
get_template_part("/templates/template-header");

//Include custom tour search feature
get_template_part("/templates/template-tour-search");
?>

<!-- Begin content -->
<?php
	//Get all portfolio items for paging
	$wp_query = grandtour_get_wp_query();
	$current_photo_count = $wp_query->post_count;
	$all_photo_count = $wp_query->found_posts;

	
?>
    
<div class="inner">

	<div class="inner_wrapper nopadding">
	
	<?php
	   // if(!empty($post->post_content) && empty($term))
	   // {
	?>
	   <!-- <div class="standard_wrapper"><?php //echo grandtour_apply_content($post->post_content); ?></div><br class="clear"/><br/>-->
	<?php
	    //}
	?>
	
	<div id="page_main_content" class="sidebar_content full_width fixed_column">
	
	<div class="standard_wrapper">
	
	<div id="portfolio_filter_wrapper" class="gallery grid four_cols portfolio-content section content clearfix" data-columns="4">
	
	<?php
		$key = 0;
		if (have_posts()) : while (have_posts()) : the_post();
			$key++;
			$image_url = "";
			$tour_ID = get_the_ID();
 
			if(has_post_thumbnail($tour_ID, 'grandtour-gallery-grid'))
			{
			    $image_id = get_post_thumbnail_id($tour_ID);
			    $small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-gallery-grid', true);
                //echo '<pre>';print_r($small_image_url);echo'</pre>';
                $image_url = $small_image_url[0]; 
			}else{

                $image_url = site_url().'/wp-content/uploads/2019/02/noimage.jpg';
			}
			
			$permalink_url = get_permalink($tour_ID);  
			
			/*if(!empty($small_image_url[0]))
			{
			   $image_url = $small_image_url[0];	
			} */

	?>
	
	<div class="element grid classic4_cols animated<?php echo esc_attr($key+1); ?>" <?php echo $tour_ID; ?>>
	
		<!-- <div class="one_fourth gallery4 grid static filterable portfolio_type themeborder" data-id="post-<?php echo esc_attr($key+1); ?>" style="background-image:url(<?php echo esc_url($small_image_url[0]); ?>);"> -->	
			<div class="one_fourth gallery4 grid static filterable portfolio_type themeborder" data-id="post-<?php echo esc_attr($key+1); ?>" style="background-image:url(<?php echo esc_url($image_url); ?>);">
			<a class="tour_image" href="<?php echo esc_url($permalink_url); ?>"></a>
			
			<?php
				//Get tour label
				$tour_label = get_post_meta($post->ID, 'tour_label', true);
				
				if(!empty($tour_label))
				{
			?>
			<div class="tour_label"><?php echo esc_html($tour_label); ?></div>
			<?php
				}	
			?>
				
			<div class="portfolio_info_wrapper" <?php echo 'image url=='.$small_image_url[0]; ?>>
				<?php

					$tour_price = null;
					//Get tour price
					//Temporary  comment out this code
					/*if( @$_GET["holiday"] == 5185 ){					
						if( have_rows('ski_option_row') ):
						    while ( have_rows('ski_option_row') ) : the_row();						
								if( @$_GET["daterange"] != null ){
									if( str_replace( "-", "", $_GET['daterange'] ) >= get_sub_field('start_date') 
										&& str_replace( "-", "", $_GET['daterange'] ) <= get_sub_field('end_date') ){
										$tour_price = get_sub_field('property_ski_price');
							        	break;
									}
								}else{
									$tour_price = get_sub_field('property_ski_price');
						        	break;
								}
						    endwhile;
						endif;
					}else{*/
						$tour_price = get_post_meta($post->ID, 'property_price', true);
					//}
					
					if(!empty($tour_price))
					{
						$tour_discount_price = get_post_meta($post->ID, 'tour_discount_price', true);
				?>
				<div class="tour_price <?php if(!empty($tour_discount_price)) { ?>has_discount<?php } ?>">
					<?php
					if(!empty($tour_discount_price))
					{
					?>
						<span class="normal_price">
							<?php echo esc_html(grandtour_format_tour_price($tour_price)); ?>
						</span>
						<?php echo esc_html(grandtour_format_tour_price($tour_discount_price)); ?>
					<?php
					}
					else
					{
					?>
						<?php echo esc_html(grandtour_format_tour_price($tour_price)); ?>
					<?php
					}
					?>
				</div>
				<?php
					}
				?>
        	    <h5><?php the_title(); ?></h5>
        	    <div class="tour_attribute_wrapper">
	        	    <?php
		    			$overall_rating_arr = get_post_meta($tour_ID, 'average_rating', true);
						$overall_rating = intval($overall_rating_arr);
						$overall_rating_count = intval($overall_rating_arr['count']);
						
						if(!empty($overall_rating))
						{
				?>
						<div class="tour_attribute_rating">
				<?php
							if($overall_rating > 0)
							{
				?>
							<div class="br-theme-fontawesome-stars-o">
								<div class="br-widget">
				<?php 
								for( $i=1; $i <= $overall_rating; $i++ ) {
									echo '<a href="javascript:;" class="br-selected"></a>';
								}
								
								$empty_star = 6 - $overall_rating;
								
								if(!empty($empty_star))
								{
									for( $i=1; $i <= $empty_star; $i++ ) {
										echo '<a href="javascript:;"></a>';
									}
								}
					?>
								</div>
							</div>
					<?php
							}
							
							if($overall_rating_count > 0)
							{
					?>
							<div class="tour_attribute_rating_count">
								<?php echo intval($overall_rating_count); ?>&nbsp;
								<?php
									if($overall_rating_count > 1)
									{
										echo esc_html__('reviews', 'grandtour' );
									}
									else
									{
										echo esc_html__('review', 'grandtour' );
									}
								?>
							</div>
					<?php
							}
					?>
						</div>
					<?php
						}    
		    		?>
		    		
		    		<?php
						$tour_days = get_post_meta($tour_ID, 'capacity_of_property', true);	
						
						if(!empty($tour_days))
						{
					?>
		    		    <div class="tour_attribute_days">
						    <span class="ti-user"></span>
						    <?php
								//Display tour durations
								//		echo grandtour_get_tour_duration($tour_ID);
						    echo get_post_meta($tour_ID, 'capacity_of_property', true);
							?>
		    		    </div>
		    		<?php
						}
					?>
        	    </div>
        	    <br class="clear"/>
			</div>
		</div>
	</div>
	<?php
			//}
		endwhile;
		else:
	?>
			<div class="tour_search_noresult"><span class="ti-info-alt"></span><?php esc_html_e("We haven't found any tour that matches you're criteria", 'grandtour'); ?></div>
	<?php
		endif;
	?>
		
	</div>
	<br class="clear"/>
	<?php
	    if($wp_query->max_num_pages > 1)
	    {
	    	if (function_exists("custom_grandtour_pagination")) 
	    	{
	    	    custom_grandtour_pagination($wp_query->max_num_pages);
	    	}
	    	else
	    	{
	    	?>
	    	    <div class="pagination"><p><?php posts_nav_link(' '); ?></p></div>
	    	<?php
	    	}
	    ?>
	    <div class="pagination_detail">
	     	<?php
	     		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	     	?>
	     	<?php esc_html_e('Page', 'grandtour' ); ?> <?php echo esc_html($paged); ?> <?php esc_html_e('of', 'grandtour' ); ?> <?php echo esc_html($wp_query->max_num_pages); ?>
	     </div>
	     <?php
	     }
	?>
	
	</div>
	</div>

</div>
</div>
</div>
<?php get_footer(); ?>
<!-- End content -->
