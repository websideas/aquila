<article <?php post_class('post-item-content'); ?>>
    <?php
    if(has_post_thumbnail()){
        echo '<div class="post-item-thumb">';
        the_post_thumbnail('recent_posts');
        echo '</div>';
    }
    the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
    kt_entry_meta();
    ?>
</article>