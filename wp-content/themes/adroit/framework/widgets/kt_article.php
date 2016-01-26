<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT_Posts widget class
 *
 * @since 1.0
 */
class Widget_KT_Posts extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_posts', 'description' => esc_html__( "Show posts of categories.",'adroit') );
        parent::__construct('kt_posts', esc_html__('KT: Posts', 'adroit'), $widget_ops);
        $this->alt_option_name = 'widget_kt_posts';
    }

    public function widget($args, $instance) {

        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;

        $just_featured = isset( $instance['just_featured'] ) ? $instance['just_featured'] : false;

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

        if( $just_featured == true ){
            $args_article['meta_key'] = '_kt_post_featured';
            $args_article['meta_value'] = 'yes';
        }

        $r = new WP_Query( apply_filters( 'widget_posts_args', $args_article ) );

        if ($r->have_posts()) :

            $layout = ( ! empty( $instance['layout'] ) ) ? absint( $instance['layout'] ) : 1;
            if ( ! $layout )
                $layout = 1;

            echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }
            ?>
            <ul class="kt_posts_widget kt-artilce-<?php echo esc_attr($layout) ?>">
                <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                    <li <?php post_class('article-widget clearfix'); ?>>
                        <?php
                            if( $layout == 2 ){
                                kt_post_thumbnail_image( 'kt_recent_posts', 'img-responsive' );
                            }else{
                                kt_post_thumbnail_image( 'kt_widget_article', 'img-responsive' );
                            }
                        ?>
                        <div class="article-attr">
                            <h3 class="title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>
                            <?php ($layout == 2) ? kt_entry_meta() : kt_entry_date(); ?>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            <?php
            echo $args['after_widget'];

            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;
    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int) $new_instance['number'];
        $instance['layout'] = isset( $new_instance['layout'] ) ? (int) $new_instance['layout'] : 1;

        $instance['just_featured'] = isset( $new_instance['just_featured'] ) ? (bool) $new_instance['just_featured'] : false;

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

        return $instance;
    }


    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'Recent Posts' , 'adroit');
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;

        $just_featured = isset( $instance['just_featured'] ) ? (bool) $instance['just_featured'] : false;

        $order = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
        $orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : 'date';
        $layout = isset( $instance['layout'] ) ? absint( $instance['layout'] ) : 1;

        $category = isset( $instance['category'] ) ? $instance['category'] : array();

        $categories = get_terms( 'category', array('hide_empty' => false));

        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'adroit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show:','adroit' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr($number); ?>" class="widefat" /></p>

        <div><label for="<?php echo $this->get_field_id('category'); ?>"><?php esc_html_e('Categories:','adroit'); ?> </label>
            <select class="widefat categories-chosen" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple="multiple">
                <?php foreach($categories as $item){ ?>
                    <option <?php if (in_array($item->term_id, $category)){ echo 'selected="selected"';} ?> value="<?php echo $item->term_id ?>"><?php echo $item->name; ?></option>
                <?php } ?>
            </select>
        </div>

        <p>
            <input class="checkbox" type="checkbox" <?php checked( $just_featured ); ?> id="<?php echo $this->get_field_id( 'just_featured' ); ?>" name="<?php echo $this->get_field_name( 'just_featured' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'just_featured' ); ?>"><?php esc_html_e( 'Display Just Featured','adroit' ); ?></label>
        </p>

        <p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php esc_html_e('Order by:', 'adroit'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
                <option <?php selected( $orderby, 'name' ); ?> value="name"><?php esc_html_e('Name','adroit'); ?></option>
                <option <?php selected( $orderby, 'id' ); ?> value="id"><?php esc_html_e('ID','adroit'); ?></option>
                <option <?php selected( $orderby, 'date' ); ?> value="date"><?php esc_html_e('Date','adroit'); ?></option>
                <option <?php selected( $orderby, 'author' ); ?> value="author"><?php esc_html_e('Author','adroit'); ?></option>
                <option <?php selected( $orderby, 'modified' ); ?> value="modified"><?php esc_html_e('Modified','adroit'); ?></option>
                <option <?php selected( $orderby, 'rand' ); ?> value="rand"><?php esc_html_e('Rand','adroit'); ?></option>
                <option <?php selected( $orderby, 'comment_count' ); ?> value="comment_count "><?php esc_html_e('Comment count','adroit'); ?></option>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id('order'); ?>"><?php esc_html_e('Order:','adroit'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
                <option <?php selected( $order, 'DESC' ); ?> value="DESC"><?php esc_html_e('Desc','adroit'); ?></option>
                <option <?php selected( $order, 'ASC' ); ?> value="ASC"><?php esc_html_e('ASC','adroit'); ?></option>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id('layout'); ?>"><?php esc_html_e('Layout:','adroit'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
                <option <?php selected( $layout, '1' ); ?> value="1"><?php esc_html_e('Layout 1','adroit'); ?></option>
                <option <?php selected( $layout, '2' ); ?> value="2"><?php esc_html_e('Layout 2','adroit'); ?></option>
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
 * Register KT_Posts widget
 *
 *
 */

register_widget('Widget_KT_Posts');
