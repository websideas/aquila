<article <?php post_class('post-item-content first-featured'); ?>>
    <div class="row row-eq-height">
        <div class="col-md-7">
            <?php kt_post_thumbnail_image('kt_first_featured'); ?>
        </div>
        <div class="col-md-5 post-item-info">
            <?php
            the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
            kt_entry_meta_categories();
            kt_entry_excerpt();
            kt_entry_meta(true);
            ?>
        </div>
    </div>
</article>

