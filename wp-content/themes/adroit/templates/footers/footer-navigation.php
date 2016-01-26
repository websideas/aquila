<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
?>

<?php if ( has_nav_menu( 'footer' ) ) { ?>
    <div id="footer-navigation">
        <div class="container">
            <?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
        </div>
    </div>
<?php } ?>