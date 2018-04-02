<?php

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// META BOXES
// register meta box
function nb_option_add_meta_box() {
	$post_types = array( 'post', 'review' );
	foreach ( $post_types as $post_type ) {
		add_meta_box(
			'nb_option_meta_box',         // Unique ID of meta box
			'Option',         // Title of meta box
			'nb_option_display_meta_box', // Callback function
			$post_type                   // Post type
		);
	}
}
add_action( 'add_meta_boxes', 'nb_option_add_meta_box' );

// display meta box
function nb_option_display_meta_box( $post ) {
	$value = get_post_meta( $post->ID, 'nb_option_meta_key', true );
	wp_nonce_field( basename( __FILE__ ), 'nb_option_meta_box_nonce' );
	?>
	<label for="nb-option-meta-box">Field Description</label>
	<select id="nb-option-meta-box" name="nb-option-meta-box">
		<option value="">Select option...</option>
		<option value="option-1" <?php selected( $value, 'option-1' ); ?>>Option 1</option>
		<option value="option-2" <?php selected( $value, 'option-2' ); ?>>Option 2</option>
		<option value="option-3" <?php selected( $value, 'option-3' ); ?>>Option 3</option>
	</select>
<?php
}

// save meta box
function nb_option_save_meta_box( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = false;
	if ( isset( $_POST[ 'nb_option_meta_box_nonce' ] ) ) {
		if ( wp_verify_nonce( $_POST[ 'nb_option_meta_box_nonce' ], basename( __FILE__ ) ) ) {
			$is_valid_nonce = true;
		}
	}
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;
	if ( array_key_exists( 'nb-option-meta-box', $_POST ) ) {
		update_post_meta(
			$post_id,                                            // Post ID
			'nb_option_meta_key',                                // Meta key
			sanitize_text_field( $_POST[ 'nb-option-meta-box' ] ) // Meta value
		);
	}
}
add_action( 'save_post', 'nb_option_save_meta_box' );