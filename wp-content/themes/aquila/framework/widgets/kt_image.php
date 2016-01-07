<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT image widget class
 *
 * @since 1.0
 */
class WP_Widget_KT_Image extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_kt_image', 'description' => esc_html__( 'Image for widget.', 'aquila' ) );
		parent::__construct('kt_image', esc_html__('KT: image', 'aquila' ), $widget_ops);
	}

	public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        $attachment = get_thumbnail_attachment($instance['attachment'], $instance['size']);

        if($attachment){
    		echo $args['before_widget'];

            if ( $title ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            echo "<div class='kt-image-content text-".$instance['align']."'>";
            if($instance['link']){
                echo "<a href='".esc_attr($instance['link'])."' target='".esc_attr($instance['target'])."'>";
            }
            echo "<img src='".$attachment['url']."' alt='".esc_attr($attachment['alt'])."' title='".esc_attr($attachment['title'])."'/>";
            if($instance['link']){
                echo "</a>";
            }
            echo "</div>";
    		echo $args['after_widget'];
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

		$instance['link'] = strip_tags($new_instance['link']);
        $instance['target'] = $new_instance['target'];
        $instance['size'] = $new_instance['size'];
        $instance['align'] = $new_instance['align'];
        $instance['attachment'] = intval($new_instance['attachment']);
        
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'target' => '_self', 'link' => '', 'attachment' => '', 'size' => '', 'align' => 'center') );
        $title = strip_tags($instance['title']);

		$link = esc_attr( $instance['link'] );
        $attachment = esc_attr( $instance['attachment'] );
        $preview = false;
        $img_preview = "";
        if($instance['attachment']){
            $file = get_thumbnail_attachment($instance['attachment'], 'full');
            $preview = true;
            $img_preview = $file['url'];
        }
		
	?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
        <div class="wrapper_kt_image_upload">
            <p style="text-align: center;">
                <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attresc_html_e('Select your image', 'aquila') ?>" />
                <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id('attachment'); ?>" name="<?php echo $this->get_field_name('attachment'); ?>" type="hidden" value="<?php echo esc_attr($attachment); ?>" />
            </p>
            <p class="kt_image_preview" style="<?php if($preview){ echo "display: block;";} ?>">
                <img src="<?php echo esc_url($img_preview); ?>" alt="" class="kt_image_preview_img" />
            </p>
        </div>
        <p style="clear: both;">
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php esc_html_e('Link:', 'aquila'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php esc_html_e( 'Target:', 'aquila'); ?></label>
			<select name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>" class="widefat">
				<option value="_self"<?php selected( $instance['target'], '_self' ); ?>><?php esc_html_e('Stay in Window', 'aquila'); ?></option>
				<option value="_blank"<?php selected( $instance['target'], '_blank' ); ?>><?php esc_html_e('Open New Window', 'aquila'); ?></option>
			</select>
		</p>
        <p>
            <?php 
                $sizes = kt_get_image_sizes();
                $sizes['full'] = array(); 
            ?>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php esc_html_e( 'Image size:', 'aquila' ); ?></label>
			<select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" class="widefat">
                <?php foreach($sizes as $key => $size){ ?>
                    <?php
                        $option_text = array();
                        $option_text[] = ucfirst($key);
                        if(isset($size['width'])){
                            $option_text[] = '('.$size['width'].' x '.$size['height'].')';
                        }
                        if(isset($size['crop']) && $size['crop']){
                            $option_text[] = esc_html__('Crop', 'aquila');
                        }
                    ?>
    				<option value="<?php echo $key; ?>"<?php selected( $instance['size'], $key ); ?>>
                        <?php echo implode(' - ', $option_text) ?>
                    </option>
                <?php } ?>
			</select>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('align'); ?>"><?php esc_html_e( 'Align:', 'aquila'); ?></label>
            <select name="<?php echo $this->get_field_name('align'); ?>" id="<?php echo $this->get_field_id('align'); ?>" class="widefat">
                <option value="center"<?php selected( $instance['align'], 'center' ); ?>><?php esc_html_e('Center', 'aquila'); ?></option>
                <option value="left"<?php selected( $instance['align'], 'left' ); ?>><?php esc_html_e('Left', 'aquila'); ?></option>
                <option value="right"<?php selected( $instance['align'], 'right' ); ?>><?php esc_html_e('Right', 'aquila'); ?></option>
            </select>
        </p>
<?php
	}

}


register_widget( 'WP_Widget_KT_Image' );