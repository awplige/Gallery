<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Grid Gallery Output
 */
$all_grid_images = array(  'p' => $grid_gallery_id, 'post_type' => 'grid_gallery', 'orderby' => 'ASC');
$loop = new WP_Query( $all_grid_images );
while ( $loop->have_posts() ) : $loop->the_post();

	$post_id = get_the_ID();
	$gg_settings = unserialize(base64_decode(get_post_meta( $post_id, 'awl_gg_settings_'.$post_id, true)));
	count($gg_settings['slide-ids']);
	// start the grid gallery contents
	?>
	<div class="container">
		<ul class="gridder gg-<?php echo $grid_gallery_id; ?>">
			<?php
			if(isset($gg_settings['slide-ids']) && count($gg_settings['slide-ids']) > 0) {
				$count = 0;
				foreach($gg_settings['slide-ids'] as $attachment_id) {
					$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
					$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
					$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
					$large = wp_get_attachment_image_src($attachment_id, 'large', true);
					$full = wp_get_attachment_image_src($attachment_id, 'full', true);
					$postthumbnail = wp_get_attachment_image_src($attachment_id, 'post-thumbnail', true);
					$attachment_details = get_post( $attachment_id );
					$href = get_permalink( $attachment_details->ID );
					$src = $attachment_details->guid;
					$title = $attachment_details->post_title;
					$description = $attachment_details->post_content;
					//$image_link_url =  $gg_settings['slide-link'][$count];
					
					//set thumbnail size
					if($gal_thumb_size == "thumbnail") { $thumbnail_url = $thumbnail[0]; }
					if($gal_thumb_size == "medium") { $thumbnail_url = $medium[0]; }
					if($gal_thumb_size == "large") { $thumbnail_url = $large[0]; }
					if($gal_thumb_size == "full") { $thumbnail_url = $full[0]; }
?><li data-griddercontent="#gridder-content-<?php echo $grid_gallery_id; ?>-<?php echo $count; ?>" class="gridder-list gg-gridder-list-<?php echo $grid_gallery_id; ?> <?php echo $thumb_bor." ".$image_hover_effect; ?>" >
<div style="background-image: url('<?php echo $thumbnail_url; ?>')" class="image">
	<div class="overlay">
		<?php if($thumb_title == "show") { ?>
		<p class="title"><?php echo ucwords($title); ?></p>
		<?php } ?>
	</div>
</div>
</li><?php
					$count++;
				}// end of attachment foreach
			} else {
				_e('Sorry! No grid gallery found ', GGP_TXTDM);
				echo ": [GGAL id=$post_id]";
			} // end of if esle of slides avaialble check into slider
			?>
		</ul>
		
			<?php
			if(isset($gg_settings['slide-ids']) && count($gg_settings['slide-ids']) > 0) {
				$count = 0;
				foreach($gg_settings['slide-ids'] as $attachment_id) {					
					$thumb = wp_get_attachment_image_src($attachment_id, 'thumb', true);
					$thumbnail = wp_get_attachment_image_src($attachment_id, 'thumbnail', true);
					$medium = wp_get_attachment_image_src($attachment_id, 'medium', true);
					$large = wp_get_attachment_image_src($attachment_id, 'large', true);
					$full = wp_get_attachment_image_src($attachment_id, 'full', true);
					$postthumbnail = wp_get_attachment_image_src($attachment_id, 'post-thumbnail', true);
					$attachment_details = get_post( $attachment_id );
					$href = get_permalink( $attachment_details->ID );
					$src = $attachment_details->guid;
					$title = $attachment_details->post_title;
					$description = $attachment_details->post_content;
					//$image_link_url =  $gg_settings['slide-link'][$count];
					
						?>
						<div class="gridder-content" id="gridder-content-<?php echo $grid_gallery_id; ?>-<?php echo $count; ?>">
							<img src="<?php echo $full[0]; ?>" class="<?php echo $thumb_bor; ?> imgbor-<?php echo $grid_gallery_id; ?>">
							<div class="description gg-description-<?php echo $grid_gallery_id; ?>">
								<?php if($title_setting == "show") { ?>
								<p class="gg-title-<?php echo $grid_gallery_id; ?>"><?php echo ucwords($title); ?></p>
								<?php } ?>
							</div>
						</div>
						<?php
					$count++;
				}// end of attachment foreach
			} else {
				_e('Sorry! No grid gallery found ', GGP_TXTDM);
				echo ":[GGAL id=$post_id]";
			} // end of if esle of slides avaialble check into slider
			?>
		
	</div>
<?php
endwhile;
wp_reset_query();
?>
<script>
jQuery(document).ready(function (jQuery) {
	// Call Gridder
	jQuery(".gg-<?php echo $grid_gallery_id; ?>").gridderExpander({
		scroll: <?php echo $scroll_loading; ?>,
		scrollOffset: 100,
		scrollTo: "panel", // panel or listitem
		animationSpeed: <?php echo $animation_speed; ?>,
		animationEasing: "easeInOutExpo",
		showNav: true,
		nextText: "<i class=\"fa fa-arrow-right\"></i>",
		prevText: "<i class=\"fa fa-arrow-left\"></i>",
		closeText: "<i class=\"fa fa-times\"></i>",
		onStart: function () {
			console.log("Gridder Inititialized");
		},
		onContent: function () {
			console.log("Gridder Content Loaded");
			jQuery(".carousel").carousel();
		},
		onClosed: function () {
			console.log("Gridder Closed");
		}
	});
});
</script>