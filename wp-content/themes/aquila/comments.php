<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title post-single-heading">
            <?php
            printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', THEME_LANG ),
                number_format_i18n( get_comments_number() ), get_the_title() );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments( array(
                'style'       => 'ul',
                'short_ping'  => true,
                'avatar_size' => 60,
                'callback' => 'kt_comments'
            ) );
            ?>
        </ol><!-- .comment-list -->

        <?php kt_comment_nav(); ?>

    <?php endif; // have_comments() ?>

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
        <p class="no-comments"><?php _e( 'Comments are closed.', 'twentyfifteen' ); ?></p>
    <?php endif; ?>
    
    <?php


    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html_req = ( $req ? " required='required'" : '' );

    $required = ' '.__('(required)', THEME_LANG);

    $new_fields = array(
        'author' => '<p class="comment_field-column comment-form-author">' .
            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"  placeholder="'.__('Name', THEME_LANG).'"' . $aria_req . $html_req . ' /></p>',
        'email'  => '<p class="comment_field-column comment-form-email">' .
            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="'.__('Email', THEME_LANG).'"' . $aria_req . $html_req . ' /></p></div>',
        'url'    => '<p class="comment-form-url">' .
            '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="'.__('Website', THEME_LANG).'" /></p>',
    );

    $comments_args = array(
        'label_submit'      => __( 'send messages' ),
        'fields' => apply_filters( 'comment_form_default_fields', $new_fields ),
        //'comment_form_before_fields' => '<div>',
        //'comment_form_after_fields' => '</div>',
        'comment_field' => '<p><textarea id="comment" name="comment" placeholder="'.__('Your Comment', THEME_LANG).'"  aria-required="true" rows="6"></textarea></p>',
        'class_submit'      => 'btn btn-default',
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title post-single-heading">',
    );

    ?>
    
    <?php comment_form($comments_args); ?>

</div><!-- .comments-area -->
