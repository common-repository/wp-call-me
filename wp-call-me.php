<?php
   /*
   Plugin Name: WP Call Me 
   Plugin URI: http://wordpress.org/plugins/wp-call-me/
   Description:  Install a browser based click to call button on your website (desktop not just mobile).  Wp Call Me also lets you setup custom phone systems including: call forwarding, call queues, call transfers, placing outbound calls, interactive voice response menus and more. Wp Call Me leverages <a target="_blank" href="https://www.ringroost.com"> www.ringroost.com</a> for the phone system.  
   Version: 1.7
   Author:Taylor Hawkes 
   Author URI: https://taylor.woodstitch.com
   License: GPL2
   */
    

/*  Copyright 2013  Taylor Hawkes  (email : thawkes@woodstitch.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/* stuff to do when we create plugin */

//register_activation_hook( __FILE__, 'wp_phone_init_plugin' );

//register_deactivation_hook( __FILE__, 'wp_phone_remove_plugin' );
add_action( 'admin_init', 'my_plugin_admin_init' );


/** Step 2 (from text above). */
add_action( 'admin_menu', 'wp_phone_my_plugin_menu' );
//add_action( 'edit_form_after_title', 'add_admin_cache_button' );

/*these are for updting the cache automaticly */
//add_action( 'edit_post', 'wp_phone_update_page_cache' );

add_action( 'admin_footer', 'wp_phone_add_javascript_to_admin' );

function wp_phone_add_javascript_to_admin() {
?>
<script src="<?php echo  plugins_url('js/intlTelInput.js',__FILE__);?>"></script>
<script src="<?php echo  plugins_url('js/signup.js',__FILE__);?>"></script>
    
<script type="text/javascript" >
//put all js stuff here
jQuery(document).ready(function($) {

});   
</script>
<?php
}

/** Step 1. */
function wp_phone_my_plugin_menu() {
    add_menu_page( 'WP Call Me', 'WP Call Me', 'publish_posts', 'wp-call-me', 'wp_phone_my_plugin_options' );
}

/** Step 3. */

function wp_phone_my_plugin_options() {
    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    
        }

?>

 <?php wp_enqueue_style( 'intlTelInput' );?>
 <?php wp_enqueue_style( 'twilio_find_number' );?>
<div class="wrap">

  <div id="icon-options-general" class="icon32"><br></div>
   <h2 > WP Call Me  </h2> 
    <p class="description"> Click to Call (Desktop/Browser) +  Business Phone System For Wordpress  </p>

