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
                $overlay = $('.demo-overlay');

            $switcher.removeClass('active');
            $overlay.removeClass('active');
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

            var skin_url =  $(this).attr('href');
            $('#kt-main-inline-css').remove();

            if( $('link#ds-skin').length > 0 ){
                $('link#ds-skin').attr( 'href', skin_url );
            }else{
                $('head').append("<link id='ds-skin' rel='stylesheet' href='"+skin_url+"' type='text/css' media='all' />");
            }


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