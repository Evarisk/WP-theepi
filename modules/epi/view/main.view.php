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
}

/**
* Documentation des variables utilisées dans la vue.
*
* @var array  $epis    Les données des EPIS.
* @var string $page    La page active en focntion du filtre.
* @var integer $offset  L'epi de départ pour la pagination.
*/
?>

<div class="wpeo-tab epi">

	<div class="epi-filter-bar">
		<?php EPI_Class::g()->display_filters( $page ); ?>
		<?php EPI_Class::g()->display_search(); ?>
	</div>

	<div class="wpeo-table table-flex epi">
		<div class="table-row table-header">
			<div class="table-cell table-100" data-title="<?php esc_attr_e( 'ID', 'theepi' ); ?>"><span><?php esc_html_e( 'ID', 'theepi' ); ?></span></div>
			<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Image', 'theepi' ); ?>"><span><?php esc_html_e( 'Image', 'theepi' ); ?></span></div>
			<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Quantity', 'theepi' ); ?>"><span><?php esc_html_e( 'Quantity', 'theepi' ); ?></span></div>
			<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Code QrCode', 'theepi' ); ?>"><span><?php esc_html_e( 'Code QrCode', 'theepi' ); ?></span></div>
			<div class="table-cell table-150" data-title="<?php esc_attr_e( 'Serial Number', 'theepi' ); ?>"><i class="fas fa-barcode"></i> <?php esc_html_e( 'Serial Number', 'theepi' ); ?></span></div>
			<div class="table-cell" data-title="<?php esc_attr_e( 'Title', 'theepi' ); ?>"><span><?php esc_html_e( 'Title', 'theepi' ); ?></span></div>
			<div class="table-cell table-100" data-title="<?php esc_attr_e( 'Manager', 'theepi' ); ?>"><span><?php esc_html_e( 'Manager', 'theepi' ); ?></span></div>
			<div class="table-cell table-150" data-title="<?php esc_attr_e( 'Last Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Last Control', 'theepi' ); ?></span></div>
			<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Add Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Add Control', 'theepi' ); ?></span></div>
			<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Next Control', 'theepi' ); ?>"><span><?php esc_html_e( 'Next Control', 'theepi' ); ?></span></div>
			<div class="table-cell table-75" data-title="<?php esc_attr_e( 'Status', 'theepi' ); ?>"><span><?php esc_html_e( 'Status', 'theepi' ); ?></span></div>
			<div class="table-cell table-100 table-end" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>"><span><?php esc_html_e( 'Actions', 'theepi' ); ?></span></div>
		</div>

		<div class="tab-container">
			<?php EPI_Class::g()->display_epi_list( $epis, false, $page ); ?>
		</div>
	</div>

	<div class="pagination epi">
		<?php EPI_Class::g()->display_epi_pagination( $offset, $page ); ?>
	</div>
</div>
