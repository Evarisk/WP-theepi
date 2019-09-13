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

<div class="wpeo-table table-flex setting">
	<div class="table-row table-header" style="background-color : #0084ff">
		<div class="table-cell table-300" data-title="<?php esc_attr_e( 'ID', 'theepi' ); ?>"><?php esc_html_e( 'ID', 'theepi' ); ?></div>
		<div class="table-cell table-300" data-title="<?php esc_attr_e( 'Email', 'theepi' ); ?>"><?php esc_html_e( 'Email', 'theepi' ); ?></div>
		<div class="table-cell table-300" data-title="<?php esc_attr_e( 'Role', 'theepi' ); ?>"><?php esc_html_e( 'Role', 'theepi' ); ?></div>
		<div class="table-cell" data-title="<?php esc_attr_e( 'Has the right on TheEPI', 'theepi' ); ?>"><?php esc_html_e( 'Has the right on TheEPI', 'theepi' ); ?></div>
	</div>

	<div class="table-container">
		<?php
		if ( ! empty( $users ) ) :
			foreach ( $users as $user ) :
				\eoxia\View_Util::exec(
					'theepi', 'setting', 'capability/list-item', array(
						'user'                 => $user,
						'has_capacity_in_role' => $has_capacity_in_role,
					)
				);
			endforeach;
		endif;
		?>
	</div>
	<!-- pagination -->
</div>
