<?php
/**
 * Affichage pour gérer les capacités des utilisateurs.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.4.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="section-capability">
	<input type="hidden" name="action" value="save_capability_theepi" />
	<?php wp_nonce_field( 'save_capability_theepi' ); ?>

	<h3><?php esc_html_e( 'Handle role TheEPI', 'theepi' ); ?></h3>

	<p><?php esc_html_e( 'Set access rights to the TheEPI app', 'theepi' ); ?></p>

	<?php Setting_Class::g()->display_role_has_cap(); ?>

	<?php do_shortcode( '[digi-search icon="dashicons dashicons-search" next-action="display_setting_user_theepi" type="user" target="list-users"]' ); ?>

	<?php Setting_Class::g()->display_user_list_capacity(); ?>

	<div class="wpeo-button button-green button-progress action-input" data-parent="section-capability">
		<span><?php esc_html_e( 'Save', 'theepi' ); ?></span>
	</div>
</div>
