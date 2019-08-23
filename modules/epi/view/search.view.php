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

<div class="wpeo-form" style="float: right; width: 50%;">
	<div class="form-element">
		<span class="form-label"></span>
		<label class="form-field-container">
			<span class="form-field-label-prev"><i class="fas fa-search"></i></span>
			<input type="text" name="term" class="form-field" placeholder="<?php esc_attr_e( 'Search term', 'theepi' ); ?>" />
			<div>
				<span class="wpeo-button button-main action-input"
					data-parent="wpeo-form"
					data-action="search_epi"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'search_epi' ) ); ?>">
					<?php esc_html_e( 'Search', 'theepi' ); ?>
				</span>
			</div>
			<!--<div><span class="wpeo-button button-main action-attribute button-square-50"
						data-parent="wpeo-form"
						data-action="clear_search_epi"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'clear_search_epi' ) ); ?>"><i class="fal fa-times"></i></span></div>-->
		</label>
	</div>
</div>
