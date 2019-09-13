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
<div class="wpeo-modal modal-active">

	<div class="modal-container" style="text-align : center; max-width : 1200px; max-height: 800px">
		<!-- Entête -->
		<div class="modal-header">
			<h2 class="modal-title"><?php echo esc_html( "QrCode EPI " . $epi->data['id'] ); ?></h2>
		</div>

		<?php  echo do_shortcode( '[qrcode text="' . $url . '" eclevel=0  height=600 width=600 transparency=1]' ); ?>

		<!-- Footer -->
		<div class="modal-footer">
			<a class="wpeo-button button-grey button-uppercase modal-close"><span><?php echo esc_html( "Close" ); ?></span></a>
		</div>
	</div>
</div>
