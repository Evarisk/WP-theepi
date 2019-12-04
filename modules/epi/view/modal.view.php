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
}

/**
* Documentation des variables utilisées dans la vue.
*
* @var EPI_Model  $epi  La donnée d'un EPI.
* @var string $url      L'url de l'EPI pour accéder a sa page frontend.
*/
?>

<!-- Structure -->
<div class="wpeo-modal modal-qr-code modal-active" style="z-index: 10">

	<div class="modal-container">
		<!-- Entête -->
		<div class="modal-header">
			<h2 class="modal-title"><?php echo esc_html( 'QrCode EPI ' . $epi->data['id'] ); ?></h2>
			<div class="modal-close"><i class="fas fa-times"></i></div>
		</div>

		<div class="modal-content">
			<?php echo do_shortcode( '[qrcode text="' . $url . '" id="' . $epi->data['id'] . '" transparency=1]' ); ?>
		</div>

		<!-- Footer -->
		<div class="modal-footer">
			<span> <?php echo esc_html( 'QrCode link : ' ); ?> </span>
			<a href="<?php echo esc_html( $url ); ?>" target="_blank"><?php echo esc_html( $url ); ?></a>
			<a class="wpeo-button button-grey button-uppercase modal-close"><span><?php echo esc_html_e( 'Close', 'theepi' ); ?></span></a>
		</div>
	</div>
</div>
