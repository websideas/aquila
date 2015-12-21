<?php

global $wp_query;


$first_featured = true;
$sidebar = array('sidebar' => 'left', 'sidebar_area' => 'primary-widget-area');
$article_column = 12;


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
        echo '<div class="col-md-'.$main_column.' '.$sidebar_class.' '.$pull_class.'"><div class="row main-content blog-posts-medium">';

        if(!$first_featured){
            printf('<div class="col-lg-%1$s col-md-%1$s">', $article_column);
            get_template_part( 'templates/blog/medium/content', get_post_format());
            echo '</div>';
        }
    }else {
        $featured = get_post_meta(get_the_ID(), '_kt_post_featured', true);

        printf('<div class="col-lg-%1$s col-md-%1$s">', $article_column);
        if($featured == 'yes'){
            get_template_part( 'templates/blog/medium/contentf', get_post_format());
        }else{
            get_template_part( 'templates/blog/medium/content', get_post_format());
        }
        echo '</div>';
    }

    if($i == $wp_query->post_count){
        echo '</div><!-- .main-content -->';
        // Previous/next page navigation.
        kt_paging_nav();
        echo "</div>";

        if($sidebar['sidebar']){
            echo '<div class="col-md-4">';
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
    kt_paging_nav();
}