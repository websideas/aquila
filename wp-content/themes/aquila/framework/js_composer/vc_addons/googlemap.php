<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

class WPBakeryShortCode_Googlemap extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        extract( shortcode_atts( array(
            'location' => '',
            'image' => '',
            'zoom' => '17',
            'height' => '300',
            'type' => 'roadmap',
            'stype' => '',
            'scrollwheel' => '',
            'el_class' => '',
            'css' => '',
        ), $atts ) );

        if(!$location){return false;}
        
        // Load Google Maps scripts
    	wp_enqueue_script('google-maps-api');
    	wp_enqueue_script('gmap3');
        
        $img_id = preg_replace('/[^\d]/', '', $image);
        $img_thumb = '';
        if( $img_id ){
            $img_array = wp_get_attachment_image_src($img_id,'full');
            $img_thumb = $img_array[0];
        }

        $elementClass = array(
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' ),
            'size' => 'wrapper-googlemap',
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        $output = '';
        $output .= '<div class=" '.$elementClass.'">';
            $output .= '<div class="googlemap" data-style="'.esc_attr($stype).'" data-iconmap="'.esc_attr($img_thumb).'" data-type="'.esc_attr($type).'" data-scrollwheel="'.esc_attr($scrollwheel).'" data-location="'.esc_attr($location).'" data-zoom="'.esc_attr($zoom).'" style="height:'.$height.'px"></div>';
            if( $content ){
                $output .= '<div class="content-map">'.do_shortcode($content).'</div>';
            }
        $output .= '</div>';
        
        return $output;
    }    
}

vc_map( array(
    "name" => esc_html__( "Google map", 'aquila'),
    "base" => "googlemap",
    "category" => esc_html__('by Theme'),
    "description" => esc_html__( "", 'aquila'),
    "params" => array(
        array(
          "type" => "textfield",
          "heading" => esc_html__("Height", 'aquila'),
          "param_name" => "height",
          "value" => 300,
          "description" => esc_html__("Enter height of map,units :'px',Leave empty to use '300px'.", 'aquila')
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Location", 'aquila'),
          "param_name" => "location",
          "admin_label" => true,
          "description" => esc_html__("Enter location", 'aquila')
        ),
        array(
            "type" => "dropdown",
        	"heading" => esc_html__("Map type",'aquila'),
        	"param_name" => "type",
            'std' => 'ROADMAP',
        	"value" => array(
                esc_html__('Roadmap', 'aquila') => 'roadmap',
                esc_html__('Satellite', 'aquila') => 'satellite',
                esc_html__('Hybrid', 'aquila') => 'hybrid',
                esc_html__('Terrain', 'aquila') => 'terrain',
        	), 
            "admin_label" => true,            
        	"description" => esc_html__('','aquila'),
        ),

        array(
            "type" => "dropdown",
            "heading" => esc_html__("Map stype",'aquila'),
            "param_name" => "stype",
            'std' => '',
            "value" => array(
                esc_html__('None', 'aquila') => '',
                esc_html__('Simple & Light', 'aquila') => '1',
                esc_html__('Light Grey & Blue', 'aquila') => '2',
                esc_html__('Dark', 'aquila') => '3',
                esc_html__('Pinkish Gray', 'aquila') => '4',
                esc_html__('Elevation', 'aquila') => '5',
                esc_html__('Mostly Grayscale', 'aquila') => '6',
                esc_html__('Red Hat Antwerp', 'aquila') => '7',
                esc_html__('Shades of Grey', 'aquila') => '8',
            ),
            "admin_label" => true,
            "description" => esc_html__('','aquila'),
        ),

        array(
            "type" => "checkbox",
        	"heading" => esc_html__("",'aquila'),
        	"param_name" => "scrollwheel",
        	'value' => array( esc_html__( 'Disable map zoom on mouse wheel scroll' ) => true ),
        	"description" => esc_html__('','aquila'),
        ),
        array(
            "type" => "dropdown",
        	"heading" => esc_html__("Map zoom",'aquila'),
        	"param_name" => "zoom",
            'std' => '17',
        	"value" => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
                '13' => '13',
                '14' => '14',
                '15' => '15',
                '16' => '16',
                '17 - Default' => '17',
                '18' => '18', 
                '19' => '19'
        	),
        	"description" => esc_html__("1 is the smallest zoom level, 19 the greatest",'aquila'),
            "admin_label" => true,
        ),
        array(
            "type" => "attach_image",
            "heading" => esc_html__( "Image marker", "js_composer" ),
            "param_name" => "image",
            "description" => esc_html__( "Select image show", "js_composer" ),
        ),
        array(
            "type" => "textarea_html",
            "heading" => esc_html__("Content", 'aquila'),
            "param_name" => "content",
            "description" => esc_html__("", 'aquila'),
        ),
        array(
            "type" => "textfield",
            "heading" => esc_html__( "Extra class", "js_composer" ),
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