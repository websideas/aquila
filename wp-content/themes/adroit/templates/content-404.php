
<div class="content-404">
    <div class="page-not-found">
        <h1><?php esc_html_e('404', 'adroit'); ?></h1>
        <h3><?php esc_html_e('Oops, page not found.', 'adroit') ?></h3>
        <p ><?php echo wp_kses(__('It looks like nothing was found at this location. <br />Click the link below to return home.', 'adroit' ),array( 'br' => array() )); ?></p>
        <div class="buttons">
            <a title="<?php esc_html_e('Back to Home', 'adroit'); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e('Return home', 'adroit' ); ?>
                <i class="fa fa-long-arrow-right"></i>
            </a>
        </div>
        
        
        <script>
            function goBack() {
                window.history.back()
            }
        </script>
    </div><!-- .page-not-found -->
</div><!-- .content-404 -->