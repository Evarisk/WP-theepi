<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @since 0.1.0
 * @version 0.5.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap wpeo-wrap wrap-theepi">

	<h1>
		<?php esc_html_e( 'List of PPE', 'theepi' ); ?>
		<div class="wpeo-button button-main button-radius-3 action-attribute" style="margin-left : 15px"
			data-action="display_view_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_view_epi' ) ); ?>">
			<span><?php esc_html_e( 'New', 'theepi' ); ?></span>
		</div>
		<div class="wpeo-button button-main button-radius-3" style="margin-left : 10px"
			<span><?php esc_html_e( 'New from images', 'theepi' ); ?></span>
		</div>
	</h1>

	<?php EPI_Class::g()->display_search(); ?>

	<div class="container-content">
		<?php EPI_Class::g()->display();?>
	</div>
</div>
