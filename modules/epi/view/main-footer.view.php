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
