<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT tabs widget class
 *
 * @since 1.0
 */
class WP_Widget_KT_Popular extends WP_Widget {

	public function __construct() {

        $widget_ops = array('classname' => 'widget_kt_post_popular', 'description' => esc_html__( "Display popular posts of week, month and year in tabbed format.",'adroit') );
        parent::__construct('kt_post_popular', esc_html__('KT: Post Popular', 'adroit'), $widget_ops);
        $this->alt_option_name = 'widget_kt_post_popular';

	}

	public function widget( $args, $instance ) {

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        
        $select_week = isset( $instance['select_week'] ) ? $instance['select_week'] : true;
        $select_month = isset( $instance['select_month'] ) ? $instance['select_month'] : true;
        $select_year = isset( $instance['select_year'] ) ? $instance['select_year'] : true;
        
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? $instance['show_thumbnail'] : true;
            
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }


        if( $select_week || $select_month || $select_year ){

            $rand = rand();

            $tabs = array();
            if($select_week)  $tabs[] = 'week';
            if($select_month)  $tabs[] = 'month';
            if($select_year)  $tabs[] = 'year';


            ?>
            <div class="kt_widget_tabs">
                <ul class="clearfix kt-tabs-nav">
                    <?php if( $select_week ){ ?><li><a href="#kt_tab_week<?php echo $rand; ?>"><?php esc_html_e( '1 Week', 'adroit' ); ?></a></li><?php } ?>
                    <?php if( $select_month ){ ?><li><a href="#kt_tab_month<?php echo $rand; ?>"><?php esc_html_e( '1 Month', 'adroit' ); ?></a></li><?php } ?>
                    <?php if( $select_year ){ ?><li><a href="#kt_tab_year<?php echo $rand; ?>"><?php esc_html_e( '1 year', 'adroit' ); ?></a></li><?php } ?>
                </ul>
                <div class="tabs-container">
                    <?php
                    if(count($tabs)){
                        $argsp =  array(
                            'posts_per_page'      => $number,
                            'ignore_sticky_posts' => true,
                            'post_status' => 'publish',
                            'orderby' => 'meta_value_num',
                            'meta_key' => 'kt_post_views_count'
                        );
                        
                        foreach($tabs as $tab){
                            $argsn = $argsp;
                            if($tab == 'week'){
                                $argsn['date_query'] = array(
                        			array(
                            			'year' => date( 'Y' ),
                            			'week' => date( 'w' ),
                            		),
                            	);
                            }elseif($tab == 'month'){
                                $argsn['date_query'] = array(
                        			array(
                            			'after'     => array(
                                            'year'  => date('Y'),
                            				'month' => date('m')-1,
                            				'day'   => date('d'),
                                        ),
                            			'before'    => array(
                            				'year'  => date('Y'),
                            				'month' => date('m'),
                            				'day'   => date('d'),
                            			),
                            			'inclusive' => true,
                            		),
                            	);
                            }elseif($tab == 'year'){
                                $argsn['date_query'] = array(
                        			array(
                            			'after'     => array(
                                            'year'  => date('Y'),
                            				'month' => date('m'),
                            				'day'   => date('d'),
                                        ),
                            			'before'    => array(
                            				'year'  => date('Y'),
                            				'month' => date('m'),
                            				'day'   => date('d'),
                            			),
                            			'inclusive' => true,
                            		),
                            	);
                            }

                            $query = new WP_Query( apply_filters( 'widget_posts_args', $argsn ) );

                            ?>
                            <div id="kt_tab_<?php echo $tab ?><?php echo $rand; ?>" class="kt_tabs_content">
                                <?php if ($query->have_posts()){ ?>
                                    <ul>
                                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                            <li <?php post_class('article-widget clearfix'); ?>>
                                                <?php if($show_thumbnail){ kt_post_thumbnail_image( 'kt_small', 'img-responsive' ); } ?>
                                                <div class="article-attr">
                                                    <h3 class="title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                                                    <div class="entry-meta-data">
                                                        <?php 
                                                            kt_entry_date( );
                                                            kt_get_post_views( );
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endwhile; wp_reset_postdata(); ?>
                                    </ul>
                                <?php } ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        <?php }
        
        echo $args['after_widget'];


	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['select_week'] = isset( $new_instance['select_week'] ) ? (bool) $new_instance['select_week'] : false;
        $instance['select_month'] = isset( $new_instance['select_month'] ) ? (bool) $new_instance['select_month'] : false;
        $instance['select_year'] = isset( $new_instance['select_year'] ) ? (bool) $new_instance['select_year'] : false;
        
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_thumbnail'] = isset( $new_instance['show_thumbnail'] ) ? (bool) $new_instance['show_thumbnail'] : false;

        return $instance;
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'Widget Tabs' , 'adroit');
        
        $select_week = isset( $instance['select_week'] ) ? (bool) $instance['select_week'] : true;
        $select_month = isset( $instance['select_month'] ) ? (bool) $instance['select_month'] : true;
        $select_year = isset( $instance['select_year'] ) ? (bool) $instance['select_year'] : true;
        
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_thumbnail = isset( $instance['show_thumbnail'] ) ? (bool) $instance['show_thumbnail'] : true;
		
	?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','adroit' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
    
    <h4><?php esc_html_e('Select Tabs', 'adroit'); ?></h4>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_week ); ?> id="<?php echo $this->get_field_id( 'select_week' ); ?>" name="<?php echo $this->get_field_name( 'select_week' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_week' ); ?>"><?php esc_html_e( 'Display Popular Posts of week','adroit' ); ?></label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_month ); ?> id="<?php echo $this->get_field_id( 'select_month' ); ?>" name="<?php echo $this->get_field_name( 'select_month' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_month' ); ?>"><?php esc_html_e( 'Display Popular Posts of Month','adroit' ); ?></label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_year ); ?> id="<?php echo $this->get_field_id( 'select_year' ); ?>" name="<?php echo $this->get_field_name( 'select_year' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_year' ); ?>"><?php esc_html_e( 'Display Popular Posts of Year','adroit' ); ?></label>
    </p>
    
    <h4><?php esc_html_e('Options Tabs', 'adroit'); ?></h4>
    
    <p> 
        <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show:','adroit' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr($number); ?>" class="widefat" />
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $show_thumbnail ); ?> id="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_thumbnail' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_thumbnail' ); ?>"><?php esc_html_e( 'Show Thumbnail (Avatar Comments)','adroit' ); ?></label>
    </p>
<?php
	}
}



/**
 * Register KT_Popular widget
 *
 *
 */

register_widget( 'WP_Widget_KT_Popular' );