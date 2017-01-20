<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//toggle button CSS
wp_enqueue_style('awl-toogle-button-css', GG_PLUGIN_URL . 'css/toogle-button.css');
wp_enqueue_style( 'awl-bootstrap-css', GG_PLUGIN_URL .'css/bootstrap.css' );
wp_enqueue_style('awl-font-awesome-css', GG_PLUGIN_URL . 'css/font-awesome.css');
wp_enqueue_style('awl-styles-css', GG_PLUGIN_URL . 'css/styles.css');
//js
wp_enqueue_script('jquery');
wp_enqueue_script( 'awl-bootstrap-js',  GG_PLUGIN_URL .'js/bootstrap.min.js', array( 'jquery' ), '', true  );

//load settings
$gg_settings = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_gg_settings_'.$post->ID, true)));
//print_r($gg_settings);
$grid_gallery_id = $post->ID;
?>
<style>
<!--color picker setting-->
.wp-color-result::after {
    height: 21px;
}
.wp-picker-container input.wp-color-picker[type="text"] {
    width: 80px !important;
    height: 22px !important;
	float: left;
}

.gg_settings {
	padding: 8px 0px 8px 8px !important;
	margin: 10px 10px 4px 0px !important;
}
.gg_settings label {
	font-size: 16px !important;
	 font-weight: bold;
}

.gg_comment_settings {
	font-size: 15px !important;
	padding-left: 4px;
	font: initial;
	margin-top: 5px;
	
	padding-left:14px;
}
</style>

<!-- Thumbnail Size -->
<p class="gg_settings gg_border">
	<p class="bg-title"><?php _e('1. Grid Gallery Thumbnail Size', GGP_TXTDM); ?></p><br>
	<?php if(isset($gg_settings['gal_thumb_size'])) $gal_thumb_size = $gg_settings['gal_thumb_size']; else $gal_thumb_size = "medium"; ?>
	<select id="gal_thumb_size" name="gal_thumb_size" class="" style="margin-left: 10px; width: 300px;">
		<option value="thumbnail" <?php if($gal_thumb_size == "thumbnail") echo "selected=selected"; ?>><?php _e('Thumbnail – 150 × 150', GGP_TXTDM); ?></option>
		<option value="medium" <?php if($gal_thumb_size == "medium") echo "selected=selected"; ?>><?php _e('Medium – 300 × 169', GGP_TXTDM); ?></option>
		<option value="large" <?php if($gal_thumb_size == "large") echo "selected=selected"; ?>><?php _e('Large – 840 × 473', GGP_TXTDM); ?></option>
		<option value="full" <?php if($gal_thumb_size == "full") echo "selected=selected"; ?>><?php _e('Full Size – 1280 × 720', GGP_TXTDM); ?></option>
	</select><br><br>
	<p class="gg_comment_settings"><?php _e('Select gallery thumnails size to display into gallery', GGP_TXTDM); ?></p>
</p>

<!-- Columns Size 
<p class="gg_settings gg_border">
	<label><?php _e('Columns In Grid Gallery', GGP_TXTDM); ?></label><br><br>
	<?php if(isset($gg_settings['col_large_desktops'])) $col_large_desktops = $gg_settings['col_large_desktops']; else $col_large_desktops = "3_Column"; ?>
	<select id="col_large_desktops" name="col_large_desktops" class="form-control">
		<option value="1_column" <?php if($col_large_desktops == "1_column") echo "selected=selected"; ?>><?php _e('1 Column', GGP_TXTDM); ?></option>
		<option value="2_column" <?php if($col_large_desktops == "2_column") echo "selected=selected"; ?>><?php _e('2 Column', GGP_TXTDM); ?></option>
		<option value="3_column" <?php if($col_large_desktops == "3_column") echo "selected=selected"; ?>><?php _e('3 Column', GGP_TXTDM); ?></option>
		<option value="4_column" <?php if($col_large_desktops == "4_column") echo "selected=selected"; ?>><?php _e('4 Column', GGP_TXTDM); ?></option>
		<option value="5_column" <?php if($col_large_desktops == "5_column") echo "selected=selected"; ?>><?php _e('5 Column', GGP_TXTDM); ?></option>
		<option value="6_column" <?php if($col_large_desktops == "6_column") echo "selected=selected"; ?>><?php _e('6 Column', GGP_TXTDM); ?></option>
	</select><br><br>
	<?php _e('Select gallery column layout for large desktop devices', GGP_TXTDM); ?><a class="be-right" href="#"><?php _e('Go To Top', GGP_TXTDM); ?></a>
