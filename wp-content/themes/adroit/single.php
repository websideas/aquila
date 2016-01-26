<?php
/**
 * The template for displaying single post
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 */

get_header();

$post_id = get_the_ID();
$sidebar = kt_get_single_sidebar();
$layout = kt_post_option(null, '_kt_blog_post_layout', 'single_layout', 1, false);
$imageSize = kt_option('single_image_size', 'full');

if($layout == 6){
    $sidebar['sidebar'] = '';
}

?>
<div class="container">
    <?php

    do_action( 'kt_before_main' );

    $main_column = ($sidebar['sidebar']) ? '8' : '12';
    $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
    $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';

    ?>
    <?php if( ! post_password_required( ) && $layout == 4 ){ ?>
        <div class="entry-thumb-fullwidth"><?php kt_post_thumbnail($imageSize, 'img-responsive', false); ?></div>
    <?php } ?>
    <div class="row main <?php echo esc_attr($sidebar_class); ?>">
        <?php echo '<div class="main-content col-sm-12 col-xs-12 col-md-'.esc_attr($main_column.' '.$pull_class).'">'; ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'templates/content', 'single' ); ?>
            <?php endwhile; // end of the loop. ?>
        </div><!-- .main-content -->
        <?php if($sidebar['sidebar']){ ?>
            <?php echo '<div class="col-md-4 col-sm-12 col-xs-12 sidebar main-sidebar">'; ?>
                <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
            </div><!-- .sidebar -->
        <?php } ?>
    </div><!-- .main -->
    <?php  do_action( 'kt_after_main' ); ?>
</div><!-- .container -->
<?php get_footer(); ?>