<?php if(get_option("wp_phone_is_registered_1.7.0")){ ?>

<?php 
    $wp_phone_options=get_option("wp_phone_registration_data");
    $wp_phone_options=unserialize($wp_phone_options);
    if(!get_option("user_personal_number") && isset($wp_phone_options['user_personal_number'])){
        update_option("user_personal_number",$wp_phone_options['user_personal_number']);
    }
?>
    <?php get_first_time_notice($wp_phone_options)?>


    <div id="wp_phone_holder">
    <h3>WP Phone Account Details</h3>
    <hr/>
    
    <table class="form-table wp_phone_form_table" style="width:600px;" >
<tr>
     <th>
        <label class=""> Click to Call Button </label>
        <p  class="description">Embed this button anywhere in yourwebsite. You may use any of these three methods.</p>
            </th> </th>
            <td>
            <?php echo get_click_to_call_button() ;?> 
        <br/>

        <p  class="description">To display your click to call button in a page or post content.</p>
        <textarea class="wp_phone_default_number_shortcode">[wp_phone_clicktocall]</textarea>
<br/>

    <p  class="description">If you would like to display the click to call button in a template use this PHP code</p>
        <textarea class="wp_phone_default_number_shortcode">&lt;?php echo get_option("wp_phone_clicktocall");?&gt;</textarea>
<br/>
<p  class="description">Embed using raw html </p>

        <textarea style="font-size:10px;height:186px; "class="wp_phone_default_number_shortcode">
            <?php echo get_click_to_call_button() ;?> 
        </textarea>
<br/>
    
             </td>
        <tr>
<tr>
     <th>
        <label class=""> Click to Call Number  </label>
        <p  class="description">This is the number your click to call button will ring.</p>
            </th> </th>
            <td>
    <span style="font-size:34px;font-weight:bold;"><?php echo $wp_phone_options['user_personal_number']?> </span>
        <br/>
             </td>
        <tr>


<!--
<tr>
     <th>
        <label class="">ringroost.com Phone Number </label>
        <p  class="description">ringroost.com gives all new users a phone number that can be used to setup IVR systems. </p>
            </th> </th>
            <td>
    <span style="font-size:34px;font-weight:bold;"><?php echo $wp_phone_options['pretty_default_number']?> </span>
        <br/>
        <p  class="description">To display your WP Phone number copy and paste this shortcode in your pages and posts.</p>
        <textarea class="wp_phone_default_number_shortcode">[wp_phone_number]</textarea>
<br/>
        <p  class="description">If you would like to display the number in a template use this PHP code</p>
        <textarea class="wp_phone_default_number_shortcode">&lt;?php echo get_option("wp_phone_number");?&gt; </textarea>
    
             </td>
        <tr>

-->

        <tr>
            <th> Manage Account & Numbers
            <p class="description"> Edit click to call number, setup call flows, IVR systems, Billing and more.</p>
             </th>
             <td> <a href="https://www.ringroost.com/login.php?email=<?php echo $wp_phone_options['email']?>" target="_blank" class="button button-primary"> Login and Manage Number </a></td>
        </tr>
        <tr>
            <th> Help videos
            <p class="description">Having trouble setting up your call system check out these help videos. </p>
             </th>
             <td><a href="https://www.ringroost.com/help-videos.php" target="_blank"> https://www.ringroost.com/help-videos.php </div> </td> 
        </tr>

     <tr>
    </table>
    </div>
   <br/> 
    <div id="wp_phone_holder" class="" >
        <h3>Setttings</h3>
        <hr/>
        <form id="wp_call_me_user_settings">
    <table class="form-table wp_phone_form_table" style="width:600px;" >
        <tr> <td> FallBack Text </td>
            <td><input type="text" name="wp_click_to_call_not_supported" id="wp_click_to_call_not_supported" value="<?php echo wp_call_me_get_not_supported_text()?>" ></td> 
        </tr>
       <tr> <td> Color Theme </td>
            <td>
                <select name="wp_click_to_call_color_theme" id="wp_click_to_call_color_theme" value="<?php echo wp_call_me_get_colored_theme()?>" >
                    <option value="rr_blue"  <?php if(wp_call_me_get_colored_theme() =='rr_blue') echo ' selected="selected"';?> > Blue </a> 
                    <option value="rr_grey"  <?php if(wp_call_me_get_colored_theme() =='rr_grey') echo ' selected="selected"';?>  >Grey </a> 
                    <option value="rr_red"  <?php if(wp_call_me_get_colored_theme() =='rr_red') echo ' selected="selected"';?> >Red </a> 
                    <option value="rr_green" <?php if(wp_call_me_get_colored_theme() =='rr_green') echo ' selected="selected"';?>  >Green </a> 
                    <option value="rr_black <?php if(wp_call_me_get_colored_theme() =='rr_black') echo ' selected="selected"';?> ">Black </a> 
                    <option value="rr_yellow <?php if(wp_call_me_get_colored_theme() =='rr_yellow') echo ' selected="selected"';?> ">Yellow </a> 
                    <option value="rr_gblue <?php if(wp_call_me_get_colored_theme() =='rr_gblue') echo ' selected="selected"';?> ">Grey Blue </a> 
                    <option value="rr_button1" <?php if(wp_call_me_get_colored_theme() =='rr_button1') echo ' selected="selected"';?> >Blue Squared </a> 
                </select>
            
                
            </td> 
        </tr>

    <tr>
        <td> </td><td> <a href="#" id="wp_call_me_user_settings_submit" class="button button-primary">Save Settings</a> </td>
    </tr>
        </table>
        </form>
    </div>
   <br/> 



    <div id="wp_phone_holder" class="" >
    <h3>WP Phone User Profile</h3>
    <hr/>

    <table class="form-table wp_phone_form_table" style="width:600px;" >
        <tr>
            <th> <label for="name">Username: </label> </th>
            <td> <?php echo $wp_phone_options['name']?></td>
        </tr>
        <tr>
           <th> <label for="email">Email: </label> </th>
            <td><?php echo $wp_phone_options['email']?> </td>
        </tr>
        <tr>   
        </tr>

        <tr>
        <th>
        <label > Your Phone Number </label>
        <p  class="description">Your personal phone number.</p>
            </th> </th>
            <td><?=($wp_phone_options['default_phone']!='null') ?  $wp_phone_options['default_phone'] : '<a href="https://www.ringroost.com/numbers.php"> None. Buy a number here.</a>'?> </td>
        <tr>
        <tr>
       
        </table>

    </div>

<?php }else{ ?>

    <!-- start of form-->
    <div style="margin-top:0px;">
    <div id="wp_phone_holder" class="" >

<form  style="display:none" id="wp_phone_sync_form">
<h3> Sync IVR Designer account with Wordpresss</h3>
    <p class="description"> 
    If you already have registered with www.ringroost.com you may sync your account with wordpress so you can easily display your IVR Designer phone number.
    </p> 
<hr/>

    <div class="error_holder_sync"></div>

    <table class="form-table wp_phone_form_table" style="width:600px;" >
    <tr>
       <th> <label for="email">IVR Designer Email: </label> </th>
        <td><input class="regular-text" type="text" name="email" id="email"> </td>

    </tr>
    <tr>   
        <th><label for="password">IVR Designer Password : </label> </th>
        <td><input class="regular-text" type="password" name="password" id="password"> </td>
    </tr>
    <tr>
        <th></th>
        <td> <input class="button button-primary" style="width:100%;" type="submit" value="Sync IVR Designer Account."> </td>
    </tr>
    </table>
<hr/>
Don't have  a www.ringroost.com account? <a  style="cursor:pointer;"id="wp_phone_register">Register One Now!</a>
</form>


    <form  id="wp_register_form">

  <h3> Register WP Call Me with ringroost.com</h3>
<p class="description"> In order to activate your click to call button you will need to register a new account with www.ringroost.com. Once you have registered you will be able to add click a click to call button on your website, setup call flow systems, setup automated voice response systems, filters inbound calls , setup customized voicemails, call queues and more. Please note: "Click to call" calls are billed on a per minute bases find <a href="https://www.ringroost.com/pricing.php">pricing here </a>. 
</p>
 
<hr/>


    <div class="error_holder"></div>


    <table class="form-table wp_phone_form_table" style="width:600px;" >
    <tr>
        <th> <label for="name">Username: </label> </th>
        <td> <input class="regular-text" type="text" name="name" id="name"> </td>
    </tr>
    <tr>
       <th> <label for="email">Email: </label> </th>
        <td><input class="regular-text" type="text" name="email" id="email"> </td>

    </tr>
    <tr>   
        <th><label for="password">Select Password: </label> </th>
        <td><input class="regular-text" type="password" name="password" id="password"> </td>
    </tr>
    <input type="hidden" name="new_signup_form" value="1">
    <input type="hidden" name="wp_signup_form" value="1">
    <tr>
    <th>
        <label > Click to Call Phone Number </label>
    <p  class="description">Phone to ring from click to call button  </p>
    </th>
    
        <td class="no-pad">
            <table id="wp_phone_form_phone" style="width:316px;" class="a-top"><tr><td>
                <input type="tel" id="phone_cc" name="phone_cc" class="country_flag_dropdown">
            </td>
            <td>
                <input style="width:60px;"class="phone_part1_signup" name="area_code" id="area_code" maxlength="3" size="3" type="text">
                <input style="width:60px;"class="phone_part2_signup" name="phone1" id="phone1" maxlength="3" size="3" type="text">
                <input style="width:90px;" class="phone_part3_signup" name="phone2" id="phone2" maxlength="20" size="10" type="text">
            </td>
            </tr>
            </table>
        </td>
    </tr>

    <tr><th></th><td>
<input class="button button-primary" style="width:100%;" type="submit" value="Register WP Call Me Account">

<hr/>
 By clicking the "Submit" button, your agree to www.ringroost.com's <a target="_blank" href="https://www.ringroost.com/terms.php">Terms of Use</a>, <a target="_blank" href="https://www.ringroost.com/aup.php">Acceptable Use Policy</a> and <a target="_blank" href="https://www.ringroost.com/privacy.php">Privacy Policy</a>

 </td> </tr>
    </table>
<!--
<hr/>
Already have a www.ringroost.com account? <a style="cursor:pointer;" id="wp_phone_sync">Sync it with Wordpress.</a>
         
    </form>
    
    </div>
    </div>
<!--end the form -->
   
<?php } ?>
</div>

    <?php
}
  

