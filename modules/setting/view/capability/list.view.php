<?php
/**
 * Affichage de la liste des utilisateurs pour affecter les capacités
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.2.0
 * @version 0.2.0
 * @copyright 2015-2017 Evarisk
 * @package TheEPI-EPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="list-users">
	<table class="table users">
		<thead>
			<tr>
				<td class="w50"></td>
				<td class="w50 padding"><?php esc_html_e( 'ID', 'theepi' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Email', 'theepi' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Role', 'theepi' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Has the right on TheEPI', 'theepi' ); ?></td>
			</tr>
		</thead>
		<?php
		if ( ! empty( $users ) ) :
			foreach ( $users as $user ) :
				\eoxia\View_Util::exec( 'theepi', 'setting', 'capability/list-item', array(
					'user'                 => $user,
					'has_capacity_in_role' => $has_capacity_in_role,
				) );
			endforeach;
		endif;
		?>
	</table>

	<!-- Pagination -->
	<?php if ( ! empty( $current_page ) && ! empty( $number_page ) ) : ?>
		<div class="wp-digi-pagination">
			<?php
			echo paginate_links( array(
				'base'               => admin_url( 'admin-ajax.php?action=theepi-setting&current_page=%_%' ),
				'format'             => '%#%',
				'current'            => $current_page,
				'total'              => $number_page,
				'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'theepi' ) . ' </span>',
				'type'               => 'plain',
				'next_text'          => '<i class="dashicons dashicons-arrow-right"></i>',
				'prev_text'          => '<i class="dashicons dashicons-arrow-left"></i>',
			) );
			?>
		</div>
	<?php endif; ?>
</div>
