<article <?php post_class('post-item-content'); ?>>
    <?php
    echo '<div class="post-item-thumb">';
    kt_post_thumbnail_image('blog_post');
    echo '</div>';
    ?>
    <div class="post-item-inner">
        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
        <div class="post-item-content">
            <?php
            kt_entry_meta_categories();
            the_content();
            kt_entry_meta(true);
            ?>
        </div>
    </div>



</article>