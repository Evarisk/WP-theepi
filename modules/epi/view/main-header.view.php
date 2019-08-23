<?php
/**
 * La vue déclarant le tableau HTML des EPI.
 *
 * @package   TheEPI
 * @audivor    Jimmy Latour <jimmy@evarisk.com>
 * @copyright 2017 Evarisk
 * @since     0.2.0
 * @version   0.5.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-table table-flex epi">
	<div class="table-row table-header">
		<div class="table-cell table-100 padding" style="text-align : center" data-title="<?php esc_attr_e( 'Image', 'theepi' ); ?>"><span><?php esc_html_e( 'Image', 'theepi' ); ?></span></div>
		<div class="table-cell table-150 padding" style="text-align : center" data-title="<?php esc_attr_e( 'Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Control', 'theepi' ); ?></span></div>
		<div class="table-cell" data-title="<?php esc_attr_e( 'Title', 'theepi' ); ?>"><span><?php esc_html_e( 'Title', 'theepi' ); ?></span></div>
		<div class="table-cell table-200" style="text-align : center" data-title="<?php esc_attr_e( 'Reference', 'theepi' ); ?>"><i class="fas fa-barcode"></i> <?php esc_html_e( 'Reference', 'theepi' ); ?></span></div>
		<div class="table-cell table-100" style="text-align : center" data-title="<?php esc_attr_e( 'Periodicity', 'theepi' ); ?>"><span><?php esc_html_e( 'Periodicity', 'theepi' ); ?></span></div>
		<div class="table-cell" style="text-align : center" data-title="<?php esc_attr_e( 'Last Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Last Control', 'theepi' ); ?></span></div>
		<div class="table-cell table-end" style="text-align : center" data-title="<?php esc_attr_e( 'Status', 'theepi' ); ?>"><span><?php esc_html_e( 'Status', 'theepi' ); ?></span></div>
	</div>
