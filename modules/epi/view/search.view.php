<?php
/**
 * La vue permettant de recherche les EPI.
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
} ?>

<div class="epi-search wpeo-form form-light">
	<div class="form-element">
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-search"></i></span>
			<input type="text" name="term" class="form-field" placeholder="<?php esc_attr_e( 'Search term', 'theepi' ); ?>" />
		</label>
	</div>
	<div class="wpeo-button button-grey action-input"
		data-parent="wpeo-form"
		data-action="search_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'search_epi' ) ); ?>">

		<?php esc_html_e( 'Search', 'theepi' ); ?>
	</div>
</div>
