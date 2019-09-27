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
		<div>
			<input type="checkbox" name="users[<?php echo esc_attr( $user->data['id'] ); ?>][create_theepi]"
			id="create_theepi_<?php echo esc_attr( $user->data['id'] ); ?>"
			<?php  echo  ( $user->wordpress_user->has_cap( 'create_theepi' ) ) ? 'checked' : ""; ?> >
			<label for="create_theepi_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Create', 'theepi' ); ?></label>
			</input>
		</div>

		<div>
			<input type="checkbox" name="users[<?php echo esc_attr( $user->data['id'] ); ?>][read_theepi]"
			id="read_theepi_<?php echo esc_attr( $user->data['id'] ); ?>"
			<?php  echo  ( $user->wordpress_user->has_cap( 'read_theepi' ) ) ? 'checked' : ""; ?> />
			<label for="read_theepi_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Read', 'theepi' ); ?></label>
		</div>

		<div>
			<input type="checkbox" name="users[<?php echo esc_attr( $user->data['id'] ); ?>][update_theepi]"
			id="update_theepi_<?php echo esc_attr( $user->data['id'] ); ?>"
			<?php  echo  ( $user->wordpress_user->has_cap( 'update_theepi' ) ) ? 'checked' : ""; ?> />
			<label for="update_theepi_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Update', 'theepi' ); ?></label>
		</div>

		<div>
			<input type="checkbox" name="users[<?php echo esc_attr( $user->data['id'] ); ?>][delete_theepi]"
			id="delete_theepi_<?php echo esc_attr( $user->data['id'] ); ?>"
			<?php  echo  ( $user->wordpress_user->has_cap( 'delete_theepi' ) ) ? 'checked' : ""; ?> />
			<label for="delete_theepi_<?php echo esc_attr( $user->data['id'] ); ?>"><?php esc_html_e( 'Delete', 'theepi' ); ?></label>
		</div>
	</div>
</div>
