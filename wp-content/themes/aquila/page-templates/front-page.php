<?php
/**
 * Template Name: Front Page
 *
 * @package aquila
 */


$post_id = get_the_ID();
$content = get_post_meta($post_id, '_kt_frontpage_content', true);
$sidebar = array('sidebar' => 'right', 'sidebar_area' => 'primary-widget-area');

get_header(); ?>
    <div class="container">
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_before_main' ); ?>

        <?php
            $main_column = ($sidebar['sidebar']) ? '8' : '12';
            $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
            $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';
        ?>
        <div class="row main">
            <?php echo '<div class="main-content col-md-'.$main_column.' '.$sidebar_class.' '.$pull_class.'">'; ?>
                <?php do_action('before_blog_posts_loop'); ?>
                <?php if ( have_posts() ) { ?>
                    <?php
                    if(!$content){
                        get_template_part( 'templates/content', 'page' );
                    }else{
                        get_template_part( 'templates/content', 'front' );
                    }
                    ?>
                <?php
                }else {
                    get_template_part( 'templates/content', 'none' );
                }
                ?>
                <?php do_action('after_blog_posts_loop'); ?>
            </div>
            <?php if($sidebar['sidebar']){ ?>
                <div class="col-md-4 sidebar main-sidebar">
                    <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
                </div><!-- .sidebar -->
            <?php } ?>
        </div><!-- .row -->
        <?php
        /**
         * @hooked
         */
        do_action( 'theme_after_main' ); ?>
    </div><!-- .container -->


<?php get_footer(); ?>