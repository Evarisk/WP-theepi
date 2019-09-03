<?php
/**
 * Affichage pour gérer les données par défaut.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.3.0
 * @version   0.6.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<form class="wpeo-form" data-page="<?php echo esc_attr( $page ); ?>" >
	<input type="hidden" name="action" value="save_default_data" />
	<?php wp_nonce_field( 'save_default_data' ); ?>

	<h3><?php esc_html_e( 'Handle default data', 'theepi' ); ?></h3>

	<div class="form-element" style="width : 20%">
		<span class="form-label"><?php esc_html_e( 'Periodicity', 'theepi' ); ?></span>
		<span class="form-sublabel"><?php echo esc_html_e( "Please indicate the periodicity of control of your PPE" ,'theepi' ); ?> </span>
		<label class="form-field-container">
			<input type="number" class="form-field" name="default-periodicity" value="<?php echo esc_attr( $default_periodicity ); ?>"/>
			<span class="form-field-label-next"><?php echo esc_html_e( 'days', 'theepi' ); ?></span>
		</label>
	</div>

	<div class="form-element" style="width : 20%">
		<span class="form-label"><?php esc_html_e( 'Lifetime', 'theepi' ); ?></span>
		<span class="form-sublabel"><?php echo esc_html_e( "Please indicate the lifetime of your PPE" ,'theepi' ); ?> </span>
		<label class="form-field-container">
			<input type="number" class="form-field" name="default-lifetime" value="<?php echo esc_attr( $default_lifetime ); ?>"/>
			<span class="form-field-label-next"><?php echo esc_html_e( 'years', 'theepi' ); ?></span>
		</label>
	</div>

	<div class="wpeo-button button-green button-progress button-disable action-input" data-parent="wpeo-form" style="margin-top : 20px">
		<span class="button-icon fas fa-save"></span>
	</div>
</form>
