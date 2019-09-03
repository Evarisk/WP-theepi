<?php
/**
 * Les bouttons pour importer ou créer une tache dans une audit.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.5.0
 * @version   0.5.0
 */

namespace task_manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<!-- Structure de la modal pour l'import de tâches -->
<div class="wpeo-modal tm-audit-import modal-active">
	<div class="modal-container">
		<div class="modal-header">
			<h2 class="modal-title-header" style="text-transform: uppercase; font-size: 18px; white-space: normal;"><?php echo esc_attr( 'Importer une Tâche', 'task-manager' ); ?></h2>
			<div class="modal-close"><i class="fas fa-times"></i></div>
		</div>

		<div class="modal-content">
			<div class="tm-import-add-keyword" style="display : flex">

				<div class="wpeo-button button-blue" data-type="task" style="margin-right: 8px;">
					<i class="button-icon fas fa-plus-circle"></i>
					<span><?php esc_html_e( 'Task', 'task-manager' ); ?></span>
				</div>

				<div class="wpeo-button button-blue" data-type="point" style="margin-right: 8px;">
					<i class="button-icon fas fa-plus-circle"></i>
					<span><?php esc_html_e( 'Point', 'task-manager' ); ?></span>
				</div>

				<?php
				\eoxia\View_Util::exec(
					'task-manager',
					'import',
					'backend/import-tag-button',
					array(
						'tags' => $tags,
					)
				);
				?>

				<div class="form-element" style="margin-left : 50px">
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fab fa-github"></i></span>
						<input type="text" class="form-field" name="github" value="" />
					</label>
				</div>

				<div class="wpeo-button button-main button-radius-3 action-input" style="margin-left: 20px"
					data-action="get_text_from_url_audit"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'get_text_from_url_audit' ) ); ?>"
					data-parent="modal-container">
					<span><i class="fas fa-download"></i></span>
				</div>
			</div>

			<textarea name="content" style="height : 80%; width : 100%; margin-top : 10px"></textarea>
		</div>

		<div class="modal-footer">
			<div class="wpeo-button button-grey button-uppercase modal-close"><span><?php esc_html_e( 'Cancel', 'task-manager' ); ?></span></div>
			<a class="wpeo-button button-main button-uppercase action-input"
				data-parent-id="<?php echo esc_attr( $parent_id ); ?>"
				data-parent="wpeo-modal"
				data-action="audit_import_tasks_and_points"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'audit_import_tasks_and_points' ) ); ?>" ><span><?php esc_html_e( 'Import', 'task-manager' ); ?></span></a>
		</div>
	</div>
</div>
