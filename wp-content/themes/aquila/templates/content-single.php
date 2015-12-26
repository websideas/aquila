<?php

$post_id = get_the_ID();
$layout = get_post_meta($post_id, '_kt_blog_post_layout', true);
$imagesize = 'full';

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( 'post-single' ); ?>>
    <?php
    if($layout == 1){
        kt_post_thumbnail($imagesize, 'img-responsive', false);
    }
    ?>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php if(kt_post_option(null, '_kt_meta_info', 'blog_meta', 1)) {
            echo '<div class="post-item-meta">';
            echo '<div class="post-item-metaleft pull-left">';
            if (kt_option('blog_meta_author', 1)) {
                kt_entry_meta_author( );
            }
            if (kt_option('blog_meta_date', 1)) {
                kt_entry_meta_time( );
            }

            echo '</div><!-- .post-item-metaleft -->';
            echo '<div class="post-item-metaright pull-right">';


            //if (kt_option('blog_view_number', 1)) {
                kt_get_post_views( );
            //}
            if (kt_option('blog_meta_comments', 1)) {
                kt_entry_meta_comments( );
            }
            echo '</div><!-- .post-item-metaright -->';
            echo '<div class="clearfix"></div></div><!-- .post-item-meta -->';
        }
        ?>
    </header><!-- .entry-header -->

    <?php
    if($layout == 2){
        kt_post_thumbnail();
    }
    ?>

    <div class="entry-content clearfix">
        <?php the_content(); ?>
        <?php
        if( ! post_password_required( ) ):
            wp_link_pages( array(
                'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', THEME_LANG ) . '</span>',
                'after'       => '</div>',
                'link_before' => '<span>',
                'link_after'  => '</span>',
                'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', THEME_LANG ) . ' </span>%',
                'separator'   => '<span class="screen-reader-text">, </span>',
            ) );
        endif;
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer clearfix">
        <?php
        kt_entry_meta_tags('<div class="tags-container pull-left">', '</div>');

        echo '<div class="entry-footer-right pull-right">';
        edit_post_link( '<i class="fa fa-pencil"></i>', '<span class="edit-link" title="'.__( 'Edit', THEME_LANG ).'">', '</span>' );
        if(kt_option('blog_like_post', 1)){
            kt_like_post();
        }
        kt_share_box(null, 'square', 'post-single-share');
        echo '</div>';

        ?>
    </footer><!-- .entry-footer -->
</div><!-- #post-<?php the_ID(); ?> -->

<div class="post-single-addons">
    <?php

    //if(kt_post_option(null, '_kt_author_info', 'blog_author', 1)){
        //kt_author_box();
        // Author bio.
        get_template_part( 'templates/author-bio' );
    //}

    if(kt_post_option(null, '_kt_prev_next', 'blog_next_prev', 1)){
        kt_post_nav();
    }

    //if(kt_post_option(null, '_kt_related_acticles', 'blog_related', 1)){
        kt_related_article(null, kt_option('blog_related_type', 'categories'));
    //}

    // If comments are open or we have at least one comment, load up the comment template.
    if ( shortcode_exists( 'fbcomments' ) ) {
        echo '<div class="kt_facebook_comment">'.do_shortcode('[fbcomments]').'</div>';
    }else{
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
    }

    ?>
</div>

