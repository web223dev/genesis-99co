(function($) {

    'use strict';

    // Remove the 'no-js' <body> class
    $('html').removeClass('no-js');

    // Enable FitVids on the content area
    fitvids('.content');

    $('.slider .lists-wrapper').slick({
        dots: false,
        infinite: true,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        variableWidth: true,
        nextArrow: '<button class="right"><i class="fa fa-chevron-right"></i></button>',
        prevArrow: '<button class="left"><i class="fa fa-chevron-left"></i></button>',
        fade: false,
        cssEase: 'ease-in-out',
        responsive: [
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    variableWidth: true
                }
            }
        ]
    });

    $('.popular .lists-wrapper, .entry-recommended .lists-wrapper').slick({
        dots: false,
        infinite: true,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 5000,
        nextArrow: '<button class="right"><i class="fa fa-chevron-right"></i></button>',
        prevArrow: '<button class="left"><i class="fa fa-chevron-left"></i></button>',
        fade: false,
        cssEase: 'ease-in-out',
        centerPadding: '40px',
        responsive: [
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    variableWidth: true
                }
            }
        ]
    });


    $(".home-section.latest .load-more > a.btn").click(function(e){
        loadArticles();
        e.preventDefault();
    });

    function loadArticles() {
        var loadmore = ".home-section.latest .load-more > a.btn";
        var offset = $(loadmore).attr("data-count");
        var category = $(loadmore).data('cat');
        var num = parseInt(offset, 10);
        var loading = $(loadmore).data('loading');
        if(loading === 0){
            $(loadmore).attr("data-loading", "1");
            $.ajax({
                url: "//" + location.host + "/singapore/insider/wp-admin/admin-ajax.php",
                type:'POST',
                data: {
                    action: 'infinitescroll_latest',
                    offset: num,
                    category: category
                },
                success: function(html){
                    $(loadmore).attr("data-loading", "0");
                    var off = parseInt(offset, 10) + 5;
                    if(html === "0"){
                        $(loadmore).addClass('disabled').html('No more posts');
                    }
                    else {
                        $(".home-section.latest .load-more").before(html);
                        $(loadmore).attr("data-count", off);
                        $(loadmore).html("Load more");
                    }
                }
            });
        }
    }

    $(".category .lists-wrapper .load-more > a.btn").click(function(e){
        loadCatArticles();
        e.preventDefault();
    });

    function loadCatArticles() {
        var loadmore = ".category .lists-wrapper .load-more > a.btn";
        var offset = $(loadmore).attr("data-count");
        var category = $(loadmore).data('cat');
        var num = parseInt(offset, 10);
        var loading = $(loadmore).data('loading');
        if(loading === 0){
            $(loadmore).attr("data-loading", "1");
            $.ajax({
                url: "//" + location.host + "/singapore/insider/wp-admin/admin-ajax.php",
                type:'POST',
                data: {
                    action: 'infinitescroll_latest',
                    offset: num,
                    category: category
                },
                success: function(html){
                    $(loadmore).attr("data-loading", "0");
                    var off = parseInt(offset, 10) + 10;
                    if(html === "0"){
                        $(loadmore).addClass('disabled').html('No more posts');
                    }
                    else {
                        $(".lists-wrapper .load-more").before(html);
                        $(loadmore).attr("data-count", off);
                        $(loadmore).html("Load more");
                    }
                }
            });
        }
    }

    $(".tag .lists-wrapper .load-more > a.btn").click(function(e){
        loadTagArticles();
        e.preventDefault();
    });

    function loadTagArticles() {
        var loadmore = ".tag .lists-wrapper .load-more > a.btn";
        var offset = $(loadmore).attr("data-count");
        var tag = $(loadmore).data('tag');
        var num = parseInt(offset, 10);
        var loading = $(loadmore).data('loading');
        if(loading === 0){
            $(loadmore).attr("data-loading", "1");
            $.ajax({
                url: "//" + location.host + "/singapore/insider/wp-admin/admin-ajax.php",
                type:'POST',
                data: {
                    action: 'infinitescroll_latest',
                    offset: num,
                    tag: tag
                },
                success: function(html){
                    $(loadmore).attr("data-loading", "0");
                    var off = parseInt(offset, 10) + 10;
                    if(html === "0"){
                        $(loadmore).addClass('disabled').html('No more posts');
                    }
                    else {
                        $(".lists-wrapper .load-more").before(html);
                        $(loadmore).attr("data-count", off);
                        $(loadmore).html("Load more");
                    }
                }
            });
        }
    }

    $(".author .lists-wrapper .load-more > a.btn").click(function(e){
        loadAuthorArticles();
        e.preventDefault();
    });

    function loadAuthorArticles() {
        var loadmore = ".author .lists-wrapper .load-more > a.btn";
        var offset = $(loadmore).attr("data-count");
        var author = $(loadmore).data('author');
        var num = parseInt(offset, 10);
        var loading = $(loadmore).data('loading');
        if(loading === 0){
            $(loadmore).attr("data-loading", "1");
            $.ajax({
                url: "//" + location.host + "/singapore/insider/wp-admin/admin-ajax.php",
                type:'POST',
                data: {
                    action: 'infinitescroll_latest',
                    offset: num,
                    author: author
                },
                success: function(html){
                    $(loadmore).attr("data-loading", "0");
                    var off = parseInt(offset, 10) + 10;
                    if(html === "0"){
                        $(loadmore).addClass('disabled').html('No more posts');
                    }
                    else {
                        $(".lists-wrapper .load-more").before(html);
                        $(loadmore).attr("data-count", off);
                        $(loadmore).html("Load more");
                    }
                }
            });
        }
    }

    $(".search .lists-wrapper .load-more > a.btn").click(function(e){
        loadSearchArticles();
        e.preventDefault();
    });

    function loadSearchArticles() {
        var loadmore = ".author .lists-wrapper .load-more > a.btn";
        var offset = $(loadmore).attr("data-count");
        var search = $(loadmore).data('search');
        var num = parseInt(offset, 10);
        var loading = $(loadmore).data('loading');
        if(loading === 0){
            $(loadmore).attr("data-loading", "1");
            $.ajax({
                url: "//" + location.host + "/singapore/insider/wp-admin/admin-ajax.php",
                type:'POST',
                data: {
                    action: 'infinitescroll_latest',
                    offset: num,
                    search: search
                },
                success: function(html){
                    $(loadmore).attr("data-loading", "0");
                    var off = parseInt(offset, 10) + 10;
                    if(html === "0"){
                        $(loadmore).addClass('disabled').html('No more posts');
                    }
                    else {
                        $(".lists-wrapper .load-more").before(html);
                        $(loadmore).attr("data-count", off);
                        $(loadmore).html("Load more");
                    }
                }
            });
        }
    }

    $('.entry-subscribe .close').click(function() {
        $('.entry-subscribe').removeClass('fadeInUp').addClass('fadeOutDown');
        setTimeout(function () {
            $('.entry-subscribe').removeClass('sticky');
        }, 500);
    });

    var waypoints = $('.popular').waypoint(function (direction) {
        $('.entry-subscribe').removeClass('fadeInUp').addClass('fadeOutDown');
        setTimeout(function () {
            $('.entry-subscribe').removeClass('sticky');
        }, 500);
    }, {
        offset: '25%'
    });

    $(document).on('ready', function () {
        var winHeight = $(window).height(),
            docHeight = $(document).height(),
            progressBar = $('progress'),
            max, value;

        /* Set the max scrollable area */
        max = docHeight - winHeight;
        progressBar.attr('max', max);

        $(document).on('scroll', function () {
            value = $(window).scrollTop();
            progressBar.attr('value', value);
        });
    });

})( window.jQuery );

