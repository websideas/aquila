<article <?php post_class('post-item-content'); ?>>
    <?php
    echo '<div class="post-item-thumb">';
    kt_post_thumbnail_image('recent_posts');
    echo '</div>';
    the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
    kt_entry_meta();
    ?>
</article>