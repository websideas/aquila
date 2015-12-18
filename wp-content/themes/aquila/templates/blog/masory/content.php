<article <?php post_class(); ?>>
    <?php
        the_post_thumbnail('full');
        the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
        printf(
            '<div class="%s">%s</div>',
            'post-item-meta',
            get_the_author()

        );
        the_excerpt();


    ?>




</article>