<?php

class Link {
	// Properties
	public $backGroundColor;
	public $icon;
	public $firstItem;

	// Methods
	function set_values($backGroundColor,$icon,$firstItem) {
		$this->backGroundColor = $backGroundColor;
		$this->icon = $icon;
		$this->firstItem = $firstItem;
	}

	// Icon check  + rendering
	function get_values() {

		$iconType = $this->icon[0];
		$iconColor = $this->icon[1];

		// Setup class
		$class = 'rcb';
		if ($this->firstItem) {
			$class = 'j-rcb';
		}

		// Setup Href
		if ($this->icon[2]) {
			$href = 'href="'.$this->icon[2].'"';

			switch($this->icon[3]){
				case "Internal":
					$linkTarget = "_self";
				break;
				case "External":
					$linkTarget = "_blank";
				break;
			}

			$target = ' target="'.$linkTarget.'"';
			$href = $href . $target;
		}

		if (strpos($iconType, 'fa-') == true ) {
			$icon = '<a class="'.$class.'"'.$href.' style="background-color:'.$this->backGroundColor.';color:'.$iconColor.';"><i class="'.$iconType.'"></i></a>';
		}else{
			$optInlineStyle =  "background-image:url('$iconType');background-color:$this->backGroundColor;";
			$icon = '<a class="'.$class.'" '.$href.' style="'.$optInlineStyle.'"></a>';
		}

		return $icon;
	}

}

function redlum_contactbox_render() {

	$query = new WP_Query(array('post_type'=> 'redlum_contact_box'));

	if ( $query->have_posts() ) {

		$redlum_cb_settings = get_option( 'redlum_contact_box' );
		$position = $redlum_cb_settings['contactbox_position'];

		if ($redlum_cb_settings['use_custom_icon']) {
			$icon = $redlum_cb_settings['custom_icon'];
			$iconColor = false;
		}else{
			$icon = $redlum_cb_settings['current_selected_icon'];
			$iconColor = $redlum_cb_settings['icon_color'];
		}

		$output = '';
		$output .= '<div class="redlum_contact_box '.$redlum_cb_settings['contactbox_position'].'">';

		if ($position === "topright" || $position === "topleft" ) {
			$mainLink = new Link();
			$mainLink->set_values($redlum_cb_settings['background_color'], array($icon,$iconColor,false),true);
			$output .= $mainLink->get_values();
		};

		while ( $query->have_posts() ) {
			$query->the_post();
			$metaData = get_post_meta(get_the_id());

			switch ($metaData['redlum_contact_box_activate-custom-icon'][0]) {
				case "1":
					$innerLinkicon = $metaData['redlum_media_upload'][0];
					$iconColor = false;
					break;
				default:
					$innerLinkicon = $metaData['redlum_contact_box_font_awesome_icon'][0];
					$iconColor = $metaData['redlum_fa_color'][0];
					break;
			}

			$innerLink = new Link();
			$innerLink->set_values($metaData['redlum_contact_box_color'][0], array($innerLinkicon,$iconColor,$metaData['redlum_contact_box_url'][0],$metaData['redlum_contact_box_url_target'][0]),false);
			$output .= $innerLink->get_values();

		}

		if ($position === "bottomright" || $position === "bottomleft" ) {
			$mainLink = new Link();
			$mainLink->set_values($redlum_cb_settings['background_color'], array($icon,$iconColor,false),true);
			$output .= $mainLink->get_values();
		};

		$output .= '</div>';

		echo $output;
		wp_reset_postdata();
	}

}

add_action( 'wp_head',	'redlum_contactbox_render');
