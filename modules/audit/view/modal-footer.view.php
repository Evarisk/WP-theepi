<?php
/**
 * La vue déclarant le modal audit.
 *
 * @author Nicolas Domenech <nicolas@eoxia.com>
 * @since 0.5.0
 * @version 0.5.0
 * @copyright 2019 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul style="display : flex">
	<li>
			<i class="fas fa-link"></i>
	</li>

	<li>
		#1459
	</li>

	<li>
		image
	</li>

	<li>
		Casque de protection
	</li>

	<li>
		statut
	</li>
</ul>

<div 	class="wpeo-button button-main button-size-large button-uppercase modal-close">
	<span><?php esc_html_e( 'Validate the control', 'theepi' ); ?></span>
</div>
