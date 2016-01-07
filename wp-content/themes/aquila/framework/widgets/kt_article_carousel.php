<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT_Posts widget class
 *
 * @since 1.0
 */
class Widget_KT_Posts_Carousel extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_posts_carousel', 'description' => esc_html__( "Show posts of categories.") );
        parent::__construct('kt_posts_carousel', esc_html__('KT: Posts Carousel', 'aquila'), $widget_ops);
        $this->alt_option_name = 'widget_kt_posts_carousel';

        add_action( 'save_post', array($this, 'flush_widget_cache') );
        add_action( 'deleted_post', array($this, 'flush_widget_cache') );
        add_action( 'switch_theme', array($this, 'flush_widget_cache') );
    }

    public function widget($args, $instance) {
        $cache = array();
        if ( ! $this->is_preview() ) {
            $cache = wp_cache_get( 'widget_kt_posts_carousel', 'widget' );
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

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;

        $args_article =  array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'order' => $instance['order'],
            'orderby' => $instance['orderby']
        );

        if(is_array($instance['category'])){
            $args_article['category__in'] = $instance['category'];
        }

        //print_r($args_article);

        /**
         * Filter the arguments for the KT Posts widget.
         *
         * @since 3.4.0
         *
         * @see WP_Query::get_posts()
         *
         * @param array $args An array of arguments used to retrieve the recent posts.
         */
        $r = new WP_Query( apply_filters( 'widget_posts_args', $args_article ) );

        if ($r->have_posts()) :

            echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            ?>
            <ul class="kt_posts_carousel_widget">
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                    <li <?php post_class('article-widget clearfix'); ?>>
                        <?php kt_post_thumbnail_image( 'kt_widget_article_carousel', 'img-responsive' ); ?>
                        <div class="article-attr">
                            <a class="carousel-prev" href="#"><i class="fa fa-angle-left"></i></a>
                            <h3 class="title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php get_the_title() ? the_title() : the_ID(); ?>
                                </a>
                            </h3>
                            <a class="carousel-next" href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php

            echo $args['after_widget'];

            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        if ( ! $this->is_preview() ) {
            $cache[ $args['widget_id'] ] = ob_get_flush();
            wp_cache_set( 'widget_kt_posts_carousel', $cache, 'widget' );
        } else {
            ob_end_flush();
        }
    }

    public function update( $new_instance, $old_instance ) {


        print_r($_POST);

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];

        $instance['category'] = isset( $new_instance['category'] ) ? $new_instance['category'] :  array();

        if ( in_array( $new_instance['orderby'], array( 'name', 'id', 'date', 'author', 'modified', 'rand', 'comment_count' ) ) ) {
            $instance['orderby'] = $new_instance['orderby'];
        } else {
            $instance['orderby'] = 'date';
        }

        if ( in_array( $new_instance['order'], array( 'DESC', 'ASC' ) ) ) {
            $instance['order'] = $new_instance['order'];
        } else {
            $instance['order'] = 'DESC';
        }

        $this->flush_widget_cache();

        $alloptions = wp_cache_get( 'alloptions', 'options' );
        if ( isset($alloptions['widget_kt_posts_carousel']) )
            delete_option('widget_kt_posts_carousel');

        return $instance;
    }

    public function flush_widget_cache() {
        wp_cache_delete('widget_kt_posts_carousel', 'widget');
    }

    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;

        $order = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
        $orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';

        $category = isset( $instance['category'] ) ? $instance['category'] : array();

        $categories = get_terms( 'category', array('hide_empty' => false));

        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show:' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" class="widefat" /></p>

        <div><label for="<?php echo $this->get_field_id('category'); ?>"><?php esc_html_e('Categories:','aquila'); ?> </label>
            <select class="widefat categories-chosen" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple="multiple">
                <?php foreach($categories as $item){ ?>
                    <option <?php if (in_array($item->term_id, $category)){ echo 'selected="selected"';} ?> value="<?php echo $item->term_id ?>"><?php echo $item->name; ?></option>
                <?php } ?>
            </select>
        </div>

        <p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php esc_html_e('Order by:', 'aquila'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option <?php selected( $orderby, 'name' ); ?> value="name"><?php esc_html_e('Name','aquila'); ?></option>
                <option <?php selected( $orderby, 'id' ); ?> value="id"><?php esc_html_e('ID','aquila'); ?></option>
                <option <?php selected( $orderby, 'date' ); ?> value="date"><?php esc_html_e('Date','aquila'); ?></option>
                <option <?php selected( $orderby, 'author' ); ?> value="author"><?php esc_html_e('Author','aquila'); ?></option>
                <option <?php selected( $orderby, 'modified' ); ?> value="modified"><?php esc_html_e('Modified','aquila'); ?></option>
                <option <?php selected( $orderby, 'rand' ); ?> value="rand"><?php esc_html_e('Rand','aquila'); ?></option>
                <option <?php selected( $orderby, 'comment_count' ); ?> value="comment_count "><?php esc_html_e('Comment count','aquila'); ?></option>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id('order'); ?>"><?php esc_html_e('Order:','aquila'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                <option <?php selected( $order, 'DESC' ); ?> value="DESC"><?php esc_html_e('Desc','aquila'); ?></option>
                <option <?php selected( $order, 'ASC' ); ?> value="ASC"><?php esc_html_e('ASC','aquila'); ?></option>
            </select>
        </p>

        <script type="text/javascript">
            (function($){
                $('document').ready(function() {
                    $('.categories-chosen').chosen();
                });
            })(jQuery);
        </script>

    <?php
    }
}




/**
 * Register KT_Posts_Carousel widget
 *
 *
 */

register_widget('Widget_KT_Posts_Carousel');