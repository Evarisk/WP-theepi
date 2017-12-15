<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.4.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap wpeo-wrap wrap-theepi">

	<h1>
		<?php esc_html_e( 'TheEPI', 'theepi' ); ?>
		<a href="#" class="wpeo-button button-main create-mass-epi">
			<span><?php esc_html_e( 'Create mass from image', 'theepi' ); ?></span>
		</a>
	</h1>

	<?php EPI_Class::g()->display_search(); ?>

	<div class="container-content">
		<?php EPI_Class::g()->display(); ?>
	</div>
</div>
