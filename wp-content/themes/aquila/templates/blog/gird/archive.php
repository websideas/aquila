<?php

global $wp_query;

$column = 2;
$first_featured = true;
$sidebar = array('sidebar' => 'right', 'sidebar_area' => 'primary-widget-area');

$article_column = 12/$column;

$i = 1;
while ( have_posts() ) : the_post();
    if($i == 1){
        if($first_featured){
            get_template_part( 'templates/blog/gird/content', 'first');
        }
        echo '<div class="row main">';
        $main_column = ($sidebar['sidebar']) ? '8' : '12';
        $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
        $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';
        echo '<div class="col-md-'.$main_column.' main-content '.$sidebar_class.' '.$pull_class.'"><div class="row multi-columns-row blog-posts-gird">';

        if(!$first_featured){
            printf('<div class="col-lg-%1$s col-md-%1$s">', $article_column);
            get_template_part( 'templates/blog/gird/content', get_post_format());
            echo '</div>';
        }
    }else {
        printf('<div class="col-lg-%1$s col-md-%1$s">', $article_column);
        get_template_part( 'templates/blog/gird/content', get_post_format());
        echo '</div>';
    }

    if($i == $wp_query->post_count){
        echo '</div><!-- .main-content -->';
        // Previous/next page navigation.
        kt_paging_nav();
        echo "</div>";

        if($sidebar['sidebar']){
            echo '<div class="col-md-4 sidebar sidebar-'.$sidebar['sidebar'].'">';
            dynamic_sidebar('primary-widget-area');
            echo '</div>';
        }
        echo '</div><!-- .main -->';
    }

    $i++;
    // End the loop.
endwhile;



if($wp_query->post_count == 1){
    // Previous/next page navigation.
    kt_paging_nav($settings['blog_pagination']);
}