<?php
/**
 * La vue modal qui s'occupe d'agrandir le QrCode.
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

<!-- Structure -->
<div class="wpeo-modal modal-qr-code modal-active">

	<div class="modal-container">
		<!-- Entête -->
		<div class="modal-header">
			<h2 class="modal-title"><?php echo esc_html( "QrCode EPI " . $epi->data['id'] ); ?></h2>
			<div class="modal-close"><i class="fas fa-times"></i></div>
		</div>

		<div class="modal-content">
			<?php echo do_shortcode( '[qrcode text="' . $url . '" id="'. $epi->data['id'] .'" eclevel=0  height=500 width=500 transparency=1]' ); ?>
		</div>

		<!-- Footer -->
		<div class="modal-footer">
			<span> <?php echo esc_html( "QrCode link :   " . $url ); ?> </span>
			<a class="wpeo-button button-grey button-uppercase modal-close"><span><?php echo esc_html( "Close" ); ?></span></a>
		</div>
	</div>
</div>
