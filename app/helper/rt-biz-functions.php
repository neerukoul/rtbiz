<?php
/**
 * rt-biz Helper Functions
 *
 * Helper functions for rt-biz
 *
 * @author udit
 */

/**
 *
 * Get rtBiz Templates
 *
 * @param $template_name
 * @param array $args
 * @param string $template_path
 * @param string $default_path
 */
function rt_biz_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

	if ( $args && is_array( $args ) ) {
		extract( $args );
	}

	$located = rt_biz_locate_template( $template_name, $template_path, $default_path );

	do_action( 'rt_biz_before_template_part', $template_name, $template_path, $located, $args );

	include( $located );

	do_action( 'rt_biz_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Loads rtBiz Templates
 *
 * @param $template_name
 * @param string $template_path
 * @param string $default_path
 * @return mixed|void
 */
function rt_biz_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	$rt_biz = rtbiz();
	if ( ! $template_path ) {
		$template_path = $rt_biz->templateURL;
	}

	if ( ! $default_path ) {
		$default_path = RT_BIZ_PATH_TEMPLATES;
	}

	// Look within passed path within the theme - this is priority
	$template = locate_template( array(
		                             trailingslashit( $template_path ) . $template_name,
		                             $template_name,
	                             ) );

	// Get default template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found
	return apply_filters( 'rt_biz_locate_template', $template, $template_name, $template_path );
}

/**
 * Sanitize Module Key
 *
 * @param $key
 * @return mixed|string
 */
function rt_biz_sanitize_module_key( $key ) {
	$filtered = strtolower( remove_accents( stripslashes( strip_tags( $key ) ) ) );
	$filtered = preg_replace( '/&.+?;/', '', $filtered ); // Kill entities
	$filtered = str_replace( array( '.', '\'', '"' ), '', $filtered ); // Kill quotes and full stops.
	$filtered = str_replace( array( ' ' ), '-', $filtered ); // Replace spaces.

	return $filtered;
}

/**
 * Register the contact connection with a post type
 *
 * @param $post_type
 * @param $label
 */
function rt_biz_register_contact_connection( $post_type, $label ) {
	global $rt_contact;
	$rt_contact->init_connection( $post_type, $label );
}

/**
 * Register a company connection with a post type
 *
 * @param $post_type
 * @param $label
 */
function rt_biz_register_company_connection( $post_type, $label ) {
	global $rt_company;
	$rt_company->init_connection( $post_type, $label );
}

/**
 * Get Posts for Person conection
 *
 * @param $post_id
 * @param $post_type
 * @param bool $fetch_contact
 *
*@return mixed
 */
function rt_biz_get_post_for_contact_connection( $post_id, $post_type, $fetch_contact = false ) {
	global $rt_contact;
	return $rt_contact->get_posts_for_entity( $post_id, $post_type, $fetch_contact );
}

/**
 * Get posts for company connection
 *
 * @param $post_id
 * @param $post_type
 * @param bool $fetch_company
 *
*@return mixed
 */
function rt_biz_get_post_for_company_connection( $post_id, $post_type, $fetch_company = false ) {
	global $rt_company;
	return $rt_company->get_posts_for_entity( $post_id, $post_type, $fetch_company );
}

function rt_biz_get_contact_labels() {
	global $rt_contact;
	return $rt_contact->labels;
}

function rt_biz_get_company_labels() {
	global $rt_company;
	return $rt_company->labels;
}

/**
 * Returns contact post type
 *
 * @return mixed
 */
function rt_biz_get_contact_post_type() {
	global $rt_contact;
	return $rt_contact->post_type;
}

/**
 * Returns company post type
 *
 * @return mixed
 */
function rt_biz_get_company_post_type() {
	global $rt_company;
	return $rt_company->post_type;
}

/**
 * get contact by email
 *
 * @param $email
 * @return mixed
 */
function rt_biz_get_contact_by_email( $email ) {
	global $rt_contact;
	return $rt_contact->get_by_email( $email );
}

/**
 * Add meta field
 *
 * @param $id
 * @param $key
 * @param $value
 */
function rt_biz_add_entity_meta( $id, $key, $value ) {
	Rt_Entity::add_meta( $id, $key, $value );
}

/**
 * get meta field
 *
 * @param $id
 * @param $key
 * @param bool $single
 * @return mixed
 */
