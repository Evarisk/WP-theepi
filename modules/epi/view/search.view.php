<?php
/**
 * La vue permettant de recherche les EPI.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 0.4.0
 * @version 0.4.0
 * @copyright 2018 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-form">
	<div class="form-element">
		<span class="form-label"><?php esc_html_e( 'Search', 'theepi' ); ?></span>
		<label class="form-field-container">
			<input type="text" name="term" class="form-field" placeholder="<?php esc_attr_e( 'Search term', 'theepi' ); ?>" />
			<span class="wpeo-button button-main action-input"
						data-parent="wpeo-form"
						data-action="search_epi"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'search_epi' ) ); ?>"><i class="fal fa-search"></i></span>
			<span class="wpeo-button button-disable action-attribute"
						data-parent="wpeo-form"
						data-action="clear_search_epi"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'clear_search_epi' ) ); ?>"><i class="fal fa-times"></i></span>
		</label>
	</div>
</div>
