<?php
/**
 * La vue permettant de recherche les EPI.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.4.0
 * @version 0.4.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-form box-search">
	<div class="form-element">
		<label for="search"><?php esc_html_e( 'Search', 'theepi' ); ?></label>
		<input id="search" name="term" type="text" value="" />
	</div>

	<div 	class="wpeo-button button-main button-progress action-input"
				data-parent="wpeo-form"
				data-action="search_epi"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'search_epi' ) ); ?>">
		<span class="fa fa-search" aria-hidden="true"></span>
	</div>

	<div 	class="wpeo-button button-light button-disable button-progress action-attribute"
				data-action="clear_search_epi"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'clear_search_epi' ) ); ?>">
		<span class="fa fa-times" aria-hidden="true"></span>
	</div>
</div>
