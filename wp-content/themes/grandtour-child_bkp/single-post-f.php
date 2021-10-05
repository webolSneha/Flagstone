<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
*/

get_header(); 

$grandtour_topbar = grandtour_get_topbar();

/**
*	Get current page id
**/

$current_page_id = $post->ID;

//If display feat content
$tg_blog_feat_content = kirki_get_option('tg_blog_feat_content');


/**
*	Get current page id
**/

$current_page_id = $post->ID;
$post_gallery_id = '';
if(!empty($tg_blog_feat_content))
{
	$post_gallery_id = get_post_meta($current_page_id, 'post_gallery_id', true);
}

//Include custom header feature
get_template_part("/templates/template-post-header");
?>
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">

    		<div class="sidebar_content full_width">
					
<?php
if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = '';
								
	if(!empty($tg_blog_feat_content) && has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
?>
						
<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
	    	
			    
			<?php
			    the_content();
			    wp_link_pages();
			?>
			
			<?php
				//Get share button
				//get_template_part("/templates/template-post-tags");
				
			    //Get post author
				//get_template_part("/templates/template-author");
				
				//Get post related
			    //get_template_part("/templates/template-post-related");
			?>
			
	    </div>
	    
	</div>

</div>
<!-- End each blog post -->


<?php endwhile; endif; ?>
						
    	</div>
    
    </div>
    <!-- End main content -->
   
</div>

<br class="clear"/>
</div>
<?php get_footer(); ?>