</p>-->

<!-- Animation Speed -->
<p class="gg_settings gg_border range-slider">
	<p class="bg-title"><?php _e('2. Animation Speed', GGP_TXTDM); ?></p><br>
	<?php if(isset($gg_settings['animation_speed'])) $animation_speed = $gg_settings['animation_speed']; else $animation_speed = 400; ?>
	<input id="animation_speed" name="animation_speed" class="range-slider__range" type="range" value="<?php echo $animation_speed; ?>" min="0" max="1000" step="50" style="width: 300px !important; margin-left: 10px;">
	<span class="range-slider__value">0</span>
	<p class="gg_comment_settings"><?php _e('Set animation speed', GGP_TXTDM); ?></p>
</p>

<!-- hover effects -->
<div class="gg_border">
	<p class="gg_settings">
		<p class="bg-title"><?php _e('3. Image Hover Effect Type', GGP_TXTDM); ?></p><br>
		<?php if(isset($gg_settings['image_hover_effect_type'])) $image_hover_effect_type = $gg_settings['image_hover_effect_type']; else $image_hover_effect_type = "no"; ?>
		<p class="switch-field em_size_field">
			<input type="radio" name="image_hover_effect_type" id="image_hover_effect_type1" value="no" <?php if($image_hover_effect_type == "no") echo "checked=checked"; ?>>
			<label for="image_hover_effect_type1"><?php _e('None', GGP_TXTDM); ?></label>
			<input type="radio" name="image_hover_effect_type" id="image_hover_effect_type2" value="sg" <?php if($image_hover_effect_type == "sg") echo "checked=checked"; ?>>
			<label for="image_hover_effect_type2"><?php _e('Shadow and Glow', GGP_TXTDM); ?></label>
			<p class="gg_comment_settings"><?php _e('Select a image hover effect type', GGP_TXTDM); ?></p>
		</p>
	</p>

	<!-- 2 -->
	<p class="he_two gg_settings" style="padding-left: 30px !important;">
		<label><?php _e('Image Hover Effects', GGP_TXTDM); ?></label><br><br>
		<?php if(isset($gg_settings['image_hover_effect_four'])) $image_hover_effect_four = $gg_settings['image_hover_effect_four']; else $image_hover_effect_four = "hvr-box-shadow-outset"; ?>
		<select name="image_hover_effect_four" id="image_hover_effect_four">
			<optgroup label="Shadow and Glow Transitions Effects" class="sg">
				<option value="hvr-float-shadow" <?php if($image_hover_effect_four == "hvr-float-shadow") echo "selected=selected"; ?>><?php _e('Float Shadow', GGP_TXTDM); ?></option>
				<option value="hvr-shadow-radial" <?php if($image_hover_effect_four == "hvr-shadow-radial") echo "selected=selected"; ?>><?php _e('Shadow Radial', GGP_TXTDM); ?></option>
				<option value="hvr-box-shadow-outset" <?php if($image_hover_effect_four == "hvr-box-shadow-outset") echo "selected=selected"; ?>><?php _e('Box Shadow Outset', GGP_TXTDM); ?></option>
			</optgroup>
		</select><br><br>
		<p class="he_two gg_comment_settings"><?php _e('Set an image hover effect on gallery', GGP_TXTDM); ?></p>
	</p>
</div>

<!-- Scroll Loading -->
<p class="gg_settings gg_border">
	<p class="bg-title"><?php _e('4. Auto Scroll On Image', GGP_TXTDM); ?></p><br>
	<?php if(isset($gg_settings['scroll_loading'])) $scroll_loading = $gg_settings['scroll_loading']; else $scroll_loading = "true"; ?>
	<p class="switch-field em_size_field">
		<input type="radio" name="scroll_loading" id="scroll_loading1" value="true" <?php if($scroll_loading == "true") echo "checked=checked"; ?>>
			<label for="scroll_loading1"><?php _e('Yes', GGP_TXTDM); ?></label>
		<input type="radio" name="scroll_loading" id="scroll_loading2" value="false" <?php if($scroll_loading == "false") echo "checked=checked"; ?>>
			<label for="scroll_loading2"><?php _e('No', GGP_TXTDM); ?></label>
		<p class="gg_comment_settings"><?php _e('Select images loading style', GGP_TXTDM); ?></p>
	</p>
</p>

