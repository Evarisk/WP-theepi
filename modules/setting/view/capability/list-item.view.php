<?php
/**
 * Affichage de la liste des utilisateurs pour affecter les capacités
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com>
 * @copyright 2015-2017 Evarisk
 * @since     0.2.0
 * @version   0.4.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr class="user-row wpeo-form">
	<td class="padding" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>"><span><strong><?php echo esc_html( \eoxia\User_Class::g()->element_prefix . $user->id ); ?><strong></span></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Email', 'theepi' ); ?>"><span><?php echo esc_html( $user->email ); ?></span></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Role', 'theepi' ); ?>"><span><?php echo esc_html( implode( ', ', $user->wordpress_user->roles ) ); ?></span></td>
	<td class="padding" data-title="<?php echo esc_attr_e( 'Has the right on TheEPI', 'theepi' ); ?>">
		<div class="form-element">
			<input <?php echo ( $has_capacity_in_role ) ? 'disabled' : ''; ?>
				<?php echo ( $user->wordpress_user->has_cap( 'manage_theepi' ) ) ? 'checked' : ''; ?>
				name="users[<?php echo esc_attr( $user->id ); ?>][capability]"
				id="have_capability_<?php echo esc_attr( $user->id ); ?>"
				type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->id ); ?>"><?php esc_html_e( 'Right to TheEPI', 'theepi' ); ?></label>
			</div>
	</td>
</tr>
