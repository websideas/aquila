<form method="get" class="searchform clearfix" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" placeholder="<?php esc_html_e('Type and hit enter ...', 'adroit'); ?>"  value="<?php echo get_search_query(); ?>" name="s" />
    <button class="submit"><i class="fa fa-search"></i></button>
</form>