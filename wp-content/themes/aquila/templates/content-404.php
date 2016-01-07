
<div class="content-404">
    <div class="page-not-found">
        <h1><?php esc_html_e('404', 'aquila'); ?></h1>
        <h3><?php esc_html_e('Oops, page not found.', 'aquila') ?></h3>
        <p ><?php wp_kses(esc_html_e('It looks like nothing was found at this location. <br />Click the link below to return home.', 'aquila' ),array( 'br' => array() )); ?></p>
        <div class="buttons">
            <a title="<?php esc_html_e('Back to Home', 'aquila'); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php esc_html_e('Return home', 'aquila' ); ?>
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