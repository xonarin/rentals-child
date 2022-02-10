<?php

function abra($ftitle, $frating, $fskidka, $fsea, $flink, $fpostImage, $fcomments_countResult, 
            $fprice, $ffeatured, $fpostID, $fphonePreview,
            $fproperty_city, $fproperty_area, $fproperty_action, $fproperty_categ
            )  {


                if ($fproperty_area != '') {
                    $fproperty_area =  trim($fproperty_area).', ';
                }

                $fproperty_city = trim($fproperty_city);


    $propCat = wp_kses_post($fproperty_categ);
    $phonePreviewResult = mb_substr($fphonePreview, 0, 8);
    
    if(!$fskidka == '') {
        $fskidkaResult = '<div class="skidka-circle">Скидка<span>-' . $fskidka . '</span></div>';
    }

    if($ffeatured==1){
        //$ffeatured = '<div class="featured_div">'.esc_html__( 'featured','wprentals').'</div>';
		$ffeatured = '';
    } else {
        $ffeatured = '';
    }



    if($fphonePreview != '') {

        $phoneHtml = '
        <div class="category_tagline phone-preview-block open-info-block">
            <span>
                <i class="fas fa-mobile-alt icone-phones"></i>
                <span class="phone_card-info" data-phonecard="'. $fpostID .'">
                    '. $phonePreviewResult .'
                </span>
            </span>
            <a href="#" id="'. $fpostID .'" class="show_phone phone-count" data-phoneshow="'. $fpostID .'" data-fullphone="'. $fphonePreview .'">показать</a>
        </div>';

    }

    echo "
    <div itemscope='' itemtype='http://schema.org/Product' class='listing_wrapper col-md-6 shortcode-col property_unit_v2  property_flex ' data-org='4' data-listid='40369'>
	<div class='property_listing '>
		<div class='listing-unit-img-wrapper'>
		<h4 class='listing_title_unit listing-new-title'>{$ftitle}</h4>
			{$fskidkaResult}
			<div class='rating-comments_block'> 
            <span class='rating-block'>
                Оценка
                {$frating} 
            </span> 
        <a href='{$flink}#listing_reviews' class='comments-link'>{$fcomments_countResult} отзывов</a> </div>
	<div id='property_unit_carousel_61d8c2c4c922d' class='carousel property_unit_carousel slide  ' data-ride='carousel' data-interval='false'>
		<div class='carousel-inner'>
			<div class='item active'>
				<a href='{$flink}' target='_self'><img itemprop='image' src='{$fpostImage[0]}' class='b-lazy img-responsive wp-post-image lazy-hidden' alt='Железный Порт, частный пансионат «Фортеця»'></a>
			</div>
		</div>
		<a href='{$flink}'> </a>
    </div>
	<div class='price_unit_wrapper'> </div>
	<div class='price_unit price_unit-newcard'>
		<div class='price-card'>Цена от <span>{$fprice}</span> грн.</div>
		<div class='sea-block'>До моря
			<br>{$fsea} мин</div>
	</div>
</div>
{$ffeatured}
<div class='property_status_wrapper'></div>
<div class='title-container'>
	<div class='owner_thumb' style='background-image: url()'></div>
	<div class='category_name'>

        {$phoneHtml}

	</div>
	<div class='property_unit_action'> 
        <span class='favoritesnew-span' onclick='favfav()' title='Добавить в избранного' data-postid='{$fpostID}'>
            <i class='fas fa-heart'></i>
        </span> 
    </div>
</div>
</div>
</div>
    
    ";
}


?>