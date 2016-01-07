<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-custom-heading.php' );

class WPBakeryShortCode_KT_Gallery_Justified extends WPBakeryShortCode_VC_Custom_heading {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'image_gallery' => '',
            'image_size' => '',
            'row_height' => 150,
            'margin_image' => 10,
            'gallery_popup' => 'true',
            'image_size_popup' => 'full',
            
            'el_class' => '',
            'css' => '',
        ), $atts );
        extract($atts);
        
        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wrapper-gallery-justified ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        if( $image_gallery ){ $image_gallery = explode( ',', $image_gallery ); }else{ $image_gallery = array(); }
        if( $gallery_popup == 'true' ){ $popup = ' popup-gallery'; }else{ $popup = ''; }
        $output = '';
        if( count($image_gallery) > 0 ){
            $output .= '<div class="'.esc_attr( $elementClass ).'">';
                $output .= '<div class="gallery-grid-outer" style="margin-left:-'.esc_attr($margin_image).'px;margin-right:-'.esc_attr($margin_image).'px;">';
                $output .= '<div class="justified-gallery'.$popup.'" data-height="'.esc_attr($row_height).'" data-margin="'.esc_attr($margin_image).'">';
                    foreach ( $image_gallery as $attach_id ) {
                    	if ( $attach_id > 0 ) {
                    		$image = wpb_getImageBySize( array( 'attach_id' => $attach_id, 'thumb_size' => $image_size ) );
                            if( $gallery_popup == 'true' ){
                                $image_popup = wp_get_attachment_image_src( $attach_id, $image_size_popup );
                            }
                    	}
                        $output .= '<div class="kt-gallery-item">';
                            if( $gallery_popup == 'true' ){
                                $output .= '<a href="call.jpg">';
                            }
                            $output .= $image['thumbnail'];
                            if( $gallery_popup == 'true' ){
                                $output .= "</a>";
                            }
                        $output .= '</div>';
                    }
                $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        }
        
        return $output;
    }
    
    public function singleParamHtmlHolder( $param, $value ) {
		$output = '';
		// Compatibility fixes
		$old_names = array( 'yellow_message', 'blue_message', 'green_message', 'button_green', 'button_grey', 'button_yellow', 'button_blue', 'button_red', 'button_orange' );
		$new_names = array( 'alert-block', 'alert-info', 'alert-success', 'btn-success', 'btn', 'btn-info', 'btn-primary', 'btn-danger', 'btn-warning' );
		$value = str_ireplace( $old_names, $new_names, $value );
		//$value = esc_html__($value, "js_composer");
		//
		$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
		$type = isset( $param['type'] ) ? $param['type'] : '';
		$class = isset( $param['class'] ) ? $param['class'] : '';

		if ( isset( $param['holder'] ) == true && $param['holder'] !== 'hidden' ) {
			$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
		}
		if ( $param_name == 'image_gallery' ) {
			$images_ids = empty( $value ) ? array() : explode( ',', trim( $value ) );
			$output .= '<ul class="attachment-thumbnails' . ( empty( $images_ids ) ? ' image-exists' : '' ) . '" data-name="' . $param_name . '">';
			foreach ( $images_ids as $image ) {
				$img = wpb_getImageBySize( array( 'attach_id' => (int)$image, 'thumb_size' => 'thumbnail' ) );
				$output .= ( $img ? '<li>' . $img['thumbnail'] . '</li>' : '<li><img width="150" height="150" class="attachment-thumbnail" alt="" title="" /></li>' );
			}
			$output .= '</ul>';
			$output .= '<a href="#" class="column_edit_trigger' . ( ! empty( $images_ids ) ? ' image-exists' : '' ) . '">' . esc_html__( 'Add images', 'js_composer' ) . '</a>';

		}
		return $output;
	}
}



// Add your Visual Composer logic here
vc_map( array(
    "name" => esc_html__( "KT Gallery Justified", 'aquila'),
    "base" => "kt_gallery_justified",
    "category" => esc_html__('by Theme', 'aquila' ),
    "description" => esc_html__( "", 'aquila'),
    "params" => array(
        //Image
        array(
			'type' => 'attach_images',
			'heading' => esc_html__( 'Image Gallery', 'aquila' ),
			'param_name' => 'image_gallery',
			'description' => esc_html__( 'Select image from media library.', 'js_composer' ),
		),
        array(
            "type" => "kt_image_sizes",
            "heading" => esc_html__( "Select image sizes", 'aquila' ),
            "param_name" => "image_size",
        ),
        array(
            "type" => "kt_number",
            "heading" => esc_html__("Row Height", 'aquila'),
            "param_name" => "row_height",
            "value" => 150,
            "min" => 0,
            "max" => 1000,
            "suffix" => "px",
            "description" => esc_html__( "The preferred height of rows in pixel.", 'aquila' ),
        ),
        array(
            "type" => "kt_number",
            "heading" => esc_html__("Margin", 'aquila'),
            "param_name" => "margin_image",
            "value" => 10,
            "min" => 0,
            "max" => 50,
            "suffix" => "px",
            "description" => esc_html__( "Decide the margins between the images.", 'aquila' ),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Gallery Popup', 'aquila' ),
            'param_name' => 'gallery_popup',
            'value' => 'true',
            "description" => esc_html__("Use or don't use popup gallery.", 'aquila'),
        ),
        array(
            "type" => "kt_image_sizes",
            "heading" => esc_html__( "Select image sizes popup gallery", 'aquila' ),
            "param_name" => "image_size_popup",
            "std" => "full",
            "dependency" => array("element" => "gallery_popup","value" => array('true'),'not_empty' => true,),
        ),
        
        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        //Design options
        array(
            'type' => 'css_editor',
            'heading' => esc_html__( 'Css', 'js_composer' ),
            'param_name' => 'css',
            // 'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group' => esc_html__( 'Design options', 'js_composer' )
        ),

    ),
));