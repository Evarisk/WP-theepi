<?php
/**
 * La vue Edition du module Control.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.6.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row epi-control-row edit" data-id="<?php echo esc_attr( $control->data['id'] ); ?>">
	<input type="hidden" name="parent-id" value="<?php echo esc_attr( $epi->data['id'] ); ?>">
	<div class="table-cell table-100" style="text-align: center;" data-title="<?php echo esc_attr_e( 'ID', 'theepi' ); ?>">
		<span style="color: grey;"><i class="fas fa-hashtag"></i> <?php echo esc_attr( $control->data['id'] ); ?></span></br>
	</div>

	<div class="table-cell table-100" data-title="<?php echo esc_attr_e( 'Avatar', 'theepi' ); ?>"> </br>
		<?php echo do_shortcode( '[theepi_avatar ids="' . $control->data['author_id'] . '" size="40"]' ); ?>
	</div>

	<div class="table-cell table-150" data-title="<?php echo esc_attr_e( 'Date', 'theepi' ); ?>">
		<i class="fas fa-calendar-alt"></i> <?php echo esc_attr( $control->data['date']['rendered']['date'] ); ?>
	</div>

	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'Comment', 'theepi' ); ?>">
		<div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<input type="text" class="form-field" name="comment" value="<?php echo esc_attr( $control->data['comment'] ); ?>"/>
				</label>
			</div>
		</div>
	</div>

	<div class="table-cell table-300" data-title="<?php echo esc_attr_e( 'URL', 'theepi' ); ?>">
		<div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<input type="text" class="form-field" name="url" value="<?php echo esc_attr( $control->data['url'] ); ?>"/>
				</label>
			</div>
		</div>
	</div>

	<div class="table-cell table-100" data-title="<?php echo esc_attr_e( 'Attached File', 'theepi' ); ?>">
		<?php if (  $control->data['id'] != 0 ): ?>
			<?php echo do_shortcode( '[wpeo_upload id="' . $control->data['id'] . '" model_name="/theepi/Control_Class" single="false" mime_type="" display_type="list" field_name="media"]' ); ?>
		<?php endif; ?>
	</div>

	<div class="table-cell table-100 table-status-control" style="text-align : center" data-title="<?php echo esc_attr_e( 'Status', 'theepi' ); ?>">
		<?php if ( $edit_mode == false ): ?>
			<div class="wpeo-dropdown">
				<div class="dropdown-toggle wpeo-button" style="background-color : white; border-color : white;"><i class="fas fa-caret-down" style="color: grey;"></i></div>
				<input type="hidden" name="status-control" value="">
				<ul class="dropdown-content" style="width : auto;">
					<li class="dropdown-item wpeo-tooltip-event"
						aria-label="<?php esc_html_e( 'Status OK', 'theepi' ); ?>"
						data-status="OK">
						<div class="wpeo-button button-green button-square-50">
							<i class="fas fa-check"></i>
						</div>
					</li>

					<li class="dropdown-item wpeo-tooltip-event"
						aria-label="<?php esc_html_e( 'Status KO', 'theepi' ); ?>"
						data-status="KO">
						<div class="wpeo-button button-red button-square-50">
							<i class="fas fa-exclamation"></i>
						</div>
					</li>

					<li class="dropdown-item wpeo-tooltip-event"
						aria-label="<?php esc_html_e( 'Status Repair', 'theepi' ); ?>"
						data-status="repair">
						<div class="wpeo-button button-square-50" style="background-color : orange; border-color : orange;">
							<i class="fas fa-tools"></i>
						</div>
					</li>

					<li class="dropdown-item wpeo-tooltip-event"
						aria-label="<?php esc_html_e( 'Status Trash', 'theepi' ); ?>"
						data-status="trash">
						<div class="wpeo-button button-square-50" style="background-color : black; border-color : black;">
							<i class="fas fa-trash-alt"></i>
						</div>
					</li>
				</ul>
			</div>
		<?php else: ?>
			<div class="wpeo-dropdown">
			<?php if ( $control->data['status_control'] == 'OK' ): ?>
				<div class="dropdown-toggle wpeo-button button-square-50" style="background-color : mediumspringgreen; border-color : mediumspringgreen;"><i class="fas fa-check"></i></div>
			<?php elseif ( $control->data['status_control'] == 'KO' ): ?>
				<div class="dropdown-toggle wpeo-button button-square-50" style="background-color : red; border-color : red;"><i class="fas fa-exclamation"></i></div>
			<?php elseif ( $control->data['status_control'] == 'repair' ): ?>
				<div class="dropdown-toggle wpeo-button button-square-50" style="background-color : orange; border-color : orange;"><i class="fas fa-tools"></i></div>
			<?php elseif ( $control->data['status_control'] == 'trash' ): ?>
				<div class="dropdown-toggle wpeo-button button-square-50" style="background-color : black; border-color : black;"><i class="fas fa-trash-alt"></i></div>
			<?php endif; ?>
				<input type="hidden" name="status-control" value="">
				<ul class="dropdown-content" style="width : auto;">
					<li class="dropdown-item wpeo-tooltip-event"
						aria-label="<?php esc_html_e( 'Status OK', 'theepi' ); ?>"
						data-status="OK">
						<div class="wpeo-button button-square-50" style="background-color : mediumspringgreen; border-color : mediumspringgreen;">
							<i class="fas fa-check"></i>
						</div>
					</li>

					<li class="dropdown-item wpeo-tooltip-event"
						aria-label="<?php esc_html_e( 'Status KO', 'theepi' ); ?>"
						data-status="KO">
						<div class="wpeo-button button-red button-square-50" style="background-color : red; border-color : red;">
							<i class="fas fa-exclamation"></i>
						</div>
					</li>

					<li class="dropdown-item wpeo-tooltip-event"
						aria-label="<?php esc_html_e( 'Status Repair', 'theepi' ); ?>"
						data-status="repair">
						<div class="wpeo-button button-square-50" style="background-color : orange; border-color : orange;">
							<i class="fas fa-tools"></i>
						</div>
					</li>

					<li class="dropdown-item wpeo-tooltip-event"
						aria-label="<?php esc_html_e( 'Status Trash', 'theepi' ); ?>"
						data-status="trash">
						<div class="wpeo-button button-square-50" style="background-color : black; border-color : black;">
							<i class="fas fa-trash-alt"></i>
						</div>
					</li>
				</ul>
			</div>
		<?php endif; ?>
	</div>

	<div class="table-cell table-end" style="text-align : center" data-title="<?php esc_attr_e( 'Actions', 'theepi' ); ?>">
		<div class="wpeo-button wpeo-tooltip-event button-green button-progress button-square-50 edit action-input"
			aria-label="<?php esc_html_e( 'Save Control', 'theepi' ); ?>"
			data-parent="epi-control-row"
			data-id="<?php echo esc_attr( $control->data['id'] ); ?>"
			data-action="save_control_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_control_epi' ) ); ?>">
			<span class="button-icon fas fa-save"></span>
		</div>

		<div class="wpeo-button wpeo-tooltip-event button-grey button-square-50 action-attribute"
			aria-label="<?php esc_html_e( 'Cancel Control', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $control->data['id'] ); ?>"
			data-action="cancel_edit_control_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'cancel_edit_control_epi' ) ); ?>">
			<i class="fas fa-undo-alt"></i>
	  	</div>
	</div>
</div>