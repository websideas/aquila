<article <?php post_class('post-item-content first-featured'); ?>>
    <div class="row row-eq-height">
        <div class="col-md-7">
            <?php kt_post_thumbnail_image('first_featured'); ?>
        </div>
        <div class="col-md-5 post-item-info">
            <?php
                the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                kt_entry_meta_categories();
                kt_entry_excerpt();

                echo '<div class="post-item-meta">';
                echo '<div class="post-item-metaleft pull-left">';
                    kt_entry_meta_author();
                    kt_entry_meta_time();
                echo '</div><!-- .post-item-metaleft -->';
                echo '<div class="post-item-metaright pull-right">';
                    kt_share_box();
                    kt_get_post_views();
                    kt_entry_meta_comments();
                echo '</div><!-- .post-item-metaright -->';
                echo '<div class="clearfix"></div></div><!-- .post-item-meta -->';
            ?>
        </div>
    </div>
</article>

