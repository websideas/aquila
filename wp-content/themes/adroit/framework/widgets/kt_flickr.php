<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT_Instagram widget class
 *
 * @since 1.0
 */
class Widget_KT_Flickr extends WP_Widget {
    
    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_flickr', 'description' => esc_html__( "Lasted images in flickr.", 'adroit') );
        parent::__construct('kt_flickr', esc_html__('KT: Flickr', 'adroit'), $widget_ops);
    }

    public function widget($args, $instance) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $user_id = $instance['user_id'];
        $number = $instance['number'];
        $api = $instance['api'];
        
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
            
        ?>
            <?php if( $user_id && $number && $api ){ ?>
                <ul class="kt_flickr">
                    <script type="text/javascript">
                		function jsonFlickrApi(rsp) {
                			if (rsp.stat != "ok"){
                				// If this executes, something broke!
                				return;
                			}
                			//variable "s" is going to contain
                			//all the markup that is generated by the loop below
                			var s = "";
                
                			//this loop runs through every item and creates HTML
                			for (var i=0; i < rsp.photos.photo.length; i++) {
                				photo = rsp.photos.photo[ i ];
                
                				//notice that "t.jpg" is where you change the
                				//size of the image
                				t_url = "http://farm" + photo.farm +
                				".static.flickr.com/" + photo.server + "/" +
                				photo.id + "_" + photo.secret + "_" + "q.jpg";
                
                				p_url = "http://www.flickr.com/photos/" +
                				photo.owner + "/" + photo.id;
                
                				s +=  '<li><a target="_blank" href="' + p_url + '">' + '<img alt="'+
                				photo.title + '"src="' + t_url + '"/></li>' + '</a>';
                			}
                
                			document.write(s);
                		}
                		</script>
                		<script type="text/javascript" src="https://api.flickr.com/services/rest/?format=json&amp;method=flickr.photos.search&amp;user_id=<?php echo $user_id; ?>&amp;api_key=<?php echo $api; ?>&amp;media=photos&amp;per_page=<?php echo $number; ?>&amp;privacy_filter=1"></script>
                		<script type="text/javascript" src="https://api.flickr.com/services/rest/?format=json&amp;method=flickr.photos.search&amp;group_id=<?php echo $user_id; ?>&amp;api_key=<?php echo $api; ?>&amp;media=photos&amp;per_page=<?php echo $number; ?>&amp;privacy_filter=1"></script>
                    </ul>
            <?php } ?>
        <?php  
        
        echo $args['after_widget'];
        
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['user_id'] = $new_instance['user_id'];
        $instance['api'] = $new_instance['api'];
        
        $instance['number'] = (int) $new_instance['number'];
        if(!$instance['number']){
            $instance['number'] = 9;
        }

        return $instance;
    }


    public function form( $instance ) {

        $defaults = array( 'title' => esc_html__( 'Flickr' , 'adroit'), 'type' => '', 'user_id' => '', 'number' => 9, 'ordering' => '', 'api' => '6346cf3fc74387e93b84f0d22c78939a' );
        $instance = wp_parse_args( (array) $instance, $defaults );

        $title = strip_tags($instance['title']);

        ?>

        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:','adroit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php esc_html_e( 'Flickr ID:','adroit' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'user_id' ); ?>" name="<?php echo $this->get_field_name( 'user_id' ); ?>" type="text" value="<?php echo $instance['user_id']; ?>" />
            <small><?php esc_html_e('To find your flickID visit','adroit'); ?> <a target="_blank" href="http://idgettr.com/"><?php esc_html_e('idGettr.','adroit'); ?></a></small>
        </p>
        
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of image to show:', 'adroit' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $instance['number']; ?>" class="widefat" />
            <small><?php esc_html_e('Select number of photos to display.','adroit'); ?></small>
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id('api'); ?>"><?php esc_html_e( 'API key (Use default or get your own from <a href="%s">Flickr APP Garden</a>):', 'adroit' ); ?>http://www.flickr.com/services/apps/create/apply"></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('api'); ?>" name="<?php echo $this->get_field_name('api'); ?>" value="<?php echo esc_attr($instance['api']); ?>" />
			<small>Default key is: 6346cf3fc74387e93b84f0d22c78939a</small>
		</p>
    <?php
    }
}

/**
 * Register Widget_KT_Flickr widget
 *
 *
 */

register_widget('Widget_KT_Flickr');
