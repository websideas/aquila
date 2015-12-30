<?php
/**
 * The template for displaying archive
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 */


$sidebar = kt_get_archive_sidebar();

get_header(); ?>

    <?php if ( have_posts() ) { ?>
        <div class='blog-posts'>
            <div class="container">
                <?php

                do_action('before_blog_posts_loop');


                if(is_author()){
                    $type = kt_option('author_loop_style', 'grid');
                    $column = kt_option('author_columns', 3);
                    $first_featured = kt_option('author_first_featured', false);
                    $pagination = kt_option('author_pagination', 'normal');
                }elseif(is_search()){
                    $type = kt_option('search_loop_style', 'grid');
                    $column = kt_option('search_columns', 3);
                    $first_featured = kt_option('search_first_featured', false);
                    $pagination = kt_option('search_pagination', 'normal');
                }else{
                    $type = kt_option('archive_loop_style', 'gird');
                    $column = kt_option('archive_columns', 2);
                    $first_featured = kt_option('archive_first_featured', false);
                    $pagination = kt_option('archive_pagination', 'normal');
                }


                if($type == 'medium' || $type == 'list'){
                    $column = 1;
                }
                $article_column = 12/$column;
                $i = 1;

                global $wp_query;
                while ( have_posts() ) : the_post();
                    if($i == 1){
                        if($first_featured){
                            get_template_part( 'templates/blog/grid/content', 'first');
                        }

                        $main_column = ($sidebar['sidebar']) ? '8' : '12';
                        $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
                        $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';

                        echo '<div class="row main '.$sidebar_class.'">';
                        echo '<div class="col-md-'.$main_column.' main-content '.$pull_class.'"><div class="row multi-columns-row blog-posts-'.$type.'">';

                        if(!$first_featured){
                            printf('<div class="col-lg-%1$s col-md-%1$s col-sm-%1$s">', $article_column);
                            get_template_part( 'templates/blog/'.$type.'/content', get_post_format());
                            echo '</div>';
                        }
                    }else {
                        printf('<div class="article-post-item col-lg-%1$s col-md-%1$s col-sm-%1$s">', $article_column);
                        $featured = get_post_meta(get_the_ID(), '_kt_post_featured', true);
                        if($featured == 'yes' && $type != 'grid' && $type != 'masonry' ){
                            get_template_part( 'templates/blog/'.$type.'/contentf', get_post_format());
                        }else{
                            get_template_part( 'templates/blog/'.$type.'/content', get_post_format());
                        }
                        echo '</div>';
                    }
                    if($i == $wp_query->post_count){
                        echo '</div><!-- .main-content -->';
                        // Previous/next page navigation.
                        kt_paging_nav($pagination);
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
                    kt_paging_nav($pagination);
                }

                do_action('after_blog_posts_loop');

                ?>
            </div><!-- .container -->
        </div><!-- .blog-posts -->
    <?php
    // If no content, include the "No posts found" template.
    }else{
        get_template_part( 'templates/content', 'none' );
    }
    ?>

<?php get_footer(); ?>
