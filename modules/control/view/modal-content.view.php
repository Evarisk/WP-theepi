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
	<div class="table-row table-header">
		<div class="table-cell table-75" data-title="<?php esc_attr_e( 'ID', 'theepi' ); ?>"><?php esc_html_e( 'ID', 'theepi' ); ?></div>
		<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Avatar', 'theepi' ); ?>"><?php esc_html_e( 'Avatar', 'theepi' ); ?></div>
		<div class="table-cell table-125" data-title="<?php esc_attr_e( 'Date', 'theepi' ); ?>"><?php esc_html_e( 'Date', 'theepi' ); ?></div>
		<div class="table-cell" data-title="<?php esc_attr_e( 'Comment', 'theepi' ); ?>">  <?php esc_html_e( 'Comment', 'theepi' ); ?></div>
		<div class="table-cell table-200" data-title="<?php esc_attr_e( 'URL', 'theepi' ); ?>"><?php esc_html_e( 'URL', 'theepi' ); ?></div>
		<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Attached File', 'theepi' ); ?>"><?php esc_html_e( 'Attached File', 'theepi' ); ?></div>
		<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Status', 'theepi' ); ?>"><?php esc_html_e( 'Status', 'theepi' ); ?></div>
		<?php if ( $type == 'add_control' ) : ?>
		<div class="table-cell table-125 table-end" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>"><?php esc_html_e( 'Actions', 'theepi' ); ?></div>
		<?php endif; ?>
	</div>

	<div class="tab-container control-epi">
		<?php Control_Class::g()->display_control_list( $epi, $frontend, $type ); ?>
	</div>

	<!-- <div clas="pagination epi-control" style="margin-top: 20px"> //v0.8.0
		<?php // Control_Class::g()->display_epi_pagination( $offset, $page ); ?>
	</div> -->
</div>
