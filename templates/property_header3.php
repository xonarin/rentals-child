<?php
global $post;
global $property_action_terms_icon;
global $property_action;
global $property_category_terms_icon;
global $property_category;
global $guests;
global $preview;
global $bedrooms;
global $bathrooms;
global $favorite_text;
global $favorite_class;
global $wpestate_options;
$rental_type=wprentals_get_option('wp_estate_item_rental_type');
$post_title = get_the_title($post->ID);
$property_area      = get_the_term_list($post->ID, 'property_area', '', ', ', '');
$property_address   = esc_html(get_post_meta($post->ID, 'property_address', true));
$price              =   get_post_meta($post->ID, 'property_price', true);
$phonepreview              =   get_post_meta($post->ID, 'phonepreview', true);
$phonePreviewResult = mb_substr($phonepreview, 0, 8);
$viber              =   get_post_meta($post->ID, 'viber', true);
$viberResult = mb_substr($viber, 0, 8);
$telegram              =   get_post_meta($post->ID, 'telegram', true);
$telegramResult = mb_substr($viber, 0, 8);
$website              =   get_post_meta($post->ID, 'website', true);
$distancesea              =   get_post_meta($post->ID, 'distancesea', true);
$skidka     =   esc_html(get_post_meta($post->ID, 'skidka', true)); 


