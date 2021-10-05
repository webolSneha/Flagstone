<?php
/**
 * Template Name: Blog Fullwidth
 * The main template file for display blog page.
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

get_header();

$is_display_page_content = TRUE;
$is_standard_wp_post = FALSE;

if(is_tag())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
} 
elseif(is_category())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
}
elseif(is_archive())
{
    $is_display_page_content = FALSE;
    $is_standard_wp_post = TRUE;
}

$grandtour_page_content_class = grandtour_get_page_content_class();
grandtour_set_page_content_class('blog_wrapper');

//Include custom header feature
get_template_part("/templates/template-header");
?>
    
    <div class="inner">

    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    	
    		<?php if ( have_posts() && $is_display_page_content) while ( have_posts() ) : the_post(); ?>		
					
		    	<div class="page_content_wrapper"><?php the_content(); ?></div>
		
		    <?php endwhile; ?>
    		
    		<div class="sidebar_content full_width blog_f">

	    		<?php if ( have_posts() && $is_display_page_content) while ( have_posts() ) : the_post(); ?>		
					
		    		<div class="page_content_wrapper"><?php the_content(); ?></div>
		
		    	<?php endwhile; ?>
					
<?php 
if(is_front_page())
{
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}
else
{
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

//If theme built-in blog template then add query
if(!$is_standard_wp_post)
{
    $query_string ="post_type=post&paged=$paged&suppress_filters=0";
    query_posts($query_string);
}

$wp_query = grandtour_get_wp_query();
$post_counter = 0;
$post_counts = $wp_query->post_count;

if (have_posts()) : while (have_posts()) : the_post();

	$image_thumb = '';
								
	if(has_post_thumbnail(get_the_ID(), 'large'))
	{
	    $image_id = get_post_thumbnail_id(get_the_ID());
	    $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
	}
	
	$post_counter++;
?>

<!-- Begin each blog post -->
<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post_wrapper">
	    
	    <div class="post_content_wrapper">
	    
	    	<?php
			    //Get post featured content
			    $post_ft_type = get_post_meta(get_the_ID(), 'post_ft_type', true);
			    
			    switch($post_ft_type)
			    {
			    	case 'Image':
			    	default:
			        	if(!empty($image_thumb))
			        	{
			        		$small_image_url = wp_get_attachment_image_src($image_id, 'grandtour-blog', true);
			?>
			
			    	    <div class="post_img static">
			    	    	<a href="<?php the_permalink(); ?>">
			    	    		<?php the_post_thumbnail('grandtour-blog'); ?>
				            </a>
			    	    </div>
			
			<?php
			    		}
			    	break;
			    	
			    	case 'Vimeo Video':
			    		$post_ft_vimeo = get_post_meta(get_the_ID(), 'post_ft_vimeo', true);
			?>
			    		<?php echo do_shortcode('[tg_vimeo video_id="'.esc_attr($post_ft_vimeo).'" width="670" height="377"]'); ?>
			    		<br/>
			<?php
			    	break;
			    	
			    	case 'Youtube Video':
			    		$post_ft_youtube = get_post_meta(get_the_ID(), 'post_ft_youtube', true);
			?>
			    		<?php echo do_shortcode('[tg_youtube video_id="'.esc_attr($post_ft_youtube).'" width="670" height="377"]'); ?>
			    		<br/>
			<?php
			    	break;
			    	
			    	case 'Gallery':
			    		$post_ft_gallery = get_post_meta(get_the_ID(), 'post_ft_gallery', true);
			?>
			    		<?php echo do_shortcode('[tg_gallery_slider gallery_id="'.esc_attr($post_ft_gallery).'" width="670" height="270"]'); ?>
			    		<br/>
			<?php
			    	break;
			    	
			    } //End switch
			?>
			<div class="post_header_wrapper">
				<div class="post_header">
					<div class="post_detail single_post">
				    		<span class="post_info_date">
					    		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo date_i18n(GRANDTOUR_THEMEDATEFORMAT, get_the_time('U')); ?></a>
				    		</span>
				    		<span class="post_info_comment">
				    			•
				    			<a href="<?php comments_link(); ?>">
				    				<?php 
					    				$post_comment_number = get_comments_number();
					    				echo intval($post_comment_number).'&nbsp;';
					    				
					    				if($post_comment_number <= 1)
					    				{
						    				echo esc_html_e('Comment', 'grandtour' );
					    				}
					    				else
					    				{
						    				echo esc_html_e('Comments', 'grandtour' );
					    				}
				    				?>
				    			</a>
				    		</span>
						</div>
			    	<div class="post_header_title">
				    	<h5><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
			    	</div>
			    </div>
					
			    <br class="clear"/>
			    
			    <?php
			    	$tg_blog_display_full = kirki_get_option('tg_blog_display_full');
			    	
			    	if(!empty($tg_blog_display_full))
			    	{
			    		the_content();
			    	}
			    	else
			    	{
			    		the_excerpt();
			    	}
			    ?>
			    <div class="post_button_wrapper">
			    	<a class="readmore" href="<?php the_permalink(); ?>"><?php echo esc_html_e('Read More', 'grandtour' ); ?><span class="ti-angle-right"></span></a>
			    </div>
			</div>
	    </div>
	    
	</div>

</div>
<br class="clear"/>
<!-- End each blog post -->

<?php endwhile; endif; ?>

    	<?php
		    if($wp_query->max_num_pages > 1)
		    {
		    	if (function_exists("grandtour_pagination")) 
		    	{
		    	    grandtour_pagination($wp_query->max_num_pages);
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
		   
		   wp_reset_postdata();
		?>
    		
    	</div>
    	
    </div>
    <!-- End main content -->

</div>  
</div>
<?php get_footer(); ?>