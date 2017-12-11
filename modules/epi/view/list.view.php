<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
if ( ! empty( $epi_list ) ) :
	foreach ( $epi_list as $epi ) :
		\eoxia\View_Util::exec( 'theepi', 'epi', 'item', array(
			'epi' => $epi,
		) );
	endforeach;
endif;
?>

<!-- Pagination -->
<?php if ( ! empty( $current_page ) && ! empty( $number_page ) ) : ?>
	<div class="pagination">
		<?php
		echo paginate_links( array(
			'base'               => admin_url( 'admin-ajax.php?action=theepi&current_page=%_%' ),
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