?>
  
    
        <div class="property_categs property_header3">
            
           
                <div class="category_wrapper ">
                    <div class="category_details_wrapper">
                        <?php 
                        
                        if(wprentals_get_option( 'wp_estate_use_custom_icon_area') =='yes' ){ 
                            wprentals_icon_bar_design();
                        }else{
                            wprentals_icon_bar_classic($property_action,$property_category,$rental_type,$guests,$bedrooms,$bathrooms);
                        } 
                        ?>
                        
                    </div>
                    
                    <?php echo do_shortcode('[ratemypost]'); ?>
                </div>
                
              
                
                <div  id="listing_description_type3">
                <h1><?php echo $post_title ?></h1>
                <div class="main-info">
                <span class="favoritesnew-span favoritesnew-span-fullpage" title="<?php print esc_attr($fav_mes); ?>" data-postid="<?php print intval($post->ID); ?>"><i class="fas fa-heart"></i></span>

                        <div class="main__info-media">
                            <img src="<?php echo $preview[0]; ?>" alt="<?php echo $post_title ?>" class="main__info-images">
                        
                            <?php


                                if(!$skidka == '') {
                                    echo $skidkaResult = '<div class="skidka-circle skidka-circle-prop">Скидка<span>-' . $skidka . '</span></div>';
                                }
                            
                            ?>
                        </div>

                        <ul class="main__info-list">
                            <li class="main__info-item">
                                <span class="main__info-key">Курорт:</span>
                                <span class="main__info-value">Железный Порт</span>
                            </li>
                            <li class="main__info-item">
                                <span class="main__info-key">Регион:</span>
                                
                                <span class="main__info-value"><?php echo $property_area ?></span>
                            </li>

                            <?php if ($property_address != '') {  ?>
                                <li class="main__info-item">
                                    <span class="main__info-key">Адрес:</span>
                                    <span class="main__info-value"><?php echo $property_address ?></span>
                                </li>
                            <?php } ?>

                            <?php if ($phonepreview != '') {  ?>
                                <li class="main__info-item open-info-block">
                                    <span class="main__info-key">Телефон:</span>
                                    <span class="main__info-value">
                                        <span class="phone_card-info" data-phonecard="<?php echo $post->ID ?>"><?php echo $phonePreviewResult ?></span>
                                        <a href="#" id="<?php echo $post->ID ?>" class="show_phone phone-count" data-phoneshow="<?php echo $post->ID ?>" data-fullphone="<?php echo $phonepreview ?>">показать</a>
                                    </span>
                                </li>
                            <?php } ?>

                            <?php if ($viber != '') {  ?>
                                <li class="main__info-item open-info-block">
                                    <span class="main__info-key">Viber:</span>
                                    <span class="main__info-value">
                                        <span class="phone_card-info" data-phonecard="<?php echo $post->ID ?>"><?php echo $viberResult ?></span>
                                        <a href="#" id="<?php echo $post->ID ?>" class="show_phone phone-count" data-phoneshow="<?php echo $post->ID ?>" data-fullphone="<?php echo $viber ?>">показать</a>
                                    </span>
                                </li>
                            <?php } ?>

                            <?php if ($telegram != '') {  ?>
                                <li class="main__info-item open-info-block">
                                    <span class="main__info-key">Telegram:</span>
                                    <span class="main__info-value">
                                        <span class="phone_card-info" data-phonecard="<?php echo $post->ID ?>"><?php echo $telegramResult ?></span>
                                        <a href="#" id="<?php echo $post->ID ?>" class="show_phone phone-count" data-phoneshow="<?php echo $post->ID ?>" data-fullphone="<?php echo $telegram ?>">показать</a>
                                    </span>
                                </li>
                            <?php } ?>

                            <?php if ($website != '') {  ?>
                                <li class="main__info-item">
                                    <span class="main__info-key">Web-сайт:</span>
                                    <span class="main__info-value"><?php echo $website ?></span>
                                </li>
                            <?php } ?>

                            <?php if ($distancesea != '') {  ?>
                                <li class="main__info-item">
                                    <span class="main__info-key">Расстояние до моря:</span>
                                    <span class="main__info-value"><?php echo $distancesea ?></span>
                                </li>
                            <?php } ?>

                            <li class="main__info-item">
                                <span class="main__info-key">Цена от:</span>
                                <span class="main__info-value"><?php echo $price ?> грн.</span>
                            </li>

                            <li class="main__info-item">
                                <span class="main__info-key">Количество просмотров:</span>
                                <span class="main__info-value"><?php echo do_shortcode('[post-views]'); ?></span>
                            </li>

                            <li class="main__info-item">
                                <span class="main__info-key">Последнее обновление:</span>
                                <span class="main__info-value"><?php the_date('j F Y H:i:s'); ?></span>
                            </li>
                            <li class="main__info-item">
                                <span class="main__info-key">ID:</span>
                                <span class="main__info-value"><?php echo $post->ID ?></span>
                            </li>
                        </ul>
                    </div>


                <?php
                    $content = get_the_content();
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    $wpestate_property_description_text         =  wprentals_get_option('wp_estate_property_description_text');
                    if (function_exists('icl_translate') ){
                        $wpestate_property_description_text     =   icl_translate('wprentals','wp_estate_property_description_text', esc_html( wprentals_get_option('wp_estate_property_description_text') ) );
                    }
                    
                    if($content!=''){   
                        print '<h4 id="listing_description" class="panel-title-description">'.esc_html($wpestate_property_description_text).'</h4>';
                        print '<div itemprop="description" id="listing_description_content"   class="panel-body">'.$content;
                            get_template_part ('/templates/download_pdf');
                        print '</div>'; //escaped above      
                    }
                ?>

                
            </div>        
                  
    
    <?php  
        $post_id=$post->ID; 
        $guest_no_prop ='';
        if(isset($_GET['guest_no_prop'])){
            $guest_no_prop = intval($_GET['guest_no_prop']);
        }
        $guest_list= wpestate_get_guest_dropdown('noany');
    ?>

   
    
    
    
    
     </div>
     <?php 
                
    $images = get_field('galereya');
    $i = 1;
    $currentIndex = 0;
    if( $images['gallery'] ): ?>
        <?php if (count($images['gallery']) >= 6) { ?>
            <h2 class="gallery-title">Фотогалерея <?php echo $post_title ?></h2>
            <ul class="properties-gallery">
                
                <?php foreach( $images['gallery'] as  $image ): 
                    
                if($currentIndex > 4) {
                ?>
                    

                    <li class="properties-gallery__item">
                        <a href="<?php echo esc_url($image['url']); ?>" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="" class="fancybox-thumb prettygalery">
                            <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo ''.$post_title.' фото '.$i.'' ?>" />
                        </a>
                    </li>
                <?php } else {  ?>
                    <li class="properties-gallery__item" style="display:none">
                        <a href="<?php echo esc_url($image['url']); ?>" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="" class="fancybox-thumb prettygalery">
                            <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo ''.$post_title.' фото '.$i.'' ?>" />
                        </a>
                    </li>
                
                <?php }
                
                $i++; $currentIndex++; endforeach; ?>
            </ul>
        <?php } ?>
    <?php endif; ?>

    <!-- Галерея 2  -->
    <?php 
    
    $images = get_field('galereya_2');
    $i = 1;
    if( $images['gallery'] ): ?>
        <h2 class="gallery-title"><?php echo $images['zagolovok_galerei'] ?></h2>
        <ul class="properties-gallery">
            
            <?php foreach( $images['gallery'] as  $image ): ?>
                <li class="properties-gallery__item">
                    <a href="<?php echo esc_url($image['url']); ?>" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="" class="fancybox-thumb prettygalery">
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo ''.$post_title.' фото '.$i.'' ?>" />
                    </a>
                </li>
            <?php $i++; endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Галерея 3  -->
    <?php 
    
    $images = get_field('galereya_3');
    $i = 1;
    if( $images['gallery'] ): ?>
        <h2 class="gallery-title"><?php echo $images['zagolovok_galerei'] ?></h2>

        <ul class="properties-gallery">
            
            <?php foreach( $images['gallery'] as  $image ): ?>
                <li class="properties-gallery__item">
                    <a href="<?php echo esc_url($image['url']); ?>" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="" class="fancybox-thumb prettygalery">
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo ''.$post_title.' фото '.$i.'' ?>" />
                    </a>
                </li>
            <?php $i++; endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Галерея 4  -->
    <?php 
    
    $images = get_field('galereya_4');
    $i = 1;
    if( $images['gallery'] ): ?>
        <h2 class="gallery-title"><?php echo $images['zagolovok_galerei'] ?></h2>

        <ul class="properties-gallery">
            
            <?php foreach( $images['gallery'] as  $image ): ?>
                <li class="properties-gallery__item">
                    <a href="<?php echo esc_url($image['url']); ?>" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="" class="fancybox-thumb prettygalery">
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo ''.$post_title.' фото '.$i.'' ?>" />
                    </a>
                </li>
            <?php $i++; endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Галерея 5 -->
    <?php 
    
    $images = get_field('galereya_5');
    $i = 1;
    if( $images['gallery'] ): ?>
        <h2 class="gallery-title"><?php echo $images['zagolovok_galerei'] ?></h2>

        <ul class="properties-gallery">
            
            <?php foreach( $images['gallery'] as  $image ): ?>
                <li class="properties-gallery__item">
                    <a href="<?php echo esc_url($image['url']); ?>" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="" class="fancybox-thumb prettygalery">
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo ''.$post_title.' фото '.$i.'' ?>" />
                    </a>
                </li>
            <?php $i++; endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Галерея 6 -->
    <?php 
    
    $images = get_field('galereya_6');
    $i = 1;
    if( $images['gallery'] ): ?>
        <h2 class="gallery-title"><?php echo $images['zagolovok_galerei'] ?></h2>

        <ul class="properties-gallery">
            
            <?php foreach( $images['gallery'] as  $image ): ?>
                <li class="properties-gallery__item">
                    <a href="<?php echo esc_url($image['url']); ?>" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="" class="fancybox-thumb prettygalery">
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo ''.$post_title.' фото '.$i.'' ?>" />
                    </a>
                </li>
            <?php $i++; endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Галерея 7 -->
    <?php 
    
    $images = get_field('galereya_7');
    $i = 1;
    if( $images['gallery'] ): ?>
        <h2 class="gallery-title"><?php echo $images['zagolovok_galerei'] ?></h2>

        <ul class="properties-gallery">
            
            <?php foreach( $images['gallery'] as  $image ): ?>
                <li class="properties-gallery__item">
                    <a href="<?php echo esc_url($image['url']); ?>" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="" class="fancybox-thumb prettygalery">
                        <img src="<?php echo esc_url($image['sizes']['thumbnail']); ?>" alt="<?php echo ''.$post_title.' фото '.$i.'' ?>" />
                    </a>
                </li>
            <?php $i++; endforeach; ?>
        </ul>
    <?php endif; ?>