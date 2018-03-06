<?php
/**
 * Handle main helpers.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Construit l'identifiant unique d'un modèle
 *
 * @since 0.1.0
 * @version 0.4.0
 *
 * @param  array  $data Les données du modèle.
 * @return object       Les données du modèle avec l'identifiant
 */
function construct_identifier( $data, $args ) {
	$model_name      = $args['model_name'];
	$controller_name = str_replace( 'model', 'class', $model_name );
	$controller_name = str_replace( 'Model', 'Class', $controller_name );
	$next_identifier = get_last_unique_key( $controller_name );

	$next_identifier++;
	if ( ! isset( $data['unique_key'] ) || empty( $data['unique_key'] ) ) {
		$data['unique_key'] = $next_identifier;
	}
	if ( ! isset( $data['unique_identifier'] ) || empty( $data['unique_identifier'] ) ) {
		$data['unique_identifier'] = $controller_name::g()->element_prefix . $next_identifier;
	}

	return $data;
}

/**
 * Remplaces l'identifiant du modèle par l'identifiant personnalisé qui se trouve dans la BDD
 *
 * @since 0.1.0
 * @version 0.4.0
 *
 * @param  object $data Les données du modèle.
 * @return object       Les données du modèle avec l'identifiant personnalisé
 */
function get_identifier( $object, $args ) {
	$object->data = construct_identifier( $object->data, $args );
	return $object;
}

/**
 * Renvoie la dernière clé unique selon le type de l'élement
 *
 * @since 0.1.0
 * @version 0.1.0
 *
 * @param string $controller   Le controller.
 *
 * @return integer             L'identifiant unique
 */
function get_last_unique_key( $controller ) {
	$element_type = $controller::g()->get_type();
	$wp_type      = $controller::g()->get_identifier_helper();

	if ( empty( $wp_type ) || empty( $element_type ) || ! is_string( $wp_type ) || ! is_string( $element_type ) ) {
		return false;
	}

	global $wpdb;
	switch ( $wp_type ) {
		case 'post':
			$query = $wpdb->prepare(
				"SELECT max( PM.meta_value + 0 )
				FROM {$wpdb->postmeta} AS PM
					INNER JOIN {$wpdb->posts} AS P ON ( P.ID = PM.post_id )
				WHERE PM.meta_key = %s
					AND P.post_type = %s", '_theepi_unique_key', $element_type );

		break;

		case 'comment':
			$query = $wpdb->prepare(
				"SELECT max( CM.meta_value + 0 )
				FROM {$wpdb->commentmeta} AS CM
					INNER JOIN {$wpdb->comments} AS C ON ( C.comment_ID = CM.comment_id )
				WHERE CM.meta_key = %s
					AND C.comment_type = %s", '_theepi_unique_key', $element_type );
		break;

		case 'user':
			$query = $wpdb->prepare(
				"SELECT max( UM.meta_value + 0 )
				FROM {$wpdb->usermeta} AS UM
				WHERE UM.meta_key = %s", '_theepi_unique_key' );
		break;

		case 'term':
			$query = $wpdb->prepare(
				"SELECT max( TM.meta_value + 0 )
				FROM {$wpdb->term_taxonomy} AS T
					INNER JOIN {$wpdb->termmeta} AS TM ON ( T.term_id = TM.term_id )
				WHERE TM.meta_key = %s AND T.taxonomy=%s", '_theepi_unique_key', $element_type );
		break;
	}

	if ( ! empty( $query ) ) {
		$last_unique_key = $wpdb->get_var( $query );
	}

	if ( empty( $last_unique_key ) ) {
		return 0;
	}

	return $last_unique_key;
}
