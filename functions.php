<?php
require_once('abra.php');
require_once('widget_skidka.php');
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
    if ( is_page( 567 ) ) {
		wp_enqueue_script('custom-fields-front', trailingslashit( get_stylesheet_directory_uri() ).'js/custom-fields-front.js',array('jquery'), '1.0', true);
	}
	
    wp_enqueue_script('jcookie', trailingslashit( get_stylesheet_directory_uri() ).'js/jquery.cookie.js',array('jquery'), '1.0', true);
    wp_enqueue_script('js-fav', trailingslashit( get_stylesheet_directory_uri() ).'js/js-fav.js',array('jquery'), '1.0', true);
    wp_enqueue_script('js-lazy', trailingslashit( get_stylesheet_directory_uri() ).'js/lazy-js.js',array('jquery'), '1.0', true);
    
    wp_enqueue_script( 'ajaxcalls', get_stylesheet_directory_uri() . '/js/open-phone.js', array(), '1.0.0', true );

    wp_localize_script( 'ajaxcalls', 'ajax_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'ajaxnonce' => wp_create_nonce( 'ajax_post_validation' )
    ) );

   }    
    
endif;
add_action( 'wp_enqueue_scripts', 'wpestate_chld_thm_cfg_parent_css' );
load_child_theme_textdomain('wprentals', get_stylesheet_directory().'/languages');
// END ENQUEUE PARENT ACTION


wp_register_style( 'tinymce_stylesheet', '/wp-includes/css/editor.min.css' );
wp_register_style( 'tinymce_themel', '/wp-includes/js/tinymce/skins/lightgray/skin.min.css' );
wp_register_style( 'acf-pro-global', '/wp-content/plugins/advanced-custom-fields-pro/assets/build/css/acf-global.css' );
wp_register_style( 'acf-input', '/wp-content/plugins/advanced-custom-fields-pro/assets/build/css/acf-input.css' );
wp_register_style( 'acf-pro-input', '/wp-content/plugins/advanced-custom-fields-pro/assets/build/css/pro/acf-pro-input.css' );
wp_register_style( 'mediaelement', '/wp-includes/js/mediaelement/mediaelementplayer-legacy.min.css' );
wp_register_style( 'wp-mediaelement', '/wp-includes/js/mediaelement/wp-mediaelement.min.css' );
wp_register_style( 'medianewviews', '/wp-includes/css/media-views.min.css' );
wp_register_script('remove-form-gallery', trailingslashit( get_stylesheet_directory_uri() ).'js/remove-form-gallery.js',array('jquery'), '1.0', true);


//Editor Stylesheet for Deck Submit
function editor_send_deck() {
    // only enqueue on specific page slug
    if ( is_page( 567 ) ) {
        wp_enqueue_style( 'tinymce_stylesheet' );
		wp_enqueue_style( 'tinymce_themel' );
		wp_enqueue_style( 'acf-pro-global' );
		wp_enqueue_style( 'acf-input' );
		wp_enqueue_style( 'acf-pro-input' );
		wp_enqueue_style( 'mediaelement' );
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_style( 'medianewviews' );
		wp_enqueue_script( 'remove-form-gallery' );
    }
}
add_action( 'wp_enqueue_scripts', 'editor_send_deck' );



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

