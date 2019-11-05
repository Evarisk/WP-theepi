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

<div class="row-advanced service main wpeo-form" data-id="<?php echo esc_attr( $epi->data[ 'id' ] ); ?>">
	<div class="advanced-service date">
		<h2>
			<?php esc_html_e( 'PPE Date', 'theepi' ); ?>
		</h2>

		<div class="epi-lifetime">
			<span> <?php esc_html_e( 'Does the PPE have a lifetime', 'theepi' ); ?> </span>
			<span class="button-toggle-lifetime" data-value="YES">
	      <span class="button-toggle-no"><?php esc_html_e( 'NO', 'theepi' ); ?></span>
	      <i class="button-toggle fas fa-toggle-on"></i>
	      <span class="button-toggle-yes"><?php esc_html_e( 'YES', 'theepi' ); ?></span>
			</span>
		</div>

		<div class="wpeo-gridlayout grid-4 grid-padding-1">
			<div class="form-element form-element-required group-date update-end-life-date-epi">
				<input type="hidden" class="manufacture-date-valued" name="manufacture-date-valued" value="<?php echo esc_attr( $manufacture_date_valued ) ?>"/>
				<span class="form-label wpeo-tooltip-event" aria-label="<?php echo ! empty( $manufacture_date_valued ) ? esc_html_e( 'Setting Date activated (Manufacture Date)', 'theepi' ) : esc_html_e( 'Setting Date disable (Manufacture Date)', 'theepi' ) ; ?>">
					<?php esc_html_e( 'Manufacture Date', 'theepi' ); ?>
				</span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
						<input type="hidden" class="mysql-date"  name="manufacture-date" value="<?php echo ( $edit_mode ) ? esc_attr( $epi->data['manufacture_date']['raw'] ) : ''; ?>"/>
						<input class="form-field date" type="text" name="manufacture-date" value="<?php echo ( $epi->data['manufacture_date_valid'] ) ? esc_attr( $epi->data['manufacture_date']['rendered']['date'] ) : ''; ?>"/>
				</label>
				<?php if ( $manufacture_date_valued != "" && $edit_mode == false ): ?>
					<span class="form-sublabel"><?php esc_html_e( 'Manufacture Date is defined in the TheEPI Settings, This field can be empty', 'theepi' ); ?></span>
				<?php endif; ?>
			</div>

			<div class="form-element form-element-required button-toggle-lifetime-display lifetime update-end-life-date-epi <?php echo ( $epi->data['toggle_lifetime'] == 'NO' ) ? 'hidden' : ''; ?>">
				<span class="form-label wpeo-tooltip-event" aria-label="<?php echo ! empty( get_option( EPI_Class::g()->option_name_default_data_lifetime ) ) ? esc_html_e( 'Setting Data activated (Lifetime)', 'theepi' ) : esc_html_e( 'Setting Data disable (Lifetime)', 'theepi' ); ?>">
					<?php esc_html_e( 'Lifetime', 'theepi' ); ?>
				</span>
				<div class="form-error"></div>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-heart"></i></span>
					<input class="form-field" type="number" name="lifetime" value="<?php $epi->data['lifetime_epi'] != 0 ? esc_attr_e( $epi->data['lifetime_epi'] ) : ''; ?>"/>
					<span class="form-field-label-next"><?php echo esc_html_e( 'days', 'theepi' ); ?></span>
				</label>
			</div>

			<div class="form-element form-element-unboxed group-date button-toggle-lifetime-display <?php echo ( $epi->data['toggle_lifetime'] == 'NO' ) ? 'hidden' : ''; ?>">
				<span class="form-label wpeo-tooltip-event" aria-label="<?php esc_html_e( 'End Life Date = Manufacture Date + Lifetime', 'theepi' ); ?>">
          <?php esc_html_e( 'End Life Date', 'theepi' ); ?>
        </span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-heart-broken"></i></span>
					<input type="hidden" class="mysql-date"  name="end-life-date" value="<?php echo ( $edit_mode ) ? esc_attr( $epi->data['end_life_date']['raw'] ) : ''; ?>"/>
					<input class="form-field date" type="text" name="end-life-date" value="<?php echo ( $epi->data['manufacture_date_valid'] ) ? esc_attr( $epi->data['end_life_date']['rendered']['date'] ) : ''; ?>"/>
				</label>
			</div>

			<div class="form-element group-date disposal-date">
				<span class="form-label"> <?php esc_html_e( 'Disposal Date', 'theepi' ); ?></span>
				<label class="form-field-container empty-date-epi">
					<span class="form-field-icon-prev"><i class="fas fa-trash-alt"></i></span>
					<?php if( $edit_mode == true && ( ( esc_attr ( $epi->data['disposal_date']['raw'] ) != '1970-01-01' ) ) ): ?>
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
  </div>

	<div class="advanced-service life-sheet">
		<h2>
			<?php esc_html_e( 'PPE Life Sheet', 'theepi' ); ?>
		</h2>

		<div class="wpeo-gridlayout grid-4 grid-padding-1">
			<div class="form-element form-element-required group-date">
				<span class="form-label wpeo-tooltip-event" aria-label="<?php echo ( $checked_purchase_date == 1 ) ? esc_html_e( 'Setting Date activated (Purchase Date)', 'theepi' ) : esc_html_e( 'Setting Date disable (Purchase Date)', 'theepi' ); ?>">
          <?php esc_html_e( 'Purchase Date', 'theepi' ); ?>
        </span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
						<input type="hidden" class="mysql-date" name="purchase-date" value="<?php echo ( $edit_mode ) ? esc_attr( $epi->data['purchase_date']['raw'] ) : ''; ?>"/>
						<input class="form-field date" type="text" name="purchase-date" value="<?php echo ( $epi->data['purchase_date_valid'] ) ? esc_attr( $epi->data['purchase_date']['rendered']['date'] ) : ''; ?>"/>
				</label>
        <?php if ( $checked_purchase_date == 1 && $edit_mode == false ): ?>
          <span class="form-sublabel"><?php esc_html_e( 'Purchase Date is defined in the TheEPI Settings, This field can be empty', 'theepi' ); ?></span>
        <?php endif; ?>
			</div>

      <?php
      if ( ( $checked_purchase_date == 1 ) && ( $manufacture_date_valued  != "" ) ) :
        $update_control_class = 'update-purchase-date-epi update-manufacture-date-epi';
      elseif ( ( $checked_purchase_date == 0 ) && ( $manufacture_date_valued  != "" ) ) :
        $update_control_class = 'update-manufacture-date-epi';
      elseif ( ( $checked_purchase_date == 1 ) && ( $manufacture_date_valued  == "" ) ) :
        $update_control_class = 'update-purchase-date-epi';
      else :
        $update_control_class = '';
      endif;
      ?>
      <div class="form-element form-element-required group-date update-control-date-epi <?php echo esc_html( $update_control_class ); ?>">
        <span class="form-label"><?php esc_html_e( 'Commissioning Date', 'theepi' ); ?></span>
        <div class="form-error"></div>
        <label class="form-field-container">
          <span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
          <input type="hidden" class="mysql-date" name="commissioning-date" value="<?php echo ( $edit_mode ) ? esc_attr( $epi->data['commissioning_date']['raw'] ) : ''; ?>"/>
          <input class="form-field date" type="text" name="commissioning-date" value="<?php echo ( $epi->data['commissioning_date_valid'] ) ? esc_attr( $epi->data['commissioning_date']['rendered']['date'] ) : ''; ?>"/>
        </label>
      </div>

			<div class="form-element form-element-required update-control-date-epi">
        <span class="form-label wpeo-tooltip-event" aria-label="<?php echo ( get_option( EPI_Class::g()->option_name_default_data_periodicity ) != "" ) ? esc_html_e( 'Setting Data activated (Periodicity)', 'theepi' ) : esc_html_e( 'Setting Date disable (Periodicity)', 'theepi' ); ?>">
          <?php esc_html_e( 'Periodicity', 'theepi' ); ?>
        </span>
        <div class="form-error"></div>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-history"></i></span>
					<input class="form-field" type="number" name="periodicity" value="<?php $epi->data['periodicity'] != 0 ? esc_attr_e( $epi->data['periodicity'] ) : ''; ?>"/>
					<span class="form-field-label-next"><?php echo esc_html_e( 'days', 'theepi' ); ?></span>
				</label>
			</div>

			<div class="form-element form-element-unboxed group-date">
				<span class="form-label wpeo-tooltip-event" aria-label="<?php esc_html_e( 'First Control Date = Commissioning Date + Periodicity', 'theepi' ); ?>"> <?php esc_html_e( 'First Control Date', 'theepi' ); ?> </span>
        <div class="form-error"></div>
      	<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-calendar-check"></i></span>
					<input type="hidden" class="mysql-date" name="control-date" value="<?php echo ( $edit_mode ) ? esc_attr( $epi->data['control_date']['raw'] ) : ''; ?>"/>
					<input class="form-field date" type="text" name="control-date" value="<?php echo ( $epi->data['commissioning_date_valid'] ) ? esc_attr( $epi->data['control_date']['rendered']['date'] ) : ''; ?>"/>
				</label>
			</div>
    </div>
	</div>

	<div class="advanced-service information wpeo-form">
		<h2>
			<?php esc_html_e( 'Additional Information', 'theepi' ); ?>
		</h2>

		<div class="wpeo-gridlayout grid-3 grid-padding-1">
			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Maker', 'theepi' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-tools"></i></span>
					<input type="text" class="form-field" name="maker" value="<?php echo esc_attr( $epi->data['maker'] ) ?>"/>
				</label>
			</div>

			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Seller', 'theepi' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-store"></i></span>
					<input type="text" class="form-field" name="seller" value="<?php echo esc_attr( $epi->data['seller'] ); ?>"/>
				</label>
			</div>

			<!-- <div class="form-element wpeo-autocomplete autocomplete-light" data-action="search_users">
				<span class="form-label"><?php esc_html_e( 'Manager', 'theepi' ); ?></span>
				<label class="form-field-container autocomplete-label">
					<i class="autocomplete-icon-before fas fa-user-tie"></i>
					<input class="autocomplete-search-input" type="text" autocomplete="off" />
					<span class="autocomplete-icon-after"><i class="fas fa-times"></i></span>
				</label>
				<ul class="autocomplete-search-list"></ul>
			</div> -->

			<!-- <div class="form-element">
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-user-tie"></i></span>
					<input type="text" class="form-field" name="manager" value="<?php echo esc_attr( $epi->data['manager'] ); ?>"/>
				</label>
			</div> -->

			<?php
				Service_Class::g()->display_form_owner( $epi );
			?>

			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Reference', 'theepi' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-barcode"></i></span>
					<input type="text" class="form-field" name="reference" value="<?php echo esc_attr( $epi->data['reference'] ); ?>"/>
				</label>
			</div>


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

			<!-- <div>
				<div class="form-element">
					<span class="form-label"><?php esc_html_e( 'File', 'theepi' ); ?></span>
					<label class="form-field-container">
						<span class="form-field-icon-prev"><i class="fas fa-barcode"></i></span>
						<input type="text" class="form-field" name="reference" value="<?php echo esc_attr( $epi->data['reference'] ); ?>"/>
					</label>
				</div>
			</div> -->
		</div>
	</div>

	<!-- <?php if( ! empty( $control )  && ( $control->data['id'] != 0) ): ?>
		<div class="advanced-service control">
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
	<?php endif; ?> -->

	<div class="advanced-service footer">
		<div class="wpeo-button wpeo-tooltip-event button-grey action-attribute event-keybord-cancel"
			aria-label="<?php esc_html_e( 'Cancel EPI', 'theepi' ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>"
			data-action="cancel_edit_epi"
			data-message="Are you sure you want to leave the PPE Edit Mode"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'cancel_edit_epi' ) ); ?>">
			<?php esc_html_e( 'Cancel', 'theepi' ); ?>
		</div>

		<div class="wpeo-button wpeo-tooltip-event button-green button-progress button-square-40 edit button-save-epi"
			aria-label="<?php esc_html_e( 'Save EPI', 'theepi' ); ?>"
			data-parent="epi-row"
			data-action="save_epi"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_epi' ) ); ?>"
			data-id="<?php echo esc_attr( $epi->data['id'] ); ?>">
			<span class="button-icon fas fa-save"></span>
		</div>
	</div>
</div>
