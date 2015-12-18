<?php


$sidebar = kt_get_archive_sidebar();
$settings = kt_get_settings_archive();

global $wp_query;
$i = $j = 1;

$type = 'gird';
$column = 2;
$first_featured = true;
$sidebar = array('sidebar' => 'right', 'sidebar_area' => 'primary-widget-area');



$article_column = 12/$column;


while ( have_posts() ) : the_post();


    if($i == 1){
        if($first_featured){
            get_template_part( 'templates/blog/gird/content', 'featured');

        }
        echo '<div class="row main">';

        $main_column = ($sidebar['sidebar']) ? '8' : '12';
        $sidebar_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';

        echo '<div class="col-md-'.$main_column.' '.$sidebar_class.'"><div class="row main-content multi-columns-row">';

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
    kt_paging_nav($settings['blog_pagination']);
}