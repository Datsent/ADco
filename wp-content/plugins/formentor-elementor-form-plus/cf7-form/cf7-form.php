<?php

namespace Cf7Form;
use Cf7Form\Widgets\CTGS_Cf7form;
use Cf7Form\Controlers\CTGS_Control_Select_Fild;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class CTGS_main_cf7_form {
    
    	public function __construct() {
                
        	$this->add_actions();

         }
    
    	private function add_actions() {

    add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
add_action('wp_enqueue_scripts', [ $this,'add_css_and_js']);
add_action( 'elementor/frontend/after_register_scripts', function() {

		} );


	}

    public function add_css_and_js(){
 wp_enqueue_style( 'cf7formcss', plugin_dir_url(__FILE__) . 'css/main.css',false,'1.1','all');
  // if(!is_single())
wp_enqueue_script('cf7formjs', plugin_dir_url(__FILE__) . 'js/main.js', array( 'jquery' ), '1.0.0', true);
    }

    
    public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}
    	private function includes() {
   //    require ABSPATH . PLUGINDIR . 'contact-form-7/admin/includes/admin-functions.php';
		require __DIR__ . '/Widgets/cf7-form-widgets.php';
       //     require __DIR__ . '/Controlers/select-fild.php';

        
	}
    public function register_controls(){
             if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
    require __DIR__ . '/Controlers/select-fild.php';
        	$controls_manager = \Elementor\Plugin::$instance->controls_manager;
		$controls_manager->register_control( 'select_fild', new Widgets\CTGS_Control_Select_My_Fild() );
}
    }
    	private function register_widget() {
       if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) 
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new CTGS_Cf7form() );
	}
	}
 new CTGS_main_cf7_form();  