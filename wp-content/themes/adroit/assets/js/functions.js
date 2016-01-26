(function($){
    "use strict"; // Start of use strict


    /* --------------------------------------------
     Mobile detect
     --------------------------------------------- */
    var ktmobile;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
        ktmobile = true;
        $("html").addClass("mobile");
    }
    else {
        ktmobile = false;
        $("html").addClass("no-mobile");
    }


    /* ---------------------------------------------
     Scripts initialization
     --------------------------------------------- */
    
    $(window).load(function(){
        
        $(window).trigger("scroll");
        $(window).trigger("resize");
        init_ktCustomCss();



    });
    
    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {

        $(window).trigger("resize");

        setInterval(init_remove_space, 100);

        // Page Loader
        $("body").imagesLoaded(function(){
            $(".kt_page_loader").delay(200).fadeOut('slow');
        });

        init_shortcodes();
        init_carousel();

        init_backtotop();
        init_MobileMenu();
        init_masonry();
        init_searchform();
        kt_sidebar_sticky();

        kt_likepost();
        init_lightbox_content();

        
        if($('#wpadminbar').length){
            $('body').addClass('admin-bar');
        }


        $('.button-toggle').click(function(e){
            e.preventDefault();
            $(this).closest('#nav').toggleClass('is-opened');
        });
        
        $('.widget-container .kt_widget_tabs').tabs();




        $('body')
            .on('click','.menu-bars-link',function(e){
                e.preventDefault();
                $('body').addClass('open-sidearea');
            })
            .on('click','#close-side-slideout-right',function(e){
                e.preventDefault();
                $('body').removeClass('open-sidearea');
            });


        $('.gallery-grid').each(function(){
            var $gallery = $(this);
            $gallery.imagesLoaded(function(){
                $gallery.photosetGrid({
                    highresLinks: $(this).data('popup'),
                    gutter: $(this).data('margin')+'px'
                });
            });
        });


        $('.popup-gallery').each(function(){
            $(this).magnificPopup({
                delegate: 'a',
                type: 'image',
                mainClass: 'mfp-zoom-in',
                removalDelay: 500,
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                },
                image: {
                    titleSrc: function(item) {
                        return item.el.find('img').attr('alt');
                    }
                },
                callbacks: {
                    beforeOpen: function() {
                        this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                        this.st.mainClass = 'mfp-zoom-in';
                    }
                }
            });
        });

        $('.justified-gallery').each(function(){
            $(this).justifiedGallery({
                rowHeight: $(this).data('height'),
                margins: $(this).data('margin'),
                captions: true,
                lastRow: 'justify'
            });
        });


        $('.gallery-images-justified').each(function(){
            $(this).justifiedGallery({
                rowHeight: 300,
                margins: 30,
                captions: false,
                lastRow: 'justify'
            });
        });


        $('#side-widget-area').mCustomScrollbar();


        $('.container').fitVids();
    });
    
    $(window).resize(function(){
        init_ktCustomCss();

        if ($.fn.ktSticky) {
            /**==============================
             ***  Sticky header
             ===============================**/
            $('.header-container.sticky-header').ktSticky({
                //contentSticky : '#header-inner'
            });
        }
        /**==============================
         ***  Height in js
         ===============================**/
        init_js_height();

    });
    /**==============================
     ***  Smooth Scrolling
     ===============================**/
    function init_smooth_scrolling(){
        $('a[href*=#]:not([href=#])').click(function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length && !target.hasClass('vc_tta-panel') && !target.hasClass('vc_icon_element-link')) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 2000);
                    return false;
                }
            }
        });
    }
    /* ---------------------------------------------
     Remove all space empty
     --------------------------------------------- */
    function init_remove_space() {

        $("p:empty").remove();
        $(".wpb_text_column:empty").remove();
        $(".wpb_wrapper:empty").remove();
        $(".wpb_column:empty").remove();
        $(".wpb_row:empty").remove();

    }

    /* ---------------------------------------------
     Masonry
     --------------------------------------------- */
    function init_masonry(){
        $(".blog-posts-masonry").each(function(){
            var $masonry = $(this);
            $masonry.imagesLoaded(function(){
                $masonry.isotope({
                    itemSelector: '.article-post-item',
                    layoutMode: 'packery',
                    packery: {columnWidth: '.grid-sizer'}
                });
            });
        });
    }

    /* ---------------------------------------------
     KT custom css
     --------------------------------------------- */
    function init_ktCustomCss(){
        $('.kt_custom_css').each(function(){
            var $this = $(this);
            if(!$this.children('style').length){
                $this.html('<style>'+$this.data('css')+'</style>');
            }
        });
    }

    /* ---------------------------------------------
     Shortcodes
     --------------------------------------------- */
    function init_shortcodes(){
        "use strict";
        
        // Tooltips (bootstrap plugin activated)
        $('[data-toggle="tooltip"]').tooltip({
            container:"body",
            delay: { "show": 100, "hide": 100 }
        });

    }

    /* ---------------------------------------------
     Mobile Menu
     --------------------------------------------- */
    function init_MobileMenu() {
        $('body')
            .on('click', '#hamburger-icon', function (e) {
                e.preventDefault();
                $(this).toggleClass('active');
                $('body').toggleClass('opened-nav-animate');
                setTimeout(function () {
                    $('body').toggleClass('opened-nav');
                }, 100);
            });

        $(' ul.sub-menu-dropdown,ul.sub-menu,.kt-megamenu-wrapper', 'ul.navigation-mobile').each(function () {
            $(this).parent().children('a').prepend('<span class="open-submenu"></span>');
        });

        $('.open-submenu').on('click', function (e) {
            e.stopPropagation();
            e.preventDefault();
            $(this).closest('li').toggleClass('active-menu-item');
            $(this).closest('li').children('.sub-menu-dropdown, .kt-megamenu-wrapper, ul.sub-menu').slideToggle();
        });

        $(window).resize(function () {
            var $navHeight = $(window).height() - $('#header-content-mobile').height();
            if($('#wpadminbar').length > 0){
                $navHeight -= parseInt( $('#wpadminbar').outerHeight(), 10 );
            }
            $('.main-nav-mobile').css({'max-height': $navHeight});

            //Disable mobile menu in desktop
            if ($(window).width() >= 992) {
                $('body').removeClass('opened-nav-animate opened-nav');
            }

        });
    }
    
    /* ---------------------------------------------
     Back to top
     --------------------------------------------- */
    function init_backtotop(){

        $('body').append('<div id="back-to-top"><i class="fa fa-angle-up"></i></div>');
        var $backtotop = $('#back-to-top');

        $backtotop.hide();


        $(window).scroll(function() {
            var heightbody = $('body').outerHeight(),
                window_height = $(window).outerHeight(),
                top_pos = heightbody/2-25;
            if($(window).scrollTop() + window_height/2 >= top_pos && heightbody > window_height) {
                $backtotop.fadeIn();
            } else {
                $backtotop.fadeOut();
            }
        });

        $backtotop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0},500);
        });
    }

    /* ---------------------------------------------
     Owl carousel
     --------------------------------------------- */
    function init_carousel(){

        var blog_posts_slick = $('.blog-posts-slick').slick({
            dots: true,
            arrows: true
        });

        $('body').on('click','#main-slideshow .slick-next',function(){
            blog_posts_slick.slick('slickNext');
            return false;
        });

        $('body').on('click','#main-slideshow .slick-prev',function(){
            blog_posts_slick.slick('slickPrev');
            return false;
        });

        $('.blog-posts-thumb').slick({
            asNavFor: '.blog-posts-slick',
            slidesToShow: 3,
            arrows: false,
            focusOnSelect: true
        });

        $('.blog-posts-related').slick({
            slidesToShow: 2,
            responsive: [
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            ]
        });

        var slide_carousel = $('.kt_posts_carousel_widget').slick({
            arrows: false
        });

        $('body').on('click','.carousel-next',function(){
            slide_carousel.slick('slickNext');
            return false;
        });

        $('body').on('click','.carousel-prev',function(){
            slide_carousel.slick('slickPrev');
            return false;
        });


        $('.gallery-fullwidth').slick({
            arrows: false,
            variableWidth: true,
            centerMode: true,
            centerPadding: 0
        });
    }

    /* ---------------------------------------------
     Height 100%
     --------------------------------------------- */
    function init_js_height(){

        $(".item-height-window").css('height', $(window).height());
        $(".item-height-parent").each(function(){
            $(this).height($(this).parent().first().height());
        });

    }

    /**==============================
    ***  Sticky sidebar
    ===============================**/
    function kt_sidebar_sticky(){
        if(!ktmobile){
            var margin_sidebar_sticky = 20;
            if($('#wpadminbar').length > 0){
                margin_sidebar_sticky += parseInt( $('#wpadminbar').outerHeight() );
            }

            if($('.sticky-header.header-container').length > 0){
                margin_sidebar_sticky += parseInt( ajax_frontend.sticky_height );
            }

            $('.main-sidebar').theiaStickySidebar({
                additionalMarginTop: margin_sidebar_sticky,
                minWidth: '992'
            });
        }

    }
    
    /**==============================
    ***  Like Post
    ===============================**/
    function kt_likepost(){
        $('body').on('click','a.kt_likepost',function(e){
            e.preventDefault();
            var objPost = $(this);
            if(objPost.hasClass('liked')) return false;
            var data = {
                action: 'fronted_likepost',
                security : ajax_frontend.security,
                post_id: objPost.data('id')
            };
            $.post(ajax_frontend.ajaxurl, data, function(response) {
                objPost
                    .text(response.count)
                    .addClass('liked')
                    .attr('title', objPost.data('already'));
            }, 'json');
        });
    }

    /**==============================
    *** Search Form
    ===============================**/

    function init_searchform(){
        $('body')
            .on('click','#main-nav-tool li.mini-search a',function(e){
                e.preventDefault();
                var $form = $(this).next();

                $form.slideToggle();
                $('input[name=s]', $form).focus();
            })
            .on('click',function(e){
                var target = $(e.target);
                if(!target.is("#main-nav-tool li .searchform input, #main-nav-tool li.mini-search i")) {
                    $('#main-nav-tool li .searchform').slideUp();
                }
            });
    }

    /* ---------------------------------------------
     Search
     --------------------------------------------- */
    function init_lightbox_content(){
        $('.socials-mobile').magnificPopup({
            type: 'inline',
            mainClass : 'mfp-zoom-in',
            items: { src: '#socials-mobile' },
            focus : 'input[name=s]',
            removalDelay: 200
        });
    }


})(jQuery); // End of use strict
