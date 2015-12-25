<?php
/**
 * The template for displaying archive
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 */


get_header(); ?>

    <?php if ( have_posts() ) { ?>
        <div class='blog-posts'>
            <?php
            /*
            <header class="page-header">
                <div class="container">
                    <div class="page-header-content">
                        <?php
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="taxonomy-description">', '</div>' );
                        ?>
                    </div><!-- .page-header-content -->
                </div><!-- .container -->
            </header><!-- .page-header -->
            */
            //the_archive_description();
            ?>
            <div class="container">
                <?php
                do_action('before_blog_posts_loop');
                get_template_part('templates/blog/archive');
                do_action('after_blog_posts_loop');
                ?>
            </div><!-- .container -->
        </div><!-- .blog-posts -->
    <?php
    // If no content, include the "No posts found" template.
    }else{
        get_template_part( 'templates/content', 'none' );
    }
    ?>

<?php get_footer(); ?>
