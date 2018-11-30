jQuery(document).ready(function($) {
   // var count_field = {};
     var my_current_field_status  =[];
    var my_count_form_index = 0;
     jQuery(".form_mobile").each(function(){
       //  debugger;
make_mobile_html(jQuery(this));
         var index = 0;
         jQuery(this).find(".elementor-field-group").not( ".elementor-field-type-submit" ).each(function(){
             jQuery(this).attr("data-fild_index",index);
             index = index + 1;
   });  
 
         
         });
 
 
  
         jQuery(".form_fixed_bg").click(function(e){
        move_back(this,-1);
      
});
  
    function on_fild_click_mobile(target_class){
               var fild_index =  jQuery( target_class).attr("data-fild_index");
        jQuery(".currently_display").removeClass("currently_display");
        jQuery(target_class).addClass("currently_display");
        jQuery(target_class).closest(".form_mobile").find(".form_fixed_bg").removeClass("unactiv");
      //  debugger;
        for(i = 0;i < parseInt(fild_index); i++){
        //    debugger;
            var qna = jQuery(target_class).closest(".form_mobile").find("div[data-fild_index='"+i+"']");
              jQuery(target_class).closest(".form_mobile").find(".qnr_worper").append("<div class='bbl bblq'>"+qna.find("label").html()+"</div>");
        jQuery(target_class).closest(".form_mobile").find(".qnr_worper").append("<div data-fild-anser='"+i+"' onClick='on_bbla(event)' class='bbl bbla'></div>");
        jQuery(target_class).closest(".form_mobile").find("div[data-fild-anser='"+i+"']").append(qna.find(".elementor-field"));
            jQuery(target_class).closest(".form_mobile").find("div[data-fild-anser='"+i+"']").children().click(function(e){
               on_bbla(e);
           });
           
        }
    //    debugger;
         jQuery(target_class).closest(".form_mobile").find(".qnr_worper").append("<div class='bbl bblq'>"+jQuery(target_class).find("label").html()+"</div>");
     jQuery(target_class).closest(".form_mobile").find(".input_worper").append("<div data-fild-anser='"+fild_index+"' ></div>");
         jQuery(target_class).closest(".form_mobile").find("div[data-fild-anser='"+fild_index+"']").append(jQuery(target_class).find(".elementor-field"));
         jQuery(target_class).closest(".form_mobile").find("div[data-fild-anser='"+fild_index+"']").children().last().focus();
        //
//jQuery(target_class).find(".elementor-field-group").not( ".elementor-field-type-submit" ).length;
    }
    jQuery(".form_mobile").find(".elementor-field-group").not( ".elementor-field-type-submit" ).click(function(e){
        on_fild_click_mobile(this);
      
});

   jQuery(".form_one_by_one").each(function(){
          if(get_data_form(jQuery( this),"data-progres_bar") == "yes"){
var my_count_field = jQuery(this).find(".elementor-field-group").not( ".elementor-field-type-submit" ).length;
         
             var obj = {
    count_field: my_count_field,
    current_field_status: 1
};
           
              my_current_field_status.push(obj);
              jQuery(this).closest(".elementor-widget-form").attr("data-form_num", my_current_field_status.length-1);
 
    updat_progres_bar( my_current_field_status.length-1,my_count_field,1);
 
        }

});

	jQuery( document ).on('submit_success', function(e){


         var tracking_con = get_data_form(e.target,"data-tracking");
 //  var tracking_con =  jQuery(target).closest(".elementor-widget-form").attr("data-tracking");
         if(tracking_con == "yes"){
             debugger;
  //var tracking_action =  jQuery(target).closest(".elementor-widget-form").attr("data-action");
             var tracking_action =   get_data_form(e.target,"data-action");
              var tracking_category =   get_data_form(e.target,"data-category");
          
            send_analitics_event(tracking_action,tracking_category);
                
         if (typeof fbq != 'undefined') {

            fbq('track',  get_data_form(e.target,"data-fb"));
              
             
         }
            }                                                                             
        
                    
	});
jQuery(".form_one_by_one button").click(function(e){
    if(jQuery(this).hasClass("finich"))
        return;
   e.preventDefault();
  //  debugger;
   var current =  jQuery(this).closest(".form_one_by_one").find( ".elementor-field-group:visible" ).first();
    try{

        if(current.hasClass("elementor-field-required")){
            if(current.find("input").length != 0){
                if(!current.find("input").val().length)
                    return;
                }
            if( current.find("textarea").length != 0){
                 if(!current.find("textarea").val().length)
                    return;
                }
            }

    current.css("display","none");
        current.next().css("display","flex");
        if(get_data_form(jQuery(this).closest(".form_one_by_one"),"data-progres_bar") == "yes"){
            var index = get_data_form(jQuery(this).closest(".form_one_by_one"),"data-form_num");
   
            my_current_field_status[index].current_field_status = my_current_field_status[index].current_field_status+ 1;
        updat_progres_bar(index, my_current_field_status[index].count_field,my_current_field_status[index].current_field_status );
        }
   // }
        
        }
    catch{
   // if(jQuery(this) == current.next()){
    jQuery(this).addClass("finich");
        jQuery(this).click();
  //  }
    }
});
    
    
 
        });
