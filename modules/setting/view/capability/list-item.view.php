<?php
/**
 * Affichage de la liste des utilisateurs pour affecter les capacités.
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
} ?>

<div class="table-row setting">
	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<span><strong><?php echo esc_html( \eoxia\User_Class::g()->element_prefix . $user->data['id'] ); ?></strong></span>
	</div>

	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'Email', 'theepi' ); ?>">
		<span><?php echo esc_html( $user->data['email'] ); ?></span>
	</div>

	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'Role', 'theepi' ); ?>">
		<span><?php echo esc_html( implode( ', ', $user->wordpress_user->roles ) ); ?></span>
	</div>

	<div class="table-cell" data-title="<?php echo esc_attr_e( 'Has the right on TheEPI', 'theepi' ); ?>">
		<div class="form-element">
			<input <?php echo ( $has_capacity_in_role ) ? 'disabled' : ''; ?> <?php echo ( $user->wordpress_user->has_cap( 'manage_theepi' ) ) ? 'checked' : ''; ?>
				name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability]"
				id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"
				type="checkbox" />
			<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Right to TheEPI', 'theepi' ); ?></label>

			<input <?php echo ( $has_capacity_in_role ) ? 'disabled' : ''; ?>
				name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability]" id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"
				type="checkbox" checked/>
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Create', 'theepi' ); ?></label>

			<input <?php echo ( $has_capacity_in_role ) ? 'disabled' : ''; ?>
				name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability]"
				id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"
				type="checkbox" />
				<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Read', 'theepi' ); ?></label>

					<input <?php echo ( $has_capacity_in_role ) ? 'disabled' : ''; ?>
						<?php echo ( $user->wordpress_user->has_cap( 'manage_theepi' ) ) ? 'checked' : ''; ?>
						name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability]"
						id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"
						type="checkbox" />
						<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Update', 'theepi' ); ?></label>

						<input <?php echo ( $has_capacity_in_role ) ? 'disabled' : ''; ?>
							<?php echo ( $user->wordpress_user->has_cap( 'manage_theepi' ) ) ? 'checked' : ''; ?>
							name="users[<?php echo esc_attr( $user->data['id'] ); ?>][capability]"
							id="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"
							type="checkbox" />
							<label for="have_capability_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Delete', 'theepi' ); ?></label>
		</div>
	</div>
</div>
