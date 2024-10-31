<?php
/**
 * @package plus-fb-slider
*/
/*
Plugin Name: Plus FB Slider
Plugin URI: https://wordpress.org/plugins/plus-fb-slider/
Description: Thanks for installing Plus FB Slider
Version: 1.0
Author: Jose Porit
Author URI: https://wordpress.org/support/profile/twitterslider
*/
class PlusFacebook{
    
    public $options;
    
    public function __construct() {
        //you can run delete_option method to reset all data
        //delete_option('sw_twitter_plugin_options');
        $this->options = get_option('plus_fb_plugin_options');
        $this->plus_fb_slider_register_settings_and_fields();
    }
    
    public static function add_fb_slider_tools_options_page(){
        add_options_page('Plus Facebook Slider ', 'Plus Facebook Slider  ', 'administrator', __FILE__, array('PlusFacebook','plus_fb_slider_tools_options'));
    }
    
    public static function plus_fb_slider_tools_options(){
?>
<div class="wrap">
    <?php screen_icon(); ?>
    <h2>Plus Facebook Slider Configuration</h2>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('plus_fb_plugin_options'); ?>
        <?php do_settings_sections(__FILE__); ?>
        <p class="submit">
            <input name="submit" type="submit" class="button-primary" value="Save Changes"/>
        </p>
    </form>
</div>
<?php
    }
    public function plus_fb_slider_register_settings_and_fields(){
        register_setting('plus_fb_plugin_options', 'plus_fb_plugin_options',array($this,'responsive_fb_validate_settings'));
        add_settings_section('plus_fb_main_section', 'Settings', array($this,'plus_fb_main_section_cb'), __FILE__);
        //Start Creating Fields and Options
        //name options
        add_settings_field('name', 'Name', array($this,'name_settings'),__FILE__,'plus_fb_main_section');
         //pageURL
        add_settings_field('fb_username', 'Facebook Page URL ', array($this,'pageURL_settings'), __FILE__,'plus_fb_main_section');
         //marginTop
        add_settings_field('icon', 'Margin Top', array($this,'marginTop_settings'), __FILE__,'plus_fb_main_section');
        //alignment option
         add_settings_field('position', 'Alignment Position', array($this,'position_settings'),__FILE__,'plus_fb_main_section');
    //face options
        add_settings_field('face', 'Display Face', array($this,'face_settings'),__FILE__,'plus_fb_main_section');
     //post options
        add_settings_field('post', 'Display Post', array($this,'post_settings'),__FILE__,'plus_fb_main_section');
        //cover options
        add_settings_field('cover', 'Hide Cover Photo', array($this,'cover_settings'),__FILE__,'plus_fb_main_section');
    //language options
        add_settings_field('language', 'Language', array($this,'language_settings'),__FILE__,'plus_fb_main_section');
         
        
    }
    public function responsive_fb_validate_settings($plugin_options){
        return($plugin_options);
    }
    public function plus_fb_main_section_cb(){
        //optional
    }
     //pageURL_settings
    public function pageURL_settings() {
        if(empty($this->options['fb_username'])) $this->options['fb_username'] = "https://www.facebook.com/Facebook";
        echo "<input name='plus_fb_plugin_options[fb_username]' type='text' value='{$this->options['fb_username']}' />";
    }
    

    //marginTop_settings
    public function marginTop_settings() {
        if(empty($this->options['icon'])) $this->options['icon'] = "150";
        echo "<input name='plus_fb_plugin_options[icon]' type='text' value='{$this->options['icon']}' />";
    }
    
