<article <?php post_class(); ?>>
    <div class="row row-eq-height">
        <div class="col-md-6">
            <?php the_post_thumbnail('first_featured'); ?>
        </div>
        <div class="col-md-6">
            <?php
            the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

            kt_entry_excerpt();
            ?>
        </div>
    </div>
    <?php

    $images = get_galleries_post('_kt_gallery_images', 'small');
    $gallery = '';
    if($images){
        $i = 1;
        foreach($images as $image){
            $gallery .= sprintf(
                '<div class="%s">%s</div>',
                'col-md-3',
                '<img src="'.$image['url'].'" title="'.esc_attr($image['title']).'" alt="'.esc_attr($image['alt']).'">'
            );
            if($i == 4){
                break;
            }
            $i++;
        }
        printf(
            '<div class="%s">%s</div>',
            'row gallery-images',
            $gallery
        );
    }
    ?>

</article>

