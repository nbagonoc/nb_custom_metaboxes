<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// META BOXES
// options
// add meta box
function nb_option_meta_box_add() {
	$post_types = array( 'post', 'review' );
	foreach ( $post_types as $post_type ) {
		add_meta_box(
			'nb_option_meta_box',         // Unique ID of meta box
			'Option',         // Title of meta box
			'nb_option_meta_box_callback', // Callback function
			$post_type                   // Post type
		);
	}
}
add_action( 'add_meta_boxes', 'nb_option_meta_box_add' );
// show meta box
function nb_option_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_nb_option_meta_box_key', true );
	wp_nonce_field( 'nb_option_meta_box_save', 'nb_option_meta_box_nonce' );
	?>
	<label for="nb_option_meta_box_field">Field Description</label>
	<select id="nb_option_meta_box_field" name="nb_option_meta_box_field">
		<option value="">Select option...</option>
		<option value="option-1" <?php selected( $value, 'option-1' ); ?>>Option 1</option>
		<option value="option-2" <?php selected( $value, 'option-2' ); ?>>Option 2</option>
		<option value="option-3" <?php selected( $value, 'option-3' ); ?>>Option 3</option>
	</select>
<?php
}
// save meta box value
function nb_option_meta_box_save( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = false;
	if ( isset( $_POST[ 'nb_option_meta_box_nonce' ] ) ) {
		if ( wp_verify_nonce( $_POST[ 'nb_option_meta_box_nonce' ], 'nb_option_meta_box_save' ) ) {
			$is_valid_nonce = true;
		}
	}
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;
	if ( array_key_exists( 'nb_option_meta_box_field', $_POST ) ) {
		update_post_meta(
			$post_id,                                            // Post ID
			'_nb_option_meta_box_key',                                // Meta key
			sanitize_text_field( $_POST[ 'nb_option_meta_box_field' ] ) // Meta value
		);
	}
}
add_action( 'save_post', 'nb_option_meta_box_save' );

//field
// add meta box
function nb_field_meta_box_add() {
	$post_types = array( 'review', 'testimonial', 'post' );
	foreach ( $post_types as $post_type ) {
		add_meta_box(
			'nb_field_meta_box',         // Unique ID of meta box
			'Field',         // Title of meta box
			'nb_field_meta_box_callback', // Callback function
            $post_type,                   // Post type
            'normal'                    //normal/side. the default value is normal
            //''                          //high,core,default,low. default is core
		);
	}
}
add_action( 'add_meta_boxes', 'nb_field_meta_box_add' );
// show meta box
function nb_field_meta_box_callback( $post ) {
	$value = get_post_meta( $post->ID, '_nb_field_meta_box_key', true );
	wp_nonce_field( 'nb_field_meta_box_save', 'nb_field_meta_box_nonce' );
	?>
	<label for="nb_field_meta_box_field">Field Description: </label>
    <input type="text" id="nb_field_meta_box_field" name="nb_field_meta_box_field" class="widefat" value="<?php echo esc_attr($value); ?>"/>
<?php
}
// save meta box value
function nb_field_meta_box_save( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = false;
	if ( isset( $_POST[ 'nb_field_meta_box_nonce' ] ) ) {
		if ( wp_verify_nonce( $_POST[ 'nb_field_meta_box_nonce' ], 'nb_field_meta_box_save' ) ) {
			$is_valid_nonce = true;
		}
	}
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;
	if ( array_key_exists( 'nb_field_meta_box_field', $_POST ) ) {
		update_post_meta(
			$post_id,                                            // Post ID
			'_nb_field_meta_box_key',                                // Meta key
			sanitize_text_field( $_POST[ 'nb_field_meta_box_field' ] ) // Meta value
		);
	}
}
add_action( 'save_post', 'nb_field_meta_box_save' );