/*this removes the codes form .htaccess*/
function wp_phone_remove_plugin(){
    //remove plugin her
}

/* this inits the plugin */
function my_plugin_admin_init(){

      wp_register_style( 'intlTelInput', plugins_url('css/intlTelInput.css', __FILE__) );
      wp_register_style( 'twilio_find_number', plugins_url('css/twilio_find_number.css', __FILE__) );
}
    
function  get_first_time_notice($wp_phone_options){
    if(isset($_GET['first_time'])){ ?>
        <div class="first_time_notice">
    Registration Success! See below for code to embed click to call button in your website. Your WP Phone number is <?php echo $wp_phone_options['pretty_default_number']?>
. Give it a call to test it out then <a href="https://www.ringroost.com/login.php?email=<?php echo $wp_phone_options['email']?>" target="_blank">customize your call flow system however you want here </a>.    
      </div>
                
    <?php  }
}
function get_click_to_call_button(){
    
    if(!get_option('wp_click_to_call_element')){
        return false; 
    }
    $base_js=plugins_url('js/',__FILE__);
    $base_css=plugins_url('css/',__FILE__);

 $click_to_call='<script src="'.$base_js.'SIPml-api.js"></script><script src="'.$base_js.'rr_clicktocall.js"></script> <link href="'.$base_css.'clicktocall.css" rel="stylesheet"> <div notsupported_text="'.wp_call_me_get_not_supported_text().'" text="Call Us" call="'.get_option('wp_click_to_call_element').'" id="ringroost_c2c" class="'.wp_call_me_get_colored_theme().'"></div>'; 

    return $click_to_call;
}
function wp_call_me_get_not_supported_text(){
//update_option('wp_click_to_call_not_supported','');

    if(!get_option('wp_click_to_call_not_supported') || get_option('wp_click_to_call_not_supported')=='undefined'){
        return "<a href='tel:".get_option('user_personal_number')."'>Call Us:".get_option('user_personal_number')."</a>";
    }
        return  base64_decode(get_option('wp_click_to_call_not_supported'));
}
function wp_call_me_get_colored_theme(){

    if(!get_option('wp_click_to_call_color_theme')){
        return 'rr_blue';
    }
    return  get_option('wp_click_to_call_color_theme');
}

  
###############################################################################
# AJAX REGISTERS FUNCTION FOR CRUD 
###############################################################################

  
add_action('wp_ajax_wp_phone_save_user_data', 'wp_phone_save_user_data'); 
add_action('wp_ajax_wp_phone_save_user_settings', 'wp_phone_save_user_settings'); 

