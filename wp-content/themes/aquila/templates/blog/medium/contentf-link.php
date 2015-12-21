<article <?php post_class(); ?>>
    <?php
    $url = get_post_meta(get_the_ID(), '_kt_external_url', true);
    ?>

    <blockquote class="post-item-quote">

        <?php
        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
        printf('<p>%s</p>', $url);
        ?>

    </blockquote>

</article>

