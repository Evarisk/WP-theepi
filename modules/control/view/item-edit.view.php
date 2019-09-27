<?php
/**
 * La vue Edition du module EPI.
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
		<div class="wpeo-form">
			<div class="form-element group-date">
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
					<?php if ( $edit_mode ): ?>
						<input type="hidden" class="mysql-date"  name="control-date" value="<?php echo esc_attr( $control->data['control_date']['raw'] ); ?>"/>
					<?php else: ?>
						<input type="hidden" class="mysql-date"  name="control-date" value=""/>
					<?php endif; ?>

					<input class="form-field date" type="text" name="control-date"
					value="<?php echo esc_attr( $control->data['control_date']['rendered']['date'] ); ?>"/>
				</label>
			</div>
		</div>
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

	<div class="table-cell table-100" data-title="<?php echo esc_attr_e( 'Attached File', 'theepi' ); ?>"> </br>
		<!-- <div class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-rounded"
			aria-label="<?php esc_html_e( 'Add Attached File', 'theepi' ); ?>">
			<i class="fas fa-paperclip"></i>
		</div> -->
		<!-- <?php if( $control->data[ 'thumbnail_id' ] != 0 ): ?>
			<input type="hidden" name="thumbnail_id" value="<?php echo esc_attr_e( $control->data[ 'thumbnail_id' ] ); ?>">
		<?php endif; ?> -->

		<?php echo do_shortcode( '[wpeo_upload id="' . $control->data['id'] . '" model_name="/theepi/Control_Class" single="false" mime_type="" display_type="list" field_name="media"]' ); ?>
		<?php echo Control_Class::g()->get_media( $control->data['id'] ) ?>
	</div>

	<div class="table-cell table-100 table-status-control" style="text-align : center" data-title="<?php echo esc_attr_e( 'Status', 'theepi' ); ?>">
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
