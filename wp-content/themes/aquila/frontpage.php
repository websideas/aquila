<?php
/**
 * Template Name: Front Page
 *
 * @package aquila
 */


$post_id = get_the_ID();
$content = get_post_meta($post_id, '_kt_frontpage_content', true);
$sidebar = kt_get_page_sidebar();


get_header(); ?>
<div class="container">
    <?php if(!$content){ ?>
        <?php
        $main_column = ($sidebar['sidebar']) ? '8' : '12';
        $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
        $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';
        echo '<div class="row main '.$sidebar_class.'">';
        echo '<div class="col-md-'.$main_column.' main-content '.$pull_class.'">';
            get_template_part( 'templates/content', 'page');
        echo '</div><!-- .main-content -->';
        if($sidebar['sidebar']){
            echo '<div class="col-md-4 sidebar main-sidebar">';
            dynamic_sidebar($sidebar['sidebar_area']);
            echo '</div>';
        }
        echo '</div><!-- .main -->';
        ?>
    <?php }else{ ?>
        <?php

        $orderby = get_post_meta($post_id, '_kt_frontpage_orderby', true);
        $order = get_post_meta($post_id, '_kt_order', true);
        $paged = get_query_var('page');
        if($paged == ''){
            $paged = get_query_var('paged');
        }
        if(!$paged){
            $paged = 1;
        }

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => get_post_meta($post_id, '_kt_max_items', true),
            'orderby' => $orderby,
            'order' => $order,
            'paged' => $paged
        );

        if($orderby == 'meta_value' || $orderby == 'meta_value_num'){
            $args['meta_key'] = $meta_key;
        }

        $source = get_post_meta($post_id, '_kt_frontpage_source', true);
        if($source == 'categories'){
            $categories = rwmb_meta( '_kt_categories', 'type=taxonomy_advanced&taxonomy=category', $post_id );
            if(count($categories)){
                $categories_arr = array();
                foreach($categories as $category){
                    $categories_arr[] = $category->term_id;
                }
                $args['category__in'] = $categories_arr;
            }
        }elseif($source == 'posts'){
            $posts = rwmb_meta( '_kt_posts', 'multiple=true', $post_id );
            if(count($posts)){
                $args['post__in'] = $posts;
            }
        }elseif($source == 'authors'){
            $authors = rwmb_meta( '_kt_authors', 'multiple=true', $post_id );
            if(count($authors)){
                $args['author__in'] = $authors;
            }
        }


        $type = get_post_meta($post_id, '_kt_frontpage_type', true);
        $column = get_post_meta($post_id, '_kt_frontpage_columns', true);
        $first_featured = get_post_meta($post_id, '_kt_first_featured', true);
        $excerpt_length = get_post_meta($post_id, '_kt_excerpt_length', true);

        $the_query = query_posts( apply_filters('kt_front_page_args', $args) );

        $function = create_function('', 'return '.intval($excerpt_length).';');
        add_filter('excerpt_length', $function, 9999);

        ?>
        <?php if ( have_posts() ) { ?>
            <div class='blog-posts'>
                <?php
                do_action('before_blog_posts_loop');



                if($type == 'medium' || $type == 'list'){
                    $column = 1;
                }
                $article_column = 12/$column;

                global $wp_query;
                $i = 1;
                while ( have_posts() ) : the_post();

                    $featured = get_post_meta(get_the_ID(), '_kt_post_featured', true);
                    if($i == 1){
                        if($first_featured){
                            get_template_part( 'templates/blog/grid/content', 'first');
                        }

                        $main_column = ($sidebar['sidebar']) ? '8' : '12';
                        $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
                        $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';

                        echo '<div class="row main '.$sidebar_class.'">';
                        echo '<div class="col-md-'.$main_column.' main-content '.$pull_class.'"><div class="row blog-posts-'.$type.'">';

                        if($type == 'grid' || $type == 'masonry'){
                            printf(
                                '<div class="clearfix col-lg-%1$s col-md-%1$s grid-sizer"></div>',
                                $article_column
                            );
                        }

                        if(!$first_featured){
                            printf('<div class="col-lg-%1$s col-md-%1$s">', $article_column);
                            get_template_part( 'templates/blog/'.$type.'/content', get_post_format());
                            echo '</div>';
                        }
                    }else {
                        if($featured == 'yes'){
                            printf('<div class="article-post-item col-lg-12 col-md-12">', $article_column);
                            get_template_part( 'templates/blog/'.$type.'/contentf', get_post_format());
                        }else{
                            printf('<div class="article-post-item col-lg-%1$s col-md-%1$s">', $article_column);
                            get_template_part( 'templates/blog/'.$type.'/content', get_post_format());

                        }
                        echo '</div>';
                    }
                    if($i == $wp_query->post_count){
                        echo '</div><!-- .main-content -->';
                        // Previous/next page navigation.
                        kt_paging_nav();
                        echo "</div>";

                        if($sidebar['sidebar']){
                            echo '<div class="col-md-4 sidebar main-sidebar">';
                            dynamic_sidebar($sidebar['sidebar_area']);
                            echo '</div>';
                        }
                        echo '</div><!-- .main -->';
                    }
                    $i++;
                    // End the loop.
                endwhile;

                if($wp_query->post_count == 1){
                    // Previous/next page navigation.
                    kt_paging_nav();
                }
                /* Restore original Post Data */
                wp_reset_query();
                remove_filter('excerpt_length', $function, 9999);

                do_action('after_blog_posts_loop');

                edit_post_link(
                    sprintf(
                    /* translators: %s: Name of current post */
                        __( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
                        get_the_title()
                    ),
                    '<footer class="entry-footer"><span class="edit-link">',
                    '</span></footer><!-- .entry-footer -->'
                );
                ?>
            </div><!-- .blog-posts -->
            <?php
        // If no content, include the "No posts found" template.
        }else{
            get_template_part( 'templates/content', 'none' );
        }
    }
    ?>
</div><!-- .container -->
<?php get_footer(); ?>