function set_type_input(targer_class,val){
    debugger;
      targer_class = jQuery(targer_class.children().last());
   
    if(targer_class.is("input"))
         targer_class.val(val);
    
    if(targer_class.is("textarea"))
         targer_class.val(val)
     if(targer_class.is("select"))
         targer_class.find("option[value="+val+"]").attr('selected','selected');
       //  return targer_class.find(":selected").val();
        
}
function get_type_input(targer_class){
    debugger;
      targer_class = jQuery(targer_class.children().first());
   
    if(targer_class.is("input"))
        return targer_class.val();
    
    if(targer_class.is("textarea"))
        return targer_class.val();
     if(targer_class.is("select"))
         return targer_class.find(":selected").val();
        
}
  function move_back(targer_class, open){
    
        targer_class = jQuery(targer_class);
  //   var last =   targer_class.closest(".form_mobile").find(".elementor-field-group").not( ".elementor-field-type-submit" ).last().attr("data-fild_index");
    debugger;
var last =   targer_class.closest(".form_mobile").find("div[data-fild-anser]").length;
      
         for(i = 0;i <= parseInt(last) - 1; i++){
    //  targer_class.find("div[data-fild-anser='"+i+"']").clone().appendTo(targer_class.closest(".form_mobile").find("div[data-fild_index='"+i+"']"));
             var val = get_type_input(targer_class.find("div[data-fild-anser='"+i+"']"));
             debugger;
           //  var val = targer_class.find("div[data-fild-anser='"+i+"']").find("input").val();
      
             targer_class.closest(".form_mobile").find("div[data-fild_index='"+i+"']").append( targer_class.find("div[data-fild-anser='"+i+"']").html());
        //   targer_class.closest(".form_mobile").find("div[data-fild_index='"+i+"']").find("input").val(val);
             set_type_input(targer_class.closest(".form_mobile").find("div[data-fild_index='"+i+"']"),val);
           
        }
        targer_class.closest(".form_mobile").find(".bbl").remove();
        targer_class.addClass("unactiv");
        targer_class.find(".input_worper").html("");
     //   debugger;
        if(open != -1){
           targer_class.closest(".form_mobile").find("div[data-fild_index='"+open+"']").click();
           if(targer_class.closest(".form_mobile").find("div[data-fild_index='"+open+"']").length == 0) 
              targer_class.closest(".form_mobile").find("button").click(); 
        }
         
    }
  function on_bbla(e){
        debugger;
      e.stopPropagation();
        e.preventDefault();
   var i =   jQuery( e.target).closest(".bbla").attr("data-fild-anser");
      var p = jQuery( e.target).closest(".form_mobile");
       move_back(e.target.closest(".form_fixed_bg"),parseInt(i));
   
    } 
  function on_next_botton(e){
      //  debugger;
      e.stopPropagation();
        e.preventDefault();
         var i =   jQuery( e.target).closest(".form_fixed_bg").find(".input_worper").find("div").attr("data-fild-anser");
      var p = jQuery( e.target).closest(".form_mobile");
  
      i = parseInt(i) + 1;
       move_back(e.target.closest(".form_fixed_bg"),parseInt(i));
   
    } 
function send_analitics_event(action,category){
   
    debugger;
    if (typeof gtag != 'undefined') {
         gtag('event', action,{
'event_category': category
});
}      
}
function updat_progres_bar(index,count_field,current_field_status){
//    debugger;
     jQuery("div[data-form_num='"+index+"']").find("#button_progres").remove();
jQuery("div[data-form_num='"+index+"']").find(".elementor-button-text").prepend("<span id='button_progres'>          ("+count_field+"/"+current_field_status+")</span>");
   
   // jQuery(".form_one_by_one .elementor-button-text")

        
}
function get_data_form(div,data){
       return jQuery(div).closest(".elementor-widget-form").attr(data);
        
}

function clos_pop_up(trget_class){
    
           trget_class.find("#frame_elementor").remove();
        trget_class.find(".loader_elemntor").removeClass("unactiv_elementor");
                   trget_class.find(".popup_elementor").addClass("unactiv_elementor"); 
}
function input_cliclk(event){
   
    event.stopPropagation();
    event.preventDefault();
}
function make_mobile_html(trget_class){
      var icon =  trget_class.attr("data-send_icon");

        
 //   debugger;

         var mypopuphtml = "<div class='form_fixed_bg unactiv'><div class='form_content'><div class='form_content_worper'> <div class='qnr_worper'></div><div class='anser_content'><div class='input_worper' onClick='input_cliclk(event)'></div><div class='icon_worper' onClick='on_next_botton(event)'><i class='" +icon+ "'></i></div> </div> </div></div> </div>";
       trget_class.prepend(mypopuphtml);
}
function make_html(trget_class){

      var mypopuphtml = "<div class='popup_elementor unactiv_elementor'><i class='fa fa-close clospopup_elementor' > </i><div class='reltivdivpop_elementor'><div class = 'framdiv_elementor framdiv_elementor_wh width_chous' ><div class= 'loader_elemntor framdiv_elementor_wh width_chous'></div>  </div></div></div>";
       trget_class.prepend(mypopuphtml);
}
function on_r_pop_up(myclass){

             
     var popupparent =  myclass.closest(".openpopup_elementor");
                popupparent.find(".loader_elemntor").css("background-image","url("+misha_loadmore_params.louder_url+")");
    
                popupparent.find(".popup_elementor").removeClass("unactiv_elementor");

                var myifrm = "<iframe id='frame_elementor' width = '"+popupparent.find(".framdiv_elementor").width()+"' src='"+myclass.attr("href")+"'  scrolling='no'>  </iframe> ";
                popupparent.find(".framdiv_elementor").append(myifrm);
            
                  popupparent.find('#frame_elementor').load(function(){
                      jQuery(this).closest(".openpopup_elementor").find(".loader_elemntor").addClass("unactiv_elementor");
 
        console.log('laod the iframe');
                       jQuery(this).closest(".openpopup_elementor").find(".framdiv_elementor").animate({scrollTop: 1});
    });
               
}

 