<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
 
/**
 * KT AboutMe widget class
 *
 * @since 1.0
 */
class WP_Widget_KT_AboutMe extends WP_Widget {

    public function __construct() {
        $widget_ops = array('classname' => 'widget_kt_aboutme', 'description' => esc_html__( 'About Me widget.', 'aquila' ) );
        parent::__construct('kt_aboutme', esc_html__('KT: About me', 'aquila' ), $widget_ops);
    }

    public function widget( $args, $instance ) {

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $attachment = kt_get_thumbnail_attachment($instance['attachment'], $instance['size']);
        $value = isset( $instance['value'] ) ? $instance['value'] : '';
        
        if($attachment){
            echo "<div class='kt-aboutwidget-img'><img src='".$attachment['url']."' alt='".esc_attr($attachment['alt'])."' class='img-responsive' title='".esc_attr($attachment['title'])."'/></div>";
        }

        if($instance['description']){
            echo '<div class="kt-aboutwidget-text">'.$instance['description'].'</div>';
        }

        $socials_arr = array(
            'facebook' => array('title' => esc_html__('Facebook', 'aquila'), 'icon' => 'fa fa-facebook', 'link' => '%s'),
            'twitter' => array('title' => esc_html__('Twitter', 'aquila'), 'icon' => 'fa fa-twitter', 'link' => 'http://www.twitter.com/%s'),
            'dribbble' => array('title' => esc_html__('Dribbble', 'aquila'), 'icon' => 'fa fa-dribbble', 'link' => 'http://www.dribbble.com/%s'),
            'vimeo' => array('title' => esc_html__('Vimeo', 'aquila'), 'icon' => 'fa fa-vimeo-square', 'link' => 'http://www.vimeo.com/%s'),
            'tumblr' => array('title' => esc_html__('Tumblr', 'aquila'), 'icon' => 'fa fa-tumblr', 'link' => 'http://%s.tumblr.com/'),
            'skype' => array('title' => esc_html__('Skype', 'aquila'), 'icon' => 'fa fa-skype', 'link' => 'skype:%s'),
            'linkedin' => array('title' => esc_html__('LinkedIn', 'aquila'), 'icon' => 'fa fa-linkedin', 'link' => '%s'),
            'googleplus' => array('title' => esc_html__('Google Plus', 'aquila'), 'icon' => 'fa fa-google-plus', 'link' => '%s'),
            'youtube' => array('title' => esc_html__('Youtube', 'aquila'), 'icon' => 'fa fa-youtube', 'link' => 'http://www.youtube.com/user/%s'),
            'pinterest' => array('title' => esc_html__('Pinterest', 'aquila'), 'icon' => 'fa fa-pinterest', 'link' => 'http://www.pinterest.com/%s'),
            'instagram' => array('title' => esc_html__('Instagram', 'aquila'), 'icon' => 'fa fa-instagram', 'link' => 'http://instagram.com/%s'),
        );

        foreach($socials_arr as $k => &$v){
            $val = kt_option($k);
            $v['val'] = ($val) ? $val : '';
        }
        ?>
        <?php if($value){
            $social_type = explode(',', $value); ?>
            <ul class="kt-aboutwidget-socials">
                <?php
                foreach ($social_type as $id) {
                    $val = $socials_arr[$id];
                    $social_text = '<i class="'.esc_attr($val['icon']).'"></i>';
                    echo '<li><a href="'.esc_url(str_replace('%s', $val['val'], $val['link'])).'" target="_blank">'.$social_text.'</a></li>';
                }
                ?>
            </ul>
        <?php }



        echo $args['after_widget'];

    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['size'] = $new_instance['size'];
        $instance['attachment'] = intval($new_instance['attachment']);

        if ( current_user_can('unfiltered_html') ){
            $instance['description'] =  $new_instance['description'];
        }else{
            $instance['description'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['description']) ) );
        }
        $instance['value'] = $new_instance['value'];

        return $instance;
    }

    public function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => esc_html__('About me', 'aquila'), 'target' => '_self', 'attachment' => '', 'size' => 'kt_recent_posts', 'description' => '') );
        $title = strip_tags($instance['title']);

        $attachment = esc_attr( $instance['attachment'] );
        $preview = false;
        $img_preview = "";
        if($instance['attachment']){
            $file = kt_get_thumbnail_attachment($instance['attachment'], 'full');
            $preview = true;
            $img_preview = $file['url'];
        }
        $value = isset( $instance['value'] ) ? $instance['value'] : '';

        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'aquila' ); ?></label>
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
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php esc_html_e( 'Description:', 'aquila' ); ?></label>
            <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo $instance['description'] ?></textarea></p>

        <?php
            $socials = array(
                'facebook' => 'fa fa-facebook',
                'twitter' => 'fa fa-twitter',
                'pinterest' => 'fa fa-pinterest-p',
                'dribbble' => 'fa fa-dribbble',
                'vimeo' => 'fa fa-vimeo-square',
                'tumblr' => 'fa fa-tumblr',
                'skype' => 'fa fa-skype',
                'linkedin' => 'fa fa-linkedin',
                'googleplus' => 'fa fa-google-plus',
                'youtube' => 'fa fa-youtube-play',
                'instagram' => 'fa fa-instagram'
            );
            
            $arr_val = ($value) ? explode(',', $value) : array();
        ?>
    
        <div class="kt-socials-options">
            <ul class="kt-socials-lists clearfix">
                <?php foreach($socials as $key => $social){ ?>
                    <?php $class = (in_array($key, $arr_val)) ? 'selected' : ''; ?>
                    <li data-type="<?php echo $key; ?>" class="<?php echo $class; ?>"><i class="<?php echo $social; ?>"></i><span></span></li>
                <?php } ?>
            </ul><!-- .kt-socials-lists -->
            <ul class="kt-socials-profiles clearfix">
            <?php
                if(count($arr_val)){
                    foreach($arr_val as $item){ ?>
                        <li data-type="<?php echo $item; ?>"><i class="<?php echo $socials[$item]; ?>"></i><span></span></li>
                    <?php }
                }
            ?>
            </ul><!-- .kt-socials-profiles -->
            <input id="<?php echo $this->get_field_id( 'value' ); ?>" type="hidden" class="wpb_vc_param_value kt-socials-value" name="<?php echo $this->get_field_name( 'value' ); ?>" value="<?php echo esc_attr($value); ?>" />
        </div><!-- .kt-socials-options -->
        <?php wp_enqueue_script( 'cosials_js', KT_FW_JS.'kt_socials.js', array('jquery'), KT_FW_VER, true); ?>
        
        <script type="text/javascript">
            (function($){
                $('document').ready(function() {
                    $( ".kt-socials-profiles" ).sortable({
                        placeholder: "ui-socials-highlight",
                        update: function( event, ui ) {
                            var $parrent_ui = ui.item.closest('.kt-socials-options'),
                                $profiles_ui = $parrent_ui.find('.kt-socials-profiles'),
                                $value_ui = $parrent_ui.find('.kt-socials-value');

                            $profiles_val_ui = [];
                            $profiles_ui.find('li').each(function(){
                                $profiles_val_ui.push($(this).data('type'));
                            });
                            $value_ui.val($profiles_val_ui.join());
                        }
                    });
                });
            })(jQuery);
        </script>

        <?php
    }

}


register_widget( 'WP_Widget_KT_AboutMe' );