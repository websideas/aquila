<article <?php post_class('post-item-content'); ?>>
    <?php
    $post_id = get_the_ID();
    $type = get_post_meta($post_id, '_kt_video_type', true);

    $video = get_post_meta($post_id, '_kt_choose_video', true);
    $video_id = get_post_meta($post_id, '_kt_video_id', true);

    ?>
    <div class="post-item-thumb embed-responsive embed-responsive-16by9">
        <?php
        if($video == 'youtube'){
            echo kt_video_youtube($video_id);
        }elseif($video == 'vimeo'){
            echo kt_video_vimeo($video_id);
        }
        ?>
    </div>
    <div class="post-item-inner">
        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
        <div class="post-item-content">
            <?php
            kt_entry_meta_categories();
            the_content(sprintf(
                esc_html__('Continue reading %s', 'adroit'),
                ' <i class="fa fa-long-arrow-right"></i>'
            ));
            kt_entry_meta(true);
            ?>
        </div>
    </div>
</article>

