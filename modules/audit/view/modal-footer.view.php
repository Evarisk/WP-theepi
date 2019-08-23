<?php
/**
 * La vue déclarant le modal audit.
 *
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @since     0.5.0
 * @version   0.5.0
 * @copyright 2019 Evarisk
 * @package   TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<ul style="display : flex">
	<li>
			<i class="fas fa-link" style="color : LightSlateGrey"></i>
	</li>

	<li>
		<span> #<?php echo esc_attr( $epi->data['id'] ); ?></span> </br>
		<span style="color : gray"> <i class="fas fa-plug" style="color : gray"></i> EPI </span>
	</li>

	<li>
		<span> <?php echo do_shortcode( '[wpeo_upload id="' . $epi->data['id'] . '" model_name="/theepi/EPI_Class" single="false" field_name="image" ]' ); ?></span>
	</li>

	<li>
		<span style="color : rgb(0,132,255)"> <?php echo esc_attr( $epi->data['title'] ); ?></span> </br>
		<span style="color : gray"> <i class="fas fa-barcode"></i> <?php echo esc_attr( $epi->data['reference'] ); ?></span>
	</li>

	<li>
		<span> <?php if ( Audit_Class::g()->get_status( $epi ) ) : ?>
			<i class="fas fa-check-circle fa-2x" style="color: mediumspringgreen;"></i>
	<?php else : ?>
			<i class="fas fa-exclamation-circle fa-2x" style="color: red;"></i>
	<?php endif; ?> </span>
	</li>
</ul>

<div     class="wpeo-button button-main button-size-large button-uppercase action-attribute modal-close"
	data-id="<?php echo esc_attr( $audit->data['parent_id'] ); ?>"
	data-action="valid_audit"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'valid_audit' ) ); ?>"
	data-status-epi="<?php echo esc_attr( $epi->data['status_epi'] ); ?>">
	<span><?php esc_html_e( 'Validate the control', 'theepi' ); ?></span>
</div>
