<?php
/**
 * The file.
 *
 * @author Eoxia <dev@eoxia.com>
 * @since 1.2.0
 * @version 1.2.0
 * @copyright 2017-2018 Eoxia
 * @package EO_Framework\EO_Upload\List\View
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<li>
	<input type="hidden" name="<?php echo esc_attr( $field_name ); ?>" value="<?php echo esc_attr( $file_id ); ?>" />
	<a class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-rounded"
		aria-label="<?php echo esc_attr( $filename_only ); ?>"
		target="_blank"
		href="<?php echo esc_attr( $fileurl_only ); ?>">
		<i class="fas fa-file"></i>
	</a>
</li>
