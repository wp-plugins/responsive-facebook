<?php
/**
 * @package WP_DEVELOPMENT/responsive-facebook
*/
/*
Plugin Name: Responsive Facebook
Plugin URI: http://www.connexdallas.com/
Description: Responsive Facebook Widget & Shortcode
Version: 1.2
Author: Visual Scope Studios
Author URI: http://www.connexdallas.com/
*/
class ResponsiveFacebook extends WP_Widget{
    
    public function __construct() {
        $params = array(
			'description' => 'Responsive Facebook Widget & Shortcode',
            'name' => 'Responsive Facebook'
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
    <label for="<?php echo $this->get_field_id( 'header' ); ?>">Hide Cover:</label> 
    <select id="<?php echo $this->get_field_id( 'header' ); ?>"
    name="<?php echo $this->get_field_name( 'header' ); ?>"
    class="widefat" style="width:100%;">
            <option value="false" <?php if ($header == 'false') echo 'selected="false"'; ?> >False</option>
            <option value="true" <?php if ($header == 'true') echo 'selected="true"'; ?> >True</option>	
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
<?php
    }
    
    public function widget($args, $instance) {
        extract($args);
        extract($instance);
        $title = apply_filters('widget_title', $title);
        $description = apply_filters('widget_description', $description);
	if(empty($title)) $title = "Responsive Facebook";
        if(empty($fb_url)) $fb_url = "http://www.facebook.com/FacebookDevelopers";
        if(empty($header)) $header = "false";
        if(empty($show_faces)) $show_faces = "true";
        if(empty($show_streams)) $show_streams = "true";
        
        echo $before_widget;
            echo $before_title . $title . $after_title;
            
?>
<div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
<div class="responsive-facebook">
	<div class="fb-page" data-href="<?php echo $fb_url;?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="<?php echo $header; ?>" 
	data-show-facepile="<?php echo $show_faces; ?>" data-show-posts="<?php echo $show_streams; ?>"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $fb_url;?>"><a href="<?php echo $fb_url;?>">Facebook</a></blockquote></div></div>
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
                'hide_cover' => 'false',
                'show_faces' => 'true',
                'show_streams' => 'true',
 	), $atts);
 	extract($atts);
        if(!empty($fb_url)):
?>

<div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
<div class="responsive-facebook">
	<div class="fb-page" data-href="<?php echo $fb_url;?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="<?php echo $hide_cover; ?>" 
	data-show-facepile="<?php echo $show_faces; ?>" data-show-posts="<?php echo $show_streams; ?>"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo $fb_url;?>"><a href="<?php echo $fb_url;?>">Facebook</a></blockquote></div></div>
</div>
<?php
        endif;
        return false;
 }