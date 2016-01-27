(function($){
    "use strict"; // Start of use strict

    /* ---------------------------------------------
     Scripts ready
     --------------------------------------------- */
    $(document).ready(function() {

        $('body').on('click', '.switcher-toggle', function (e) {
            e.preventDefault();
            var $switcher = $('.switcher'),
                $overlay = $('.demo-overlay'),
                $html = $('html');
            if($switcher.hasClass('active')){
                $switcher.removeClass('active');
                $overlay.removeClass('active');
                $html.removeAttr('style');
            }else{
                var scrollbarWidth = _getScrollbarSize();
                $html.css({
                    overflow: "hidden",
                    marginLeft: -scrollbarWidth
                });
                $switcher.addClass('active');
                $overlay.addClass('active');
            }
        }).on('click', '.demo-overlay', function(){
            var $switcher = $('.switcher'),
                $overlay = $('.demo-overlay'),
                $html = $('html');

            $switcher.removeClass('active');
            $overlay.removeClass('active');
            $html.removeAttr('style');
        });


        $('#switcher_layout').on('change', function(){
            var $val = $(this).val(),
                $_body = $('body');
            if($val == 'boxed'){
                $_body.addClass('layout-boxed');
            }else{
                $_body.removeClass('layout-boxed');
                $_body.removeAttr('style');
            }

            $(window).trigger("resize");
        });


        $('#switcher_background').on('click', 'a', function(e){
            e.preventDefault();
            var $this = $(this);
            $('body').css({
                'background-image': 'url('+$this.find('img').attr('src')+')',
                'background-repeat': $this.data('repeat')
            });
        });


        $('#switcher_color').on('click', 'a', function(e){
            e.preventDefault();
            var $path = $('#switcher_color').data('path'),
                $this = $(this),
                $skin_color = $this.data('color'),
                $skin_url = $path+'color-'+$skin_color+'.css',
                $skin_logo = $path+'logo-'+$skin_color+'.png',
                $skin_logo_footer = $path+'footer-logo-'+$skin_color+'.png';


            if( $('link#switcher-skin').length > 0 ){
                $('link#switcher-skin').attr( 'href', $skin_url );
            }else{
                $('head').append("<link id='switcher-skin' rel='stylesheet' href='"+$skin_url+"' type='text/css' media='all' />");
            }

            $('.header-branding-outer .default-logo').attr('src', $skin_logo);
            $('.logo-footer img').attr('src', $skin_logo_footer);

            $('#kt-main-inline-css').remove();
        });

    });

    function _getScrollbarSize() {
        var scrollDiv = document.createElement("div"),
            scrollbarSize;
        scrollDiv.style.cssText = 'width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;';
        document.body.appendChild(scrollDiv);
        scrollbarSize = scrollDiv.offsetWidth - scrollDiv.clientWidth;
        document.body.removeChild(scrollDiv);
        return scrollbarSize;
    }

})(jQuery);