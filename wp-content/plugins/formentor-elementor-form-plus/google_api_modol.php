<?php
/**
 * @package client_to_google_sheet
 * @version 1.0
 */
/*
Plugin Name: Formentor - Elementor Form Plus
Plugin URI: https://wordpress.org/plugins/elementor-form-plus/
Description: Elementor Form Plus allows you to send submited forms directly from your Wordpress site to Google Sheet and more.
Author: Tziki Trop
Version: 1
Author URI: https://sheet.webduck.co.il
Text Domain: client_to_google_sheet
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 require __DIR__ . '/option_page.php';
 include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
  require __DIR__ . '/cf7-form/cf7-form.php';
} 
class CTGS_client_to_google_sheet {
 protected $requestkey = [];
    protected $requesteval = [];
  protected $request = [];
 protected $id;
protected $pas;
    protected $mainurl;


	public function __construct() {

        $this->mainurl = "https://sheet.webduck.co.il/api/";
		$this->add_actions();
 

	}


     protected function addrequestitem($key,$val){
    array_push($this->requestkey,$key); 
        array_push($this->requesteval,$val);
    }
      protected function setrequestarray(){

          $args = array(
        'method' => 'POST',
        'timeout' => 5,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => json_encode(array_combine($this->respansekey,$this->respanseval)),
        'cookies' => array()
        );

          $this->request = $args;

    }
	private function add_actions() {
        add_action('wp_enqueue_scripts', [ $this,'client_to_google_sheet_enqueue']);
        add_action( 'elementor/frontend/widget/before_render',  [ $this,'custom_render_popup'] );
 add_action( 'admin_init', [ $this,'page_init_add_settings']  );
        add_action( 'elementor_pro/forms/validation', [ $this,'loop_form_and_send_data'],10,2);
        add_action( 'elementor/element/form/section_form_style/before_section_start',[ $this,'add_control_sectio_to_form' ], 10, 2 );
add_action( 'wp_ajax_askAccsesToken',  [ $this,'askAccsesToken'] );
add_action( 'wp_ajax_nopriv_askAccsesToken',  [ $this,'askAccsesToken' ]);
        add_action( 'wp_ajax_savetokeb',  [ $this,'savetokeb'] );
add_action( 'wp_ajax_nopriv_savetokeb',  [ $this,'savetokeb' ]);
       add_action('plugins_loaded', [ $this,'client_google_sheet_api_load_textdomain']);
add_action( 'wp_footer',  [ $this,'add_js_to_wp_to_get_google_sheet']);
        
        add_action('wpcf7_before_send_mail',[ $this,'send_cf7_to_google_sheet'],10,1);

	}
  public function client_to_google_sheet_enqueue() {
   wp_enqueue_style( 'popupcss', plugin_dir_url(__FILE__) . '/addtrackingform.css',false,'1.1','all');
    wp_enqueue_script('addtrackingform', plugin_dir_url(__FILE__) . '/adminscript.js', array( 'jquery' ), '1.0.0', true);
}
public function client_google_sheet_api_load_textdomain() {
    
	load_plugin_textdomain( 'client_to_google_sheet', false, dirname( plugin_basename(__FILE__) ) . '/' );

}
public function  custom_render_popup( $element ) {
  if( 'form' === $element->get_name()) {
   $settings = $element->get_settings();

       if( $settings['enable_one_by_one'] == "yes" ) {{

    	$element->add_render_attribute( '_wrapper', [
		'class' => 'form_one_by_one',
           
	] );


}
           if( $settings['enable_progres_bar'] == "yes" ) {

    	$element->add_render_attribute( '_wrapper', [
		'data-progres_bar' => 'yes',
           
	] );

}
    }
      //form_mobile
  /*          if( $settings['enable_form_mobile'] == "yes" ) {
if ( wp_is_mobile() ) {


    	$element->add_render_attribute( '_wrapper', [
		'class' => 'form_mobile',
           
	] );
    }
                //<i class="' . $settings['icon'] . '" aria-hidden="true"></i>
    	$element->add_render_attribute( '_wrapper', [
		'data-send_icon' => $settings['send_icon'],
] );

}*/
   if( $settings['enable'] == "yes") {

       
     
    	$element->add_render_attribute( '_wrapper', [
		'data-tracking' => 'yes',
            'data-action' => $settings['action'],
              'data-category' => $settings['category'],
              'data-fb' => $settings['facobook'],
		
          
            
	] );
}
}
}


    	 public function send_cf7_to_google_sheet($contact_form)
    {
      $form_id = $contact_form->id();
             $send =  get_post_meta((int)$form_id,"send_data_to_google",true );
$send_to_zaiper =   get_post_meta((int)$form_id,"zaiper_url",true );
if($send_to_zaiper != "no"){

                          $args = array(
        'method' => 'POST',
        'timeout' => 5,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array("Access-Control-Allow-Credentials" => "true"),
        'body' => json_encode($_POST),
        'cookies' => array()
        );
   
      $reqest =   wp_remote_post($send_to_zaiper,$args);
}
             if($send == "yes_send_data_to_google" ){
                 $isglobal =   get_post_meta((int)$form_id,"enabole_sepred",true );
                 if($isglobal == "yes"){
                          $reg_id = get_post_meta((int)$form_id,"form_reg_id",true );
                        $pas = get_post_meta((int)$form_id,"form_reg_pas",true );
                 }
                 else{
                     $this->get_id_settings();
                  $this->get_pas_settings();
                
                 if($this->id == false){
                    return;
                       }
                     $reg_id = $this->id;
                      $pas = $this->pas;
                 }
                  $sheet_id  =   get_post_meta((int)$form_id,"sheet_id",true );
                 
                 $fildstring = get_post_meta((int)$form_id,"fild_to_googl",true );
                 $fields = [];
	foreach ( $_POST as $key => $value ) {
        if (strpos($fildstring, $key) !== false) {
         $fields[$key] =(string)$value;
}
	}
    
                      $args = array(
        'method' => 'POST',
        'timeout' => 5,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array("Access-Control-Allow-Credentials" => "true"),
        'body' => json_encode(array('id' =>  $reg_id ,'sheet' => $sheet_id,'row' => $fields,'pas' => $pas )),
        'cookies' => array()
        );
   
      $reqest =   wp_remote_post($this->mainurl."addrow",$args);

      $body = wp_remote_retrieve_body($reqest);
    
             }



    }
   
    public function castumregister(){
    
  
 $args = array(
        'method' => 'POST',
        'timeout' => 5,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => json_encode(array('url' =>  get_site_url())),
        'cookies' => array()
        );
     
      $reqest =   wp_remote_post($this->mainurl."register",$args);
      $body = wp_remote_retrieve_body($reqest);
            if(is_wp_error($reqest))
            return false;
         $body = wp_remote_retrieve_body($reqest);
        $json = str_replace('&quot;', '"', $body);
        $res = json_decode($json);
  
  
         return $res;
        
 
  
}
 
