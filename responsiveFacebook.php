<?php
/**
 * @package WP_DEVELOPMENT/responsive-facebook
*/
/*
Plugin Name: Responsive Facebook
Plugin URI: http://www.connexdallas.com/
Description: Responsive Facebook Widget & Shortcode
Version: 1.0
Author: Visual Scope Studios
Author URI: http://www.connexdallas.com/
*/
class ResponsiveFacebook extends WP_Widget{
    
    public function __construct() {
        $params = array(
            'name' => 'Responsive Facebook',
            'description' => 'Responsive Facebook Widget & Shortcode'
        );
        parent::__construct('ResponsiveFacebook','',$params);
    }
    
    public function form($instance) {
        extract($instance);
        ?>
<p>
    <label for="<?php echo $this->get_field_id('title');?>">Title: </label>
    <input
	class="widefat"
	id="<?php echo $this->get_field_id('title');?>"
	name="<?php echo $this->get_field_name('title');?>"
    value="<?php echo !empty($title) ? $title : "Responsive Facebook"; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('fb_url');?>">Facebook Page URL: </label>
    <input
	class="widefat"
	id="<?php echo $this->get_field_id('fb_url');?>"
	name="<?php echo $this->get_field_name('fb_url');?>"
    value="<?php echo !empty($fb_url) ? $fb_url : "http://www.facebook.com/FacebookDevelopers"; ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'header' ); ?>">Show Header:</label> 
    <select id="<?php echo $this->get_field_id( 'header' ); ?>"
    name="<?php echo $this->get_field_name( 'header' ); ?>"
    class="widefat" style="width:100%;">
            <option value="true" <?php if ($header == 'true') echo 'selected="true"'; ?> >Yes</option>
            <option value="false" <?php if ($header == 'false') echo 'selected="false"'; ?> >No</option>	
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'border' ); ?>">Show Border:</label> 
    <select id="<?php echo $this->get_field_id( 'border' ); ?>"
        name="<?php echo $this->get_field_name( 'border' ); ?>"
        class="widefat" style="width:100%;">
            <option value="true" <?php if ($border == 'true') echo 'selected="true"'; ?> >Yes</option>
            <option value="false" <?php if ($border == 'false') echo 'selected="false"'; ?> >No</option>	
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'show_faces' ); ?>">Show Faces:</label> 
    <select id="<?php echo $this->get_field_id( 'show_faces' ); ?>"
        name="<?php echo $this->get_field_name( 'show_faces' ); ?>"
        class="widefat" style="width:100%;">
            <option value="true" <?php if ($show_faces == 'true') echo 'selected="true"'; ?> >Yes</option>
            <option value="false" <?php if ($show_faces == 'false') echo 'selected="false"'; ?> >No</option>	
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'show_streams' ); ?>">Show Post:</label> 
    <select id="<?php echo $this->get_field_id( 'show_streams' ); ?>"
        name="<?php echo $this->get_field_name( 'show_streams' ); ?>"
        class="widefat" style="width:100%;">
            <option value="true" <?php if ($show_streams == 'true') echo 'selected="true"'; ?> >Yes</option>
            <option value="false" <?php if ($show_streams == 'false') echo 'selected="false"'; ?> >No</option>	
    </select>
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'color_scheme' ); ?>">Color Scheme:</label> 
    <select id="<?php echo $this->get_field_id( 'color_scheme' ); ?>"
        name="<?php echo $this->get_field_name( 'color_scheme' ); ?>"
        class="widefat" style="width:100%;">
            <option value="light" <?php if ($color_scheme == 'light') echo 'selected="light"'; ?> >Light</option>
            <option value="dark" <?php if ($color_scheme == 'dark') echo 'selected="dark"'; ?> >Dark</option>	
    </select>
</p>
<?php
    }
    
    public function widget($args, $instance) {
        extract($args);
        extract($instance);
        $title = apply_filters('widget_title', $title);
        $description = apply_filters('widget_description', $description);
	if(empty($title)) $title = "Responsive Facebook";
        if(empty($fb_url)) $fb_url = "http://www.facebook.com/FacebookDevelopers";
        if(empty($header)) $header = "true";
        if(empty($border)) $border = "true";
        if(empty($show_faces)) $show_faces = "true";
        if(empty($show_streams)) $show_streams = "true";
        if(empty($color_scheme)) $color_scheme = "light";
        
        echo $before_widget;
            echo $before_title . $title . $after_title;
            
?>
<style>
    .responsive-facebook .fb-like-box { width:100% !important;}
    .responsive-facebook .fb-like-box iframe[style]{width: 100% !important; }
	.responsive-facebook .fb_iframe_widget span {
		width:100%!important; 
	}
 </style>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="responsive-facebook">
    <div class="fb-like-box fb_iframe_widget" data-href="<?php echo $fb_url;?>" data-colorscheme="<?php echo $color_scheme; ?>"
    data-show-faces="<?php echo $show_faces; ?>" data-header="<?php echo $header; ?>" data-show-border="<?php echo $border; ?>" data-stream="<?php echo $show_streams; ?>">
    </div>
</div>
<?php
        echo $after_widget;
    }
    
}
//register the widget
add_action('widgets_init','register_responsive_facebook');
function register_responsive_facebook(){
    register_widget('ResponsiveFacebook');
}

//shortcode
add_shortcode('responsivefb', 'responsiveFacebookShortcode');
function responsiveFacebookShortcode($atts){
 	$atts = shortcode_atts(array(
 		'fb_url' => 'http://www.facebook.com/FacebookDevelopers',
                'header' => 'true',
                'border' => 'true',
                'show_faces' => 'true',
                'show_streams' => 'true',
                'color_scheme' => 'light'
 	), $atts);
 	extract($atts);
        if(!empty($fb_url)):
            ?>
<style>
    .responsive-facebook .fb-like-box { width:100% !important;}
    .responsive-facebook .fb-like-box iframe[style]{width: 100% !important; }
	.responsive-facebook .fb_iframe_widget span {
		width:100%!important; 
	}
 </style>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="responsive-facebook">
    <div class="fb-like-box fb_iframe_widget" data-href="<?php echo $fb_url;?>" data-colorscheme="<?php echo $color_scheme; ?>"
    data-show-faces="<?php echo $show_faces; ?>" data-header="<?php echo $header; ?>" data-show-border="<?php echo $border; ?>" data-stream="<?php echo $show_streams; ?>">
    </div>
	<div id="support" style="font-size: 9px; color: #ccc; text-align: right;"><a href="http://www.liveherechicago.com/search-listing-lincoln-park.php" title="Click here" target="_blank">Lincoln Park Apartments Chicago</a></div>
</div>
<?php
        endif;
        return false;
 }
        