<?php


/**
 * rt-biz Helper Functions
 *
 * Helper functions for rt-biz
 *
 * @author udit
 */

function rt_biz_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

	if ( $args && is_array($args) )
		extract( $args );

	$located = rt_biz_locate_template( $template_name, $template_path, $default_path );

	do_action( 'rt_biz_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'rt_biz_after_template_part', $template_name, $template_path, $located, $args );
}

function rt_biz_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	global $rt_biz;
	if ( ! $template_path ) $template_path = $rt_biz->templateURL;
	if ( ! $default_path ) $default_path = RT_BIZ_PATH_TEMPLATES;

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template )
		$template = $default_path . $template_name;

	// Return what we found
	return apply_filters('rt_biz_locate_template', $template, $template_name, $template_path);
}

function rt_biz_register_person_connection( $post_type, $label ) {
	global $rt_person;
	$rt_person->init_connection( $post_type, $label );
}

function rt_biz_register_organization_connection( $post_type, $label ) {
	global $rt_organization;
	$rt_organization->init_connection( $post_type, $label );
}

function rt_biz_get_post_for_person_connection( $post_id, $post_type, $fetch_person = false ) {
	global $rt_person;
	return $rt_person->get_posts_for_entity( $post_id, $post_type, $fetch_person );
}

function rt_biz_get_post_for_organization_connection( $post_id, $post_type, $fetch_organization = false ) {
	global $rt_organization;
	return $rt_organization->get_posts_for_entity( $post_id, $post_type, $fetch_organization );
}

function rt_biz_get_person_post_type() {
	global $rt_person;
	return $rt_person->post_type;
}

function rt_biz_get_organization_post_type() {
	global $rt_organization;
	return $rt_organization->post_type;
}

function rt_biz_get_person_by_email( $email ) {
	global $rt_person;
	return $rt_person->get_by_email( $email );
}

function rt_biz_add_entity_meta( $id, $key, $value ) {
	Rt_Entity::add_meta( $id, $key, $value );
}

function rt_biz_get_entity_meta( $id, $key, $single = false ) {
	return Rt_Entity::get_meta( $id, $key, $single );
}

function rt_biz_update_entity_meta( $id, $key, $value ) {
	Rt_Entity::update_meta( $id, $key, $value );
}

function rt_biz_delete_entity_meta( $id, $key, $value ) {
	Rt_Entity::delete_meta( $id, $key, $value );
}

function rt_biz_add_organization( $name, $note = '', $address = '', $country = '', $meta = array() ) {
	global $rt_organization;
	return $rt_organization->add_organization( $name, $note, $address, $country, $meta );
}

function rt_biz_add_person( $name, $description = '' ) {
	global $rt_person;
	return $rt_person->add_person( $name, $description );
}

function rt_biz_connect_post_to_person( $post_type, $from = '', $to = '', $clear_old = false ) {
	global $rt_person;
	$rt_person->connect_post_to_entity( $post_type, $from, $to, $clear_old );
}

function rt_biz_connect_post_to_organization( $post_type, $from = '', $to = '', $clear_old = false ) {
	global $rt_organization;
	$rt_organization->connect_post_to_entity( $post_type, $from, $to, $clear_old );
}

function rt_biz_connect_organization_to_person( $from = '', $to = '' ) {
	global $rt_biz;
	$rt_biz->connect_organization_to_person( $from, $to );
}

function rt_biz_person_connection_to_string( $post_id, $term_seperator = ' , ' ) {
	global $rt_person;
	return Rt_Entity::connection_to_string( $post_id, $rt_person->post_type, $term_seperator );
}

function rt_biz_organization_connection_to_string( $post_id, $term_seperator = ' , ' ) {
	global $rt_organization;
	return Rt_Entity::connection_to_string( $post_id, $rt_organization->post_type, $term_seperator );
}

function rt_biz_get_organization_to_person_connection( $connected_items ) {
	global $rt_biz;
	return $rt_biz->get_organization_to_person_connection( $connected_items );
}

function rt_biz_get_person_capabilities() {
	global $rt_person;
	return $rt_person->get_post_type_capabilities();
}

function rt_biz_get_organization_capabilities() {
	global $rt_organization;
	return $rt_organization->get_post_type_capabilities();
}

function rt_biz_get_dependent_capabilities() {
	$caps = array();
	foreach ( Rt_Biz_Roles::$global_caps as $cap ) {
		$caps[$cap] = true;
	}
	return $caps;
}

function rt_biz_search_person( $query ) {
	global $rt_person;
	return $rt_person->search( $query );
}

function rt_biz_search_organization( $query ) {
	global $rt_organization;
	return $rt_organization->search( $query );
}

function rt_biz_get_person_meta_fields() {
	global $rt_person;
	return $rt_person->meta_fields;
}

function rt_biz_get_organization_meta_fields() {
	global $rt_organization;
	return $rt_organization->meta_fields;
}