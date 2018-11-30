<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//require __DIR__ . '/google-api-php-client-2.2.2/vendor/autoload.php';
class CTGS_option_page {
    public function __construct() {
		$this->add_actions();
 
	}
    	private function add_actions() {
        add_action('admin_menu', [ $this,'create_menu_page']);


	}

public function create_menu_page() {

	//create new top-level menu
	add_menu_page(__( 'Elementor Form ++', 'client_to_google_sheet' ),
                  __( 'Elementor Form ++', 'client_to_google_sheet' ), 'administrator',
                  __FILE__, [ $this,'main_settings_page'] ,
                  'dashicons-editor-table' );

	//call register settings function
	add_action( 'admin_init', [ $this,'register_plugin_settings'] );
}


public function register_plugin_settings() {

      register_setting('Elementor_Form_Plus', 'api_google_token' );
      register_setting( 'Elementor_Form_Plus', 'api_google_token_pas' );
}

public function main_settings_page() {
?>
<div class="wrap">
<h1><?php  echo __( 'Elementor Form ++', 'client_to_google_sheet' ); ?></h1>
<a href="http://sheet.webduck.co.il" target="_blank">
<button class="button button-primary"><?php  echo __( 'Need more than 200 per month? Upgrade to PRO', 'client_to_google_sheet' ); ?></button></a>
<button class="conect button button-primary" id="conecttogoogle"><?php  echo __( 'conect to google sccount', 'client_to_google_sheet' ); ?></button>
<form method="post" action="options.php">
    <?php settings_fields( 'Elementor_Form_Plus' ); ?>
    <?php do_settings_sections( 'Elementor_Form_Plus' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php  echo __( 'ID', 'client_to_google_sheet' ); ?></th>
        <td><input type="text" name="api_google_token" value="<?php echo esc_attr( get_option('api_google_token') ); ?>" /></td>
        </tr>
         
        <tr valign="top">
        <th scope="row"><?php  echo __( 'password', 'client_to_google_sheet' )?></th>
        <td><input type="text" name="api_google_token_pas" value="<?php echo esc_attr( get_option('api_google_token_pas') ); ?>" /></td>
        </tr>
  
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
    <script type="text/javascript">
        jQuery(document).ready(function($) { 
jQuery("#conecttogoogle").click(function() { 
      debugger;
                 jQuery.ajax({
                type: 'POST',
                 dataType: 'json',
             crossDomain: true,
                url: "/wp-admin/admin-ajax.php",
                
                data: { action: 'askAccsesToken',
                  
                       domain: window.location.hostname,
                       form_name: "global",
                       sheet: "none",
                       current_page: window.location.href
                 
                },       
                success: function (data) {
                    debugger;
                    
                    localStorage.setItem('currentpage', window.location.href );
                    window.location.href = data[0];

             

                }
    });
        });
   
    });
              </script>
<?php }

}
new CTGS_option_page();