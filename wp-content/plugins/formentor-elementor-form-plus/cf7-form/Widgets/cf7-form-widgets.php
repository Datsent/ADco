<?php
namespace Cf7Form\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use WPCF7_ContactForm;
use WPCF7_ConfigValidator;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use WP_Query;
//require __DIR__ . '/ChromePhp.php';
//include 'ChromePhp.php';
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class CTGS_Cf7form extends Widget_Base {

public function get_name() {
		return 'cf7form';
	}

	public function get_title() {
		return __( 'Cf7form', 'client_to_google_sheet' );
	}

	public function get_icon() {
		return 'fa fa-ship';
	}

	public function get_categories() {
		return [ 'general' ];
	}
    protected function _register_controls() {
        		$this->start_controls_section(
			'cf7fileds',
			[
				'label' => __( 'Content', 'client_to_google_sheet' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
     $this->add_control(
			'title',
			[
				'label' => __( 'Title', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' =>  __( 'my new form', 'client_to_google_sheet' ),
			]
		);
		$repeater = new \Elementor\Repeater();
    

		
         $repeater->add_control(
			'filed_id', [
				'label' => __( 'We will provide a unique ID, Change only if required', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);     
	$repeater->add_control(
			'filed_type',
			[
				'label' => __( 'Field Type', 'client_to_google_sheet' ),
				'type' => "select_fild",
				'default' => 'text',
				'options' => [
					'text'  => __( 'text', 'client_to_google_sheet' ),
					'textarea' => __( 'textarea', 'client_to_google_sheet' ),
					'number' => __( 'number', 'client_to_google_sheet' ),
					'email' => __( 'email', 'client_to_google_sheet' ),
                    'tel' => __( 'phone', 'client_to_google_sheet' ),
                    'select' => __( 'multybole optin', 'client_to_google_sheet' ),
                    'custom' => __( 'custom', 'client_to_google_sheet' ),
                   
				],
			]
		);
     
    $repeater->add_control(
			'filed_val_select', [
				'label' => __( 'Select Options (like: "1" "2" "3") ', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' => "\"foo\" \"very foo\"",
				'label_block' => true,
			]
		);
         $repeater->add_control(
			'custom_html', [
				'label' => __( 'Custom CF7 Fields', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'default' =>"[radio myradio id:my-id class:my-class default:1 \"1\" \"2\" \"3\"]",
			]
		);
     
             $repeater->add_control(
			'required',
			[
				'label' => __( 'Required?', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'client_to_google_sheet' ),
				'label_off' => __( 'no', 'client_to_google_sheet' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
       
		$repeater->add_control(
			'filed_label', [
				'label' => __( 'Label', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'show_label' => true,
			]
		);
        $repeater->add_control(
			'filed_placeholder', [
				'label' => __( 'placeholder', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'show_label' => true,
			]
		);

	    $repeater->add_responsive_control(
        	'width',
			[
				'label' => __( 'Width', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'25'  => __( '25%', 'client_to_google_sheet' ),
					'50' => __( '50%', 'client_to_google_sheet' ),
					'75' => __( '75%', 'client_to_google_sheet' ),
					'100' => __( '100%', 'client_to_google_sheet' ),
				],
				'default' => 50,
           
				
			]
		);

		$this->add_control(
			'mycf7fileds',
			[
				'label' => __( 'Fileds', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'filed_label' => __( 'Name', 'client_to_google_sheet' ),
						'filed_type' => 'text',
					],
					[
						'filed_label' => __( 'Phone', 'client_to_google_sheet' ),
						'filed_type' => 'number',
					],
				],
				'title_field' => '{{{ filed_label }}}',
			]
		);
//submitwidth
         $this->add_responsive_control(
        	'submitwidth',
			[
				'label' => __( 'Submit Width', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'25'  => __( '25%', 'client_to_google_sheet' ),
					'50' => __( '50%', 'client_to_google_sheet' ),
					'75' => __( '75%', 'client_to_google_sheet' ),
					'100' => __( '100%', 'client_to_google_sheet' ),
				],
				'default' => 50,
         
				
			]
		);
                $this->add_control(
        	'button_text',
			[
				'label' => __( 'Submit Text', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				
				'default' => __( 'send', 'client_to_google_sheet' ),
         
				
			]
		);
                    $this->add_control(
        	'button_icon',
			[
				'label' => __( 'Submit Icon', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::ICON,
				'default' => 'fa fa-send',
         
				
			]
		);
        		$this->add_control(
			'button_icon_after',
			[
				'label' => __( 'Icon after text?', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
		'label_on' => __( 'yes', 'client_to_google_sheet' ),
				'label_off' => __( 'no', 'client_to_google_sheet' ),
				'return_value' => 'yes',
				'default' => 'no',
				
			]
		); 
        
           $this->end_controls_section();
           $this->start_controls_section(
			'form_settings_mail',
			[
				'label' => __( 'After Submit', 'client_to_google_sheet' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
        global $current_user;
$current_user = wp_get_current_user();

$email = (string) $current_user->user_email;
          		$this->add_control(
			'to_mail',
			[
                'type' => \Elementor\Controls_Manager::TEXT,
				'label' => __( 'Send To:', 'client_to_google_sheet' ),	
                 'default' => $email,	
			]
		); 
    
        		$this->add_control(
			'subject',
			[
				'label' => __( 'Subject', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
	'default' => __( 'new lead', 'client_to_google_sheet' ),
				
			]
		); 
   
          		$this->add_control(
			'from_mail',
			[
				'label' => __( 'Send From:', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => "admin@mysitedomain.com",	
			]
		);
             		$this->add_control(
			'mail_body',
			[
				'label' => __( 'Mail Body:', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '[all]',
                'label_block' => true,
                'description' => __( 'Put [all] to add all fields. To add one, put it id, like [MyFieldId]
', 'client_to_google_sheet' ),
			]
		);
        		$this->add_control(
			'tnxpage',
			[
				'label' => __( 'Redirect (Thank you page)', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
			]
		);
         		$this->add_control(
			'zaiper_url',
			[
				'label' => __( 'Zaiper Url', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
			]
		);
        $this->end_controls_section();
           $this->start_controls_section(
			'form_style',
			[
				'label' => __( 'Feilds', 'client_to_google_sheet' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
        
        	$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'fild_typography',
				'label' => __( 'Typography', 'client_to_google_sheet' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} input, {{WRAPPER}} textarea, {{WRAPPER}} select ',
			]
		);
        $this->add_group_control(
        	Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Label Typography', 'client_to_google_sheet' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} label',
                          
			]
		);
	$this->add_responsive_control(
			'fild_border',
			[
				'label' => __( 'Border Width', 'popuplabels' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} input ,{{WRAPPER}} textarea,{{WRAPPER}} select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
               'default' => [
                 'top' => 1,
               'right' => 1,
                'bottom' => 1,
             'left' => 1,
            'isLinked' => true,
               ],
			]
		);
             $this->add_control(
			'fild_border_color',
			[
				'label' => __( 'Border Color', 'popuplabels' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [	'{{WRAPPER}} input ,{{WRAPPER}} textarea,{{WRAPPER}} select' => 'border-color: {{VALUE}}',],
			]
            	);
         $this->add_responsive_control(
        	'gup',
			[
				'label' => __( 'Height', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 15,
                	'selectors' => [
                    '{{WRAPPER}} .mycf7form .wpcf7-form-control' => 'padding: {{VALUE}}px;',
                    '{{WRAPPER}} .mycf7fild button' => 'padding: {{VALUE}}px!important;',
                    
                ],
				
			]
		);
    
		$this->end_controls_section();
    $this->start_controls_section(
			'button_style',
			[
				'label' => __( 'Button', 'client_to_google_sheet' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
        $this->add_control(
			'button_bg',
			[
				'label' => __( 'Background Color', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#e43b3b',
				'selectors' => [	'{{WRAPPER}} button' => 'background-color: {{VALUE}}',],
			]
            	);
              $this->add_control(
			'button_color',
			[
				'label' => __( 'Color', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [	'{{WRAPPER}} button' => 'color: {{VALUE}}',],
			]
            	);
        	$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Typography', 'client_to_google_sheet' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} button',
			]
		);
        $this->add_control(
	'button_hover',
	[
		'label' => __( 'Hover', 'client_to_google_sheet' ),
		'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
		'label_off' => __( 'the same', 'client_to_google_sheet' ),
		'label_on' => __( 'Custom', 'client_to_google_sheet' ),
		'return_value' => 'yes',
	]
);

$this->start_popover();
          $this->add_control(
			'button_hover_bg',
			[
				'label' => __( 'Background Color', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#e43b3b',
				'selectors' => [	'{{WRAPPER}} button:hover' => 'background-color: {{VALUE}}',],
			]
            	);
              $this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Color', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [	'{{WRAPPER}} button:hover' => 'color: {{VALUE}}',],
			]
            	);
        	$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_hover_typography',
				'label' => __( 'Typography', 'client_to_google_sheet' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} button:hover',
			]
		);
        $this->add_control(
			'button_hover_animation',
			[
				'label' => __( 'Hover Animation', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
				'prefix_class' => '',
			]
		);
        $this->end_popover();
        $this->end_controls_section();
        $this->start_controls_section(
			'condition',
			[
				'label' => __( 'Google Sheets', 'client_to_google_sheet' ),
				'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
			]
		);

		$this->add_control(
			'send_data_to_google',
			[
				'label' => __( 'Send to Google Sheet', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
		'label_on' => __( 'yes', 'client_to_google_sheet' ),
				'label_off' => __( 'no', 'client_to_google_sheet' ),
				'return_value' => 'yes_send_data_to_google',
				'default' => 'no',
				
			]
		); 
 //conect_to_google
        $this->add_control(
			'sheet_example',
			[
				'label' => __( 'Get  Sheet ID:', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'ID is the value between the "/d/" and the "/edit" in the URL of your spreadsheet. For example:<br><span> /spreadsheets/d/<b>****</b>/edit#gid=0</span> 
', 'client_to_google_sheet' ),
				'content_classes' => 'google_sheet_example',
			]
		);
      	$this->add_control(
			'sheet_id',
			[
				'label' =>  __( 'Sheet id', 'client_to_google_sheet' ),
                'show_label' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
				
			]
		);
      $this->add_control(
			'sheet_example2',
			[
				'label' => __( 'IMPORTENT!', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'If you want this form to function as a separate site (e.g. landing page), enable this option and connect a separate Google Account to this specific form. If not, go to Dashboard > Elementor Form + and set up your Google Account ' ),
				'content_classes' => 'google_sheet_example',
			]
		);
    	$this->add_control(
			'enabole_sepred',
			[
				'label' => __( 'enable?', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
		'label_on' => __( 'yes', 'client_to_google_sheet' ),
				'label_off' => __( 'no', 'client_to_google_sheet' ),
				'return_value' => 'yes',
				'default' => 'no',
				
			]
		); 
 	$this->add_control(
			'conect_to_google',
			[
				'label' =>  __( 'Conect Google Sheet Account', 'client_to_google_sheet' ),
                'show_label' => true,
				'type' => \Elementor\Controls_Manager::BUTTON,
				'separator' => 'before',
				'button_type' => 'success',
				'text' => __( 'conect', 'client_to_google_sheet' ),
				'event' => 'conectgoogleacount',
				
			]
		);

        $this->add_control(
			'conect_to_google__example',
			[
				'label' => __( 'Notice:', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'Once you have approved access to Google, we\'ll redirect you back to the current page', 'client_to_google_sheet' ),
				'content_classes' => 'google_sheet_example',
			]
		);
        $this->add_control(
			'line_very_nise_line',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
    $this->add_control(
			'Upgrade_pro',
			[
				'label' => __( 'Upgrade to PRO', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => "<a href=\"http://sheet.webduck.co.il\" target=\"_blank\">
<button class=\"button button-primary\" style=\"
    cursor:  pointer;
    -webkit-appearance: button-bevel;
    background-color: #84d576;
    padding:  5px 5px;
\">". __( 'Need more than 200 per month? Upgrade to PRO', 'client_to_google_sheet' )."</button></a>",
				'content_classes' => 'pro_class',
			]
		);
      	$this->add_control(
			'form_reg_id',
			[
				'label' =>  __( 'Site ID (Automatically updated, do not change)', 'client_to_google_sheet' ),
                'show_label' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				
			]
		);
    	$this->add_control(
			'form_reg_pas',
			[
				'label' =>  __( 'password (same as above)', 'client_to_google_sheet' ),
                'show_label' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				
			]
		);
		$this->end_controls_section();
  
    	$this->start_controls_section(
   		'form_tracking',
   		[
   			'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
   			'label' => __( 'Submit Events', 'client_to_google_sheet' ),
   		]
   	);
    //
    
	$this->add_control(
			'enabletracking',
			[
				'label' => __( 'Enable?', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'client_to_google_sheet' ),
				'label_off' => __( 'no', 'client_to_google_sheet' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
	$this->add_control(
		'action',
		[
			'type' => \Elementor\Controls_Manager::TEXT,
			'label' => __( 'google: event action', 'client_to_google_sheet' ),
            'default' => 'Click',

		]
         
	);
    	$this->add_control(
		'category',
		[
			'type' => \Elementor\Controls_Manager::TEXT,
			'label' => __( 'google: event category', 'client_to_google_sheet' ),
            'default' => 'Lead',

		]
         
	);
        	$this->add_control(
		'facobook',
		[
			'type' => \Elementor\Controls_Manager::SELECT,
			'label' => __( 'FB: event', 'client_to_google_sheet' ),
   		'default' => 'Lead',
				'options' => [
					'Lead'  => __( 'Lead', 'client_to_google_sheet' ),
					'Purchase' => __( 'Purchase', 'client_to_google_sheet' ),
				
				],
			]
		);
        

 
       	$this->end_controls_section();
    }
    /* */
 protected function check_if_form(){
                  $args=array(
           'post_type' => 'wpcf7_contact_form',
       'meta_query' => array(
     array(
        'key'     => 'myacf7id',
        'value'   => 'form_'.$this->get_id(),
        'compare' => 'LIKE',
     ),
   ),
 );
        $my_query = new WP_Query($args);
        if( $my_query->have_posts() ){
            while ($my_query->have_posts()) : $my_query->the_post(); 
   return get_the_ID();
endwhile;
        }
       
        else return -1;
    // return false;
    }
protected function update_post($post_id){
     $output =  $this->make_post_content();
      $settings = $this->get_settings_for_display();
           $post_data = array(
                'ID'           => (int)$post_id,
                 'post_content' => $output,
           'post_title'   => "new cf7 form ".$this->get_id(),
        'post_type' => 'wpcf7_contact_form',
            'post_status'  => 'publish',
   'meta_input' => array(
        '_form'     =>  $output,
       'myacf7id' => 'form_'.$this->get_id()
           ),
  
            );
      wp_update_post( $post_data );
}
    public function make_post_content(){
            $settings = $this->get_settings_for_display();
    // $output = "<div class='mycf7form'>";
     foreach (  $settings['mycf7fileds'] as $item ) {
          //placeholder "testsgsgd"
         if($item['filed_id'] != "")
             $id = $item['filed_id'];
         else  $id ="fildid".$item['_id'];
          if($item['filed_placeholder'] != "")
         $placeholder = "placeholder \"".$item['filed_placeholder']."\"";
         else $placeholder = "";
         if($item['required'] == "yes")
         $required = "*";
         else $required = "";
         
              if($item['filed_type'] == 'select'){
         $def_val = $item['filed_val_select'];
                  $placeholder = "";
                  }
         else $def_val = "";
         if($item['filed_label'] != "")
             $br = "<br>";
         else
              $br = '';
  
         // set worper div
             $output .=  "<div class='mycf7fild width".$item['width']."  width_mobile".$item['width_mobile']."  width_tablet".$item['width_tablet']." elementor-field-group'><label>";
               // set fild   
         if($item['filed_type'] != "custom"){
             $output .= $item['filed_label'].$br."[";
    
             $output .=  $item['filed_type'].$required." ".$id." ".$def_val." ".$placeholder."]</label>";
             }
         else $output .= $item['custom_html'];
             // close worper div
             $output .="</div>";
              
                } //submitwidth
           $output .="<div class='mycf7fild hidden width".$settings['submitwidth']."  width_mobile".$settings['submitwidth_mobile']."  width_tablet".$settings['submitwidth_tablet']." elementor-field-group elementor-field-type-submit mycfsubmit'>[submit 'send']</div>";

        if($settings['button_icon'] != ''){
        if($settings['button_icon_after'] == "yes"){
            $button_icon_before = '';
            $button_icon_after = "<i class='".$settings['button_icon'] ."'></i>";
        }
            else{
               $button_icon_after = '';
            $button_icon_before = "<i class='".$settings['button_icon'] ."'></i>"; 
            }
         }
        else{
             $button_icon_before = '';
          $button_icon_after = '';  
        }
   $output .= "<div class='mycf7fild width".$settings['submitwidth']."  width_mobile".$settings['submitwidth_mobile']."  width_tablet".$settings['submitwidth_tablet']." elementor-field-group elementor-field-type-submit mycfsubmit elementor-animation-".$settings['button_hover_animation']."'> <button type='submit' class='elementor-button elementor-size-sm'><span>".$button_icon_before."	<span class='elementor-button-text'>".$settings['button_text']."</span>	".$button_icon_after."</span>	</button></div>";
       return $output;
      
    }
 protected function make_mail_body(){
         $settings = $this->get_settings_for_display();
$res = $settings['mail_body'];
     if (strpos($settings['mail_body'], '[all]') !== false) {
       //  $res = "enter if";
   $resall = '';
         foreach (  $settings['mycf7fileds'] as $item ) {
          
         if($item['filed_id'] != "")
             $id = $item['filed_id'];
         else  $id ="fildid".$item['_id'];
             $resall .= $item['filed_label'].":"." "."[".$id."]<br>";
            
}
       $res =  str_replace('[all]',$resall,$res);
     }
     return $res;
 }
protected function make_post(){
 $output =  $this->make_post_content();
             $post_data = array(
                 'post_content' => $output,
           'post_title'   => "new cf7 form ".$this->get_id()." ".$settings['cf7id'],
        'post_type' => 'wpcf7_contact_form',
            'post_status'  => 'publish',
   'meta_input' => array(
        '_form'     =>  $output,
       'myacf7id' => 'form_'.$this->get_id()
           ),
  
            );
     $clientid = wp_insert_post( $post_data );
    return $clientid;
}
      public function make_cf7_form($post_id){
             $settings = $this->get_settings_for_display();
  if ( !function_exists( 'wpcf7_save_contact_form' ) ) { 
    require_once ABSPATH . PLUGINDIR . 'contact-form-7/admin/includes/admin-functions.php'; 
} 
       if ( -1 != $post_id ) { 
           $contact_form = WPCF7_ContactForm::get_template(); 
      //  $contact_form = wpcf7_contact_form( $post_id ); 
    } 
 
    if ( empty( $contact_form ) ) { 
        $contact_form = wpcf7_contact_form(); 
    } 
              $properties = $contact_form->get_properties();
          //mail_body
        $properties['form'] = $this->make_post_content();
        $mail = $properties['mail'];
        $mail['subject'] = $settings['subject'];

        $mail['sender'] = $settings['from_mail'];

        $mail['body'] = $this->make_mail_body();

        $mail['recipient'] = $settings['to_mail'];
 $mail['use_html'] = 1;
    $mail['exclude_blank'] = 1;
    $properties['mail'] = $mail;

   $contact_form->set_title($settings['title']);
    $contact_form->set_properties($properties);
    do_action('wpcf7_save_contact_form', $contact_form);
           $post_id = $contact_form->save(); 
           if (function_exists( 'wpcf7_validate_configuration') ){ 
        $config_validator = new WPCF7_ConfigValidator( $contact_form ); 
       $config_validator->validate(); 
    } 
          return $post_id;
         // $result = wpcf7_save_contact_form($contact_form); 
         }
       public function get_fild_string(){
         $settings = $this->get_settings_for_display();
        $ids = '';
            foreach (  $settings['mycf7fileds'] as $item ) {
          //placeholder "testsgsgd"
         if($item['filed_id'] != "")
             $ids .= $item['filed_id'].";";
         else  $ids .= "fildid".$item['_id'].";";
            }
        return $ids;
    }
    public function render_plain_content() {
       
       $settings = $this->get_settings_for_display();
if($settings['mycf7fileds']){
           $post_id = $this->check_if_form();
    $temp_post = 0;
if($post_id  == -1){
  $post_id =  $this->make_post();
    $temp_post = $post_id;
    }
$post_id =  $this->make_cf7_form($post_id);
 update_post_meta($post_id, "myacf7id", 'form_'.$this->get_id() );
  update_post_meta($post_id, "send_data_to_google", $settings['send_data_to_google'] );
     update_post_meta($post_id, "sheet_id", $settings['sheet_id'] );
    update_post_meta($post_id, "form_reg_id", $settings['form_reg_id'] );
      update_post_meta($post_id, "form_reg_pas", $settings['form_reg_pas'] );
     update_post_meta($post_id, "enabole_sepred", $settings['enabole_sepred'] );

   update_post_meta($post_id, "fild_to_googl", $this->get_fild_string() );
    if($settings['zaiper_url']){
     update_post_meta($post_id, "zaiper_url", $settings['zaiper_url'] );
}
    else   update_post_meta($post_id, "zaiper_url", "no" );
      //
    
    wp_delete_post($temp_post);
    
//$post_id = $exsist; 

            }
        
        $this->render_content();
     }
    protected function render() {
        $settings = $this->get_settings_for_display();
        $id = $this->check_if_form();
        $this->get_render_attribute_string( '_wrapper' );
        $this->add_render_attribute(
		'_wrapper',
		[
			'class' => 'mycf7form',
            'data-tnx-page' => $settings['tnxpage'],
		
		]
            );
  if( $settings['enabletracking'] == "yes") {

       
     
    	$this->add_render_attribute( '_wrapper', [
		'data-tracking' => 'yes',
            'data-action' => $settings['action'],
              'data-category' => $settings['category'],
              'data-fb' => $settings['facobook'],
		
          
            
	] );
}
	
       echo  "<div ".$this->get_render_attribute_string( '_wrapper' ).">";
     echo   do_shortcode("[contact-form-7 id=\"".$id."\" title='none']");
        echo  "</div>"; 
   ?>        <div data-lng="<?php echo $settings['cf7id'];?>"></div>
<?php
    }

    protected function _content_template(){
        ?>
		<# if ( settings.mycf7fileds.length ) { #>
		<div class="mycf7form"><div role="form" class="wpcf7" id="wpcf7-f1372-p1372-o1" lang="he-IL" dir="rtl">
<div class="screen-reader-response"></div>
<form action="/elementor-1268/?preview_nonce=b48c2c78c1&amp;preview=true#wpcf7-f1372-p1372-o1" method="post" class="wpcf7-form" novalidate="novalidate">
			<# _.each( settings.mycf7fileds, function( item ) { #>
                <div class="mycf7fild width{{{ item.width }}}  width_mobile{{{ item.width_mobile }}}  width_tablet{{{ item.width_tablet }}} elementor-field-group">
                    <label>{{{ item.filed_label }}}<br>
                        <span class="wpcf7-form-control-wrap fildidc46934a">
                            <input type="{{{ item.filed_type }}}" name="fildid{{{ item.filed_id }}}" value="" size="40" class="wpcf7-form-control wpcf7-{{{ item.filed_type }}}" aria-invalid="false" placeholder="{{{ item.filed_placeholder }}}"></span></label>
                </div>
			
			<# }); #>
       <div class="mycf7fild width{{{ settings.submitwidth }}}  width_mobile{{{ settings.submitwidth_mobile }}}  width_tablet{{{ settings.submitwidth_tablet }}} elementor-field-group">
           <button type="submit" class="elementor-button elementor-size-sm"><span>
               <i class="{{{ settings.button_icon }}}"></i>
               <span class="elementor-button-text">{{{ settings.button_text }}}</span>
               </span>	
   </button></div>
<div class="wpcf7-response-output wpcf7-display-none"></div></form></div></div>
    
            
		<# } #>
		<?php
    }
}