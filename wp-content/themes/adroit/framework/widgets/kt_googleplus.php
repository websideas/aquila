<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT_Goolge widget class
 *
 * @since 1.0
 */
class Widget_KT_Goolge extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_google', 'description' => esc_html__( "Embed Google+ Badge.", 'adroit') );
        parent::__construct('widget_kt_google', esc_html__('KT: Google+ Badge', 'adroit'), $widget_ops);
        $this->alt_option_name = 'widget_kt_google';


    }
    public function widget($args, $instance) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        $href = esc_url($instance['href']);
        if($href){

            $cover = isset( $instance['cover'] ) ? (bool) $instance['cover'] : true;
            $tagline = isset( $instance['tagline'] ) ? (bool) $instance['tagline'] : true;

            $layout =  ( in_array( $instance['layout'], array( 'portrait', 'landscape' ) ) ) ? $instance['layout'] : 'portrait';
            $type =  ( in_array( $instance['type'], array( 'person', 'page', 'community' ) ) ) ? $instance['type'] : 'person';
            $color =  ( in_array( $instance['color'], array( 'light', 'dark' ) ) ) ? $instance['color'] : 'light';

            echo $args['before_widget'];
            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            if($type == 'page'){
                $badge_attr = 'data-rel="publisher"';
            }elseif($type == 'person'){
                $badge_attr = 'data-rel="author"';
            }else{
                $badge_attr = '';
            }

            ?>
            <!-- Place this tag where you want the widget to render. -->
            <div class="g-<?php echo esc_attr($instance['type']) ?>" data-href="<?php echo esc_attr($href) ?>" <?php echo $badge_attr; ?> data-width="335" data-layout="<?php echo esc_attr($layout) ?>" data-theme="<?php echo esc_attr($color) ?>" data-showtagline="<?php echo ($tagline) ? 'true' : 'false' ?>" data-showphoto="<?php echo ($cover) ? 'true' : 'false' ?>"></div>
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <?php
            echo $args['after_widget'];
        }
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['href'] = esc_url( $new_instance['href'] );

        $instance['cover'] = isset( $new_instance['layout'] ) ? (bool) $new_instance['cover'] : false;
        $instance['tagline'] = isset( $new_instance['tagline'] ) ? (bool) $new_instance['tagline'] : false;

        if ( in_array( $new_instance['layout'], array( 'portrait', 'landscape' ) ) ) {
            $instance['layout'] = $new_instance['layout'];
        } else {
            $instance['layout'] = 'portrait';
        }

        if ( in_array( $new_instance['type'], array( 'person', 'page', 'community' ) ) ) {
            $instance['type'] = $new_instance['type'];
        } else {
            $instance['type'] = 'person';
        }


        if ( in_array( $new_instance['color'], array( 'light', 'dark' ) ) ) {
            $instance['color'] = $new_instance['color'];
        } else {
            $instance['color'] = 'light';
        }

        return $instance;

    }

    public function form( $instance ) {

        $defaults = array( 'title' => esc_html__( 'Google Plus' , 'adroit'), 'href' => '', 'layout' => 'portrait', 'type' => 'person', 'color' => 'light', 'cover' => true, 'tagline' => true);
        $instance = wp_parse_args( (array) $instance, $defaults );

        $title = strip_tags($instance['title']);

        ?>

        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','adroit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('type'); ?>"><?php esc_html_e('Type:','adroit'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
                <option <?php selected( $instance['type'], 'person' ); ?> value="person"><?php esc_html_e('Profile badge','adroit'); ?></option>
                <option <?php selected( $instance['type'], 'page' ); ?> value="page"><?php esc_html_e('Google+ page','adroit'); ?></option>
                <option <?php selected( $instance['type'], 'community' ); ?> value="community"><?php esc_html_e('Community page','adroit'); ?></option>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id( 'href' ); ?>"><?php esc_html_e( 'The URL of the Google plus Page:', 'adroit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'href' ); ?>" name="<?php echo $this->get_field_name( 'href' ); ?>" type="text" value="<?php echo esc_attr($instance['href']); ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('layout'); ?>"><?php esc_html_e('Layout:','adroit'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
                <option <?php selected( $instance['layout'], 'portrait' ); ?> value="portrait"><?php esc_html_e('Portrait','adroit'); ?></option>
                <option <?php selected( $instance['layout'], 'landscape' ); ?> value="landscape"><?php esc_html_e('Landscape','adroit'); ?></option>
            </select>
        </p>

        <p><label for="<?php echo $this->get_field_id('color'); ?>"><?php esc_html_e('Color theme:','adroit'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>">
                <option <?php selected( $instance['color'], 'light' ); ?> value="light"><?php esc_html_e('Light','adroit'); ?></option>
                <option <?php selected( $instance['color'], 'dark' ); ?> value="dark"><?php esc_html_e('Dark','adroit'); ?></option>
            </select>
        </p>

        <p><input class="checkbox" type="checkbox" <?php checked( $instance['cover'] ); ?> id="<?php echo $this->get_field_id( 'cover' ); ?>" name="<?php echo $this->get_field_name( 'cover' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'cover' ); ?>"><?php esc_html_e( 'Cover Photo', 'adroit' ); ?></label>
            <br/><small><?php esc_html_e('Only work with portrait layout', 'adroit'); ?></small></p>

        <p><input class="checkbox" type="checkbox" <?php checked( $instance['tagline'] ); ?> id="<?php echo $this->get_field_id( 'tagline' ); ?>" name="<?php echo $this->get_field_name( 'tagline' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'tagline' ); ?>"><?php esc_html_e( 'Tagline', 'adroit' ); ?></label>
            <br/><small><?php esc_html_e('Only work with portrait layout', 'adroit'); ?></small></p>

    <?php
    }
}

/**
 * Register KT_Goolge widget
 *
 *
 */

register_widget('Widget_KT_Goolge');