    //alignment_settings
    public function position_settings(){
        if(empty($this->options['position'])) $this->options['position'] = "right";
        $items = array('right','left');
        echo "<select name='plus_fb_plugin_options[position]'>";
        foreach($items as $item){
            $selected = ($this->options['position'] === $item) ? 'selected = "selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }
        echo "</select>";
    }

       //name_settings
    public function name_settings(){
      if(empty($this->options['name'])) $this->options['name'] = "Facebook";
        echo "<input name='plus_fb_plugin_options[name]' type='text' value='{$this->options['name']}' />";
    }

 
      //face_settings
    public function face_settings(){
        if(empty($this->options['face'])) $this->options['face'] = "true";
        $items = array('true','false');
        echo "<select name='plus_fb_plugin_options[face]'>";
        foreach($items as $face){
            $selected = ($this->options['face'] === $face) ? 'selected = "selected"' : '';
            echo "<option value='$face' $selected>$face</option>";
        }
        echo "</select>";
    }
  

          //cover_settings
    public function cover_settings(){
        if(empty($this->options['cover'])) $this->options['cover'] = "true";
        $items = array('true','false');
        echo "<select name='plus_fb_plugin_options[cover]'>";
        foreach($items as $cover){
            $selected = ($this->options['cover'] === $cover) ? 'selected = "selected"' : '';
            echo "<option value='$cover' $selected>$cover</option>";
        }
        echo "</select>";
    }

        //post_settings
    public function post_settings(){
        if(empty($this->options['post'])) $this->options['post'] = "false";
        $items = array('false','true');
        echo "<select name='plus_fb_plugin_options[post]'>";
        foreach($items as $post){
            $selected = ($this->options['post'] === $post) ? 'selected = "selected"' : '';
            echo "<option value='$post' $selected>$post</option>";
        }
        echo "</select>";
    }
       //language_settings
    public function language_settings(){
        if(empty($this->options['language'])) $this->options['language'] = "en_US";
        $items = array('en_US','en_GB','af_ZA','bn_IN','es_ES','it_IT','ar_AR','tt_RU');
        echo "<select name='plus_fb_plugin_options[language]'>";
        foreach($items as $language){
            $selected = ($this->options['language'] === $language) ? 'selected = "selected"' : '';
            echo "<option value='$language' $selected>$language</option>";
        }
        echo "</select>";
    }

   
   



     
}
add_action('admin_menu', 'plus_fb_slider_trigger_options_function');

function plus_fb_slider_trigger_options_function(){
    PlusFacebook::add_fb_slider_tools_options_page();
}

add_action('admin_init','plus_fb_slider_trigger_create_object');
function plus_fb_slider_trigger_create_object(){
    new PlusFacebook();
}
add_action('wp_footer','plus_fb_slider_add_content_in_footer');
function plus_fb_slider_add_content_in_footer(){
    
 $o = get_option('plus_fb_plugin_options');
extract($o);
$responsive_fb = '';
$responsive_fb .= ' <div class="fb-page" data-href="'.$fb_username.'"

                        data-show-facepile="'.$face.'"  

                        data-small-header="true" 

                        data-width="350"  data-height="585"

                        data-show-posts="'.$post.'" 
                         
                        data-hide-cover="'.$cover.'" 
            
              
            
      
          </div>

            </div>
			
			<div style="font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: '.$position.'; direction: ltr;"><a href="https://www.nationalcprassociation.com/" target="_blank" style="color: #808080;">National CPR association</a></div>' ;
			
$imgURL = plugins_url('plus-fb-slider/assets/css/fb-left.png');
$imgURLR = plugins_url('plus-fb-slider/assets/css/fb-right.png');
?>
<style type="text/css">



    .cd-main-content-fb .cd-btn-fb {

   height: 150px;
width: 47px;
   position:fixed;

   top:<?php echo $icon;?>px;
   <?php if($position=='right'){ ?>

   background:url(<?php echo $imgURLR;?>);

   background-repeat: no-repeat;

   right: 0px;
   <?php } else { ?>

   background:url(<?php echo $imgURL;?>);
   background-repeat: no-repeat;
   left: 0px;
   <?php } ?> 

}

.cd-panel-content-fb {
min-width: 195px !important;
background: #fff;

}




</style>


</style>





  <main class="cd-main-content-fb">

        <a href="#0" class="cd-btn-fb"></a>

        <!-- your content here -->

    </main>


<?php if($position=='right'){ ?>
      <div class="cd-panel-fb from-right-fb ">
<?php } else { ?>
      <div class="cd-panel-fb from-left-fb ">
<?php } ?>    
    
        <header class="cd-panel-header-fb">
        
            <h3 style="text-align:center">Facebook User Timeline</h3>
            <a href="#0" class="cd-panel-close-fb">Close</a>

        </header>
    


        <div class="cd-panel-container-fb" style="width:25%">

            <div class="cd-panel-content-fb">
             <script>

        (function(d, s, id) {

          var js, fjs = d.getElementsByTagName(s)[0];

          if (d.getElementById(id)) return;

          js = d.createElement(s); js.id = id;

          js.src = "//connect.facebook.net/<?php echo $language; ?>/sdk.js#xfbml=1&version=v2.0";

          fjs.parentNode.insertBefore(js, fjs);

        }(document, 'script', 'facebook-jssdk'));

            </script>  

               <?php echo $responsive_fb;?>

                



            </div> <!-- cd-panel-content -->

        </div> <!-- cd-panel-container -->

    </div> <!-- cd-panel -->



<?php
}
add_action( 'wp_enqueue_scripts', 'register_plus_fb_slider_likebox_sidebar_styles' );
 function register_plus_fb_slider_likebox_sidebar_styles() {
    wp_register_style( 'register_plus_fb_slider_likebox_sidebar_styles', plugins_url( 'assets/css/style.css' , __FILE__ ) );
    wp_enqueue_style( 'register_plus_fb_slider_likebox_sidebar_styles' );
    wp_enqueue_script('jquery');
 }
add_action( 'wp_enqueue_scripts', 'wp_fb_scripts_with_jquery' );
function wp_fb_scripts_with_jquery()
{
    
    wp_register_script( 'custom-script', plugins_url( 'assets/js/main.js', __FILE__ ), array( 'jquery' ) );
    wp_enqueue_script( 'custom-script' );
}