public function register(){
    
       $this->get_id_settings();
       if($this->id != false){
       return;
    }
    else{
 $args = array(
        'method' => 'POST',
        'timeout' => 5,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => json_encode(array('url' =>  get_site_url())),
        'cookies' => array()
        );
     
      $reqest =   wp_remote_post($this->mainurl."register",$args);
      $body = wp_remote_retrieve_body($reqest);
            if(is_wp_error($reqest))
            return false;
         $body = wp_remote_retrieve_body($reqest);
        $json = str_replace('&quot;', '"', $body);
        $res = json_decode($json);
        $this->id =  $res->id;
        $this->pas = $res->pas;
         $this->set_pas_settings();
         $this->set_id_settings();
  
         return true;
        
 
    }
}
    public function askAccsesToken(){
              $arrresolt = [];    
      if($_POST["form_name"] != "global"){
          $reg_config = $this->castumregister();
            $this->id =  $reg_config->id;
        $this->pas = $reg_config->pas;
      }
        else{
            
      $this->get_id_settings();
        $this->get_pas_settings();
        }
       if($this->id == false){
         array_push($arrresolt, "fale");
             echo json_encode($arrresolt);
        wp_die();
    }
            $args = array(
        'method' => 'POST',
        'timeout' => 5,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => json_encode(array('id' =>  $this->id,'pas' => $this->pas,'current_page' => $_POST["current_page"] )),
        'cookies' => array()
        );
   
      $reqest =   wp_remote_post($this->mainurl."addform",$args);
      $body = wp_remote_retrieve_body($reqest);
            
            if(is_wp_error($reqest)){
             array_push($arrresolt, "res->url");
                
         echo json_encode($arrresolt);
        wp_die();
                }
      
         $body = wp_remote_retrieve_body($reqest);
        $json = str_replace('&quot;', '"', $body);
        $res = json_decode($json);  
          array_push($arrresolt,  $res->url);
        array_push($arrresolt,  $this->id);
          array_push($arrresolt,  $this->pas);
         echo json_encode($arrresolt);
        wp_die();
    }

   public function add_js_to_wp_to_get_google_sheet(){ ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) { 

            try{
	
              elementor.channels.editor.on('conectgoogleacount', function(e){
				  debugger;
				  var i = "<i class=\"ctggbi fa fa-spinner fa-spin\"></i>"
			
                var to =	elementor.$body.find("button[data-event=\"conectgoogleacount\"]");
				   jQuery(i).insertAfter(to);
               var form_name =    e.options.elementSettingsModel.attributes.form_name;
                  if(form_name =='')
                      form_name = "castum";
                
                 jQuery.ajax({
                type: 'POST',
                 dataType: 'json',
             crossDomain: true,
                url: "/wp-admin/admin-ajax.php",
                
                data: { action: 'askAccsesToken',
                  
                       domain: window.top.location.hostname,
                       form_name: form_name,
                       sheet: "test",
                       current_page: window.top.location.href
                 
                },       
                success: function (data) {
                  
                    localStorage.setItem('currentpage', window.top.location.href );
               //     window.top.location.href = data[0];
elementor.$body.find(".elementor-control-form_reg_id").find("input").val(data[1]);
      elementor.$body.find(".elementor-control-form_reg_pas").find("input").val(data[2]);
                 e.options.elementSettingsModel.attributes.form_reg_id = data[1];
                e.options.elementSettingsModel.attributes.form_reg_pas = data[2];
                    debugger;
  
                    elementor.$body.find("#elementor-panel-saver-button-publish").removeClass("elementor-saver-disabled");
                    elementor.$body.find("#elementor-panel-saver-button-publish").click();
                 setTimeout(function() {
  window.top.location.href = data[0];
}, 10000);
                    

                }
              
            });
	});
                }
            
            catch{
                var a= 4;
        }
    });
              </script>
