<?php
/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}


//Get Page Menu Transparent Option
$page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);

//Get page header display setting
$page_title = get_the_title();
$page_show_title = get_post_meta($current_page_id, 'page_show_title', true);

if(is_tag())
{
	$page_show_title = 0;
	$page_title = single_cat_title( '', false );
	$term = 'tag';
} 
elseif(is_category())
{
    $page_show_title = 0;
	$page_title = single_cat_title( '', false );
	$term = 'category';
}
elseif(is_archive())
{
	$page_show_title = 0;

	if ( is_day() ) : 
		$page_title = get_the_date(); 
    elseif ( is_month() ) : 
    	$page_title = get_the_date('F Y'); 
    elseif ( is_year() ) : 
    	$page_title = get_the_date('Y'); 
    elseif ( !empty($term) ) : 
    	$ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    	$page_taxonomy = get_taxonomy($ob_term->taxonomy);
    	$page_title = $ob_term->name;
    else :
    	$page_title = esc_html__('Blog Archives', 'grandtour'); 
    endif;
    
    $term = 'archive';
    
}
else if(is_search())
{
	$page_show_title = 0;
	$page_title = esc_html__('Search', 'grandtour' );
	$term = 'search';
}

$grandtour_page_content_class = grandtour_get_page_content_class();

$grandtour_hide_title = grandtour_get_hide_title();
if($grandtour_hide_title == 1)
{
	$page_show_title = 1;
}

$grandtour_screen_class = grandtour_get_screen_class();
if($grandtour_screen_class == 'split' OR $grandtour_screen_class == 'single_client')
{
	$page_show_title = 0;
}
if($grandtour_screen_class == 'single_client')
{
	$page_show_title = 1;
}

if(empty($page_show_title))
{
	//Get current page tagline
	$page_tagline = get_post_meta($current_page_id, 'page_tagline', true);
	
	if(is_category())
	{
		$page_tagline = category_description();
	}
	
	if(is_tag())
	{
		$page_tagline = category_description();
	}
	
	if(is_archive() && !is_category() && !is_tag() && empty($term))
	{
		$page_tagline = esc_html__('Archive posts in ', 'grandtour' );
		
		if ( is_day() ) : 
			$page_tagline.= get_the_date(); 
	    elseif ( is_month() ) : 
	    	$page_tagline.= get_the_date('F Y'); 
	    elseif ( is_year() ) : 
	    	$page_tagline.= get_the_date('Y');
	    endif;
	}
	
	//If on gallery post type page
	if(is_single() && $post->post_type == 'galleries')
	{
		$page_tagline = get_the_excerpt();
	}
	
	if(is_search())
	{
		$page_tagline = esc_html__('Search Results for ', 'grandtour' ).get_search_query();
	}
	
	if(!empty($term) && !is_tag() && !is_search())
	{
		$ob_term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$page_tagline = $ob_term->description;
	}

	$pp_page_bg = '';
	
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'original') && empty($term))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'original', true);
        
        if(isset($image_thumb[0]) && !empty($image_thumb[0]))
        {
        	$pp_page_bg = $image_thumb[0];
        }
    }
    elseif(!empty($term) && function_exists('z_taxonomy_image_url'))
    {
	    $pp_page_bg = z_taxonomy_image_url();
	    $tg_page_header_bg_parallax = 0;
    }
    
    //Check if add parallax effect
	$tg_page_header_bg_parallax = kirki_get_option('tg_page_header_bg_parallax');
	
	$grandtour_topbar = grandtour_get_topbar();
	$page_header_type = '';
	
	if(is_page())
	{
		//Get header featured content
		$page_header_type = get_post_meta(get_the_ID(), 'page_header_type', true);
		
		$video_url = '';
					
		if($page_header_type == 'Youtube Video' OR $page_header_type == 'Vimeo Video')
		{
			//Add jarallax video script
			wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
			
			if($page_header_type == 'Youtube Video')
			{
				$page_header_youtube = get_post_meta(get_the_ID(), 'page_header_youtube', true);
				$video_url = 'https://www.youtube.com/watch?v='.$page_header_youtube;
			}
			else
			{
				$page_header_vimeo = get_post_meta(get_the_ID(), 'page_header_vimeo', true);
				$video_url = 'https://vimeo.com/'.$page_header_vimeo;
			}
		}
	}
	elseif(isset($post->post_type) && $post->post_type == 'destination')
	{
		//Get header featured content
		$page_header_type = get_post_meta(get_the_ID(), 'destination_header_type', true);
		
		$video_url = '';
					
		if($page_header_type == 'Youtube Video' OR $page_header_type == 'Vimeo Video')
		{
			//Add jarallax video script
			wp_enqueue_script("jarallax-video", get_template_directory_uri()."/js/jarallax-video.js", false, GRANDTOUR_THEMEVERSION, true);
			
			if($page_header_type == 'Youtube Video')
			{
				$page_header_youtube = get_post_meta(get_the_ID(), 'destination_header_youtube', true);
				$video_url = 'https://www.youtube.com/watch?v='.$page_header_youtube;
			}
			else
			{
				$page_header_vimeo = get_post_meta(get_the_ID(), 'destination_header_youtube', true);
				$video_url = 'https://vimeo.com/'.$page_header_vimeo;
			}
		}
	}
        
        $shortcode = get_field( 'banner_image', get_the_ID() );
        if($shortcode != ''){
            echo do_shortcode($shortcode);
        }else{
?>

<div id="page_caption" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php if(!empty($tg_page_header_bg_parallax)) { ?>parallax<?php } ?> <?php } ?> <?php if(!empty($grandtour_topbar)) { ?>withtopbar<?php } ?> <?php if(!empty($grandtour_screen_class)) { echo esc_attr($grandtour_screen_class); } ?> <?php if(!empty($grandtour_page_content_class)) { echo esc_attr($grandtour_page_content_class); } ?>" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url(<?php echo esc_url($pp_page_bg); ?>);"<?php } ?> <?php if($page_header_type == 'Youtube Video' OR $page_header_type == 'Vimeo Video') { ?>data-jarallax-video="<?php echo esc_url($video_url); ?>"<?php } ?>>

	<?php
		//Check page title vertical alignment
		$tg_page_title_vertical_alignment = kirki_get_option('tg_page_title_vertical_alignment');
		if($tg_page_title_vertical_alignment == 'center')
		{	
	?>
		<div class="overlay_background visible"></div>
	<?php
		}
	?>

	<div class="page_title_wrapper">
		<div class="page_title_inner">
			<div class="page_title_content">
				<!-- <h1><?php the_title(); ?></h1> -->
				<div class="post_detail single_post">
					<!-- <span class="post_info_date">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php //echo date_i18n(GRANDTOUR_THEMEDATEFORMAT, get_the_time('U')); ?></a>
					</span> -->
					
				</div>
			</div>
		</div>
	</div>

