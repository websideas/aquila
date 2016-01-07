<article <?php post_class('post-item-content post-item-featured'); ?>>
    <div class="row row-eq-height">
        <div class="col-md-6 col-sm-6 post-item-thumb">
            <?php the_post_thumbnail('kt_first_featured'); ?>
        </div>
        <div class="col-md-6 col-sm-6 post-item-info">
            <?php
            the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
            kt_entry_excerpt();
            ?>
        </div>
    </div>
</article>