<!-- Navigation Buttons Position -->
<p class="gg_settings gg_border">
	<p class="bg-title"><?php _e('5. Navigation Buttons Position', GGP_TXTDM); ?></p><br>
	<?php if(isset($gg_settings['nbp_setting'])) $nbp_setting = $gg_settings['nbp_setting']; else $nbp_setting = "in"; ?>
	<?php if(isset($gg_settings['nbp_setting2'])) $nbp_setting2 = $gg_settings['nbp_setting2']; else $nbp_setting2 = "left"; ?>
	<p class="switch-field em_size_field">
		<input type="radio" name="nbp_setting2" id="nbp_setting2_1" value="left" <?php if($nbp_setting2 == "left") echo "checked=checked"; ?>>
			<label for="nbp_setting2_1"><?php _e('Left', GGP_TXTDM); ?></label>
		<input type="radio" name="nbp_setting2" id="nbp_setting2_2" value="right" <?php if($nbp_setting2 == "right") echo "checked=checked"; ?>>
			<label for="nbp_setting2_2"><?php _e('Right', GGP_TXTDM); ?></label>
		<br>
		<p class="gg_comment_settings"><?php _e('Select navigation buttons position for grid gallery', GGP_TXTDM); ?></p>
	</p>
</p>

<!-- thumbnail title -->
<p class="gg_settings gg_border">
	<p class="bg-title"><?php _e('A. Title On Thumbnail', GGP_TXTDM); ?></p>
	<p class="switch-field em_size_field">
		<?php if(isset($gg_settings['thumb_title'])) $thumb_title = $gg_settings['thumb_title']; else $thumb_title = "show"; ?>
		<input type="radio" name="thumb_title" id="thumb_title1" value="hide" <?php if($thumb_title == "hide") echo "checked=checked"; ?>>
		<label for="thumb_title1"><?php _e('Hide', GGP_TXTDM); ?></label>
		<input type="radio" name="thumb_title" id="thumb_title2" value="show" <?php if($thumb_title == "show") echo "checked=checked"; ?>>
		<label for="thumb_title2"><?php _e('Show', GGP_TXTDM); ?></label>
		<br><br>
		<p class="gg_comment_settings"><?php _e('You can hide / show title on grid gallery thumbnails', GGP_TXTDM); ?></p>
	</p>	
</p>

<!-- Title On Image Preview -->
<p class="gg_settings gg_border switch-field em_size_field">
	<p class="bg-title"><?php _e('6. Title On Image Preview', GGP_TXTDM); ?></p><br>
	<?php if(isset($gg_settings['title_setting'])) $title_setting = $gg_settings['title_setting']; else $title_setting = "show"; ?>
	<p class="switch-field em_size_field">	
		<input type="radio" name="title_setting" id="title_setting1" value="hide" <?php if($title_setting == "hide") echo "checked=checked"; ?>>
		<label for="title_setting1"><?php _e('Hide', GGP_TXTDM); ?></label>
		<input type="radio" name="title_setting" id="title_setting2" value="show" <?php if($title_setting == "show") echo "checked=checked"; ?>>
		<label for="title_setting2"><?php _e('Show', GGP_TXTDM); ?></label>
		<p class="gg_comment_settings"><?php _e('You can hide / show title for grid gallery', GGP_TXTDM); ?></p>
	</p>
	
	<p class="tfs gg_settings">
		<label><?php _e(' Title Font Color', GGP_TXTDM); ?></label><br><br>
		<?php if(isset($gg_settings['title_color'])) $title_color = $gg_settings['title_color']; else $title_color = "white"; ?>
		<p class="switch-field em_size_field tfs">
			<input type="radio" name="title_color" id="title_color1" value="white" <?php if($title_color == "white") echo "checked=checked"; ?>>
			<label for="title_color1"><?php _e('White', GGP_TXTDM); ?></label>
			<input type="radio" name="title_color" id="title_color2" value="black" <?php if($title_color == "black") echo "checked=checked"; ?>>
			<label for="title_color2"><?php _e('Black', GGP_TXTDM); ?></label>
			<input type="radio" name="title_color" id="title_color3" value="red" <?php if($title_color == "red") echo "checked=checked"; ?>>
			<label for="title_color3"><?php _e('Red', GGP_TXTDM); ?></label>
			<input type="radio" name="title_color" id="title_color4" value="blue" <?php if($title_color == "blue") echo "checked=checked"; ?>>
			<label for="title_color4"><?php _e('Blue', GGP_TXTDM); ?></label>
		</p>
		<p class="tfs gg_comment_settings"><?php _e('You can change color of title on full size of image for grid gallery', GGP_TXTDM); ?></p>
	</p>
	