/**
 * Display a search icon and hidden search box
 * Show search box on click, and other trickery
 */
jQuery(function( $ ) {
    'use strict';

    // On click of the search button
    $('body').on( 'click', '.search-btn a', function(e){
        e.preventDefault();
        // Close if the button has open class, otherwise open
        if ( $(this).hasClass('search-btn-open') ) {
            searchClose();
        } else {
            searchOpen();
        }
    });

    // Close search if close button clicked
    $('#search-box').on( 'click', '.search-close', function(e){
        e.preventDefault();
        searchClose();
    });

    // Close search listener
    $('body').mouseup(function(e){
        // Set our search box container as a variable
        var search = $("#search-box");
        /**
         * If click is not on our search container
         * If click is not on a child of our search container
         * If click is not another link (stays open while new page opens)
         */
        if( e.target.id != search.attr('id') && ! search.has(e.target).length && ! $(e.target).closest('a').length ) {
            searchClose();
        }
    });

    // Helper function to open search form and add class to search button
    function searchOpen() {
        $('.search-btn a').addClass('search-btn-open');
        $('#search-box').slideDown('fast', function() {
            $(this).find('input[type="search"]').focus();
        });
    }

    // Helper function to close search form and remove class to search button
    function searchClose() {
        $('.search-btn a').removeClass('search-btn-open');
        $('#search-box').slideUp('fast');
    }

    $("h2.screen-reader-text + .menu-toggle").text("Categories");

});

(function($) {
    'use strict';

    $(document).ready(function() {
        setTimeout(function() {
            if(window.innerWidth < 1025 && window.innerWidth > 767) {
                $('.tablet-ads').css({
                    display: 'block',
                    opacity: '1',
                    height: 'auto'
                });
                $('.desktop-ads').css({
                    display: 'none',
                    opacity: '0'
                });
                $('.mobile-ads').css({
                    display: 'none',
                    opacity: '0'
                });
            } else if( window.innerWidth < 768 ) {
                $('.desktop-ads').css({
                    display: 'none',
                    opacity: '0'
                });
                $('.tablet-ads').css({
                    display: 'none',
                    opacity: '0'
                });
                $('.mobile-ads').css({
                    display: 'block',
                    opacity: '1',
                    height: 'auto'
                });
            } else {
                $('.desktop-ads').css({
                    display: 'block',
                    opacity: '1',
                    height: 'auto'
                });
                $('.tablet-ads').css({
                    display: 'none',
                    opacity: '0'
                });
                $('.mobile-ads').css({
                    display: 'none',
                    opacity: '0'
                });
            }
        }, 300);
    });
})(window.jQuery);