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

<div class="wpeo-tab epi">
	<ul class="tab-list tab-redirect" style="float: left">
		<li class="tab-element <?php echo $page == "all" ? 'tab-active' : ''; ?>" data-tab="all" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=all' ) ); ?>"> <i class="fas fa-list fa-2x"></i> </li>
		<li class="tab-element <?php echo $page == "ok" ? 'tab-active' : ''; ?>" data-tab="ok" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=ok' ) ); ?>"> <i class="fas fa-check-circle fa-2x" style="color: mediumspringgreen;"></i></li>
		<li class="tab-element <?php echo $page == "ko" ? 'tab-active' : ''; ?>" data-tab="ko" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=ko' ) ); ?>"> <i class="fas fa-exclamation-circle fa-2x" style="color: red;"></i></li>
		<li class="tab-element <?php echo $page == "rebut" ? 'tab-active' : ''; ?>" data-tab="rebut" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=rebut' ) ); ?>"> <i class="fas fa-trash fa-2x" style="color: black;"></i></li>
	</ul>

	<?php EPI_Class::g()->display_search(); ?>

	<div class="wpeo-table table-flex epi">
		<div class="table-row table-header">
			<div class="table-cell table-100 padding" data-title="<?php esc_attr_e( 'Image', 'theepi' ); ?>"><span><?php esc_html_e( 'Image', 'theepi' ); ?></span></div>
			<div class="table-cell table-150 padding" style="text-align : center" data-title="<?php esc_attr_e( 'Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Control', 'theepi' ); ?></span></div>
			<div class="table-cell table-300" data-title="<?php esc_attr_e( 'Title', 'theepi' ); ?>"><span><?php esc_html_e( 'Title', 'theepi' ); ?></span></div>
			<div class="table-cell table-200" style="text-align : center" data-title="<?php esc_attr_e( 'Serial Number', 'theepi' ); ?>"><i class="fas fa-barcode"></i> <?php esc_html_e( 'Serial Number', 'theepi' ); ?></span></div>
			<div class="table-cell table-250" style="text-align : center" data-title="<?php esc_attr_e( 'Commissioning Date', 'theepi' ); ?>"><span><?php esc_html_e( 'Commissioning Date', 'theepi' ); ?></span></div>
			<div class="table-cell" style="text-align : center" data-title="<?php esc_attr_e( 'Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Control', 'theepi' ); ?></span></div>
			<div class="table-cell" style="text-align : center" data-title="<?php esc_attr_e( 'Status', 'theepi' ); ?>"><span><?php esc_html_e( 'Status', 'theepi' ); ?></span></div>
			<div class="table-cell table-end" style="text-align : center" data-title="<?php esc_attr_e( 'Life Sheet', 'theepi' ); ?>"><span><?php esc_html_e( 'Life Sheet', 'theepi' ); ?></span></div>
		</div>


		<div class="tab-container">
			<?php EPI_Class::g()->display_epi_list( $epis, false, $page ); ?>
		</div>
	</div>

	<div class="wpeo-button button-main action-attribute button-size-large epi-load-more <?php echo esc_attr( ( ( $offset + $per_page ) >= $count_epi ) ? 'button-disable' : '' ); ?>"
		data-action="load_more_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_more_epi' ) ); ?>"
		data-offset="<?php echo esc_attr( $offset + $per_page ); ?>"
		data-term="">
		<span>
			<span><?php esc_html_e( 'Load more', 'theepi' ); ?></span>
			&nbsp;
			(<span class="number-epi"><?php echo esc_attr( $offset + $per_page ); ?></span>/<span class="total-number-epi"><?php echo esc_attr( $count_epi ); ?></span>)
		</span>
	</div>

	<div class="wpeo-button button-light scroll-top"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i></div>
</div>