function wp_phone_save_user_settings(){
    $clean= stripslashes($_POST['wp_click_to_call_not_supported']);
    $clean= str_replace("\"","'",$clean);
    update_option("wp_click_to_call_not_supported",base64_encode($clean));
    update_option("wp_click_to_call_color_theme",$_POST['wp_click_to_call_color_theme']);
}
function wp_phone_save_user_data(){
    $data=array();
    $data['name']=$_POST['name'];
    $data['email']=$_POST['email'];
    $data['user_personal_number']= $_POST['user_personal_number'];
    $data['phone_cc'] =$_POST['phone_cc'];
    $data['default_phone']=$_POST['default_phone'];
    $data['pretty_default_number']=$_POST['default_phone'];
    $data['signup_source']=$_POST['signup_source'];
    $data=serialize($data);
    update_option("wp_phone_registration_data",$data);
    update_option("user_personal_number",$_POST['user_personal_number']);
    update_option("wp_phone_number",$_POST['pretty_number']);
    update_option("wp_click_to_call_element",$_POST['click_to_call_element']);
    update_option("wp_phone_is_registered_1.7.0","1");
    update_option("wp_phone_clicktocall",get_click_to_call_button());

    //save the user data
    return true;
}

###############################################################################
#  filters
###############################################################################


function wp_phone_replace_phone_number($content){
$number=get_option("wp_phone_number");
if(!$number){  $number='';}
return str_replace("[wp_phone_number]",$number,$content);

}

function wp_phone_replace_click_to_call($content){
$button=get_click_to_call_button();
    if(!$button){ 
        return $content;
    }else{
        return str_replace("[wp_phone_clicktocall]",$button,$content);
    }

}

//add_filter( 'the_content', 'wp_phone_replace_phone_number');
add_filter( 'the_content', 'wp_phone_replace_click_to_call');


?>
