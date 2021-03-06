<?php
/**
 * The main template file for display page.
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

$page_sidebar = get_post_meta($current_page_id, 'destination_sidebar', true);

if(empty($page_sidebar))
{
	$page_sidebar = 'Page Sidebar';
}

get_header(); 
?>

<?php
    //Include custom header feature
	get_template_part("/templates/template-header");
?>

    <div class="inner">
    
    <!-- Begin main content -->
    <div class="inner_wrapper">
	    
	   <!--  <?php
		  	//Check related tour order
		    //$tg_destination_single_tour_order = kirki_get_option('tg_destination_single_tour_order');
		    
		    //if($tg_destination_single_tour_order == 'before')
		    {
		  		//Include related tours
		  		//get_template_part("/templates/template-destination-single-related");
		  	}
		?> -->
        	
        <div class="sidebar_content full_width ">
        	<!-- <blockquote><?php //the_excerpt(); ?></blockquote> -->
	        	
	         <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			 	<?php the_content(); ?>
			 <?php endwhile; ?>
			 
			 
        </div>
    
    </div>
    <!-- End main content -->
    
    </div>
</div>
<br class="clear"/>
<?php get_footer(); ?>
