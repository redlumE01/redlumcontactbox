<?php

require_once('RationalOptionPages.php');
$pages = array(
	'redlum_contact_box'	=> array(
		'parent_slug'	=> 'edit.php?post_type=redlum_contact_box',
		'page_title'	=> __( 'Settings', 'sample-domain' ),
		'sections'		=> array(
			'section-one'	=> array(
				'title'			=> __( 'Index link options', 'sample-domain' ),
				'fields'		=> array(

					'text'		=> array(
						'title'			=> __( 'Current selected Icon', 'sample-domain' )
					),

					'radio'			=> array(
						'title'			=> __( 'Fontawesome Icon Library', 'sample-domain' ),
						'type'			=> 'radio',
						'choices'		=> array(
							'option-one'	=> __( 'Option One', 'sample-domain' )
						),
					),

					'color'			=> array(
						'title'			=> __( 'Icon color', 'sample-domain' ),
						'type'			=> 'color',
						'value'			=> '#000',
					),

					'checkbox'		=> array(
						'title'			=> __( 'Use Custom Icon', 'sample-domain' ),
						'type'			=> 'checkbox',
						'text'			=> __( 'Prefer a custom icon above of the Fontawesome Library' ),
					),

					'media'			=> array(
						'title'			=> __( 'Custom Icon', 'sample-domain' ),
						'type'			=> 'media'
					),

					'bgColor'			=> array(
						'title'			=> __( 'Background Color', 'sample-domain' ),
						'type'			=> 'color',
						'value'			=> '#000',
					),

					'select'		=> array(
						'title'			=> __( 'Contactbox position', 'sample-domain' ),
						'type'			=> 'select',
						'value'			=> 'option-two',
						'choices'		=> array(
							'topleft'	=> __( 'Top left', 'sample-domain' ),
							'topright'	=> __( 'Top right', 'sample-domain' ),
							'bottomleft'	=> __( 'Bottom left', 'sample-domain' ),
							'bottomright'	=> __( 'Bottom right', 'sample-domain' ),
						),
					),

				),
			),
		),
	),
);

$option_page = new RationalOptionPages( $pages );
