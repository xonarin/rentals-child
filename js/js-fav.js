function favor() {
    

if (typeof jQuery.cookie('abra2') !== 'undefined') {
    var storedAry = JSON.parse(jQuery.cookie('abra2'));
    var countArray = storedAry.length;
    jQuery( ".hearth-favorites span" ).text(countArray);
    
     jQuery.each(storedAry, function(index, value){
        jQuery('[data-postid="'+ value +'"]').addClass('favoritesnew-span-active');
     });
        
    }
    
    jQuery(".favoritesnew-span").click(function(){
        if (typeof jQuery.cookie('abra2') === 'undefined'){
            var cookArray = [];
            var newDate = jQuery(this).attr('data-postid');
            var newDate2 = +newDate;
            cookArray.unshift(newDate2);
            console.log(cookArray);
            jQuery.cookie('abra2', JSON.stringify(cookArray), { expires: 365, path: '/' });
    
            if(jQuery(this).hasClass('favoritesnew-span-active')) {
                jQuery(this).removeClass( 'favoritesnew-span-active' );
            } else {
                jQuery(this).addClass( 'favoritesnew-span-active' );
            }
    
            var storedAry = JSON.parse(jQuery.cookie('abra2'));
            var countArray = storedAry.length;
            jQuery( ".hearth-favorites span" ).text(countArray);
    
        } else {
            if(jQuery(this).hasClass('favoritesnew-span-active')) {
                jQuery(this).removeClass( 'favoritesnew-span-active' );
            } else {
                jQuery(this).addClass( 'favoritesnew-span-active' );
            }
             
            var storedAry = JSON.parse(jQuery.cookie('abra2'));
            var newDate = jQuery(this).attr('data-postid');
            var newDate2 = +newDate;
            let check = storedAry.some(function(elem) {
                if (elem == newDate2) {
                    return true;
                } else {
                    return false;
                }
            });
    
           console.log('check' + ' ' + check);
    
            if(check) {
                var deleteElement = storedAry.indexOf(newDate2);
                storedAry.splice(deleteElement, 1);
                jQuery.cookie('abra2', JSON.stringify(storedAry), { expires: 365, path: '/' });
    
            } else {
                console.log('Такого нет');
                storedAry.unshift(newDate2);
                jQuery.cookie('abra2', JSON.stringify(storedAry), { expires: 365, path: '/' });
            }
    
    
            var newnew = JSON.parse(jQuery.cookie('abra2'));
    
            console.log(newnew);
            var storedAry = JSON.parse(jQuery.cookie('abra2'));
            var countArray = storedAry.length;
            jQuery( ".hearth-favorites span" ).text(countArray);
        }
    });
    
    jQuery('.favoritesnew-span').on('click', function(){
        if (jQuery(window).width() > 1180){
        if(jQuery(this).hasClass( 'favoritesnew-span-active' )) {
        var that = jQuery(this).closest('.listing_wrapper').find('.wp-post-image');
        var bascket = jQuery(".desctop-hearth");
        var w = that.width();
        
           that.clone()
               .css({'width' : w,
            'position' : 'absolute',
            'z-index' : '9999',
            top: that.offset().top,
            left:that.offset().left})
               .appendTo("body")
               .animate({opacity: 0.05,
                   left: bascket.offset()['left'],
                   top: bascket.offset()['top'],
                   width: 20}, 1000, function() {	
                    jQuery(this).remove();
                });
        }
    }
    
    });
}

favor();

jQuery('#listing_ajax_container').bind("DOMSubtreeModified",function(){
    favor();
})