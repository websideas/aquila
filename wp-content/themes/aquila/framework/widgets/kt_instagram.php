<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT_Instagram widget class
 *
 * @since 1.0
 */
class Widget_KT_Instagram extends WP_Widget {
    
    private $client_id;
    private $access_token;
    private $username;
    private $userid;
    
    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_instagram', 'description' => esc_html__( "Lasted images in instagram.", 'aquila') );
        parent::__construct('kt_instagram', esc_html__('KT: Instagram', 'aquila'), $widget_ops);
        $this->alt_option_name = 'widget_kt_instagram';
        
        $this->client_id = get_option( 'kt_instagram_client_id' );
        $this->access_token = get_option('kt_instagram_access');
        $this->username = get_option('kt_instagram_username');
        $this->userid = get_option('kt_instagram_userid');
    }

    public function widget($args, $instance) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        if($this->access_token && $this->username ){
            
            $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 9;
                if ( ! $number )
                    $number = 9;
            
            require_once ( KT_FW_CLASS . 'instagram-api.php' );
            
            $kt_instagram = new KT_Instagram();
            $data = $kt_instagram->getUserMedia( array('count' => $number ));
            $show_follow = isset( $instance['show_follow'] ) ? (bool) $instance['show_follow'] : true;

            if(!empty($data)){
                $columns = ( ! empty( $instance['columns'] ) ) ? absint( $instance['columns'] ) : 3;
                if ( ! $columns )
                    $columns = 3;

                echo $kt_instagram->showInstagram($data, $columns);
                if($show_follow){
                    printf(
                        '<p>%s <a target="_blank" href="%s">@%s</a></p>',
                        esc_html__('Follow Us', 'aquila'),
                        'https://instagram.com/'.$this->username,
                        $this->username
                    );
                }
            }else{
                printf(
                    '<strong>%s</strong>',
                    esc_html__('Empty username or access token', 'aquila') 
                );
            }

            
        }else{
            printf(
                '<strong>%s</strong>',
                esc_html__('Please fill all widget settings!', 'aquila') 
            );
        }
        
        echo $args['after_widget'];
        
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        $instance['number'] = (int) $new_instance['number'];
        if(!$instance['number']){
            $instance['number'] = 9;
        }
        $instance['columns'] = (int) $new_instance['columns'];
        if(!$instance['columns']){
            $instance['columns'] = 3;
        }
        $instance['show_follow'] = isset( $new_instance['show_follow'] ) ? (bool) $new_instance['show_follow'] : false;

        return $instance;
    }


    public function form( $instance ) {

        $defaults = array( 'title' => esc_html__( 'Instagram' , 'aquila'), 'number' => 9, 'columns' => 3, 'show_follow' => true);
        $instance = wp_parse_args( (array) $instance, $defaults );

        $title = strip_tags($instance['title']);

        ?>

        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <?php if($this->access_token && $this->username ){ ?>
            <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of image to show:', 'aquila' ); ?></label>
                <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $instance['number']; ?>" class="widefat" /></p>
    
            <p><label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php esc_html_e( 'Columns:', 'aquila' ); ?></label>
                <select class="widefat" id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>">
                    <option <?php selected( $instance['columns'], '2' ); ?> value="2"><?php esc_html_e('2','aquila'); ?></option>
                    <option <?php selected( $instance['columns'], '3' ); ?> value="3"><?php esc_html_e('3','aquila'); ?></option>
                    <option <?php selected( $instance['columns'], '4' ); ?> value="4"><?php esc_html_e('4','aquila'); ?></option>
                </select></p>

            <p><input class="checkbox" type="checkbox" <?php checked( $instance['show_follow'] ); ?> id="<?php echo $this->get_field_id( 'show_follow' ); ?>" name="<?php echo $this->get_field_name( 'show_follow' ); ?>" />
                <label for="<?php echo $this->get_field_id( 'show_follow' ); ?>"><?php esc_html_e( 'Follow link', 'aquila' ); ?></label></p>

        <?php }else{ 
            printf(
                '<p>Please config instagram in %shere%s for use widget</p>',
                '<a href="'.admin_url( 'options-general.php?page=kt-instagram-settings').'">',
                '</a>'
            );    
        } 
        ?>
    <?php
    }
}

/**
 * Register Widget_KT_Instagram widget
 *
 *
 */

register_widget('Widget_KT_Instagram');
