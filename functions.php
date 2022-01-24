<?php
require_once('abra.php');
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if ( !function_exists( 'wpestate_chld_thm_cfg_parent_css' ) ):
   function wpestate_chld_thm_cfg_parent_css() {

    $parent_style = 'wpestate_style'; 
    wp_enqueue_style('bootstrap',get_template_directory_uri().'/css/bootstrap.css', array(), '1.0', 'all');
    wp_enqueue_style('bootstrap-theme',get_template_directory_uri().'/css/bootstrap-theme.css', array(), '1.0', 'all');
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css',array('bootstrap','bootstrap-theme'),'all' );
    wp_enqueue_style( 'wpestate-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
	 
    wp_enqueue_script('ajaxcalls_add', trailingslashit( get_stylesheet_directory_uri() ).'js/ajaxcalls_addnew.js',array('jquery'), '1.0', true);
    wp_enqueue_script('custom-fields-front', trailingslashit( get_stylesheet_directory_uri() ).'js/custom-fields-front.js',array('jquery'), '1.0', true);
    wp_enqueue_script('jcookie', trailingslashit( get_stylesheet_directory_uri() ).'js/jquery.cookie.js',array('jquery'), '1.0', true);
    wp_enqueue_script('js-fav', trailingslashit( get_stylesheet_directory_uri() ).'js/js-fav.js',array('jquery'), '1.0', true);
    wp_enqueue_script('js-lazy', trailingslashit( get_stylesheet_directory_uri() ).'js/lazy-js.js',array('jquery'), '1.0', true);
    
    wp_enqueue_script( 'ajaxcalls', get_stylesheet_directory_uri() . '/js/open-phone.js', array(), '1.0.0', true );

    wp_enqueue_script( 'wpestate_mapfunctions_base2', get_stylesheet_directory_uri() . '/js/google_js/maps_base.js', array(), '1.0.0', true );

    wp_localize_script( 'ajaxcalls', 'ajax_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'ajaxnonce' => wp_create_nonce( 'ajax_post_validation' )
    ) );

   }    
    
endif;
add_action( 'wp_enqueue_scripts', 'wpestate_chld_thm_cfg_parent_css' );
load_child_theme_textdomain('wprentals', get_stylesheet_directory().'/languages');
// END ENQUEUE PARENT ACTION
// Создаём шорткод [year] при вставление в текст 
// будет выводить текущий код

add_shortcode( 'year', 'sc_year' );
function sc_year(){
    return date( 'Y' );
}

add_filter( 'single_post_title', 'my_shortcode_title' );
add_filter( 'the_title', 'my_shortcode_title' );
function my_shortcode_title( $title ){
    return do_shortcode( $title );
}

/// Считаем сколько раз открыли телефон
function custom_update_post() {
    $post_id = $_POST['post_id'];
    $test = get_post_meta($_POST['post_id'], 'open-phone', true);
    $test += 1;
    update_post_meta( $post_id, 'open-phone', $test );
    cema93_faq_hook_js();
    wp_die();
}

add_action( 'wp_ajax_custom_update_post', 'custom_update_post' );
add_action ('wp_ajax_nopriv_custom_update_post', 'custom_update_post');

///Создание шорткода для куки
add_shortcode( 'favorites', 'favorites_item' );



function favorites_item( $atts ){


    function forFavor() {
        $newCookie = $_COOKIE["abra2"];

        $array = json_decode($newCookie, true);
        foreach ($array as $elem) {
            $post_title = get_the_title($elem);
            $sea    =   get_post_meta($elem, 'distanceseafilter', true);
            $skidka =   esc_html(get_post_meta($elem, 'skidka', true)); 
            $link = get_permalink($elem);
            $postImage = wp_get_attachment_image_src(get_post_thumbnail_id($elem), 'wpestate_property_featured');
            $comments_count = wp_count_comments( $elem ); //получаем количество комментариев для карточки поста.
            $comments_countResult = $comments_count->total_comments;
            $price = floatval(get_post_meta($elem, 'property_price', true));
            $featured  =   intval  ( get_post_meta($elem, 'prop_featured', true) );
            $postID = $elem;
            $phonePreview = get_post_meta($elem, 'phonepreview', true);
            $property_city      =   get_the_term_list($elem, 'property_city', '', ', ', '') ;
            $property_area      =   get_the_term_list($elem, 'property_area', '', ', ', '');
            $property_action    =   get_the_term_list($elem, 'property_action_category', '', ', ', '');
            $property_categ     =   get_the_term_list($elem, 'property_category', '', ', ', '');
    
    
    
            $ratingfav = do_shortcode("[ratemypost-result id={$elem}] ");
            abra($post_title, $ratingfav, $skidka, $sea, $link, 
            $postImage, $comments_countResult, $price, $featured, 
            $postID, $phonePreview, $property_city, $property_area, $property_action, $property_categ);
    
        }
    }

    print "<div class='favor-new'>";
        forFavor();
    print "</div>";


}

// remove dashicons
function wpdocs_dequeue_dashicon() {
    if (current_user_can( 'update_core' )) {
        return;
    }
    wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' ); 

///Заголовок поиска
function wpseo_title_hook($title)
{
$catName = $_GET["property_category"];
$priceLow = $_GET["price_low"];
$priceMax = $_GET["price_max"];

if($catName === 'bazy-otdyha') {
    $catName = 'Базы отдыха';
} else if($catName === 'villy') {
    $catName = 'Виллы';
} else if($catName === 'gostiniczy') {
    $catName = 'Гостиницы';
} else if($catName === 'kvartiry') {
    $catName = 'Квартиры';
}else if($catName === 'oteli') {
    $catName = 'Отели';
}else if($catName === 'pansionaty') {
    $catName = 'Пансионаты';
}else if($catName === 'usadby') {
    $catName = 'Усадьбы';
} else if($catName === '') {
    $catName = 'Усадьбы';
}

    if(is_page(7)) {
        return 'Железный Порт ' . $catName . ' цена от '. $priceLow .' грн до '. $priceMax. ' грн и 5-10 мин до моря';
    } else {
        return $title;
    }
}

add_filter('wpseo_title', 'wpseo_title_hook', 10, 1);