</p>
<!-- thumbnail border on image -->
<p class="gg_settings gg_border">
	<p class="bg-title"><?php _e('7. Thumbnail Border On Image', GGP_TXTDM); ?></p><br>
	<?php if(isset($gg_settings['thumbnail_border'])) $thumbnail_border = $gg_settings['thumbnail_border']; else $thumbnail_border = "show"; ?>
	<p class="switch-field em_size_field">
		<input type="radio" name="thumbnail_border" id="thumbnail_border1" value="hide" <?php if($thumbnail_border == "hide") echo "checked=checked"; ?>>
		<label for="thumbnail_border1"><?php _e('Hide', GGP_TXTDM); ?></label>
		<input type="radio" name="thumbnail_border" id="thumbnail_border2" value="show" <?php if($thumbnail_border == "show") echo "checked=checked"; ?>>
		<label for="thumbnail_border2"><?php _e('Show', GGP_TXTDM); ?></label>
		<p class="gg_comment_settings"><?php _e('You can hide / show thumbnail border on image for grid gallery', GGP_TXTDM); ?></p>
	</p>
</p>

<!-- thumbnail spacing -->
<p class="gg_settings gg_border">
	<p class="bg-title"><?php _e('8. Hide Image Spacing', GGP_TXTDM); ?></p><br>
	<?php if(isset($gg_settings['no_spacing'])) $no_spacing = $gg_settings['no_spacing']; else $no_spacing = "no"; ?>
	<p class="switch-field em_size_field">
		<input type="radio" name="no_spacing" id="no_spacing1" value="yes" <?php if($no_spacing == "yes") echo "checked=checked"; ?>>
		<label for="no_spacing1"><?php _e('Yes', GGP_TXTDM); ?></label>
		<input type="radio" name="no_spacing" id="no_spacing2" value="no" <?php if($no_spacing == "no") echo "checked=checked"; ?>>
		<label for="no_spacing2"><?php _e('No', GGP_TXTDM); ?></label>
		<p class="gg_comment_settings"><?php _e('Hide gap / spacing between gallery images', GGP_TXTDM); ?></p>
	</p>
</p>

<!-- custom css -->
<p class="gg_settings gg_border">
	<p class="bg-title"><?php _e('9. Custom CSS', GGP_TXTDM); ?></p><br>
	<?php if(isset($gg_settings['custom-css'])) $custom_css = $gg_settings['custom-css']; else $custom_css = ""; ?>
	<textarea name="custom-css" id="custom-css" style="width: 100%; height: 120px;" placeholder="Type direct CSS code here. Don't use <style>...</style> tag."><?php echo $custom_css; ?></textarea><br>
	<br>
	<p class="gg_comment_settings"><?php _e('Apply own css on image gallery and dont use style tag', GGP_TXTDM); ?></p>
</p>
<hr>

<?php 
	// syntax: wp_nonce_field( 'name_of_my_action', 'name_of_nonce_field' );
	wp_nonce_field( 'gg_save_settings', 'gg_save_nonce' );
