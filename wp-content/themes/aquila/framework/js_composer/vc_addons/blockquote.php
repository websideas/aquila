<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Blockquote extends WPBakeryShortCode {
    var $excerpt_length;
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'author' => '',
            'style' => '',
            'reverse' => 'false',
            'css' => '',
            'css_animation' => '',
            'el_class' => '',
        ), $atts );

        extract($atts);
        $output = '';

        $reverse = apply_filters('sanitize_boolean', $reverse);

        $elementClass = array(
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'reverse' => ( $reverse) ? 'blockquote-reverse' : '',
            'style' => $style
        );

        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $output .= '<blockquote class="'.esc_attr( $elementClass ).'"><div class="blockquote-content">';
            $output .= '<p>'. do_shortcode($content).'</p>';
            if( $author ){
                $output .= '<footer>'.$author.'</footer>';
            }
        $output .= '</div></blockquote>';
        
    	return $output;
    }
}

vc_map( array(
    "name" => esc_html__( "Blockquote", 'aquila'),
    "base" => "blockquote",
    "category" => esc_html__('by Theme', 'aquila' ),
    "wrapper_class" => "clearfix",
    "params" => array(

        array(
            "type" => "textarea_html",
            "heading" => esc_html__("Content", 'aquila'),
            "param_name" => "content",
            "description" => esc_html__("", 'aquila'),
            'holder' => 'div',
        ),
        array(
            "type" => "textfield",
            'heading' => esc_html__( 'Author', 'js_composer' ),
            'param_name' => 'author',
            "admin_label" => true,
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Style', 'aquila' ),
            'param_name' => 'style',
            'value' => array(
                esc_html__( 'Normal', 'aquila' ) => '',
                esc_html__( 'Post quote', 'aquila' ) => 'post-item-quote',
                esc_html__( 'Simple', 'aquila' ) => 'simple',
            ),
            'description' => esc_html__( 'Position of content.', 'aquila' ),
        ),
        array(
            'type' => 'kt_switch',
            'heading' => esc_html__( 'Reverse Blockquote', 'aquila' ),
            'param_name' => 'reverse',
            'value' => 'false',
            "description" => esc_html__("", 'aquila'),
        ),
        
        array(
        	'type' => 'dropdown',
        	'heading' => esc_html__( 'CSS Animation', 'js_composer' ),
        	'param_name' => 'css_animation',
        	'admin_label' => true,
        	'value' => array(
        		esc_html__( 'No', 'js_composer' ) => '',
        		esc_html__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
        		esc_html__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
        		esc_html__( 'Left to right', 'js_composer' ) => 'left-to-right',
        		esc_html__( 'Right to left', 'js_composer' ) => 'right-to-left',
        		esc_html__( 'Appear from center', 'js_composer' ) => "appear"
        	),
        	'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class name", "js_composer"),
            "param_name" => "el_class",
            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => esc_html__( 'Design options', 'js_composer' )
		),
    ),
));