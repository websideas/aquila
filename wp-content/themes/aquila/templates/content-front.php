<?php

$post_id = get_the_ID();
$frontpage_type = get_post_meta($post_id, '_kt_frontpage_type', true);

echo $frontpage_type;

?>