?>
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<hr>
<script>
// ===== Scroll to Top ==== 
jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
        jQuery('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        jQuery('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
jQuery('#return-to-top').click(function() {      // When arrow is clicked
    jQuery('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});
	// title size range settings.  on change range value
	function updateRange(val, id) {
		jQuery("#" + id).val(val);
		jQuery("#" + id + "_text").val(val);	  
	}
	
	//color-picker
	(function( jQuery ) {
		jQuery(function() {
			// Add Color Picker to all inputs that have 'color-field' class
			jQuery('#title_color').wpColorPicker();
			jQuery('#desc_color').wpColorPicker();	
			jQuery('#border_color').wpColorPicker();	
		});
	})( jQuery );
	jQuery(document).ajaxComplete(function() {
		jQuery('#title_color,#decs_color,#border_color').wpColorPicker();
	});	

	// start pulse on page load
	function pulseEff() {
	   jQuery('#shortcode').fadeOut(600).fadeIn(600);
	};
	var Interval;
	Interval = setInterval(pulseEff,1500);

	// stop pulse
	function pulseOff() {
		clearInterval(Interval);
	}
	// start pulse
	function pulseStart() {
		Interval = setInterval(pulseEff,2000);
	}
	
	//hover effect hide and show 
	var effect_type = jQuery('input[name="image_hover_effect_type"]:checked').val();
	if(effect_type == "no") {
		jQuery('.he_one').hide();
		jQuery('.he_two').hide();
		jQuery('.he_ancer').show();
	}
	
	if(effect_type == "2d") {
		jQuery('.he_one').show();
		jQuery('.he_two').hide();
		jQuery('.he_ancer').hide();
	}
	
	if(effect_type == "sg") {
		jQuery('.he_one').hide();
		jQuery('.he_two').show();
		jQuery('.he_ancer').hide();
	}
	
	// on load title font hide show
	var title = jQuery('input[name="title_setting"]:checked').val();
	if(title == "hide"){
		jQuery('.tfs').hide();	
		jQuery('.tfs_ancer').show();	
	}
	if(title == "show"){
		jQuery('.tfs').show();	
		jQuery('.tfs_ancer').hide();	
	}
	
	// on load description font hide show
	var desc = jQuery('input[name="desc_setting"]:checked').val();
	if(desc == "hide"){
		jQuery('.dfs').hide();	
		jQuery('.dfs_ancer').show();	
	}
	if(desc == "show"){
		jQuery('.dfs').show();	
		jQuery('.dfs_ancer').hide();	
	}
	
	// on load image border hide show
	var border = jQuery('input[name="image_border"]:checked').val();
	if(border == "hide"){
		jQuery('.btc').hide();	
		jQuery('.btc_ancer').show();	
	}
	if(border == "show"){
		jQuery('.btc').show();	
		jQuery('.btc_ancer').hide();	
	}
	
	// on load link hide show
	var link = jQuery('input[name="image_link"]:checked').val();
	if(link == "none"){
		jQuery('.ilu').hide();	
		jQuery('.ilu_ancer').show();	
	}
	if(link == "image"){
		jQuery('.ilu').show();
		jQuery('.ilu_ancer').hide();		
	}
	if(link == "title"){
		jQuery('.ilu').show();
		jQuery('.ilu_ancer').hide();
	}
	if(link == "desc"){
		jQuery('.ilu').show();
		jQuery('.ilu_ancer').hide();
	}
	
	// on load navigation button center hide show
	var button = jQuery('input[name="nbp_setting"]:checked').val();
	if(button == "in"){
		jQuery('.nbc').hide();		
	}
	if(button == "out"){
		jQuery('.nbc').show();		
	}
	
	//on change effect
	jQuery(document).ready(function() {
		// image hover effect hide show live
		jQuery('input[name="image_hover_effect_type"]').change(function(){
			var effect_type = jQuery('input[name="image_hover_effect_type"]:checked').val();
			if(effect_type == "no") {
				jQuery('.he_one').hide();
				jQuery('.he_two').hide();
				jQuery('.he_ancer').show();
			}
			
			if(effect_type == "2d") {
				jQuery('.he_one').show();
				jQuery('.he_two').hide();
				jQuery('.he_ancer').hide();
			}
			
			if(effect_type == "sg") {
				jQuery('.he_one').hide();
				jQuery('.he_two').show();
				jQuery('.he_ancer').hide();
			}
		});
		
		// title font size hide show live
		jQuery('input[name="title_setting"]').change(function(){
			var title = jQuery('input[name="title_setting"]:checked').val();
			if(title == "hide"){
					jQuery('.tfs').hide();	
					jQuery('.tfs_ancer').show();	
				}
				if(title == "show"){
					jQuery('.tfs').show();	
					jQuery('.tfs_ancer').hide();	
				}
		});
		
		// description font size hide show live
		jQuery('input[name="desc_setting"]').change(function(){
			var desc = jQuery('input[name="desc_setting"]:checked').val();
			if(desc == "hide"){
					jQuery('.dfs').hide();	
					jQuery('.dfs_ancer').show();	
				}
				if(desc == "show"){
					jQuery('.dfs').show();	
					jQuery('.dfs_ancer').hide();	
				}
		});
		
		// border settings hide show live
		jQuery('input[name="image_border"]').change(function(){
			var border = jQuery('input[name="image_border"]:checked').val();
			if(border == "hide"){
				jQuery('.btc').hide();	
				jQuery('.btc_ancer').show();	
			}
			if(border == "show"){
				jQuery('.btc').show();	
				jQuery('.btc_ancer').hide();	
			}
		});
		
		// border settings hide show live
		jQuery('input[name="image_link"]').change(function(){
			var link = jQuery('input[name="image_link"]:checked').val();
			if(link == "none"){
				jQuery('.ilu').hide();	
				jQuery('.ilu_ancer').show();	
			}
			if(link == "image"){
				jQuery('.ilu').show();
				jQuery('.ilu_ancer').hide();		
			}
			if(link == "title"){
				jQuery('.ilu').show();
				jQuery('.ilu_ancer').hide();
			}
			if(link == "desc"){
				jQuery('.ilu').show();
				jQuery('.ilu_ancer').hide();
			}
		});
		
		// navigation button center hide show live
		jQuery('input[name="nbp_setting"]').change(function(){
			var button = jQuery('input[name="nbp_setting"]:checked').val();
			if(button == "in"){
				jQuery('.nbc').hide();		
			}
			if(button == "out"){
				jQuery('.nbc').show();		
			}
		});
	});
	
	
	//range slider
	var rangeSlider = function(){
	  var slider = jQuery('.range-slider'),
		  range = jQuery('.range-slider__range'),
		  value = jQuery('.range-slider__value');
		
	  slider.each(function(){

		value.each(function(){
		  var value = jQuery(this).prev().attr('value');
		  jQuery(this).html(value);
		});

		range.on('input', function(){
		  jQuery(this).next(value).html(this.value);
		});
	  });
	};
	rangeSlider();	
</script>
<br>
<style>
	.awp_bale_offer {
		background-image: url("<?php echo GG_PLUGIN_URL ?>/img/awp-bale.jpg");
		background-repeat:no-repeat;
		padding:30px;
	}
	.awp_bale_offer h1 {
		font-size:35px;
		color:#FFFFFF;
	}
	.awp_bale_offer h3 {
		font-size:25px;
		color:#FFFFFF;
	}
</style>
<div class="row awp_bale_offer">
	<div class="">
		<h1>Plugin's Bale Offer</h1>
		<h3>Get All Premium Plugin ( Personal Licence) in just $99 </h3>
		<h3><strike>$149</strike> For $99 Only</h3>
	</div>
	<div class="">
		<a href="http://awplife.com/account/signup/all-premium-plugins" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">BUY NOW</a>
	</div>
</div>
<p class="">
	<br>
	<a href="http://awplife.com/account/signup/grid-gallery-premium" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Buy Premium Version</a>
	<a href="http://demo.awplife.com/grid-gallery-premium/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Check Live Demo</a>
	<a href="http://demo.awplife.com/grid-gallery-premium-admin-demo/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Try Admin Demo</a>
</p>
<p class="gg_settings"><label>If you have any problem with this plugin, please share with us</label></p>
<hr>
<p>
	<a href="https://wordpress.org/support/plugin/new-grid-gallery" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Support Forum</a>
	<a href="http://awplife.com/contact/" target="_blank" class="button button-primary button-hero load-customize hide-if-no-customize">Contact Us</a>
</p>
<hr>
<p class="">
	<h1><strong>Try Our Other Free Plugins:</strong></h1>
	<br>
	<a href="https://wordpress.org/plugins/portfolio-filter-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Portfolio Filter Gallery</a>
	<a href="https://wordpress.org/plugins/new-grid-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Grid Gallery</a>
	<a href="https://wordpress.org/plugins/new-social-media-widget/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Social Media</a>
	<a href="https://wordpress.org/plugins/new-image-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Image Gallery</a>
	<a href="https://wordpress.org/plugins/new-photo-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Photo Gallery</a>
	<a href="https://wordpress.org/plugins/responsive-slider-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Responsive Slider Gallery</a>
	<a href="https://wordpress.org/plugins/new-contact-form-widget/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Contact Form Widget</a><br><br>
	<a href="https://wordpress.org/plugins/facebook-likebox-widget-and-shortcode/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Facebook Likebox Plugin</a>
	<a href="https://wordpress.org/plugins/slider-responsive-slideshow/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Slider Responsive Slideshow</a>
	<a href="https://wordpress.org/plugins/new-video-gallery/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Video Gallery</a><br><br>
	<a href="https://wordpress.org/plugins/new-facebook-like-share-follow-button/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Facebook Like Share Follow Button</a>
	<a href="https://wordpress.org/plugins/new-google-plus-badge/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Google Plus Badge</a>
	<a href="https://wordpress.org/plugins/media-slider/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Media Slider</a>
	<a href="https://wordpress.org/plugins/weather-effect/" target="_blank" class="button button-primary load-customize hide-if-no-customize">Weather Effect</a>
</p>