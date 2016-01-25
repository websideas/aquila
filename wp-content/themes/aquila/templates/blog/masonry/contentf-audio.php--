<article <?php post_class('post-item-content post-item-featured'); ?>>
    <?php
    $post_id = get_the_ID();
    $type = get_post_meta($post_id, '_kt_audio_type', true);
    ?>

    <?php if($type == 'soundcloud'){ ?>
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
    <?php } ?>


    <?php
    if($type == 'soundcloud'){
        if($soundcloud = get_post_meta($post_id, '_kt_audio_soundcloud', true)){
            echo '<div class="featured-soundcloud">';
            echo do_shortcode($soundcloud);
            echo '</div><!-- .entry-thumb -->';
        }

    }elseif($type == 'upload'){
        if($audios = rwmb_meta('_kt_audio_mp3', 'type=file')){
            printf(
                '<div class="entry-thumb-audio" style="%s">',
                "background-image: url('".get_the_post_thumbnail_url()."');"
            );
            the_title( sprintf( '<h3 class="entry-title-audio"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
            foreach($audios as $audio) {
                echo do_shortcode('[audio src="'.$audio['url'].'"][/audio]');
                break;
            }
            echo '</div><!-- .entry-thumb-audio -->';
        }
    }
    ?>

</article>

