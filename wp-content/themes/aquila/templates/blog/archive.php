<?php


$type = 'list';
$column = 3;
$first_featured = true;
$sidebar = array('sidebar' => 'right', 'sidebar_area' => 'primary-widget-area');



if($type == 'medium' || $type == 'list'){
    $column = 1;
}
$article_column = 12/$column;
$i = 1;


global $wp_query;
while ( have_posts() ) : the_post();
    if($i == 1){
        if($first_featured){
            get_template_part( 'templates/blog/gird/content', 'first');
        }

        $main_column = ($sidebar['sidebar']) ? '8' : '12';
        $sidebar_class = ($sidebar['sidebar']) ? 'sidebar-'.$sidebar['sidebar'] : 'no-sidebar';
        $pull_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';

        echo '<div class="row main '.$sidebar_class.'">';
        echo '<div class="col-md-'.$main_column.' main-content '.$pull_class.'"><div class="row multi-columns-row blog-posts-'.$type.'">';

        if(!$first_featured){
            printf('<div class="col-lg-%1$s col-md-%1$s">', $article_column);
            get_template_part( 'templates/blog/'.$type.'/content', get_post_format());
            echo '</div>';
        }
    }else {
        printf('<div class="article-post-item col-lg-%1$s col-md-%1$s">', $article_column);
        $featured = get_post_meta(get_the_ID(), '_kt_post_featured', true);
        if($featured == 'yes' && $type != 'gird' && $type != 'masonry' ){
            get_template_part( 'templates/blog/'.$type.'/contentf', get_post_format());
        }else{
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