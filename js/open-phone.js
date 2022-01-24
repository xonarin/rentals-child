jQuery(document).ready( function($) {
    $('.phone-count').on('click', function() {
        var post_id = $(this).attr( 'id' );
        $.ajax({
            type: 'POST',
            url: ajax_object.ajaxurl,
            data: {
                action: 'custom_update_post',
                post_id: post_id
            }
        });
    });
});

function phoneShowClick() {
    let phoneShow = document.querySelectorAll('.show_phone');

    Array.from(phoneShow).forEach(function(item) {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            item.closest('.open-info-block').querySelector('[data-phonecard="'+item.dataset.phoneshow+'"]').textContent = item.dataset.fullphone;
            item.remove();
        })
    }) 
}

phoneShowClick();