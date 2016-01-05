<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * KT image widget class
 *
 * @since 1.0
 */
class WP_Widget_KT_Promo extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_kt_promo', 'description' => __( 'Promo for widget.', THEME_LANG ) );
		parent::__construct('kt_promo', __('KT: promo', THEME_LANG ), $widget_ops);
	}

	public function widget( $args, $instance ) {

        $attachment = get_thumbnail_attachment($instance['attachment'], $instance['size']);

        if($attachment){
    		echo $args['before_widget'];

            echo "<div class='kt-promo-content'>";
            if($instance['link']){
                echo "<a href='".esc_attr($instance['link'])."' target='".esc_attr($instance['target'])."'></a>";
            }
            echo "<img src='".$attachment['url']."' alt='".esc_attr($attachment['alt'])."' title='".esc_attr($attachment['title'])."'/>";
            if( $instance['promo_text'] ){
                echo '<div class="promo-text"><div class="promo-text-inner"><h4>'.$instance['promo_text'].'</h4></div></div>';
            }

            echo "</div>";
    		echo $args['after_widget'];
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['link'] = strip_tags($new_instance['link']);
        $instance['promo_text'] = strip_tags($new_instance['promo_text']);
        $instance['target'] = $new_instance['target'];
        $instance['size'] = $new_instance['size'];
        $instance['attachment'] = intval($new_instance['attachment']);
        
		return $instance;
	}

	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'target' => '_self', 'link' => '','promo_text' => '', 'attachment' => '', 'size' => '') );

		$link = esc_attr( $instance['link'] );
        $promo_text = esc_attr( $instance['promo_text'] );
        $attachment = esc_attr( $instance['attachment'] );
        $preview = false;
        $img_preview = "";
        if($instance['attachment']){
            $file = get_thumbnail_attachment($instance['attachment'], 'full');
            $preview = true;
            $img_preview = $file['url'];
        }
		
	?>
        <div class="wrapper_kt_image_upload">
            <p style="text-align: center;">
                <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr_e('Select your image', THEME_LANG) ?>" />
                <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id('attachment'); ?>" name="<?php echo $this->get_field_name('attachment'); ?>" type="hidden" value="<?php echo esc_attr($attachment); ?>" />
            </p>
            <p class="kt_image_preview" style="<?php if($preview){ echo "display: block;";} ?>">
                <img src="<?php echo esc_url($img_preview); ?>" alt="" class="kt_image_preview_img" />
            </p>
        </div>
        <p style="clear: both;">
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php _e( 'Target:', THEME_LANG); ?></label>
			<select name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>" class="widefat">
				<option value="_self"<?php selected( $instance['target'], '_self' ); ?>><?php _e('Stay in Window', THEME_LANG); ?></option>
				<option value="_blank"<?php selected( $instance['target'], '_blank' ); ?>><?php _e('Open New Window', THEME_LANG); ?></option>
			</select>
		</p>
        <p>
            <?php 
                $sizes = kt_get_image_sizes();
                $sizes['full'] = array(); 
            ?>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php _e( 'Image size:', THEME_LANG ); ?></label>
			<select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" class="widefat">
                <?php foreach($sizes as $key => $size){ ?>
                    <?php
                        $option_text = array();
                        $option_text[] = ucfirst($key);
                        if(isset($size['width'])){
                            $option_text[] = '('.$size['width'].' x '.$size['height'].')';
                        }
                        if(isset($size['crop']) && $size['crop']){
                            $option_text[] = __('Crop', THEME_LANG);
                        }
                    ?>
    				<option value="<?php echo $key; ?>"<?php selected( $instance['size'], $key ); ?>>
                        <?php echo implode(' - ', $option_text) ?>
                    </option>
                <?php } ?>
			</select>
		</p>
        <p style="clear: both;">
            <label for="<?php echo $this->get_field_id('promo_text'); ?>"><?php _e('Promo Text:', THEME_LANG); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('promo_text'); ?>" name="<?php echo $this->get_field_name('promo_text'); ?>" type="text" value="<?php echo esc_attr($promo_text); ?>" />
        </p>
<?php
	}

}


register_widget( 'WP_Widget_KT_Promo' );