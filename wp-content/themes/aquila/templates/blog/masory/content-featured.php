<article <?php post_class(); ?>>
    <div class="row">
        <div class="col-md-7">
            <?php the_post_thumbnail('full'); ?>
        </div>
        <div class="col-md-5">
            <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
            <?php the_excerpt(); ?>
        </div>

    </div>
    <p>&nbsp;</p>
</article>

