<?php
/**
 * Filtres des EPI
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2018 Evarisk
 * @since     0.4.0
 * @version   0.4.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fiter_options = array(
	'all'    => __( 'All', 'theepi' ),
	'ok'     => __( 'OK', 'theepi' ),
	'ko'     => __( 'KO', 'theepi' ),
	'repair' => __( 'To fix', 'theepi' ),
	'trash'  => __( 'Trashed', 'theepi' ),
);

?>

<div class="epi-filters wpeo-form form-light">
	<div class="form-element">
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-filter"></i></span>
			<select id="filters" name="filters" class="form-field">
				<option value="all"><?php esc_html_e( 'All', 'theepi' ); ?></option>
				<option value="ok"><?php esc_html_e( 'OK', 'theepi' ); ?></option>
				<option value="ko"><?php esc_html_e( 'KO', 'theepi' ); ?></option>
				<option value="repair"><?php esc_html_e( 'To fix', 'theepi' ); ?></option>
				<option value="trash"><?php esc_html_e( 'Trashed', 'theepi' ); ?></option>
			</select>
		</label>
	</div>
	<div class="wpeo-button button-grey action-input"
		data-parent="epi-filters"
		data-action="filter_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'filter_epi' ) ); ?>">
		<?php esc_html_e( 'Filter', 'theepi' ); ?>
	</div>
</div>
