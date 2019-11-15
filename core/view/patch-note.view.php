<?php
/**
 * Gestion de la modal et de la notification pour les notes de mise à jour.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006 2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.3.0
 */

namespace theepi;

use eoxia\Config_Util;

defined( 'ABSPATH' ) || exit;

if ( true === $result['status'] && ! empty( $result['content'] ) ) : ?>
	<div class="wpeo-notification patch-note notification-active">
		<img class="notification-thumbnail" src="<?php echo esc_attr( PLUGIN_THEEPI_URL. 'core/assets/images/icon-256x256.png' ); ?>" />

		<div class="notification-title">
			<span>Note de mise à jour de la <a href="#">version <?php echo esc_attr( Config_Util::$init['theepi']->version ); ?></a></span>
		</div>

		<div class="notification-close action-attribute"
			data-action="close_change_log"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'close_change_log' ) ); ?>"
			data-version="<?php echo esc_attr( Config_Util::$init['theepi']->version ); ?>"><i class="fas fa-times"></i></div>
	</div>

	<div class="wpeo-modal patch-note">
		<div class="modal-container">
			<div class="modal-header">
				<h2 class="title"><?php echo esc_html( 'Note de version: ' . $result['content']->numero_de_version ); ?></h2>
				<div class="modal-close"><i class="fas fa-times"></i></div>
			</div>
			<div class="modal-content">
				<?php
				if ( ! empty( $result['content']->note_de_version ) ) :
					foreach ( $result['content']->note_de_version as $element ) :
						?>
						<div class="note">
							<div class="entry-content"><?php echo $element->description; ?></div>
								<?php
								if ( ! empty( $element->illustration ) && ! empty( $element->illustration->url ) ) :
									?>
									<img src="<?php echo esc_attr( $element->illustration->url ); ?>" alt="<?php echo esc_attr( $element->numero_de_suivi ); ?>" />
									<?php
								endif;
								?>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>
<?php
endif;