function rt_biz_get_entity_meta( $id, $key, $single = false ) {
	return Rt_Entity::get_meta( $id, $key, $single );
}

/**
 * update meta field
 *
 * @param $id
 * @param $key
 * @param $value
 */
function rt_biz_update_entity_meta( $id, $key, $value ) {
	Rt_Entity::update_meta( $id, $key, $value );
}

/**
 * delete meta field
 *
 * @param $id
 * @param $key
 * @param $value
 */
function rt_biz_delete_entity_meta( $id, $key, $value ) {
	Rt_Entity::delete_meta( $id, $key, $value );
}

/**
 * adds an company
 *
 * @param $name
 * @param string $note
 * @param string $address
 * @param string $country
 * @param array $meta
 * @return mixed
 */
function rt_biz_add_company( $name, $note = '', $address = '', $country = '', $meta = array() ) {
	global $rt_company;
	return $rt_company->add_company( $name, $note, $address, $country, $meta );
}

/**
 * add a contact
 *
 * @param $name
 * @param string $description
 * @return mixed
 */
function rt_biz_add_contact( $name, $description = '' ) {
	global $rt_contact;
	return $rt_contact->add_contact( $name, $description );
}

function rt_biz_clear_post_connections_to_contact( $post_type, $from ) {
	global $rt_contact;
	$rt_contact->clear_post_connections_to_entity( $post_type, $from );
}

function rt_biz_clear_post_connections_to_company( $post_type, $from ) {
	global $rt_company;
	$rt_company->clear_post_connections_to_entity( $post_type, $from );
}

/**
 *
 * @param $post_type
 * @param string $from
 * @param string $to
 */
function rt_biz_connect_post_to_contact( $post_type, $from = '', $to = '' ) {
	global $rt_contact;
	$rt_contact->connect_post_to_entity( $post_type, $from, $to );
}

/**
 * @param $post_type
 * @param string $from
 * @param string $to
 * @param bool $clear_old
 */
function rt_biz_connect_post_to_company( $post_type, $from = '', $to = '', $clear_old = false ) {
	global $rt_company;
	$rt_company->connect_post_to_entity( $post_type, $from, $to, $clear_old );
}

/**
 * @param string $from
 * @param string $to
 */
function rt_biz_connect_company_to_contact( $from = '', $to = '' ) {
	$rt_biz = rtbiz();
	$rt_biz->connect_company_to_contact( $from, $to );
}

/**
 * @param $post_id
 * @param string $term_seperator
 * @return string
 */
function rt_biz_contact_connection_to_string( $post_id, $term_seperator = ' , ' ) {
	global $rt_contact;
	return Rt_Entity::connection_to_string( $post_id, $rt_contact->post_type, $term_seperator );
}

/**
 * @param $post_id
 * @param string $term_seperator
 * @return string
 */
function rt_biz_company_connection_to_string( $post_id, $term_seperator = ' , ' ) {
	global $rt_company;
	return Rt_Entity::connection_to_string( $post_id, $rt_company->post_type, $term_seperator );
}

/**
 * @param $connected_items
 * @return mixed
 */
function rt_biz_get_company_to_contact_connection( $connected_items ) {
	$rt_biz = rtbiz();
	return $rt_biz->get_company_to_contact_connection( $connected_items );
}

/**
 * @return mixed
 */
function rt_biz_get_contact_capabilities() {
	global $rt_contact;
	return $rt_contact->get_post_type_capabilities();
}

/**
 * @return mixed
 */
function rt_biz_get_company_capabilities() {
	global $rt_company;
	return $rt_company->get_post_type_capabilities();
}

/**
 * Search contact
 *
 * @param $query
 * @return mixed
 */
function rt_biz_search_contact( $query, $args = array() ) {
	global $rt_contact;
	return $rt_contact->search( $query, $args );
}

/**
 *
 * @param $query
 * @return mixed
 */
function rt_biz_search_company( $query, $args = array() ) {
	global $rt_company;
	return $rt_company->search( $query, $args );
}

/**
 * @return mixed
 */
function rt_biz_get_contact_meta_fields() {
	global $rt_contact;
	return $rt_contact->meta_fields;
}

/**
 * @return mixed
 */
function rt_biz_get_company_meta_fields() {
	global $rt_company;
	return $rt_company->meta_fields;
}


