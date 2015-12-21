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
<div class="container">
    <?php if ( have_posts() ) : ?>
        <div class='blog-posts'>
            <?php
            do_action('before_blog_posts_loop');
            get_template_part( 'templates/blog/list/archive');
            do_action('after_blog_posts_loop');
            ?>
        </div><!-- .blog-posts -->
        <?php
    // If no content, include the "No posts found" template.
    else :
        get_template_part( 'templates/content', 'none' );
    endif;
    ?>
</div><!-- .container -->
<?php get_footer(); ?>