//Тестовый шорткод
add_shortcode( 'widget_hotel', 'widget_hotel' );
function widget_hotel( $atts ){
	$args = shortcode_atts( 
		array( // в массиве укажите значения параметров по умолчанию
			'total' => '5', // количество по умолчанию
			'lang' => 'ru', // язык выборки
			'category' => 88, //айди категории удобства
			'title' => '', // заголовок виджета
			'title_link' => 'Перейти в категорию', // заголовок виджета
		), 
		$atts 
	);
	
	
	global $wpdb;
	$sqlQuery1 = $wpdb->get_col( "SELECT * FROM `wp_term_relationships`LEFT JOIN wp_postmeta ON (wp_term_relationships.object_id = wp_postmeta.post_id) LEFT JOIN wp_icl_translations ON wp_icl_translations.element_id=wp_postmeta.post_id WHERE `term_taxonomy_id` = {$args[ 'category' ]} AND `language_code` LIKE '{$args[ 'lang' ]}' AND wp_postmeta.meta_key = 'prop_featured' ORDER BY RAND() LIMIT {$args[ 'total' ]}" );
	$sqlQuery2 = $wpdb->get_col( "SELECT * FROM `wp_term_relationships`LEFT JOIN wp_postmeta ON (wp_term_relationships.object_id = wp_postmeta.post_id) LEFT JOIN wp_icl_translations ON wp_icl_translations.element_id=wp_postmeta.post_id WHERE `term_taxonomy_id` = {$args[ 'category' ]} AND `language_code` LIKE '{$args[ 'lang' ]}' AND wp_postmeta.meta_key = 'prop_featured' AND wp_postmeta.meta_value = 1 ORDER BY RAND() LIMIT 2" );
	$newArr = [];
	
	$catid = $args[ 'category' ];
	
	$cat_link = get_category_link( $catid );
	
	foreach($sqlQuery1 as $key => $value) {
		// Порядковый номер элемента 1,2,3 ...
		$position = $key + 1;
		if ($position === 2) {
			// когда подошли элементу с порядковому номеру 2 
			// то сначала push им в массив наше значение
			$newArr[] = $sqlQuery2[0];
		} else if ($position === 4) {
			// когда подошли  номеру 4, то в новом массиве это уже 5-ая позиция
			// тоже сначала push им значение
			$newArr[] = $sqlQuery2[1];
		}
		// Затем всех остальных
		$newArr[] = $value;
	}
	
	print "
		<h4 class='widget__title'>{$args[ 'title' ]}</h4>
		<ul class='widget__list'>
	";
		foreach ($newArr as $id) {
			$post_id= $id;
			if(!is_null($post_id)) {
				widget_skidka($post_id);
			}
		}
	print "</ul>
		<div class='category-all'><a href='$cat_link'>{$args[ 'title_link' ]}</a></div>
	";
	
}

//Шорткод виджет объектов со скидами
//с выбором количества и языка.
//[skidkaWidget total="5" lang="ru"]
add_shortcode( 'skidkaWidget', 'skidka_widget' );
function skidka_widget( $atts ){
	
	$params = shortcode_atts( 
		array( // в массиве укажите значения параметров по умолчанию
			'total' => '5', // количество по умолчанию
			'lang' => 'ru', // язык выборки
			'title' => '', // заголовок виджета
		), 
		$atts 
	);

	global $wpdb;
	
    $skidkaWidget = $wpdb->get_col( "SELECT wp_postmeta.post_id FROM wp_postmeta LEFT JOIN wp_icl_translations ON wp_icl_translations.element_id=wp_postmeta.post_id WHERE `meta_key` LIKE 'skidka' AND `language_code` LIKE '{$params[ 'lang' ]}' AND `meta_value` IS NOT NULL AND `meta_value` <> '' ORDER BY `wp_postmeta`.`meta_value` DESC LIMIT {$params[ 'total' ]}" );

	
	print "
		<h4 class='widget__title'>{$params[ 'title' ]}</h4>
		<ul class='widget__list'>
	";
		foreach ($skidkaWidget as $id) {
			$post_id= $id;
			
			if(!is_null($post_id)) {
				widget_skidka($post_id);
			}
		}
	print "</ul>";
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


///Заголовок поиска
function wpseo_title_hook($title)
{
$catName = $_GET["property_category"];
$priceLow = $_GET["price_low"];
$priceMax = $_GET["price_max"];
$distancesea = $_GET["distancesea"];
	
	
	
if($catName === 'bazy-otdyha') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$catName = 'Базы отдыха';
	} else {
    	$catName = 'Бази відпочинку';
	}
} else if($catName === 'villy') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$catName = 'Виллы';
	} else {
    	$catName = 'Вілли';
	}
} else if($catName === 'gostiniczy') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$catName = 'Гостиницы';
	} else {
    	$catName = 'Готелі';
	}
} else if($catName === 'kvartiry') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$catName = 'Квартиры';
	} else {
    	$catName = 'Квартири';
	}
}else if($catName === 'oteli') {
    $catName = 'Отели';
}else if($catName === 'pansionaty') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$catName = 'Пансионаты';
	} else {
    	$catName = 'Пансіонати';
	}
}else if($catName === 'usadby') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$catName = 'Усадьбы';
	} else {
    	$catName = 'Садиби';
	}
} else if($catName === '') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$catName = 'отели, квартиры, усадьбы, виллы для отдыха';
	} else {
    	$catName = 'готелі, квартири, садиби, вілли для відпочинку';
	}
}

