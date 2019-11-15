<?php
/**
 * Affichage pour gérer les capacités des utilisateurs.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.2.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Documentation des variables utilisées dans la vue.
*
* @var string $page La page Capacité.
*/
?>

<div class="setting-epi"  data-page="<?php echo esc_attr( $page ); ?>">
	<input type="hidden" name="action" value="save_capability_theepi" />
	<?php wp_nonce_field( 'save_capability_theepi' ); ?>

	<h3><?php esc_html_e( 'Handle role TheEPI', 'theepi' ); ?></h3>

	<p><?php esc_html_e( 'Set access rights to the TheEPI app', 'theepi' ); ?></p>

	<?php Setting_Class::g()->display_role_has_cap(); ?>

	<?php do_shortcode( '[digi-search icon="dashicons dashicons-search" next-action="display_setting_user_theepi" type="user" target="list-users"]' ); ?>

	<?php Setting_Class::g()->display_user_list_capacity(); ?>

	<div class="wpeo-button button-green button-progress button-disable action-input" data-parent="setting-epi" style="margin-top : 20px">
		<span class="button-icon fas fa-save"></span>
	</div>
</div>
