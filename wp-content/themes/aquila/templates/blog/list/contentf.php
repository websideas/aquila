<article <?php post_class('post-item-content'); ?>>
    <?php
    $post_id = get_the_ID();
    $type = get_post_meta($post_id, '_kt_gallery_type', true);

    if($type == 'slider' ||!$type){
        $images = get_galleries_post('_kt_gallery_images', 'blog_post');
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
    }elseif($type == 'gird'){
        $images = get_galleries_post('_kt_gallery_images', 'small');
        $gallery = '';
        if($images){
            foreach($images as $image){
                $gallery .= sprintf(
                    '<div class="%s">%s</div>',
                    'gallery-image-item',
                    '<a href="'.$image['full_url'].'"><img src="'.$image['url'].'" title="'.esc_attr($image['title']).'" alt="'.esc_attr($image['alt']).'"></a>'
                );
            }
            printf(
                '<div class="%s">%s</div>',
                'gallery-images clearfix',
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

    <?php if($type == 'gird'){ ?>
        <div class="post-item-inner">
            <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
            <div class="post-item-content">
                <?php

                kt_entry_meta_categories();

                kt_entry_excerpt();

                echo '<div class="post-item-meta">';
                echo '<div class="post-item-metaleft pull-left">';
                kt_entry_meta_author();
                kt_entry_meta_time();
                echo '</div><!-- .post-item-metaleft -->';
                echo '<div class="post-item-metaright pull-right">';
                kt_share_box();
                kt_get_post_views();
                kt_entry_meta_comments();
                echo '</div><!-- .post-item-metaright -->';
                echo '<div class="clearfix"></div></div><!-- .post-item-meta -->';

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
                kt_entry_meta_time();
                echo '</div><!-- .post-item-meta-featured -->';
                ?>
            </div><!-- .post-info-featured-inner -->
        </div><!-- .post-info-featured -->
    <?php } ?>
</article>

