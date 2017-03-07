<?php

/**
 * Admin Interface for setting performance meta
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */

function event_add_meta_boxes( $post ){
	add_meta_box( 'event_meta_box', __( 'Performance Details', 'event_festival' ), 'performance_build_meta_box', 'performance', 'side', 'low' );
}
add_action( 'add_meta_boxes_performance', 'event_add_meta_boxes' );

function performance_build_meta_box ( $post ) {
    // make sure the form request comes from WordPress
	wp_nonce_field( basename( __FILE__ ), 'performance_meta_box_nonce' );

	// retrieve the day, start and end times
	$day = ( get_post_meta( $post->ID, 'day', true ) ) ? get_post_meta( $post->ID, 'day', true ) : '';
	$start_time = ( get_post_meta( $post->ID, 'start_time', true ) ) ? get_post_meta( $post->ID, 'start_time', true ) : '';
	$end_time = ( get_post_meta( $post->ID, 'end_time', true ) ) ? get_post_meta( $post->ID, 'end_time', true ) : '';

    ?>

        <div class='inside'>
            <p><span><?php _e( 'Day', 'event_festival' ); ?></span>

                <select name="day" value="<?php echo $day; ?>">
                    <option value="saturday" <?php selected( $day, 'saturday' ); ?>>Saturday</option>
                    <option value="sunday" <?php selected( $day, 'sunday' ); ?>>Sunday</option>
                </select>
            </p>
        </div>
        <div class='inside'>
        	<p><span><?php _e( 'Start Time', 'event_festival' ); ?></span>
        		<input type="time" name="start_time" value="<?php echo $start_time; ?>" />
        	</p>
        </div>
        <div class='inside'>
            <p><span><?php _e( 'End Time', 'event_festival' ); ?></span>
                <input type="time" name="end_time" value="<?php echo $end_time; ?>" />
            </p>
        </div>
    <?php
}

/**
 * Persist Performance Metadata
 *
 * @param int $post_id The post ID.
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/save_post
 */
function performance_save_meta_box_data( $post_id ){
	// verify meta box nonce
	if ( !isset( $_POST['performance_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['performance_meta_box_nonce'], basename( __FILE__ ) ) ){
		return;
	}
	// return if autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
		return;
	}
  // Check the user's permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ){
		return;
	}
	// store custom fields values
	// start, end times
	if( isset( $_POST['start_time'] ) ){
		$start_time = sanitize_text_field( $_POST['start_time'] );
		update_post_meta( $post_id, 'start_time', $start_time );
	}else{
		// delete data
		delete_post_meta( $post_id, 'start_time' );
	}
	if( isset( $_POST['end_time'] ) ){
		$end_time = sanitize_text_field( $_POST['end_time'] );
		update_post_meta( $post_id, 'end_time', $end_time );
	}else{
		// delete data
		delete_post_meta( $post_id, 'end_time' );
	}
	if( isset( $_POST['day'] ) ){
		$day = sanitize_text_field( $_POST['day'] );
		update_post_meta( $post_id, 'day', $day );
	}else{
		// delete data
		delete_post_meta( $post_id, 'day' );
	}
//	// store custom fields values
//	// carbohydrates string
//	if ( isset( $_REQUEST['carbohydrates'] ) ) {
//		update_post_meta( $post_id, '_food_carbohydrates', sanitize_text_field( $_POST['carbohydrates'] ) );
//	}
//	// store custom fields values
//	// vitamins array
//	if( isset( $_POST['vitamins'] ) ){
//		$vitamins = (array) $_POST['vitamins'];
//		// sinitize array
//		$vitamins = array_map( 'sanitize_text_field', $vitamins );
//		// save data
//		update_post_meta( $post_id, '_food_vitamins', $vitamins );
//	}else{
//		// delete data
//		delete_post_meta( $post_id, '_food_vitamins' );
//	}
}
add_action( 'save_post_performance', 'performance_save_meta_box_data' );



function stage_add_meta_fields( $taxonomy ) {
    ?>
    <div class="form-field term-group">
        <label for="order"><?php _e( 'Order', 'event_festival' ); ?></label>
        <input type="text" id="order" name="order" />
    </div>
    <?php
}
add_action( 'stage_add_form_fields', 'stage_add_meta_fields', 10, 2 );

function stage_edit_meta_fields( $term, $taxonomy ) {
    $order = get_term_meta( $term->term_id, 'order', true );
    ?>
    <tr class="form-field term-group-wrap">
        <th scope="row">
            <label for="order"><?php _e( 'Order', 'event_festival' ); ?></label>
        </th>
        <td>
            <input type="text" id="order" name="order" value="<?php echo $order; ?>" />
        </td>
    </tr>
    <?php
}
add_action( 'stage_edit_form_fields', 'stage_edit_meta_fields', 10, 2 );

function stage_save_taxonomy_meta( $term_id, $tag_id ) {
    if( isset( $_POST['order'] ) ) {
        update_term_meta( $term_id, 'order', esc_attr( $_POST['order'] ) );
    }
}
add_action( 'created_stage', 'stage_save_taxonomy_meta', 10, 2 );
add_action( 'edited_stage', 'stage_save_taxonomy_meta', 10, 2 );

function stage_add_field_columns( $columns ) {
    $columns['order'] = __( 'Order', 'event_festival' );

    return $columns;
}
add_filter( 'manage_edit-stage_columns', 'stage_add_field_columns' );

function stage_add_field_column_contents( $content, $column_name, $term_id ) {
    switch( $column_name ) {
        case 'order' :
            $content = get_term_meta( $term_id, 'order', true );
            break;
    }

    return $content;
}
add_filter( 'manage_stage_custom_column', 'stage_add_field_column_contents', 10, 3 );