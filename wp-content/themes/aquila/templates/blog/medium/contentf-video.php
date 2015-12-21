<article <?php post_class('post-item-featured'); ?>>
    <?php
    $post_id = get_the_ID();
    $type = get_post_meta($post_id, '_kt_video_type', true);

    $video = get_post_meta($post_id, '_kt_choose_video', true);
    $video_id = get_post_meta($post_id, '_kt_video_id', true);


    ?>

    <div class="row row-eq-height">
        <div class="col-md-6">
            <?php the_post_thumbnail('first_featured'); ?>
        </div>
        <div class="col-md-6">
            <?php
            the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
            kt_entry_excerpt();
            ?>
        </div>
    </div>

    <div class="embed-responsive embed-responsive-16by9">
        <?php
        if($video == 'youtube'){
            echo video_youtube($video_id);
        }elseif($video == 'vimeo'){
            echo video_vimeo($video_id);
        }

        ?>
    </div>


</article>

