<?php

add_action( 'init', 'register_performance_custom_post_type' );

if ( ! function_exists('register_performance_custom_post_type') ) {

// Register Custom Post Type
function register_performance_custom_post_type() {

    $labels = array(
        'name'                  => _x( 'Performances', 'Post Type General Name', 'event-festival' ),
        'singular_name'         => _x( 'Performance', 'Post Type Singular Name', 'event-festival' ),
        'menu_name'             => __( 'Festival', 'event-festival' ),
        'name_admin_bar'        => __( 'Festival', 'event-festival' ),
        'archives'              => __( 'Item Archives', 'event-festival' ),
        'attributes'            => __( 'Item Attributes', 'event-festival' ),
        'parent_item_colon'     => __( 'Parent Item:', 'event-festival' ),
        'all_items'             => __( 'All Performances', 'event-festival' ),
        'add_new_item'          => __( 'Add New Performance', 'event-festival' ),
        'add_new'               => __( 'Add New', 'event-festival' ),
        'new_item'              => __( 'New Performance', 'event-festival' ),
        'edit_item'             => __( 'Edit Performance', 'event-festival' ),
        'update_item'           => __( 'Update Performance', 'event-festival' ),
        'view_item'             => __( 'View Performance', 'event-festival' ),
        'view_items'            => __( 'View Performances', 'event-festival' ),
        'search_items'          => __( 'Search Performance', 'event-festival' ),
        'not_found'             => __( 'Not found', 'event-festival' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'event-festival' ),
        'featured_image'        => __( 'Featured Image', 'event-festival' ),
        'set_featured_image'    => __( 'Set featured image', 'event-festival' ),
        'remove_featured_image' => __( 'Remove featured image', 'event-festival' ),
        'use_featured_image'    => __( 'Use as featured image', 'event-festival' ),
        'insert_into_item'      => __( 'Insert into item', 'event-festival' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'event-festival' ),
        'items_list'            => __( 'Items list', 'event-festival' ),
        'items_list_navigation' => __( 'Items list navigation', 'event-festival' ),
        'filter_items_list'     => __( 'Filter items list', 'event-festival' ),
    );
    $args = array(
        'label'                 => __( 'Performance', 'event-festival' ),
        'description'           => __( 'Performances at SF Pride Celebration', 'event-festival' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', ),
        'taxonomies'            => array( 'category', 'stage' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'performance', $args );

}
}

if ( ! function_exists( 'register_stage_taxonomy' ) ) {

// Register Custom Taxonomy
function register_stage_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Stage', 'Taxonomy General Name', 'event_festival' ),
		'singular_name'              => _x( 'Stage', 'Taxonomy Singular Name', 'event_festival' ),
		'menu_name'                  => __( 'Stages', 'event_festival' ),
		'all_items'                  => __( 'All Items', 'event_festival' ),
		'parent_item'                => __( 'Parent Item', 'event_festival' ),
		'parent_item_colon'          => __( 'Parent Item:', 'event_festival' ),
		'new_item_name'              => __( 'New Item Name', 'event_festival' ),
		'add_new_item'               => __( 'Add New Stage', 'event_festival' ),
		'edit_item'                  => __( 'Edit Stage', 'event_festival' ),
		'update_item'                => __( 'Update Stage', 'event_festival' ),
		'view_item'                  => __( 'View Stage', 'event_festival' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'event_festival' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'event_festival' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'event_festival' ),
		'popular_items'              => __( 'Popular Stages', 'event_festival' ),
		'search_items'               => __( 'Search Stages', 'event_festival' ),
		'not_found'                  => __( 'Not Found', 'event_festival' ),
		'no_terms'                   => __( 'No items', 'event_festival' ),
		'items_list'                 => __( 'Items list', 'event_festival' ),
		'items_list_navigation'      => __( 'Items list navigation', 'event_festival' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'stage', array( 'performance' ), $args );

}
add_action( 'init', 'register_stage_taxonomy', 0 );

}
