
<div class="content-404">
    <div class="page-not-found">
        <h1><?php _e('404', THEME_LANG); ?></h1>
        <h3><?php _e('Oops, page not found.', THEME_LANG) ?></h3>
        <p ><?php _e('It looks like nothing was found at this location. <br />Click the link below to return home.', THEME_LANG ); ?></p>
        <div class="buttons">
            <a title="<?php _e('Back to Home', THEME_LANG); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php _e('Return home', THEME_LANG ); ?>
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