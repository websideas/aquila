<article <?php post_class('post-item-content'); ?>>
    <?php
    $post_id = get_the_ID();
    $type = get_post_meta($post_id, '_kt_audio_type', true);

    if($type == 'soundcloud'){
        if($soundcloud = get_post_meta($post_id, '_kt_audio_soundcloud', true)){
            echo '<div class="featured-soundcloud post-item-thumb">';
            echo do_shortcode($soundcloud);
            echo '</div><!-- .entry-thumb -->';
        }

    }elseif($type == 'upload'){

        if($audios = rwmb_meta('_kt_audio_mp3', 'type=file')){
            printf(
                '<div class="entry-thumb-audio post-item-thumb" style="%s">',
                "background-image: url('".get_the_post_thumbnail_url()."');"
            );
            foreach($audios as $audio) {
                echo do_shortcode('[audio src="'.$audio['url'].'"][/audio]');
                break;
            }
            echo '</div><!-- .entry-thumb-audio -->';
        }
    }
    ?>
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

