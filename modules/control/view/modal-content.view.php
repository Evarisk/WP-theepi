<?php
/**
 * La vue contenue déclarant le modal contrôle.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<!-- Corps -->
<div class="wpeo-table table-flex control-epi">
	<div class="table-row table-header" style="background-color : #0084ff">
		<div class="table-cell table-100" style="text-align : center;" data-title="<?php esc_attr_e( 'ID', 'theepi' ); ?>"><span><?php esc_html_e( 'ID', 'theepi' ); ?></span></div>
		<div class="table-cell table-100" style="text-align : center;" data-title="<?php esc_attr_e( 'Avatar', 'theepi' ); ?>"><span><?php esc_html_e( 'Avatar', 'theepi' ); ?></span></div>
		<div class="table-cell table-150" data-title="<?php esc_attr_e( 'Date', 'theepi' ); ?>"><span><?php esc_html_e( 'Date', 'theepi' ); ?></span></div>
		<div class="table-cell table-300" data-title="<?php esc_attr_e( 'Comment', 'theepi' ); ?>"> <span> <?php esc_html_e( 'Comment', 'theepi' ); ?></span></div>
		<div class="table-cell table-300" data-title="<?php esc_attr_e( 'URL', 'theepi' ); ?>"><span><?php esc_html_e( 'URL', 'theepi' ); ?></span></div>
		<div class="table-cell table-100" style="text-align : center;" data-title="<?php esc_attr_e( 'Attached File', 'theepi' ); ?>"><span><?php esc_html_e( 'Attached File', 'theepi' ); ?></span></div>
		<div class="table-cell table-100" style="text-align : center;" data-title="<?php esc_attr_e( 'Status', 'theepi' ); ?>"><span><?php esc_html_e( 'Status', 'theepi' ); ?></span></div>
		<div class="table-cell table-end" style="text-align : center;" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>"><span><?php esc_html_e( 'Actions', 'theepi' ); ?></span></div>
	</div>

	<div class="tab-container control-epi">
		<div class="new-row-control-epi">

		</div>
		<?php Control_Class::g()->display_control_list( $epi, $frontend ) ?>
	</div>

	<!-- <div clas="pagination epi-control" style="margin-top: 20px"> //v0.8.0 
		<?php // Control_Class::g()->display_epi_pagination( $offset, $page ); ?>
	</div> -->
</div>
