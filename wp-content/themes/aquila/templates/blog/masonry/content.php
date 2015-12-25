<article <?php post_class('post-item-content'); ?>>
    <?php
    echo '<div class="post-item-thumb">';
    kt_post_thumbnail_image('recent_posts');
    echo '</div>';

    the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );

    kt_entry_meta_categories();

    kt_entry_excerpt();

    echo '<div class="post-item-meta">';
    echo '<div class="post-item-metaleft pull-left">';
        kt_entry_meta_author();
        kt_entry_meta_time();
    echo '</div><!-- .post-item-metaleft -->';
    echo '<div class="post-item-metaright pull-right">';
        kt_get_post_views();
        kt_entry_meta_comments();
    echo '</div><!-- .post-item-metaright -->';
    echo '<div class="clearfix"></div></div><!-- .post-item-meta -->';

    ?>
</article>