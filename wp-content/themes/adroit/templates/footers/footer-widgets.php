<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$layouts = explode('-', kt_option('footer_widgets_layout', '4-4-4'));

$sidebar_widgets = true;
foreach($layouts as $i => $layout){
    if(is_active_sidebar($layout)){
        $sidebar_widgets = false;
        break;
    }
}

if($sidebar_widgets){
?>
<footer id="footer-area">
    <div class="container">
        <div class="row">
            <?php foreach($layouts as $i => $layout){ ?>
                <?php $footer_class = ($layout == 12) ? 'footer-area-one col-md-offset-2 col-md-8 col-sm-12 col-xs-12' : 'col-md-'.$layout . ' col-sm-'.$layout . ' col-xs-12'; ?>
                <div class="<?php echo esc_attr($footer_class); ?>">
                    <?php dynamic_sidebar('footer-column-'.($i+1)) ?>
                </div>
            <?php } ?>
        </div>
    </div><!-- .container -->
</footer><!-- #footer-area -->
<?php } ?>