if($distancesea === 'на берегу') {
	if (ICL_LANGUAGE_CODE == 'ru') {
		$distancesea = 'на берегу';
	} else {
    	$distancesea = 'на березі';
	}
} else if($distancesea === ' 1-5 мин') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$distancesea = '1-5 мин до моря';
	} else {
    	$distancesea = '1-5 хв до моря';
	}
} else if($distancesea === ' 5-10 мин') {
	if (ICL_LANGUAGE_CODE == 'ru') {
		$distancesea = '5-10 мин до моря';
	} else {
    	$distancesea = '5-10 хв до моря';
	}
} else if($distancesea === ' 10-15 мин') {
	if (ICL_LANGUAGE_CODE == 'ru') {
		$distancesea = '10-15 мин до моря';
	} else {
    	$distancesea = '10-15 хв до моря';
	}

} else if($distancesea === ' 15-20 мин') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$distancesea = '15-20 мин до моря';
	} else {
    	$distancesea = '15-20 хв до моря';
	}
} else if($distancesea === '') {
	if (ICL_LANGUAGE_CODE == 'ru') {
    	$distancesea = 'у моря';
	} else {
    	$distancesea = 'біля моря';
	}
}

    if(is_page(7)) {
        return 'Железный Порт ' . $catName . ' цена от '. $priceLow .' грн до '. $priceMax. ' грн и ' . 	$distancesea . '';
    } else if(is_page(56960)) {
        return 'Залізний порт ' . $catName . ' ціна від '. $priceLow .' грн до '. $priceMax. ' грн та ' . 	$distancesea . '';
    } else {
        return $title;
    }
}

add_filter('wpseo_title', 'wpseo_title_hook', 10, 1);



//Отключаем поле веб-сайта в комментариях
function sheens_unset_url_field ( $fields ) {
 if ( isset( $fields['url'] ) )
 unset ( $fields['url'] );
 return $fields;
}
add_filter( 'comment_form_default_fields', 'sheens_unset_url_field' );

//дублируем комментарии на все языки
/*global $sitepress;

remove_filter( 'comments_clauses', array( $sitepress, 'comments_clauses' ), 10, 2 );

add_action( 'pre_get_comments', function( $c ){
    if( !is_admin() ) {
        $id = [];
        $languages = apply_filters( 'wpml_active_languages', '' );
        if( 1 < count( $languages ) ){
            foreach( $languages as $l ){
                $id[] = apply_filters( 'wpml_object_id', $c->query_vars['post_id'], 'page', FALSE, $l['code'] );
            }
        }
        $c->query_vars['post_id'] = '';
        $c->query_vars['post__in'] = $id;
        return $c;
    }
} );
*/

///Скрип для админ панели, для удаления изображений с галереи и сразу с вкладки изображений темы

function my_enqueue($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    if ('post.php' !== $hook) {
        return;
    }
    wp_enqueue_script('my_custom_script', trailingslashit( get_stylesheet_directory_uri() ). '/js/adm-gallery-remove.js');
	wp_enqueue_style( 'adm-style', get_stylesheet_directory_uri() . '/css/admin-css-style.css',array(),'all' );
}

add_action('admin_enqueue_scripts', 'my_enqueue');

///Редирект не админов с главной

function only_admin()
{
if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
                wp_redirect( '/my-listings/' );
    }
}
add_action( 'admin_init', 'only_admin', 1 );

//Запрещает редакторам удалять медиа
add_action('delete_attachment', 'DontDeleteMedia', 11, 1);
function DontDeleteMedia($postID)
{

	if (!current_user_can('administrator')) { // роли 
		exit('You cannot delete media.');
	}
}

//Запрещаем ссылки в комментариях
// ЗАПРЕТ ССЫЛОК В КОММЕНТАХ
function remove_link_comment($link_text) {
return strip_tags($link_text);
}
add_filter('pre_comment_content','remove_link_comment');
add_filter('comment_text','remove_link_comment');



/////Продлить сессию администратора до 20 дней если установлена галочка "Запомнить меня" и до 5 дней если не установлена.
add_filter( 'auth_cookie_expiration',  'cookie_expiration_new', 20, 3 );
function cookie_expiration_new ( $expiration, $user_id, $remember ) {
	// Время жизни cookies для администратора
	if ( $remember && user_can( $user_id, 'manage_options' ) ) {
		// Если установлена галочка
		if ( $remember == true ) {
			return 20 * DAY_IN_SECONDS;
		}

		// Если не установлена
		return 5 * DAY_IN_SECONDS;
	}
	// Для всех остальных пользователей
	// Если установлена галочка
	if ( $remember == true ) {
		return 360 * DAY_IN_SECONDS;
	}

	// Если не установлена
	return 180 * DAY_IN_SECONDS;
}

