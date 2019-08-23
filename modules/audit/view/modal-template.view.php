<?php
/**
 * La vue déclarant le modal audit.
 *
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @since     0.5.0
 * @version   0.5.0
 * @copyright 2019 Evarisk
 * @package   TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

	<!-- Structure -->
	<div class="wpeo-modal modal-active">
		<div class="modal-container">

			<!-- Entête -->
			<div class="modal-header">
				<h2 class="modal-title-header">
				<?php
				\eoxia\View_Util::exec(
					'theepi', 'audit', 'modal-header', array(
						'audit' => $audit,
						'epi'   => $epi,
					)
				);
				?>
				</h2>
			</div>

			<!-- Corps -->
			<div class="modal-content">
				<?php
				if ( ! empty( $tasks ) ) :
					foreach ( $tasks as $task ) :
						\eoxia\View_Util::exec(
							'task-manager',
							'task',
							'backend/task',
							array(
								'task'        => $task,
								'hide_footer' => 1,
								'with_wrapper' => '',
							)
						);
					endforeach;
				endif;
				 ?>
			</div>

			<!-- Footer -->
			<div class="modal-footer">
				<?php
				\eoxia\View_Util::exec(
					'theepi', 'audit', 'modal-footer', array(
						'audit' => $audit,
						'epi'   => $epi,
					)
				);
				?>
			</div>
		</div>
	</div>
