<?php
/**
 * Filtres des EPI
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2018 Evarisk
 * @since     0.4.0
 * @version   0.4.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Documentation des variables utilisées dans la vue.
 *
 * @var array  $filter_options  Les valeurs du filtres.
 * @var string $page            La page active en focntion du filtre.
 */
?>

<div class="epi-filters wpeo-form form-light">
	<div class="form-element">
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-filter"></i></span>
			<select id="filters" name="filters" class="form-field">
				<?php foreach ( $filter_options as $key => $value ) : ?>
					<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $page ); ?> ><?php echo esc_html( $value ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
	</div>
	<div class="wpeo-button button-grey action-input"
		data-parent="epi-filters"
		data-action="filter_epi"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'filter_epi' ) ); ?>">
		<?php esc_html_e( 'Filter', 'theepi' ); ?>
	</div>
</div>