function rt_biz_connect_contact_to_user( $from = '', $to = '' ){
	global $rt_contact;
	$rt_contact->connect_contact_to_user( $from, $to );
}

function rt_biz_remove_contact_to_user( $from = '', $to = '' ){
	global $rt_contact;
	$rt_contact->remove_contact_to_user( $from, $to );
}

/**
 * @return array|WP_Error
 */
function rt_biz_get_department() {
	$Department = get_terms( RT_Departments::$slug, array( 'hide_empty' => false ) );
	return $Department;
}

function rt_biz_get_module_department_users( $department_id, $category_slug = '', $module_key = '' ) {
	global $rt_contact;

	$department = get_term_by( 'id', $department_id, RT_Departments::$slug );

	$args = array(
		RT_Departments::$slug => $department->slug,
		'post_type'           => $rt_contact->post_type,
		'post_status'         => 'any',
		'nopaging'            => true,
	);

	if ( ! empty( $category_slug ) ) {
		$args = array_merge( $args, array( Rt_Contact::$user_category_taxonomy => $category_slug ) );
	}

	$contacts = get_posts( $args );

	$contact_ids = array();
	foreach ( $contacts as $contact ) {
		// module filter
		if ( ! empty( $module_key ) ) {
			$pp = get_post_meta( $contact->ID, 'rt_biz_profile_permissions', true );
			if ( isset( $pp[ $module_key ] ) && 0 == intval( $pp[ $module_key ] ) ) {
				continue;
			}
		}
		$contact_ids[] = $contact->ID;
	}

	if ( ! empty( $contact_ids ) ) {
		return rt_biz_get_wp_user_for_contact( $contact_ids );
	}
	return array();
}

function rt_biz_get_department_users( $department_id ) {
	global $rt_contact;
	$department = get_term_by( 'id', $department_id, RT_Departments::$slug );
	$contacts = get_posts( array(
		                       RT_Departments::$slug => $department->slug,
		                       'post_type'           => $rt_contact->post_type,
		                       'post_status'         => 'any',
		                       'nopaging'            => true,
	                       ) );
	$contact_ids = array();
	foreach ( $contacts as $contact ) {
		$contact_ids[] = $contact->ID;
	}

	if ( ! empty( $contact_ids ) ){
		return rt_biz_get_wp_user_for_contact( $contact_ids );
	}
	return array();
}

/**
 * @return mixed
 */
function rt_biz_get_acl_permissions() {
	return Rt_Access_Control::$permissions;
}

/**
 * @return mixed
 */
function rt_biz_get_modules() {
	return Rt_Access_Control::$modules;
}

/**
 * @param $module_key
 * @param string $role
 * @return string
 */
function rt_biz_get_access_role_cap( $module_key, $role = 'no_access' ) {
	return Rt_Access_Control::get_capability_from_access_role( $module_key, $role );
}

function rt_biz_get_employees() {
	global $rt_contact;
	return $rt_contact->get_contact_by_category( Rt_Contact::$employees_category_slug );
}

function rt_biz_get_customers() {
	global $rt_contact;
	return $rt_contact->get_contact_by_category( Rt_Contact::$customer_category_slug );
}

function rt_biz_get_vendors() {
	global $rt_contact;
	return $rt_contact->get_contact_by_category( Rt_Contact::$vendor_category_slug );
}

function rt_biz_get_companies() {
	global $rt_company;
	return $rt_company->get_company();
}

function rt_biz_search_employees( $query ) {
	$args = array(
		'tax_query' => array(
			'taxonomy' => Rt_Contact::$user_category_taxonomy,
			'field'    => 'slug',
			'terms'    => Rt_Contact::$employees_category_slug,
		),
	);
	return rt_biz_search_contact( $query, $args );
}

function rt_biz_get_module_users( $module_key ) {
	global $rt_access_control;
	return $rt_access_control->get_module_users( $module_key );
}

function rt_biz_get_module_employee( $module_key ) {
	global $rt_access_control;
	return $rt_access_control->get_module_users( $module_key, Rt_Contact::$employees_category_slug );
}

function rt_biz_get_module_customer( $module_key  ) {
	global $rt_access_control;
	return $rt_access_control->get_module_users( $module_key, Rt_Contact::$customer_category_slug );
}

