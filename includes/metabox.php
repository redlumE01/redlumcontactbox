<?php

// Meta Box

class metaBox {

	private $screen = array('redlum_contact_box',);
	public function __construct($metaBoxId, $metaBoxName, $definedMetafields) {

		$this->id = $metaBoxId;
		$this->name = $metaBoxName;
		$this->fields = $definedMetafields;

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes'));
		add_action( 'save_post', array( $this, 'save_fields' ));

		if ($this->id === "fontawesome_icon") {
			add_action( 'rest_api_init', 'register_icon_to_api');
			function register_icon_to_api() {
				register_rest_field( 'redlum_contact_box',
					'redlum_contact_box_font_awesome_icon',
					array(
						'get_callback'    => 'get_icon_class',
						'update_callback' => null,
						'schema'          => null
					)
				);
			}

			function get_icon_class( $object, $field_name, $request ) {
				return get_post_meta( $object[ 'id' ], 'redlum_contact_box_font_awesome_icon', true);
			}
		}
	}

	// Unique Names / Context / Priority

	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box( $this->id, __( $this->name, 'rcb' ),array( $this, 'meta_box_callback' ),$single_screen, 'advanced', 'default');
		}
	}

	public function meta_box_callback( $post ) {
		$this->field_generator( $post );
	}

	public function field_generator( $post ) {
		$output = '';

		foreach ( $this->fields as $meta_field ) {

			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );

			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default'];
			}

			switch ( $meta_field['type'] ) {

				case 'media':
					$input = sprintf(
						'<input style="width: 80%%" id="%s" name="%s" type="text" value="%s"> <button type="button" class="button" id="events_video_upload_btn" data-media-uploader-target="%s">Choose file</button>',
						$meta_field['id'],
						$meta_field['id'],
						$meta_value,
						$meta_field['id'],
						$meta_field['id']
					);


					break;

				case 'radio':

					$input = '<fieldset><legend class="screen-reader-text">' . $meta_field['label'] . '</legend>';
					$i = 0;

					foreach ( $meta_field['options'] as $key => $value ) {
						$meta_field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<label><input %s id=" % s" name="% s" type="radio" value="% s"> %s</label>%s',
							$meta_value === $meta_field_value ? 'checked' : '',
							$meta_field['id'],
							$meta_field['id'],
							$meta_field_value,
							$value,
							$i < count( $meta_field['options'] ) - 1 ? '<br>' : ''
						);
						$i++;
					}
					$input .= '</fieldset>';

					break;

				case 'checkbox':
					$input = sprintf('<input %s id="%s" name="%s" type="checkbox" value="1">',$meta_value === '1' ? 'checked' : '', $meta_field['id'],$meta_field['id']);
					break;
				default:
					// ID | Name | Type | Value
					$input = sprintf('<input %s id="%s" name="%s" type="%s" value="%s">','', $meta_field['id'], $meta_field['id'], $meta_field['type'],$meta_value);
			}

			$output .= $this->format_rows( $label, $input );

		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}

	public function save_fields( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;

		// Field Cases Handler

		foreach ($this->fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		}
	}
}
