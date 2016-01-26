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
		$widget_ops = array('classname' => 'widget_kt_promo', 'description' => esc_html__( 'Promo for widget.', 'adroit' ) );
		parent::__construct('kt_promo', esc_html__('KT: promo', 'adroit' ), $widget_ops);
	}

	public function widget( $args, $instance ) {

        $attachment = kt_get_thumbnail_attachment($instance['attachment'], $instance['size']);
        $promo_text = $instance['promo_text'];

        if($attachment){
    		echo $args['before_widget'];

            $image = sprintf(
                '<img src="%s" alt="%s" title="%s"/>',
                $attachment['url'],
                esc_attr($attachment['alt']),
                esc_attr($attachment['title'])
            );

            if($instance['link']){
                $link_promo = sprintf(
                    '<a href="%s" target="%s"></a>',
                    esc_attr($instance['link']),
                    esc_attr($instance['target'])
                );
            }

            if($promo_text){
                $promo_text_html = sprintf(
                    '<div class="promo-text"><div class="promo-text-inner"><h4>%s</h4></div></div>',
                    esc_attr($promo_text)
                );
            }

            printf(
                '<div class="kt-promo-content">%s %s %s</div>',
                $image,
                $link_promo,
                $promo_text_html
            );

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
            $file = kt_get_thumbnail_attachment($instance['attachment'], 'full');
            $preview = true;
            $img_preview = $file['url'];
        }
		
	?>
        <p style="clear: both;">
            <label for="<?php echo $this->get_field_id('promo_text'); ?>"><?php esc_html_e('Promo Text:', 'adroit'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('promo_text'); ?>" name="<?php echo $this->get_field_name('promo_text'); ?>" type="text" value="<?php echo esc_attr($promo_text); ?>" />
        </p>
        <div class="wrapper_kt_image_upload">
            <p style="text-align: center;">
                <input type="button" style="width: 100%; padding: 10px; height: auto;" class="button kt_image_upload" value="<?php esc_attr(esc_html_e('Select your image', 'adroit')) ?>" />
                <input class="widefat kt_image_attachment" id="<?php echo $this->get_field_id('attachment'); ?>" name="<?php echo $this->get_field_name('attachment'); ?>" type="hidden" value="<?php echo esc_attr($attachment); ?>" />
            </p>
            <p class="kt_image_preview" style="<?php if($preview){ echo "display: block;";} ?>">
                <img src="<?php echo esc_url($img_preview); ?>" alt="" class="kt_image_preview_img" />
            </p>
        </div>
        <p style="clear: both;">
            <label for="<?php echo $this->get_field_id('link'); ?>"><?php esc_html_e('Link:', 'adroit'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('target'); ?>"><?php esc_html_e( 'Target:', 'adroit'); ?></label>
			<select name="<?php echo $this->get_field_name('target'); ?>" id="<?php echo $this->get_field_id('target'); ?>" class="widefat">
				<option value="_self"<?php selected( $instance['target'], '_self' ); ?>><?php esc_html_e('Stay in Window', 'adroit'); ?></option>
				<option value="_blank"<?php selected( $instance['target'], '_blank' ); ?>><?php esc_html_e('Open New Window', 'adroit'); ?></option>
			</select>
		</p>
        <p>
            <?php 
                $sizes = kt_get_image_sizes();
                $sizes['full'] = array(); 
            ?>
			<label for="<?php echo $this->get_field_id('size'); ?>"><?php esc_html_e( 'Image size:', 'adroit' ); ?></label>
			<select name="<?php echo $this->get_field_name('size'); ?>" id="<?php echo $this->get_field_id('size'); ?>" class="widefat">
                <?php foreach($sizes as $key => $size){ ?>
                    <?php
                        $option_text = array();
                        $option_text[] = ucfirst($key);
                        if(isset($size['width'])){
                            $option_text[] = '('.$size['width'].' x '.$size['height'].')';
                        }
                        if(isset($size['crop']) && $size['crop']){
                            $option_text[] = esc_html__('Crop', 'adroit');
                        }
                    ?>
    				<option value="<?php echo $key; ?>"<?php selected( $instance['size'], $key ); ?>>
                        <?php echo implode(' - ', $option_text) ?>
                    </option>
                <?php } ?>
			</select>
		</p>

<?php
	}

}


register_widget( 'WP_Widget_KT_Promo' );