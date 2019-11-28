<?php
function load_admin_scripts() {

	$screen = get_current_screen();

	if ($screen->id == 'redlum_contact_box' || $screen->id == 'redlum_contact_box_page_settings' ) {
		wp_enqueue_media();
		wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . '../scripts/mediaupload.js' );
		wp_register_script( 'font-awesome-cdn',  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js' );
		wp_register_script( 'font-awesome-script', plugin_dir_url( __FILE__ ) . '../scripts/fontawesome.js' );
		wp_register_style( 'font-awesome-css', 'https://use.fontawesome.com/releases/v5.11.2/css/all.css');
		wp_register_style( 'be_style', plugin_dir_url( __FILE__ ) . '../style/be_style.css' );

		wp_localize_script( 'meta-box-image', 'meta_image',
			array(
				'title' => __( 'Choose or Upload Media', 'events' ),
				'button' => __( 'Use this media', 'events' )
			)
		);

		wp_enqueue_script( 'meta-box-image' );
		wp_enqueue_script( 'font-awesome-cdn' );
		wp_enqueue_script( 'font-awesome-script' );
		wp_enqueue_style( 'font-awesome-css' );
		wp_enqueue_style( 'be_style' );
	}

}

add_action( 'admin_enqueue_scripts', 'load_admin_scripts', 10, 1 );

// Meta Box
include('metabox.php');

class fontAweSomeIcon extends metaBox{};

new fontAweSomeIcon(
	'fontawesome_icon',
	'Icons',
	array(
		array(
			'label' => 'Current selected Icon',
			'id' => 'redlum_contact_box_current_font_awesome_icon',
			'type' => 'hidden'
		),
		array(
			'label' => 'Fontawesome Icon Library',
			'id' => 'redlum_contact_box_font_awesome_icon',
			'type' => 'radio',
			'options' => array(''),
		),
		array(
			'label' => 'Icon color',
			'id' => 'redlum_fa_color',
			'type' => 'color',
			'default' => '#000'
		),
		array(
			'id' => 'redlum_contact_box_activate-custom-icon',
			'label' => 'Use Custom Icon',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Custom Icon',
			'id' => 'redlum_media_upload',
			'default' => '',
			'type' => 'media'
		)
	)
);

class linkBox extends metaBox {}

new linkBox(
	'url',
	'Link',
	array(
		array(
			'label' => 'Url',
			'id' => 'redlum_contact_box_url',
			'default' => '/',
			'type' => 'url',
		),
		array(
			'label' => 'Target',
			'id' => 'redlum_contact_box_url_target',
			'default' => 'Internal',
			'type' => 'radio',
			'options' => array(
				'Internal',
				'External',
			),
		)
	)
);

class colorBox extends metaBox {}

new colorBox(
	'color',
	'Background Color',
	array(
		array(
			'label' => 'Color',
			'id' => 'redlum_contact_box_color',
			'type' => 'color',
			'default' => '#FFFFFF'
		)
	)
);
