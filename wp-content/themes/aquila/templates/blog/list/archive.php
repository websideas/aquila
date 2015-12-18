<?php


$sidebar = kt_get_archive_sidebar();
$settings = kt_get_settings_archive();

global $wp_query;
$i = 1;

$sidebar = array('sidebar' => '', 'sidebar_area' => 'primary-widget-area');


echo '<div class="row main">';

$main_column = ($sidebar['sidebar']) ? '8' : '12';
$sidebar_class = ($sidebar['sidebar'] == 'left') ? 'pull-right' : '';
$article_column = 12;

echo '<div class="col-md-'.$main_column.' '.$sidebar_class.'"><div class="row main-content blog-posts-list">';


while ( have_posts() ) : the_post();
    printf('<div class="col-lg-%1$s col-md-%1$s">', $article_column);
    get_template_part( 'templates/blog/list/content', get_post_format());
    echo '</div>';
    $i++;
    // End the loop.
endwhile;

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
