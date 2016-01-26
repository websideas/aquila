<?php
/**
 * The template used for displaying page content
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-content'); ?>>
    <div class="entry-content">
        <?php
        the_content();
        wp_link_pages( array(
            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'adroit' ) . '</span>',
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
            'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'adroit' ) . ' </span>%',
            'separator'   => '<span class="screen-reader-text">, </span>',
        ) );
        ?>
    </div><!-- .entry-content -->
    <?php
    if( kt_option( 'show_page_comment', 0 ) ){
        // If comments are open or we have at least one comment, load up the comment template.
        if ( shortcode_exists( 'fbcomments' ) ) {
            echo '<div class="kt_facebook_comment">'.do_shortcode('[fbcomments]').'</div>';
        }else{
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
        }
    }
    ?>
    <?php
    edit_post_link(
        sprintf(
        /* translators: %s: Name of current post */
            wp_kses(__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'adroit' ), array( 'span' => array('class' => true) ) ),
            get_the_title()
        ),
        '<footer class="entry-footer"><span class="edit-link">',
        '</span></footer><!-- .entry-footer -->'
    );
    ?>
</article><!-- #post-## -->
