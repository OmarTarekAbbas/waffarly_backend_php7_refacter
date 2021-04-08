/*=====================================================================================
 Video Gallery Lightbox
 *====================================================================================*/
$(function(){
    $(document).on('click','.thumbnail',function(e){
        e.preventDefault();
        var videoTitle = $(this).attr('data-video-title');
        var videoSrc = $(this).attr('href');


        var lightbox = $('<div class="lightbox popUp">'+
        '<div class="lightbox-wrapper">'+
        '<div class="close-btn fa fa-times-circle"></div>'+

        '<div class="video-item">'+
        '<h3 class="title">'+videoTitle+'</h3>'+
        '<div class="video-item-wrapper">'+
        '<video controls>'+
        '<source src="'+videoSrc+'" type="video/mp4" />'+
        '</video>'+
        '</div>'+
        '</div>'+
        '<div class="gallery-arrows cf">'+
        '<div class="fa fa-chevron-left prev"></div>'+
        '<div class="fa fa-chevron-right next"></div>'+
        '</div>'+
        '</div>'+
        +'</div>');

        $('body').append(lightbox);
        $('body').addClass('isLightBox');

        $('.close-btn').click(function(){
            $('.lightbox').fadeOut(300).remove();
            $('body').removeClass('isLightBox');
        });


        var prevItem = $(this).parent().prev();

        $(document).on('click','.next',function(){
            var currentVideoSrc = $('.video-item video source').attr('src');
            var currentItem = $('.media-gallery').find('a[href="'+currentVideoSrc+'"]');
            var currentItemLi = currentItem.parent();

            if(currentItemLi.is(':last-child')){
                var nextItem = $('.media-gallery li:first-child');
            }else{
                var nextItem = currentItem.parent().next();
            }
            var nextVideoSrc = nextItem.find('a').attr('href');
            var nextVideoTitle = nextItem.find('a').attr('data-video-title');
            var videoItem = $('.video-item');
            var newVideoItem =  '<h3 class="title">'+nextVideoTitle+'</h3>'+
                                '<div class="video-item-wrapper">'+
                                    '<video controls>'+
                                    '<source src="'+nextVideoSrc+'" type="video/mp4" />'+
                                    '</video>'+
                                '</div>';
            videoItem.html(newVideoItem);
        });//end click

        $(document).on('click','.prev',function(){
            var currentVideoSrc = $('.video-item video source').attr('src');
            var currentItem = $('.media-gallery').find('a[href="'+currentVideoSrc+'"]');
            var currentItemLi = currentItem.parent();

            if(currentItemLi.is(':first-child')){
                var prevItem = $('.media-gallery li:last-child');
            }else{
                var prevItem = currentItem.parent().prev();
            }

            var prevVideoSrc = prevItem.find('a').attr('href');
            var prevVideoTitle = prevItem.find('a').attr('data-video-title');
            var videoItem = $('.video-item');
            var newVideoItem =  '<h3 class="title">'+prevVideoTitle+'</h3>'+
                '<div class="video-item-wrapper">'+
                '<video controls>'+
                '<source src="'+prevVideoSrc+'" type="video/mp4" />'+
                '</video>'+
                '</div>';


            videoItem.html(newVideoItem);
        });//end click
    });


});