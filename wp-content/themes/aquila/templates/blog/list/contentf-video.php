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
            echo video_youtube($video_id);
        }elseif($video == 'vimeo'){
            echo video_vimeo($video_id);
        }
        ?>
    </div>
    <div class="post-item-inner">
        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
        <div class="post-item-content">
            <?php
            kt_entry_meta_categories();
            kt_entry_excerpt();
            kt_entry_meta();
            ?>
        </div>
    </div>
</article>

