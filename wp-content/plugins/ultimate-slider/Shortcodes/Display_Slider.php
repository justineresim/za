<?php

function EWD_US_Display_Slider($atts, $content = null) {
	global $wpdb;
	global $items_table_name;

	$Carousel = get_option("EWD_US_Carousel");
	$Carousel_Link_To_Full = get_option("EWD_US_Carousel_Link_To_Full");
	$Slide_Indicators = get_option("EWD_US_Slide_Indicators");
	$Link_Action = get_option("EWD_US_Link_Action");
	$Add_Watermark = get_option("EWD_US_Add_Watermark");

	if ($Link_Action == "Same") {$Target_Text = "";}
	elseif ($Link_Action == "New") {$Target_Text = "target='_blank'";}

	$Selected_Arrow = get_option("EWD_us_Arrow");
	$us_Arrow_Background_Shape = get_option("EWD_us_Arrow_Background_Shape");

	if ($us_Arrow_Background_Shape != "None") {$Background_Class = "ewd-us-" . $us_Arrow_Background_Shape;}
	else {$Background_Class = "";}

	extract( shortcode_atts( array(
		'posts' => '-1',
		'slider_type' => '',
		'category' => '',
	), $atts ) );

	$return_string = '<div class="clear"></div>';
	$return_string .= '<div class="ewd-slider-section">';
	$return_string .= EWD_US_Add_Modified_Styles();
	$return_string .= '<div class="slider">';
	$return_string .= '<div id="timerBar"><div id="innerTimerBar"></div></div>';
	$return_string .= '<ul class="slider-window">';

		if ($slider_type == "woocommerce") {
			$args = array(
							'posts_per_page' => $posts,
							'post_type' => 'product',
							'product_cat' => $category,
							'orderby' => 'rand'
				);
		}
		elseif ($slider_type == "upcp") {
			$args = array(
							'posts_per_page' => $posts,
							'post_type' => 'upcp_product',
							'product_cat' => $category,
							'orderby' => 'rand'
				);
		}
		else {
			$args = array(
							'posts_per_page' => $posts,
							'post_type' => 'ultimate_slider',
							'ultimate_slider_categories' => $category,
							'meta_key' => 'EWD_US_Slide_Order',
							'orderby' => 'meta_value_num',
							'order' => 'ASC',
				);
		}
		$Slider_Query = new WP_Query($args);

		$Slide_Counter = 0;

		while ($Slider_Query->have_posts()) : $Slider_Query->the_post();
			$post = get_post();

			if ($slider_type == "woocommerce") {
				$Content_Type = "woocommerce_product";
				$WC_Product_ID = $post->ID;
				if (!is_array($Buttons)) {$Buttons = array();}
			}
			elseif ($slider_type == "upcp") {
				$Content_Type = "upcp_product";
				$UPCP_Product_ID = $post->ID;
				if (!is_array($Buttons)) {$Buttons = array();}
			}
			else {
				$Content_Type = get_post_meta($post->ID, "EWD_US_Content_Type", true);
				$UPCP_Product_ID = get_post_meta($post->ID, "EWD_US_UPCP_Product_ID", true);
				$WC_Product_ID = get_post_meta($post->ID, "EWD_US_WC_Product_ID", true);
				$Max_Title_Chars = get_post_meta($post->ID, "EWD_US_Max_Title_Chars", true);
				$Max_Body_Chars = get_post_meta($post->ID, "EWD_US_Max_Body_Chars", true);
				$Image_Type = get_post_meta($post->ID, "EWD_US_Image_Type", true);
				$Buttons = get_post_meta($post->ID, "EWD_US_Buttons", true);
				if (!is_array($Buttons)) {$Buttons = array();}
			}

			if ($Content_Type == 'upcp_product') {
				if (class_exists('UPCP_Product')) {
					$Product = new UPCP_Product(array('ID' => $UPCP_Product_ID));
					$Title = $Product->Get_Product_Name();
					$Content = $Product->Get_Field_Value('Item_Description');
					$Image_URL = $Product->Get_Field_Value('Item_Photo_URL');
				}
			}
			elseif ($Content_Type == 'woocommerce_product') {
				$Title = get_the_title($WC_Product_ID);
				$Content_Post = get_post($WC_Product_ID);
				$Content = $Content_Post->post_content;
				$Content = apply_filters('the_content', $Content);
				$Content = str_replace(']]>', ']]&gt;', $Content);
				$post_thumbnail_id = get_post_thumbnail_id($WC_Product_ID);
				$Image_URL = wp_get_attachment_url( $post_thumbnail_id );
			}
			else {
				$Title = get_the_title();
				$Content = get_the_content();
				$post_thumbnail_id = get_post_thumbnail_id();
				$Image_URL = wp_get_attachment_url( $post_thumbnail_id );
			}

			if ($Add_Watermark == "Yes" and $Image_Type != "youtube_video") {
				$upload_dir = wp_upload_dir();
				$plugin_upload_dir = $upload_dir['baseurl'] . "/ultimate-slider/";
				if (!file_exists($plugin_upload_dir . basename($Image_URL))) {
					file_get_contents(plugins_url() . "/ultimate-slider/Functions/EWD_US_Create_Watermark_Image.php?Image_URL=" . $Image_URL);
				}
				$Image_URL = $plugin_upload_dir . basename($Image_URL);
			}

			if ($Image_Type == "youtube_video") {
				$YouTube_ID = EWD_US_Get_YouTube_ID(get_post_meta($post->ID, "EWD_US_YouTube_URL", true));
				$Image_URL = EWD_US_Get_YouTube_Image_URL($YouTube_ID);
				$Video_Background_Class = "ewd-us-video";
			}
			else {
				$Video_Background_Class = "";
			}

			if ($Max_Title_Chars != "") {$Title = substr($Title, 0, $Max_Title_Chars);}
			if ($Max_Body_Chars != "") {$Content = substr($Content, 0, $Max_Body_Chars);}

			if ($Slide_Counter != 0) {$Hidden_Class = "ewd-us-hidden";}
			else {$Hidden_Class = "";}

			if ($Carousel == 'Yes') {$carouselClass = 'carouselSlider ';}
			else {$carouselClass = '';}

			$return_string .= '<li class="ewd-slide ' . $carouselClass . $Hidden_Class . $Video_Background_Class . '" id="ewd-slide-' . $Slide_Counter . '"  data-src="' . $Image_URL . '">';
				if ($Image_Type == "youtube_video") {
					$return_string .= "<div class='ewd-us-video-holder iframetrack'>";
					$return_string .= "<div>";
					$return_string .= EWD_US_Get_YouTube_Embed_Code($YouTube_ID);
					$return_string .= "</div>";
					$return_string .= "</div>";
				}
				else {$return_string .= '<div class="slideImg" style="background-image: url(' . $Image_URL . ')""></div>';}
				$return_string .= '<div class="slideText">';
					$return_string .= '<div class="slideTitle">' . $Title . '</div>';
					$return_string .= '<div class="clear"></div>';
					$return_string .= '<div class="slideExcerpt">' . $Content . '</div>';
					$return_string .= '<div class="clear"></div>';
					$return_string .= '<ul class="slideButtons">';
						foreach ($Buttons as $Button) {
							if ($Button['Post_ID'] == 0) {$Link = $Button['Custom_Link'];}
							else {$Link = get_permalink($Button['Post_ID']);}
							if ($Link_Action == "Smart") {
								if (strpos($Link, get_site_url()) === false) {$Target_Text = "target='_blank'";}
								else {$Target_Text = "";}
							}
							$return_string .= '<li>';
							$return_string .= "<a class='ewd-us-slide-button' href='" . $Link . "' " . $Target_Text . ">" . strtoupper($Button['Text']) . "</a>";
							$return_string .= '</li>';
						}
					$return_string .= '</ul>';
				$return_string .= '</div> <!-- slideText -->';
				if($Carousel == 'Yes' && $Carousel_Link_To_Full == 'Yes'){
					$return_string .= '<a href="' . get_the_permalink() . '" class="carouselLinkToFull"></a>';
				}
			$return_string .= '</li> <!-- ewd-slide -->';

			$Slide_Previews[$Slide_Counter] = $Image_URL;

			$Slide_Counter++;

		endwhile;
		wp_reset_query();

	$return_string .= '</ul> <!-- slider-window -->';
	if($Selected_Arrow == 'None'){
		$Selected_Arrow = '';
	}
	$return_string .= ' <div class="nav-arrow" id="left"><div class="ewd-us-arrow-div ' . $Background_Class . '"><div class="ewd-slider-icon us-arrow" id="left"><span class="ion-chevron-left"></span></div></div></div> <!-- nav arrow -->';
	$return_string .= ' <div class="nav-arrow" id="right"><div class="ewd-us-arrow-div ' . $Background_Class . '"><div class="ewd-slider-icon us-arrow"  id="right"><span class="ion-chevron-right"></span></div></div></div> <!-- nav arrow -->';
	$return_string .= '</div> <!-- slider -->';
	if ($Slide_Indicators == "Dots") {$return_string .= '<div class="ewd-slider-control" id=""><div class="ewd-slider-control-button-list"></div></div>';}
	if ($Slide_Indicators == "Thumbnails") {
		$return_string .= '<div class="ewd-slider-control"></div>';
		foreach ($Slide_Previews as $Slide_Counter => $Image_URL) {
			$return_string .= '<div class="ewd-slider-control-thumbnail" data-slidenumber="' . $Slide_Counter . '">';
			$return_string .= '<img src="' . $Image_URL . '" class="ewd-slider-control-thumbnail-img" />';
			$return_string .= '</div>';
		}
		$return_string .= "</div>";
	}
	$return_string .= '</div> <!-- slider-section -->';

	$return_string .= '<div class="clear"></div>';

	/*$return_string = "<div>";
	$return_string .= "<ul id='lightbox-test'>";
	$return_string .= "<li data-src='wp-content/uploads/ultimate-slider/cityscape.jpg'>";
	$return_string .= "<a href><img style='max-width:300px;' src='wp-content/uploads/ultimate-slider/cityscape.jpg' /></a>";
	$return_string .= "</li>";
	$return_string .= "<li data-src='wp-content/uploads/ultimate-slider/trainyard.jpg'>";
	$return_string .= "<a href><img style='max-width:300px;' src='wp-content/uploads/ultimate-slider/trainyard.jpg' /></a>";
	$return_string .= "</li>";
	$return_string .= "</ul>";
	$return_string .= "</div>";*/

	return $return_string;

}
add_shortcode('ultimate-slider', 'EWD_US_Display_Slider');

function EWD_US_Get_YouTube_ID($YouTube_URL) {
	preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $YouTube_URL, $matches);
	
	return $matches[0];
}

function EWD_US_Get_YouTube_Embed_Code($YouTube_ID) {
	return "<iframe class='ewd-us-video' width='640' height='360' src='http://www.youtube.com/embed/" . $YouTube_ID . "?rel=0&fs=1' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
}

function EWD_US_Get_YouTube_Image_URL($YouTube_ID) {
	return "http://img.youtube.com/vi/" . $YouTube_ID . "/default.jpg";
}