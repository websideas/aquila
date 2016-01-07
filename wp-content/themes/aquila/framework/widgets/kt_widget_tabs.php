<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT tabs widget class
 *
 * @since 1.0
 */
class WP_Widget_KT_Tabs extends WP_Widget {

	public function __construct() {

        $widget_ops = array('classname' => 'widget_kt_post_tabs', 'description' => esc_html__( "Display popular posts, recent posts and comments in tabbed format.",'aquila') );
        parent::__construct('kt_post_tabs', esc_html__('KT: Post Tabs', 'aquila'), $widget_ops);
        $this->alt_option_name = 'widget_kt_post_tabs';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );

	}

	public function widget( $args, $instance ) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'widget_kt_post_tabs', 'widget' );
        }

        if ( ! is_array( $cache ) ) {
            $cache = array();
        }

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        $select_recent = isset( $instance['select_recent'] ) ? $instance['select_recent'] : true;
        $select_comments = isset( $instance['select_comments'] ) ? $instance['select_comments'] : true;
        $select_view = isset( $instance['select_view'] ) ? $instance['select_view'] : true;

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;

            
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }



        if( $select_view || $select_recent || $select_comments){

            $rand = rand();

            $tabs = array();
            if($select_view)  $tabs[] = 'view';
            if($select_recent)  $tabs[] = 'recent';
            if($select_comments)  $tabs[] = 'comments';

            ?>
            <div class="kt_widget_tabs">
                <ul class="clearfix kt-tabs-nav">
                    <?php if( $select_view ){ ?><li><a href="#kt_tab_view<?php echo $rand; ?>"><span><?php esc_html_e( 'Most View', 'aquila' ); ?></span><i class="fa fa-eye"></i></a></li><?php } ?>
                    <?php if( $select_recent ){ ?><li><a href="#kt_tab_recent<?php echo $rand; ?>"><span><?php esc_html_e( 'Most recent', 'aquila' ); ?></span><i class="fa fa-newspaper-o"></i></a></li><?php } ?>
                    <?php if( $select_comments ){ ?><li><a href="#kt_tab_comments<?php echo $rand; ?>"><span><?php esc_html_e( 'Most comment', 'aquila' ); ?></span><i class="fa fa-comments-o"></i></a></li><?php } ?>
                </ul>
                <div class="tabs-container">
                    <?php
                    if(count($tabs)){
                        $argsp =  array(
                            'posts_per_page'      => $number,
                            'ignore_sticky_posts' => true,
                            'order'               => 'DESC',
                        );
                        foreach($tabs as $tab){
                            $argsn = $argsp;
                            if($tab == 'view'){
                                $argsn['orderby'] = 'meta_value_num';
                                $argsn['meta_key']  = 'kt_post_views_count';
                            }elseif($tab == 'recent'){
                                $argsn['orderby'] = 'date';
                            }elseif($tab == 'comments'){
                                $argsn['orderby'] = 'comment_count';
                            }

                            $query = new WP_Query( apply_filters( 'widget_posts_args', $argsn ) );

                            ?>
                            <div id="kt_tab_<?php echo $tab ?><?php echo $rand; ?>" class="kt_tabs_content">
                                <?php if ($query->have_posts()){ ?>
                                    <ul class="kt_posts_widget">
                                        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                            <li <?php post_class('article-widget clearfix'); ?>>
                                                <?php kt_post_thumbnail_image( 'kt_recent_posts', 'img-responsive' ); ?>
                                                <div class="article-attr">
                                                    <h3 class="title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                                                    <?php kt_entry_date();?>
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

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'widget_kt_post_tabs', $cache, 'widget' );
        } else {
            ob_end_flush();
        }

	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['select_view'] = isset( $new_instance['select_view'] ) ? (bool) $new_instance['select_view'] : false;
        $instance['select_recent'] = isset( $new_instance['select_recent'] ) ? (bool) $new_instance['select_recent'] : false;
        $instance['select_comments'] = isset( $new_instance['select_comments'] ) ? (bool) $new_instance['select_comments'] : false;
        
        $instance['number'] = (int) $new_instance['number'];

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_kt_post_tabs']) )
            delete_option('widget_kt_post_tabs');

        return $instance;
	}

    public function flush_widget_cache() {
        wp_cache_delete('widget_kt_post_tabs', 'widget');
    }

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        
        $select_view = isset( $instance['select_view'] ) ? (bool) $instance['select_view'] : true;
        $select_recent = isset( $instance['select_recent'] ) ? (bool) $instance['select_recent'] : true;
        $select_comments = isset( $instance['select_comments'] ) ? (bool) $instance['select_comments'] : true;
        
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		
	?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','aquila' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
    
    <h4><?php esc_html_e('Select Tabs', 'aquila'); ?></h4>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_view ); ?> id="<?php echo $this->get_field_id( 'select_view' ); ?>" name="<?php echo $this->get_field_name( 'select_view' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_view' ); ?>"><?php esc_html_e( 'Display Most View','aquila' ); ?></label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_recent ); ?> id="<?php echo $this->get_field_id( 'select_recent' ); ?>" name="<?php echo $this->get_field_name( 'select_recent' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_recent' ); ?>"><?php esc_html_e( 'Display Recent Posts','aquila' ); ?></label>
    </p>
    <p>
        <input class="checkbox" type="checkbox" <?php checked( $select_comments ); ?> id="<?php echo $this->get_field_id( 'select_comments' ); ?>" name="<?php echo $this->get_field_name( 'select_comments' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'select_comments' ); ?>"><?php esc_html_e( 'Display Most Comments','aquila' ); ?></label>
    </p>
    
    <h4><?php esc_html_e('Options Tabs', 'aquila'); ?></h4>
    
    <p>
        <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show:','aquila' ); ?></label>
        <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" class="widefat" />
    </p>
<?php
	}
}



/**
 * Register KT_Tabs widget
 *
 *
 */

register_widget( 'WP_Widget_KT_Tabs' );