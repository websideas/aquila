<article <?php post_class(); ?>>
    <?php

    if(has_post_thumbnail()){
        echo '<div class="post-item-thumb">';
        the_post_thumbnail('blog_post');
        echo '</div>';
    }

    ?>

    <div class="post-item-inner">
        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
        <div class="post-item-content">
            <?php

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