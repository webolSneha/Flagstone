<?php

//include file 
include_once 'include.php';

//home page widgets and custom post with shortcode
// top header siderbar

if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Top Header',
        'id' => 'top-header',
		'before_widget' => '<div id="%1$s" class="widget sidebar-block %2$s">',
		'after_widget' => '</div> <!-- end .widget -->',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
    ));

// footer side bars

// fotter top siderbars
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Top Left Sidebar',
        'id' => 'footer-top-left-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-top-left-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Top Center sidebar',
        'id' => 'footer-top-center-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-top-center-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Top Right Sidebar',
        'id' => 'footer-top-right-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-top-right-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
));
//footer middle sidebars
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Middle Left Sidebar',
        'id' => 'footer-middle-left-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-middle-left-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Middle Center sidebar',
        'id' => 'footer-middle-center-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-middle-center-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Middle Right Sidebar',
        'id' => 'footer-middle-right-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-middle-right-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
));

//footer bottom sidebars
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Bottom Left Sidebar',
        'id' => 'footer-bottom-left-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-bottom-left-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
    ));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Bottom Center sidebar',
        'id' => 'footer-bottom-center-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-bottom-center-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'Footer Bottom Right Sidebar',
        'id' => 'footer-bottom-right-sidebar',
        'before_widget' => '<div id="%1$s" class="widget sidebar-block footer-bottom-right-sidebar %2$s">',
        'after_widget' => '</div> <!-- end .widget -->',
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>',
));

// holiday type custom post
///////Banner Slider start/////////////////////////
add_action( 'init', 'register_cpt_holiday_type' );

