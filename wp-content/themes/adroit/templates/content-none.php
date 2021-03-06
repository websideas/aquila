<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?>
<div class="container">
    <div class="no-results not-found">
        <div class="page-content">

            <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

                <p><?php printf( wp_kses(__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'adroit' ), array( 'a' => array('href' => array(),'title' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

            <?php elseif ( is_search() ) : ?>

                <p>
                    <?php printf( wp_kses(__( "Sorry ! No post was found by <span class='search-keyword'>'%s'</span>.", 'adroit' ), array( 'span' => array() ) ), get_search_query() ); ?>
                    <?php esc_html_e('Try searching for something else', 'adroit'); ?>
                </p>
                <?php get_search_form(); ?>

            <?php else : ?>

                <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'adroit' ); ?></p>
                <?php get_search_form(); ?>

            <?php endif; ?>

        </div><!-- .page-content -->
    </div><!-- .no-results -->
</div>