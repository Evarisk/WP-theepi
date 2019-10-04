<?php
/**
 * La vue service d'un EPI.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.6.0
 * @version   0.7.0
 */

namespace theepi;

if (! defined('ABSPATH') ) {
    exit;
} ?>

<div class="epi-row service main" data-id="<?php echo esc_attr( $epi->data[ 'id' ] ); ?>">
	<div class="epi-row service date">
		<h2>
			<?php esc_html_e( 'PPE Date', 'theepi' ); ?>
		</h2>
		<span> <?php esc_html_e( 'Does the PPE have a lifetime', 'theepi' ); ?> </span>
		<span class="button-toggle-lifetime" data-value="">
			<?php if ( $epi->data['toggle_lifetime'] == 'YES' ) : ?>
				<span class="button-toggle-NO" style="color : grey; font-weight: auto"><?php esc_html_e( 'NO', 'theepi' ); ?></span>
				<span><i class="button-toggle fas fa-toggle-on"></i></span>
				<span class="button-toggle-YES" style="color : black; font-weight: bold"><?php esc_html_e( 'YES', 'theepi' ); ?></span>
			<?php else : ?>
				<span class="button-toggle-NO" style="color : black; font-weight: bold"><?php esc_html_e( 'NO', 'theepi' ); ?></span>
				<span><i class="button-toggle fas fa-toggle-off"></i></span>
				<span class="button-toggle-YES" style="color : grey; font-weight: auto"><?php esc_html_e( 'YES', 'theepi' ); ?></span>
			<?php endif; ?>
		</span>

		<form class="wpeo-grid grid-4 grid-padding-1 wpeo-form">
			<div>
				<div class="form-element form-element-required group-date update-end-life-date-epi">
					<input type="hidden" class="manufacture-date-valued" name="manufacture-date-valued" value="<?php echo esc_attr( $manufacture_date_valued ) ?>"/>
					<?php if ( $manufacture_date_valued != "" && $edit_mode == false ): ?>
						<span class="info" style="color: #47e58e; float : right; font-size: 13px"> <?php esc_html_e( 'Manufacture Date is defined in the TheEPI Settings, This field can be empty', 'theepi' ); ?> </span>
					<?php else: ?>
						<span class="error" style="color : red ; float : right"></span>
					<?php endif; ?>

					<?php if ( ( $manufacture_date_valued != "" ) ): ?>
						<span class="form-label wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Setting Date activated (Manufacture Date)', 'theepi' ); ?>" style="width: 40%"> <?php esc_html_e( 'Manufacture Date', 'theepi' ); ?> </span>
					<?php else: ?>
						<span class="form-label"><?php esc_html_e( 'Manufacture Date', 'theepi' ); ?></span>
					<?php endif; ?>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
						<?php if ( $edit_mode ): ?>
							<input type="hidden" class="mysql-date"  name="manufacture-date" value="<?php echo esc_attr( $epi->data['manufacture_date']['raw'] ); ?>"/>
						<?php else: ?>
							<input type="hidden" class="mysql-date"  name="manufacture-date" value=""/>
						<?php endif; ?>

						<?php if( $epi->data['manufacture_date_valid'] ): ?>
							<input class="form-field date" type="text" name="manufacture-date"
							value="<?php echo esc_attr( $epi->data['manufacture_date']['rendered']['date'] ); ?>"/>
						<?php else: ?>
							<input class="form-field date" type="text" name="manufacture-date"
							value=""/>
						<?php endif; ?>
					</label>
				</div>
			</div>

			<?php if ( $epi->data['toggle_lifetime'] == 'YES' ): ?>
			<div class="button-toggle-lifetime-display">
			<?php else: ?>
			<div class="button-toggle-lifetime-display hidden" >
			<?php endif; ?>
				<div class="form-element form-element-required lifetime update-end-life-date-epi">
					<span class="error" style="color : red ; float : right"></span>
					<?php if ( ( get_option( EPI_Class::g()->option_name_default_data_lifetime ) != "" ) ): ?>
						<span class="form-label wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Setting Data activated (Lifetime)', 'theepi' ); ?>" style="width: 40%"> <?php esc_html_e( 'Lifetime', 'theepi' ); ?> </span>
					<?php else: ?>
						<span class="form-label"><?php esc_html_e( 'Lifetime', 'theepi' ); ?></span>
					<?php endif; ?>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-heart"></i></span>
						<input class="form-field" type="number" name="lifetime" value="<?php echo esc_attr( $epi->data['lifetime_epi'] ); ?>"/>
						<span class="form-field-label-next"><?php echo esc_html_e( 'years', 'theepi' ); ?></span>
					</label>
				</div>
			</div>

			<?php if ( $epi->data['toggle_lifetime'] == 'YES' ): ?>
			<div class="button-toggle-lifetime-display">
			<?php else: ?>
			<div class="button-toggle-lifetime-display hidden" >
			<?php endif; ?>
				<div class="form-element form-element-disable group-date">
					<span class="form-label wpeo-tooltip-event" aria-label="<?php esc_html_e( 'End Life Date = Manufacture Date + Lifetime', 'theepi' ); ?>" style="width : 30%;"> <?php esc_html_e( 'End Life Date', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-heart-broken"></i></span>
						<?php if ( $edit_mode ): ?>
							<input type="hidden" class="mysql-date"  name="end-life-date" value="<?php echo esc_attr( $epi->data['end_life_date']['raw'] ); ?>"/>
						<?php else: ?>
							<input type="hidden" class="mysql-date"  name="end-life-date" value=""/>
						<?php endif; ?>

						<?php if( $epi->data['manufacture_date_valid'] ): ?>
							<input class="form-field date" type="text" name="end-life-date"
							value="<?php echo esc_attr( $epi->data['end_life_date']['rendered']['date'] ); ?>"/>
						<?php else: ?>
							<input class="form-field date" type="text" name="end-life-date"
							value=""/>
						<?php endif; ?>
					</label>
				</div>
			</div>

			<div>
				<div class="form-element group-date disposal-date">
					<span class="form-label"> <?php esc_html_e( 'Disposal Date', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-trash-alt"></i></span>
						<?php if( $edit_mode == true && ( $epi->data['disposal_date']['rendered']['date'] != '01/01/1970' ) ): ?>
							<input type="hidden" class="mysql-date"  name="disposal-date" value="<?php echo esc_attr( $epi->data['disposal_date']['raw'] ); ?>"/>
							<input class="form-field date" type="text" name="disposal-date"
							value="<?php echo esc_attr( $epi->data['disposal_date']['rendered']['date'] ); ?>"/>
						<?php else: ?>
							<input type="hidden" class="mysql-date"  name="disposal-date" value=""/>
							<input class="form-field date" type="text" name="disposal-date" value=""/>
						<?php endif; ?>
					</label>
				</div>
			</div>
		</form>
	</div>

	<div class="epi-row service life-sheet">
		<h2>
			<?php esc_html_e( 'PPE Life Sheet', 'theepi' ); ?>
		</h2>

		<form class="wpeo-grid grid-4 grid-padding-1 wpeo-form">
			<div>
				<div class="form-element form-element-required group-date">
					<?php if ( $checked_purchase_date == 1 && $edit_mode == false ): ?>
						<span class="info" style="color: #47e58e; float : right"> <?php esc_html_e( 'Purchase Date is defined in the TheEPI Settings, This field can be empty', 'theepi' ); ?> </span>
					<?php else: ?>
						<span class="error" style="color : red ; float : right"></span>
					<?php endif; ?>

					<?php if ( ( $checked_purchase_date == 1 ) ): ?>
						<span class="form-label wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Setting Date activated (Purchase Date)', 'theepi' ); ?>" style="width: 40%"> <?php esc_html_e( 'Purchase Date', 'theepi' ); ?> </span>
					<?php else: ?>
						<span class="form-label"> <?php esc_html_e( 'Purchase Date', 'theepi' ); ?> </span>
					<?php endif; ?>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
						<?php if ( $edit_mode ): ?>
							<input type="hidden" class="mysql-date" name="purchase-date" value="<?php echo esc_attr( $epi->data['purchase_date']['raw'] ); ?>"/>
						<?php else: ?>
							<input type="hidden" class="mysql-date" name="purchase-date" value=""/>
						<?php endif; ?>

						<?php if( $epi->data['purchase_date_valid'] ):  ?>
							<input class="form-field date" type="text" name="purchase-date"
							value="<?php echo esc_attr( $epi->data['purchase_date']['rendered']['date'] ); ?>"/>
						<?php else: ?>
							<input class="form-field date" type="text" name="purchase-date"
							value="" />
						<?php endif; ?>
					</label>
				</div>
			</div>

			<div>
			<?php if ( ( $checked_purchase_date == 1 ) && ( $manufacture_date_valued  != "" ) ): ?>
				<div class="form-element form-element-required group-date update-control-date-epi update-purchase-date-epi update-manufacture-date-epi">
			<?php elseif ( ( $checked_purchase_date == 0 ) && ( $manufacture_date_valued  != "" ) ): ?>
				<div class="form-element form-element-required group-date update-control-date-epi update-manufacture-date-epi">
			<?php elseif ( ( $checked_purchase_date == 1 ) && ( $manufacture_date_valued  == "" ) ): ?>
				<div class="form-element form-element-required group-date update-control-date-epi update-purchase-date-epi">
			<?php else: ?>
				<div class="form-element form-element-required group-date update-control-date-epi">
			<?php endif; ?>
					<span class="error" style="color : red ; float : right"></span>
					<span class="form-label"> <?php esc_html_e( 'Commissioning Date', 'theepi' ); ?> </span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
						<?php if ( $edit_mode ): ?>
							<input type="hidden" class="mysql-date" name="commissioning-date" value="<?php echo esc_attr( $epi->data['commissioning_date']['raw'] ); ?>"/>
						<?php else: ?>
							<input type="hidden" class="mysql-date" name="commissioning-date" value=""/>
						<?php endif; ?>

						<?php if( $epi->data['commissioning_date_valid'] ): ?>
							<input class="form-field date" type="text" name="commissioning-date"
							value="<?php echo esc_attr( $epi->data['commissioning_date']['rendered']['date'] ); ?>"/>
						<?php else: ?>
							<input class="form-field date" type="text" name="commissioning-date"
							value=""/>
						<?php endif; ?>
					</label>
				</div>
			</div>

			<div>
				<div class="form-element form-element-required update-control-date-epi">
					<span class="error" style="color : red ; float : right"></span>
					<?php if ( ( get_option( EPI_Class::g()->option_name_default_data_periodicity ) != "" ) ): ?>
						<span class="form-label wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Setting Data activated (Periodicity)', 'theepi' ); ?>" style="width: 40%"> <?php esc_html_e( 'Periodicity', 'theepi' ); ?> </span>
					<?php else: ?>
						<span class="form-label"><?php esc_html_e( 'Periodicity', 'theepi' ); ?></span>
					<?php endif; ?>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-history"></i></span>
						<input class="form-field" type="number" name="periodicity" value="<?php echo esc_attr( $epi->data['periodicity'] ); ?>"/>
						<span class="form-field-label-next"><?php echo esc_html_e( 'days', 'theepi' ); ?></span>
					</label>
				</div>
			</div>

			<div>
				<div class="form-element form-element-disable group-date">
					<span class="error" style="color : red ; float : right"></span>
					<span class="form-label wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Control Date = Commissioning Date + Periodicity', 'theepi' ); ?>" style="width : 30%;"> <?php esc_html_e( 'Control Date', 'theepi' ); ?> </span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-calendar-check"></i></span>
						<?php if ( $edit_mode ): ?>
							<input type="hidden" class="mysql-date" name="control-date" value="<?php echo esc_attr( $epi->data['control_date']['raw'] ); ?>"/>
						<?php else: ?>
							<input type="hidden" class="mysql-date" name="control-date" value=""/>
						<?php endif; ?>

						<?php if( $epi->data['commissioning_date_valid'] ): ?>
							<input class="form-field date" type="text" name="control-date"
							value="<?php echo esc_attr( $epi->data['control_date']['rendered']['date'] ); ?>"/>
						<?php else: ?>
							<input class="form-field date" type="text" name="control-date"
							value=""/>
						<?php endif; ?>
					</label>
				</div>
			</div>
		</form>
	</div>

	<div class="epi-row service information">
		<h2>
			<?php esc_html_e( 'Additional Information', 'theepi' ); ?>
		</h2>

		<form class="wpeo-grid grid-3 grid-padding-1 wpeo-form">
			<div>
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Maker', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-tools"></i></span>
						<input type="text" class="form-field" name="maker" value="<?php echo esc_attr( $epi->data['maker'] ) ?>"/>
					</label>
				</div>
			</div>

			<div>
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Seller', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-store"></i></span>
						<input type="text" class="form-field" name="seller" value="<?php echo esc_attr( $epi->data['seller'] ); ?>"/>
					</label>
				</div>
			</div>

			<div>
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Manager', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-user-tie"></i></span>
						<input type="text" class="form-field" name="manager" value="<?php echo esc_attr( $epi->data['manager'] ); ?>"/>
					</label>
				</div>
			</div>

			<div>
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'Reference', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-barcode"></i></span>
						<input type="text" class="form-field" name="reference" value="<?php echo esc_attr( $epi->data['reference'] ); ?>"/>
					</label>
				</div>
			</div>

			<div>
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'URL Notice', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-book-reader"></i></span>
						<input type="text" class="form-field" name="url-notice" value="<?php echo esc_attr( $epi->data['url_notice'] ); ?>"/>
						<?php if ( esc_attr( $epi->data['url_notice'] ) != "" ): ?>
							<a class="wpeo-button wpeo-tooltip-event button-grey button-square-50"
								href="<?php echo esc_attr( $epi->data['url_notice'] ); ?>"
								target="_blank"
								aria-label="<?php esc_html_e( 'Display Url File', 'theepi' ); ?>">
								<i class="fas fa-copy"></i>
							</a>
						<?php endif; ?>
					</label>
				</div>
			</div>

			<!-- <div>
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'File', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-barcode"></i></span>
						<input type="text" class="form-field" name="reference" value="<?php echo esc_attr( $epi->data['reference'] ); ?>"/>
					</label>
				</div>
			</div> -->
		</form>
	</div>

	<?php if( ! empty( $control )  && ( $control->data['id'] != 0) ): ?>
		<div class="epi-row service control">
			<h2>
				<?php esc_html_e( 'Last Control', 'theepi' ); ?>
			</h2>
			<?php
				\eoxia\View_Util::exec(
					'theepi', 'control', 'single-view-control', array(
						'control'    => $control,
					)
				);
			?>
		</div>
	<?php endif; ?>

	<div class="epi-row service button-edit">
		<div class="wpeo-button wpeo-tooltip-event button-grey action-attribute"
			aria-label="<?php esc_html_e( 'Cancel EPI', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
			data-action="cancel_edit_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'cancel_edit_epi' ) ); ?>">
			<?php esc_html_e( 'Cancel', 'theepi' ); ?>
		</div>

		<div class="wpeo-button wpeo-tooltip-event button-green button-progress button-square-50 edit button-save-epi"
			aria-label="<?php esc_html_e( 'Save EPI', 'theepi' ); ?>"
			data-parent="epi-row"
			data-action="save_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_epi' ) ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
			<span class="button-icon fas fa-save"></span>
		</div>
	</div>
</div>