function register_cpt_holiday_type() {

    $labels = array( 
        'name' => _x( 'Holiday_Type', 'holiday_type' ),
        'singular_name' => _x( 'Holiday_Type', 'holiday_type' ),
        'add_new' => _x( 'Add New', 'holiday_type' ),
        'add_new_item' => _x( 'Add New Holiday_Type', 'holiday_type' ),
        'edit_item' => _x( 'Edit Holiday_Type', 'holiday_type' ),
        'new_item' => _x( 'New Holiday_Type', 'holiday_type' ),
        'view_item' => _x( 'View Holiday_Type', 'holiday_type' ),
        'search_items' => _x( 'Search Holiday_Type', 'holiday_type' ),
        'not_found' => _x( 'No Holiday_Type found', 'holiday_type' ),
        'not_found_in_trash' => _x( 'No Holiday_Type found in Trash', 'holiday_type' ),
        'parent_item_colon' => _x( 'Parent Holiday_Type:', 'holiday_type' ),
        'menu_name' => _x( 'Holiday Type', 'holiday_type' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 
        'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-palmtree',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array('slug' => "holiday-types", 'with_front' => false),
        'capability_type' => 'post'
    );

    register_post_type( 'holiday_type', $args );
}
//holiday post type
function holiday_grid(){
$args = array(
        'post_type' => 'holiday_type',
        'posts_per_page' => 9,
        'orderby' => 'menu_order',
        'order' => 'asc'
    );

$holiday_grid_setup = new WP_Query($args);
$res = '
<div class="holiday-grid-wrapper portfolio_filter_wrapper  four_cols masonry">';
foreach ($holiday_grid_setup->posts as $holiday){
$title = get_the_title($holiday->ID);
$holiday_img = get_the_post_thumbnail_url($holiday->ID);
if ( $title ) {     
    $res .='<div class="element  masonry-brick" style="background-image: url('.$holiday_img.');"><a href="'.get_the_permalink($holiday->ID).'"><img src="'.$holiday_img.'" class="masonry-img"/><div class="holiday-title">'.$title.'</div></a></div>';
} }
$res .= '</div>';
return $res;
}
add_shortcode('fg_holiday_grid','holiday_grid');


// Itinerary custom post
///////Itinerary start/////////////////////////
add_action( 'init', 'register_cpt_itinerary' );

function register_cpt_itinerary() {

    $labels = array( 
        'name' => _x( 'Itinerary', 'itinerary' ),
        'singular_name' => _x( 'Itinerary', 'itinerary' ),
        'add_new' => _x( 'Add New', 'itinerary' ),
        'add_new_item' => _x( 'Add New Itinerary', 'itinerary' ),
        'edit_item' => _x( 'Edit Itinerary', 'itinerary' ),
        'new_item' => _x( 'New Itinerary', 'itinerary' ),
        'view_item' => _x( 'View Itinerary', 'itinerary' ),
        'search_items' => _x( 'Search Itinerary', 'itinerary' ),
        'not_found' => _x( 'No Itinerary found', 'itinerary' ),
        'not_found_in_trash' => _x( 'No Itinerary found in Trash', 'itinerary' ),
        'parent_item_colon' => _x( 'Parent Itinerary:', 'itinerary' ),
        'menu_name' => _x( 'Itinerary', 'itinerary' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-location-alt',

        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'itinerary', $args );
}
//holiday post type
function itinerary_grid($atts){
     $atts = shortcode_atts( array(
        'ids' => null,
    ), $atts );

$args1 = array(
        'post_type' => 'itinerary',
        'posts_per_page' => 3,
        'post__in' => explode(',', $atts['ids'] ),
        'orderby' => 'post__in',
        'order' => 'asc'
    );

$itinerary_grid_setup = new WP_Query($args1);
$res1 = '
<div class="itinerary-grid-wrapper classic two_cols portfolio-content section content clearfix">';
foreach ($itinerary_grid_setup->posts as $itinerarybox){
$title = get_the_title($itinerarybox->ID);
$itinerary_img = get_the_post_thumbnail_url($itinerarybox->ID);
$my_post_content = apply_filters('get_the_excerpt', get_post_field('post_excerpt', $itinerarybox->ID));
$itinerary_sub_title = get_field('itinerary_sub_title',$itinerarybox->ID);
$itinerary_price = get_field('itinerary_price',$itinerarybox->ID);
if ( $title ) {     
    $res1 .='
    <div class="full-width-itinerary">
            <div class="one_third">
                <a href="'.get_the_permalink($itinerarybox->ID).'">
                <img src="'.$itinerary_img.'" class="itinerary-img"/>
                </a>
            </div>
            <div class="two_third last">
                <a href="'.get_the_permalink($itinerarybox->ID).'" class="itinerary-title"><h3>'.$title.'</h3></a>
                <h4>'.$itinerary_sub_title.'</h4>
                <h6>Prices from &pound;'.$itinerary_price.' pp</h6>
                <div class="itinerary-content">'.$my_post_content.'</div>
                <div class="read-more-btn"><a href="'.get_the_permalink($itinerarybox->ID).'">Read More <i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
            </div>
    </div>';
} }
$res1 .= '</div>';
return $res1;
}
add_shortcode('fg_itinerary_grid','itinerary_grid');

//body class 
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );


//holiday post type
function destination_grid(){
$desargs = array(
        'post_type' => 'destination',
        'post_parent' => 0,
        'posts_per_page' => 6,
        'orderby' => 'menu_order',
        'order' => 'asc'
    );

$destination_grid_setup = new WP_Query($desargs);
$desres = '
<div class="destination-grid-wrapper portfolio_filter_wrapper gallery grid portrait four_cols">';
foreach ($destination_grid_setup->posts as $destination){
$title = get_the_title($destination->ID);
$destination_img = get_the_post_thumbnail_url($destination->ID);
if ( $title ) {     
    $desres .='<div class="element grid baseline classic4_cols"><a href="'.get_the_permalink($destination->ID).'"><img src="'.$destination_img.'" class="destination-img"/><div class="destination-title">'.$title.'</div></a></div>';
} }
$desres .= '</div>';
return $desres;
}
add_shortcode('fg_destination_grid','destination_grid');





//holiday post type
function destination_child_grid( $atts ) {
    $atts = shortcode_atts( array(
        'id' => null,
        'per_page' => -1,
        'additional_ids'=>0,
        'not_in'=>0,
    ), $atts );
$child_query = new WP_Query(array(
                'post_type' => 'destination',
                'post_parent' => $atts['id'],
                'posts_per_page' => $atts['per_page'],
                'orderby'=> 'title', 
                'order' => 'ASC',
                'post__not_in'=>$atts['not_in'])
        );
$desbres ='';
while ($child_query->have_posts()) : $child_query->the_post();
$desbres .= '
<div class="child-grid">';
$title = get_the_title();
$destination_child_img = get_the_post_thumbnail_url();
    $desbres .='<a href="'.get_the_permalink().'"><img src="'.$destination_child_img.'" class="destination-child-img"/><div class="destination-child-title">'.$title.'</div></a>';
$desbres .= '</div>';
endwhile;

if($atts['additional_ids']){
     $ids = explode(',',$atts['additional_ids']);
     foreach ($ids as $id){
         $desbres .= '<div class="child-grid">
                    <a href="'.get_the_permalink($id).'"><img src="'.get_the_post_thumbnail_url($id).'" class="destination-child-img"/><div class="destination-child-title">'.get_the_title($id).'</div></a>
                 </div>';
     }
     
}

return $desbres;
}

add_shortcode('fg_destination_child_grid','destination_child_grid');


// Properties custom post
///////Properties start/////////////////////////
add_action( 'init', 'register_cpt_properties' );

function register_cpt_properties() {

    $labels = array( 
        'name' => _x( 'Properties', 'properties' ),
        'singular_name' => _x( 'Property', 'property' ),
        'add_new' => _x( 'Add New', 'properties' ),
        'add_new_item' => _x( 'Add New Properties', 'properties' ),
        'edit_item' => _x( 'Edit Properties', 'properties' ),
        'new_item' => _x( 'New Properties', 'properties' ),
        'view_item' => _x( 'View Properties', 'properties' ),
        'search_items' => _x( 'Search Properties', 'properties' ),
        'not_found' => _x( 'No Properties found', 'properties' ),
        'not_found_in_trash' => _x( 'No Properties found in Trash', 'properties' ),
        'parent_item_colon' => _x( 'Parent Properties:', 'properties' ),
        'menu_name' => _x( 'Properties', 'properties' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'category', 'post_tag', 'page-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-building',

        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'properties', $args );
}


add_action( 'wp_footer', function(){ ?>
    <script type="text/javascript">
        document.addEventListener( 'wpcf7mailsent', function( event ) {
           if ( '5265' == event.detail.contactFormId || '5131' == event.detail.contactFormId ) { 
                location = '<?php echo get_home_url(); ?>/thank-you-for-getting-in-touch/';
           }
        }, false );
    </script>
<?php
});

/* override widgets */

function widget_params1( $params ) { 
  if ('Blog Sidebar' === $params[0]['name']) {
      /*echo "<pre>";
    print_r($params);
    print_r($post);
    echo "</pre>";*/
  }
  return $params;
}
add_filter( 'dynamic_sidebar_params', 'widget_params1' );




