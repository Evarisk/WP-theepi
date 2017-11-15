<?php
/**
 * Affichage pour gérer les capacités des utilisateurs.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="section-capability">
	<input type="hidden" name="action" value="save_capability_epi" />
	<?php wp_nonce_field( 'save_capabilitye_pi' ); ?>

	<h3><?php esc_html_e( 'Gestion des droits de DigiRisk EPI', 'digirisk-epi' ); ?></h3>

	<p><?php esc_html_e( 'Définissez les droits d\'accés à l\'application DigiRisk EPI', 'digirisk-epi' ); ?></p>

	<?php Setting_Class::g()->display_role_has_cap(); ?>

	<?php do_shortcode( '[digi-search icon="dashicons dashicons-search" next-action="display_setting_user_epi" type="user" target="list-users"]' ); ?>

	<?php Setting_Class::g()->display_user_list_capacity(); ?>

	<a href="#" class="margin action-input button blue right" data-parent="section-capability"><?php esc_html_e( 'Enregistrer', 'digirisk-epi' ); ?></a>
</div>
