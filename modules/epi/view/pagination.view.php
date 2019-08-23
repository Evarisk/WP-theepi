<?php
/**
 * La vue déclarant le tableau HTML des EPI.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com>
 * @copyright 2017 Evarisk
 * @since     0.2.0
 * @version   0.4.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php if ( ! empty( $current_page ) && ! empty( $number_page ) ) : ?>
	<div class="wp-digi-pagination">
	<?php
	echo paginate_links(
		array(
			'base'               => admin_url( 'admin-ajax.php?action=theepi-setting&current_page=%_%' ),
			'format'             => '%#%',
			'current'            => $current_page,
			'total'              => $number_page,
			'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'theepi' ) . ' </span>',
			'type'               => 'plain',
			'next_text'          => '<i class="dashicons dashicons-arrow-right"></i>',
			'prev_text'          => '<i class="dashicons dashicons-arrow-left"></i>',
		)
	);
	?>
	</div>
<?php endif; ?>
