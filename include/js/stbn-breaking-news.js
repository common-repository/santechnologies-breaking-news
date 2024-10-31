jQuery(document).ready(function(){
    jQuery(".stbn-breaking-news-header").sticky({topSpacing:0});

    jQuery('.stbn-close-btn').click(function(){
        jQuery('.stbn-breaking-news-footer').slideToggle();
        jQuery('.sticky-wrapper').slideUp(100);
    })
});
