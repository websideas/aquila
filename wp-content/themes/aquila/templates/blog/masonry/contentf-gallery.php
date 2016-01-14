<article <?php post_class('post-item-content post-item-featured'); ?>>
    <?php
    $post_id = get_the_ID();
    $type = get_post_meta($post_id, '_kt_gallery_type', true);
    ?>

    <?php if($type == 'grid'){ ?>
        <div class="row row-eq-height">
            <div class="col-md-6 col-sm-6">
                <?php the_post_thumbnail('kt_first_featured'); ?>
            </div>
            <div class="col-md-6 col-sm-6 post-item-info">
                <?php
                the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
                kt_entry_excerpt();
                ?>
            </div>
        </div>
    <?php }else{ ?>
        <div class="post-info-featured">
            <div class="post-info-featured-inner">
                <?php
                the_title( sprintf( '<h3 class="entry-title-featured"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
                echo '<div class="post-item-meta-featured">';
                kt_entry_meta_author();
                kt_entry_date();
                echo '</div><!-- .post-item-meta-featured -->';
                ?>
            </div><!-- .post-info-featured-inner -->
        </div><!-- .post-info-featured -->
    <?php } ?>
    <?php

    if($type == 'slider' ||!$type){
        $images = kt_get_galleries_post('_kt_gallery_images', 'kt_blog_post');
        if($images){
            $slider_class = array('blog-posts-slick');
            $slider_option = '{"arrows": false}';
            $slider_html = '';
            foreach($images as $image){
                $slider_html .= sprintf(
                    '<div class="gallery-slider-item">%1$s</div>',
                    '<img src="'.$image['url'].'" title="'.esc_attr($image['title']).'" alt="'.esc_attr($image['alt']).'">'
                );
            }
            printf(
                '<div class="%1$s" data-slick=\'%2$s\'>%3$s</div>',
                implode(' ', $slider_class),
                esc_attr($slider_option),
                $slider_html
            );
        }
    }elseif($type == 'grid'){
        $images = kt_get_galleries_post('_kt_gallery_images', 'kt_small');
        $gallery = '';
        if($images){
            foreach($images as $image){
                $gallery .= sprintf(
                    '<div class="%s">%s</div>',
                    'gallery-image-item',
                    '<a href="'.$image['full_url'].'"><span></span><img src="'.$image['url'].'" title="'.esc_attr($image['title']).'" alt="'.esc_attr($image['alt']).'"></a>'
                );
            }
            printf(
                '<div class="%s">%s</div>',
                'gallery-images popup-gallery clearfix',
                $gallery
            );
        }
    }elseif($type == 'revslider' && class_exists( 'RevSlider' )){
        if ($rev = rwmb_meta('_kt_gallery_rev_slider')) {
            echo '<div class="entry-thumb">';
            putRevSlider($rev);
            echo '</div><!-- .entry-thumb -->';
        }
    }elseif($type == 'layerslider' && is_plugin_active( 'LayerSlider/layerslider.php' )){
        if($layerslider = rwmb_meta('_kt_gallery_layerslider')){
            echo '<div class="entry-thumb">';
            echo do_shortcode('[layerslider id="'.rwmb_meta('_kt_gallery_layerslider').'"]');
            echo '</div><!-- .entry-thumb -->';
        }
    }

    ?>

</article>