<?php
   
   }

 public function page_init_add_settings()    { 

$this->register();

}
       private function reset_id_settings()    { 
            update_option( 'api_google_token' ,false );
     update_option( 'api_google_token_pas' ,false );
 
}
     private function get_id_settings()    {        
     $this->id  =  get_option( 'api_google_token' , $this->id  );
 
}
   
              private function set_id_settings()    {        
      update_option( 'api_google_token' ,$this->id );
 
}
   

   private function get_pas_settings()    {        
     $this->pas  =  get_option( 'api_google_token_pas' , $this->pas  );
 
}
   
              private function set_pas_settings()    {        
      update_option( 'api_google_token_pas' ,$this->pas );
 
}
   

public function add_control_sectio_to_form( $element, $args ) {
	/** @var \Elementor\Element_Base $element */
    	$element->start_controls_section(
			'send_data_to_google_sheet',
			[
				'label' =>   __( 'Google Sheet', 'client_to_google_sheet' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$element->add_control(
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
   
           $element->add_control(
			'sheet_example',
			[
				'label' => __( 'Get Sheet ID:', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'ID is the value between the "/d/" and the "/edit" in the URL of your spreadsheet. For example:<br><span> /spreadsheets/d/<b>****</b>/edit#gid=0</span> 
', 'client_to_google_sheet' ),
				'content_classes' => 'google_sheet_example',
			]
		);
      	$element->add_control(
			'sheet_id',
			[
				'label' =>  __( 'Sheet id:', 'client_to_google_sheet' ),
                'show_label' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				
			]
		);
    	       $element->add_control(
			'sheet_example2',
			[
				'label' => __( 'IMPORTENT!', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'If you want this form to function as a separate site (e.g. landing page), enable this option and connect a separate Google Account to this specific form.
 If not, go to Dashboard > Elementor Form + and set up your Google Account', 'client_to_google_sheet' ),
				'content_classes' => 'google_sheet_example',
			]
		);
    	$element->add_control(
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
 	$element->add_control(
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
     $element->add_control(
			'conect_to_google__example',
			[
				'label' => __( 'Notice:', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __( 'Once you have approved access to Google, we\'ll redirect you back to the current page', 'client_to_google_sheet' ),
				'content_classes' => 'google_sheet_example',
			]
		);
    $element->add_control(
			'line_very_nise_line',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);
    $element->add_control(
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
      	$element->add_control(
			'form_reg_id',
			[
				'label' =>  __( 'Site ID (Automatically updated, do not change)', 'client_to_google_sheet' ),
                'show_label' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				
			]
		);
    	$element->add_control(
			'form_reg_pas',
			[
				'label' =>  __( 'password (same as above)', 'client_to_google_sheet' ),
                'show_label' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				
			]
		);
		$element->end_controls_section();

     	$element->start_controls_section(
   		'one_by_one',
   		[
   			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
   			'label' => __( '\'Baby Steps\' Mood ', 'client_to_google_sheet' ),
   		]
   	);
    	$element->add_control(
			'enable_one_by_one',
			[
				'label' => __( 'enable?', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'client_to_google_sheet' ),
				'label_off' => __( 'no', 'client_to_google_sheet' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
        $element->add_control(
			'enable_progres_bar',
			[
				'label' => __( 'Enable Progress Bar?', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'client_to_google_sheet' ),
				'label_off' => __( 'no', 'client_to_google_sheet' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
    
     

  
       	$element->end_controls_section();
    	$element->start_controls_section(
   		'custom_section',
   		[
   			'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
   			'label' => __( 'Submit Events', 'client_to_google_sheet' ),
   		]
   	);
    //
    
	$element->add_control(
			'enable',
			[
				'label' => __( 'Enable?', 'client_to_google_sheet' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'yes', 'client_to_google_sheet' ),
				'label_off' => __( 'no', 'client_to_google_sheet' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
	$element->add_control(
		'action',
		[
			'type' => \Elementor\Controls_Manager::TEXT,
			'label' => __( 'google: event action', 'client_to_google_sheet' ),
            'default' => 'click',

		]
         
	);
    	$element->add_control(
		'category',
		[
			'type' => \Elementor\Controls_Manager::TEXT,
			'label' => __( 'google: event category', 'client_to_google_sheet' ),
            'default' => 'Lead',

		]
         
	);
        	$element->add_control(
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

  
       	$element->end_controls_section();

}
public function loop_form_and_send_data ( $record, $ajax_handler ) {

 $send = $record->get_form_settings( 'send_data_to_google' );
if($send != "yes_send_data_to_google")
    return;
     $isglobal = $record->get_form_settings( 'enabole_sepred' );
    if($isglobal == "yes"){
        $reg_id = $record->get_form_settings( 'form_reg_id' );
        $pas = $record->get_form_settings( 'form_reg_pas' );
    }
    else {
        $this->get_id_settings();
         $this->get_pas_settings();
            if($this->id == false){ return; }
        $reg_id = $this->id;
         $pas = $this->pas;
    }

   
    $sheet_id = $record->get_form_settings( 'sheet_id' );
       $raw_fields = $record->get( 'fields' );
	$fields = [];
	foreach ( $raw_fields as $id => $field ) {
		$fields[ $id ] = (string)$field['value'];
	}
         $args = array(
        'method' => 'POST',
        'timeout' => 5,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array("Access-Control-Allow-Credentials" => "true"),
        'body' => json_encode(array('id' =>  $reg_id,'sheet' => $sheet_id,'row' => $fields,'pas' => $pas )),
        'cookies' => array()
        );
   
      $reqest =   wp_remote_post($this->mainurl."addrow",$args);

      $body = wp_remote_retrieve_body($reqest);


}
}
new CTGS_client_to_google_sheet();