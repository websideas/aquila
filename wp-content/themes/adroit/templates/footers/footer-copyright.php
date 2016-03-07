<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

$copyright_text = kt_option('footer_copyright_text', '&copy; Copyright Alitstudio 2016 .All Rights Reserved.');
echo sprintf('<div class="footer-copyright">%s</div>', do_shortcode($copyright_text));
