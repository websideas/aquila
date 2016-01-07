<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 */

$sidebar = kt_get_page_sidebar();

get_header(); ?>

    <div class="container">
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'kt_before_main' );

        ?>
        <?php
            $main_column = ($sidebar['sidebar']) ? '8' : '12';
            $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
            $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';
        ?>
        <div class="row main <?php echo $sidebar_class; ?>">
            <?php echo '<div class="main-content col-md-'.$main_column.' '.$pull_class.'">'; ?>
            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php
                    // Include the page content template.
                    get_template_part( 'templates/content', 'page' );
                ?>
            <?php endwhile; ?>
            </div><!-- .main-content -->
            <?php if($sidebar['sidebar']){ ?>
                <?php echo '<div class="col-md-4 sidebar main-sidebar">'; ?>
                    <?php dynamic_sidebar($sidebar['sidebar_area']); ?>
                </div><!-- .sidebar -->
            <?php } ?>
        </div><!-- .row -->
        <?php
    	/**
    	 * @hooked 
    	 */
    	do_action( 'kt_after_main' ); ?>
    </div><!-- .container -->
<?php get_footer(); ?>