function rt_biz_get_module_vendor( $module_key  ) {
	global $rt_access_control;
	return $rt_access_control->get_module_users( $module_key, Rt_Contact::$vendor_category_slug );
}

function rt_biz_get_contact_for_wp_user( $user_id ) {
	global $rt_contact;
	return $rt_contact->get_contact_for_wp_user( $user_id );
}

function rt_biz_get_wp_user_for_contact( $contact_id ) {
	global $rt_contact;
	return $rt_contact->get_wp_user_for_contact( $contact_id );
}

function rt_biz_get_user_department( $user_ID ) {
	$user_contacts = rt_biz_get_contact_for_wp_user( $user_ID );
	$ug_terms = array();
	if ( ! empty( $user_contacts ) ) {
		foreach ( $user_contacts as $contact ) {
			$temp_terms = wp_get_post_terms( $contact->ID, RT_Departments::$slug );
			$ug_terms = array_merge( $ug_terms, $temp_terms );
		}
	}
	return $ug_terms;

}

/**
 * wp1_text_diff
 *
 * @param      $left_string
 * @param      $right_string
 * @param null $args
 *
 * @return string
 * @since rt-BIZ
 */
function rtbiz_text_diff( $left_string, $right_string, $args = null ) {
	$defaults = array( 'title' => '', 'title_left' => '', 'title_right' => '' );
	$args     = wp_parse_args( $args, $defaults );

	$left_string  = normalize_whitespace( $left_string );
	$right_string = normalize_whitespace( $right_string );
	$left_lines   = explode( "\n", $left_string );
	$right_lines  = explode( "\n", $right_string );

	$renderer  = new Rt_Biz_Text_Diff();
	$text_diff = new Text_Diff( $left_lines, $right_lines );
	$diff      = $renderer->render( $text_diff );

	if ( ! $diff ) {
		return '';
	}

	$r = "<table class='diff' style='width: 100%;background: white;margin-bottom: 1.25em;border: solid 1px #dddddd;border-radius: 3px;margin: 0 0 18px;'>\n";
	$r .= "<col class='ltype' /><col class='content' /><col class='ltype' /><col class='content' />";

	if ( $args['title'] || $args['title_left'] || $args['title_right'] ) {
		$r .= '<thead>';
	}
	if ( $args['title'] ) {
		$r .= "<tr class='diff-title'><th colspan='4'>" . $args['title'] . '</th></tr>\n';
	}
	if ( $args['title_left'] || $args['title_right'] ) {
		$r .= "<tr class='diff-sub-title'>\n";
		$r .= "\t<td></td><th>{$args['title_left']}</th>\n";
		$r .= "\t<td></td><th>{$args['title_right']}</th>\n";
		$r .= "</tr>\n";
	}
	if ( $args['title'] || $args['title_left'] || $args['title_right'] ) {
		$r .= "</thead>\n";
	}
	$r .= "<tbody>\n$diff\n</tbody>\n";
	$r .= '</table>';

	return $r;
}

// Setting ApI
function biz_get_redux_settings() {
	if ( ! isset( $GLOBALS[ Rt_Biz_Setting::$biz_opt ] ) ) {
		$GLOBALS[ Rt_Biz_Setting::$biz_opt ] = get_option( Rt_Biz_Setting::$biz_opt, array() );
	}
	return $GLOBALS[ Rt_Biz_Setting::$biz_opt ];
}

function biz_is_primary_email_unique( $email ) {
	global $rt_contact;
	$meta_query_args = array(
		array(
			'key'   => Rt_Entity::$meta_key_prefix . $rt_contact->primary_email_key,
			'value' => $email,
		),
	);
	$posts = get_posts( array( 'post_type' => rt_biz_get_contact_post_type(), 'meta_query' => $meta_query_args ) );
	$count = count( $posts );
	if ( 0 == $count ) {
		return true;
	}
	return false;
}

function biz_is_primary_email_unique_company( $email ) {
	$meta_query_args = array(
		array(
			'key'     => Rt_Entity::$meta_key_prefix.Rt_Company::$primary_email,
			'value'   => $email,
		),
	);
	$posts = get_posts( array( 'post_type' => 'rt_account', 'meta_query' => $meta_query_args ) );
	$count = count( $posts );
	if ( 0 == $count ){
		return true;
	}
	return false;
}
