<article <?php post_class('post-item-content post-item-featured'); ?>>
    <?php
    $post_id = get_the_ID();
    $type = get_post_meta($post_id, '_kt_video_type', true);

    $video = get_post_meta($post_id, '_kt_choose_video', true);
    $video_id = get_post_meta($post_id, '_kt_video_id', true);


    ?>

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
    <?php
    if($video == 'youtube'){
        printf(
            '<div class="embed-responsive embed-responsive-16by9">%s</div>',
            kt_video_youtube($video_id)
        );
    }elseif($video == 'vimeo'){
        printf(
            '<div class="embed-responsive embed-responsive-16by9">%s</div>',
            kt_video_vimeo($video_id)
        );
    }
    ?>


</article>

