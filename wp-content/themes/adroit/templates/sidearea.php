<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

?>


<aside id="side-slideout-right">
    <a href="#" class="nav-close" id="close-side-slideout-right">
        <i class="fa fa-times"></i>
    </a>
    <?php if ( is_active_sidebar( 'side-widget-area' ) ) : ?>
    	<?php $title_side_area = kt_option('title_header_bars'); ?>
    	<?php if($title_side_area){ ?><h3 class="title-side-area"><?php echo $title_side_area; ?></h3><?php } ?>
        <div id="side-widget-area" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'side-widget-area' ); ?>
        </div><!-- .widget-area -->
    <?php endif; ?>
</aside><!-- #side-slideout-left -->
