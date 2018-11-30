document.addEventListener( 'wpcf7mailsent', function( event ) {
    debugger;
    var mycf7form = jQuery(event.target).closest(".mycf7form");
             var tracking_con = mycf7form.attr("data-tracking"); 
         if(tracking_con == "yes"){
             debugger;
             var tracking_action =   mycf7form.attr("data-action");
              var tracking_category =   mycf7form.attr("data-category");
          
            send_analitics_event(tracking_action,tracking_category);
                
         if (typeof fbq != 'undefined') {

            fbq('track',  mycf7form.attr("data-fb"));
              
             
         }
            }  
    if(mycf7form.attr("data-tnx-page") != '')
        window.location.href = mycf7form.attr("data-tnx-page");
  //	location = 'http://example.com/';
}, false );
try{
jQuery(window).on( 'elementor/frontend/init', function() {
    debugger;
    if (typeof elementor == "undefined") {
   return;
}
    if(isRealValue(elementor)){
	     	var myselectfild = elementor.modules.controls.BaseData.extend( {

                
//renderOnChange
		saveValue: function() {
            debugger;
			this.setValue( this.ui.select["0"].value );
		},
                renderOnChange: function() {
          //  debugger;
			//this.setValue( this.ui.textarea.getText() );
		},
onInputChange: function() {
   var val =   this.ui.select["0"].value;
     debugger;
   // if(val != "select")
    set_panel_fild(elementor.$body,val);
     //   elementor.$body.find(".elementor-control-filed_val_select").css("display","none");

		},
		onBeforeDestroy: function() {
		//	this.saveValue();
		//	this.ui.textarea.emojioneArea().destroy();
		}
	} );
	elementor.addControlView( 'select_fild', myselectfild );
    }
});
}
catch{
    console.log("elementor nut activ");
}
function isRealValue(obj)
{
 return obj && obj !== 'null' && obj !== 'undefined';
}
function set_panel_fild(panel,val){
    switch(val) {
    case "custom":
             panel.find(".elementor-control-filed_val_select").css("display","none");
            panel.find(".elementor-control-filed_placeholder").css("display","none");
             panel.find(".elementor-control-filed_id").css("display","none");
            panel.find(".elementor-control-required").css("display","none");
            panel.find(".elementor-control-filed_label").css("display","none");
            panel.find(".elementor-control-custom_html").css("display","block");
            //required 
            
        break;
    case "select":
        panel.find(".elementor-control-filed_val_select").css("display","block");
            panel.find(".elementor-control-filed_placeholder").css("display","none");
                     panel.find(".elementor-control-custom_html").css("display","none");
                      panel.find(".elementor-control-filed_id").css("display","block");
            panel.find(".elementor-control-required").css("display","block");
            panel.find(".elementor-control-filed_label").css("display","block");
        break;
    case "text":
                 panel.find(".elementor-control-filed_placeholder").css("display","block");
                     panel.find(".elementor-control-custom_html").css("display","none");
            panel.find(".elementor-control-filed_val_select").css("display","none");
                              panel.find(".elementor-control-filed_id").css("display","block");
            panel.find(".elementor-control-required").css("display","block");
            panel.find(".elementor-control-filed_label").css("display","block");
        break;
    default:
            panel.find(".elementor-control-filed_placeholder").css("display","block");
           panel.find(".elementor-control-filed_val_select").css("display","none");
            panel.find(".elementor-control-custom_html").css("display","none");
            panel.find(".elementor-control-filed_placeholder").css("display","block");
             panel.find(".elementor-control-filed_id").css("display","block");
            panel.find(".elementor-control-required").css("display","block");
            panel.find(".elementor-control-filed_label").css("display","block");
}
}