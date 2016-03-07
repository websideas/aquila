<div <?php post_class('post-item-content post-item-featured'); ?>>
    <?php
    $quote = get_post_meta(get_the_ID(), '_kt_quote_content', true);
    $author = get_post_meta(get_the_ID(), '_kt_quote_author', true);

    ?>

    <blockquote class="post-item-quote">
        <?php
        printf('<p>%s</p>', $quote);
        if($author){
            printf('<footer>%s</footer>', $author);
        }
        ?>

    </blockquote>

</div>