</div>
<?php
        }
    
}
?>
<div class="breadcrumbs" typeof="BreadcrumbList" vocab="http://schema.org/">
	<div class="custom-container">
		<?php if(function_exists('bcn_display'))
		{
			
		global $post;
		//echo "POST ID=".$post->ID."<br>";
		$category_detail=get_the_category($post->ID);//$post->ID
		
		foreach($category_detail as $cd){
			if($cd->slug=='blogs'){				
				$cat=$cd->slug;
			}		
		}
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		if($cat=='blogs'){
			$u=site_url().'/blogs/';		
			if($actual_link==$u){
				wp_redirect($u);				
				/*$c='';
				$c.='<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to Flagstone Travel." href="'.site_url().'" class="home"><span property="name">Home</span></a><meta property="position" content="1"></span> > ';
				$c.='<span class="archive post-properties-archive current-item">blogs</span>';
				echo $c;*/
			}else{		
				$c.='<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to Flagstone Travel." href="'.site_url().'" class="home"><span property="name">Home</span></a><meta property="position" content="1"></span> > ';				
				$c.='<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to the Blogs category archives." href="'.site_url().'/blogs/" class="taxonomy category"><span property="name">Blogs</span></a><meta property="position" content="2"></span> > ';
				$c.='<span class="post post-post current-item">'.get_the_title().'</span>';
				echo $c;
			}
			
		}else{
			bcn_display();
			}
		}
		?>
	</div>
</div>
<!-- Begin content -->
<?php
$grandtour_page_content_class = grandtour_get_page_content_class();
?>
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg <?php } ?><?php if(!empty($pp_page_bg) && !empty($grandtour_topbar)) { ?>withtopbar <?php } ?><?php if(!empty($grandtour_page_content_class)) { echo esc_attr($grandtour_page_content_class); } ?>">
