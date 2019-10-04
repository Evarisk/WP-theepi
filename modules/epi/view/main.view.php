<?php
/**
 * La vue principale qui s'occupe de la Navigation des EPI + Affichage du tableau et son contene.
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

<div class="wpeo-tab epi">
	<ul class="tab-list tab-redirect" style="float: left">
		<li class="tab-element <?php echo $page == "all" ? 'tab-active' : ''; ?>" data-tab="all" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=all' ) ); ?> "> <i class="fas fa-list fa-2x" style="color : #0084ff"></i> </li>
		<li class="tab-element <?php echo $page == "ok" ? 'tab-active' : ''; ?>" data-tab="ok" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=ok' ) ); ?>"> <i class="fas fa-check-circle fa-2x" style="color: mediumspringgreen;"></i></li>
		<li class="tab-element <?php echo $page == "ko" ? 'tab-active' : ''; ?>" data-tab="ko" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=ko' ) ); ?>"> <i class="fas fa-exclamation-circle fa-2x" style="color: red;"></i></li>
		<li class="tab-element <?php echo $page == "repair" ? 'tab-active' : ''; ?>" data-tab="repair" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=repair' ) ); ?>"> <i class="fas fa-tools fa-2x" style="color: orange;"></i></li>
		<li class="tab-element <?php echo $page == "trash" ? 'tab-active' : ''; ?>" data-tab="trash" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi&tab=trash' ) ); ?>"> <i class="fas fa-trash fa-2x" style="color: black;"></i></li>
	</ul>

	<?php EPI_Class::g()->display_search(); ?>

	<div class="wpeo-table table-flex epi">
		<div class="table-row table-header" style="background-color : #0084ff">
			<div class="table-cell table-75" style="text-align : center;" data-title="<?php esc_attr_e( 'ID', 'theepi' ); ?>"><span><?php esc_html_e( 'ID', 'theepi' ); ?></span></div>
			<div class="table-cell table-100" style="text-align : center;" data-title="<?php esc_attr_e( 'Image', 'theepi' ); ?>"><span><?php esc_html_e( 'Image', 'theepi' ); ?></span></div>
			<div class="table-cell table-75" style="text-align : center;" data-title="<?php esc_attr_e( 'Quantity', 'theepi' ); ?>"><span><?php esc_html_e( 'Quantity', 'theepi' ); ?></span></div>
			<div class="table-cell table-200" style="text-align : center;" data-title="<?php esc_attr_e( 'Serial Number', 'theepi' ); ?>"><i class="fas fa-barcode"></i> <?php esc_html_e( 'Serial Number', 'theepi' ); ?></span></div>
			<div class="table-cell table-75" style="text-align : center;" data-title="<?php esc_attr_e( 'Code QrCode', 'theepi' ); ?>"><span><?php esc_html_e( 'Code QrCode', 'theepi' ); ?></span></div>
			<div class="table-cell" style="max-width: 375px;" data-title="<?php esc_attr_e( 'Title', 'theepi' ); ?>"><span><?php esc_html_e( 'Title', 'theepi' ); ?></span></div>
			<div class="table-cell table-200" data-title="<?php esc_attr_e( 'Last Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Last Control', 'theepi' ); ?></span></div>
			<div class="table-cell table-150" style="text-align : center;" data-title="<?php esc_attr_e( 'Next Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Next Control', 'theepi' ); ?></span></div>
			<div class="table-cell table-150" style="text-align : center;" data-title="<?php esc_attr_e( 'Status EPI', 'theepi' ); ?>"><span><?php esc_html_e( 'Status EPI', 'theepi' ); ?></span></div>
			<div class="table-cell table-end" style="text-align : center;" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>"><span><?php esc_html_e( 'Actions', 'theepi' ); ?></span></div>
		</div>

		<div class="tab-container">
			<?php EPI_Class::g()->display_epi_list( $epis, false, $page ); ?>
		</div>
	</div>

	<div clas="pagination epi" style="margin-top: 20px">
		<?php EPI_Class::g()->display_epi_pagination( $offset, $page ); ?>
	</div>
</div>
