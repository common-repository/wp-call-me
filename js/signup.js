jQuery(document).ready(function($) {
$("#phone_cc").intlTelInput();
$("#phone_cc").on('change',function(){
    console.log($(this).val());
    if($(this).val()=="+1 "){
        change_to_us_number();
    }else{
        change_to_intl_number();
    }
});

function change_to_intl_number(){
    $("#area_code").hide();
    $("#phone1").hide();
    $("#phone2").css('width','230px');
}


function change_to_us_number(){
    $("#area_code").show();
    $("#phone1").show();
    $("#phone2").css('width','90px');
}

function  objectFromUrl(query){
  var result = {};
  query.split("&").forEach(function(part) {
    var item = part.split("=");
    result[item[0]] = decodeURIComponent(item[1]);
  });
  return result;
}




$("#wp_register_form").on('submit',function(event){
var form_data=$(this).serialize();
var user_personal_number=$("#area_code").val()+$("#phone1").val()+$("#phone2").val();
    var phone_cc=$("#phone_cc").val().replace(/\s+/g,"").replace("+","");
    user_personal_number=user_personal_number.replace(/\s+/g,"");
    form_data+="&user_personal_number="+user_personal_number;
    form_data+="&wp_call_me=1";
    form_data+="&phone_cc="+phone_cc;
    var form_stuff=form_data;

    
    $.ajax({
      type: "POST",
      url: '//www.ringroost.com/rest/signup.php',
      dataType:'JSON',
      data:form_data,
      success:function(data,form_data){
        if(data.success == "1"){
                        add_wp_phone_wordpress_options(form_stuff,'new_account',data);            
              }else{
                     var errors_holder="<ul class='errors'>";
                            errors_holder+="<h5>Oops, there was a problem. Please fix the below errors.</h5>";
                        $.each(data.errors,function(key,error){
                            errors_holder+="<li>"+error+"</li>";
                        });     

                        errors_holder+="</ul>";

                        $('.error_holder').html(errors_holder);
            
                  
          }
      }
    });
    event.preventDefault();
    return false;
    
});

$("#wp_phone_sync_form").on('submit',function(event){
var form_data=$(this).serialize();
//this is for syncing wordpress
  $.ajax({
      type: "POST",
      url: '//www.ringroost.com/rest/sync_wp.php',
      dataType:'JSON',
      data:form_data,
      success:function(data,form_data){
        if(data.success == "1"){
            data.freindly_name=data.data.pretty_number
            var account_data='';
             account_data+="&name="+data.data.name;
             account_data+="&email="+data.data.email;
             account_data+="&user_personal_number="+data.data.user_personal_number;
             account_data+="&phone_cc="+data.data.phone_cc;
             account_data+="&pretty_number="+data.data.pretty_number;
                    add_wp_phone_wordpress_options(account_data,'account_sync',data);            
              }else{

                     var errors_holder="<ul class='errors'>";
                            errors_holder+="<h5>Oops, there was a problem. Please fix the below errors.</h5>";
                        $.each(data.errors,function(key,error){
                            errors_holder+="<li>"+error+"</li>";
                        });     

                        errors_holder+="</ul>";
                        $('.error_holder_sync').html(errors_holder);
            
                  
          }
      }
    });
    event.preventDefault();
    return false;
    
});

$('#wp_phone_sync').on('click',function(){
   $('#wp_phone_sync_form').show(); 
   $('#wp_register_form').hide(); 
});
$('#wp_phone_register').on('click',function(){
   $('#wp_phone_sync_form').hide(); 
   $('#wp_register_form').show(); 
});

$('#wp_call_me_user_settings_submit').on('click',function(event){
    var form_data=$("#wp_call_me_user_settings").serialize();
    save_settings(form_data);
    event.preventDefault();
    return false;
});

    //saves data to worpdress
    function save_settings(form_data){
        var data=form_data;
        data+="&action=wp_phone_save_user_settings";
        $.post(ajaxurl, data, function(response) {
            var reload_page=window.location.href;
            window.location=reload_page;
        });
     }

    //saves data to worpdress
    function add_wp_phone_wordpress_options(form_data,signup_source,return_data){
         //var s_form_data=objectFromUrl(form_data); 
        var data=form_data;
        data+="&signup_source="+signup_source;
        data+="&action=wp_phone_save_user_data";
        data+="&default_phone="+return_data.friendly_name;
        data+="&click_to_call_element="+return_data.click_to_call_element;
        $.post(ajaxurl, data, function(response) {
            var reload_page=window.location.href;
                reload_page+="&first_time=true"
            window.location=reload_page;
        });
     }

});
