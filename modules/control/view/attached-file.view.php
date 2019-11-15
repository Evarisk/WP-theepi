<?php
/**
 * la vue modifié pour gérée les médias.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
 * @version   0.7.0
 */

namespace eoxia;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input type="hidden" name="<?php echo esc_attr( $field_name ) ?>" value="<?php echo esc_attr( $file_id ); ?>" />
<a class="wpeo-button wpeo-tooltip-event button-grey button-square-30 button-rounded"
	aria-label="<?php echo esc_attr( $filename_only ); ?>"
	target="_blank"
	href="<?php echo esc_attr( $fileurl_only ); ?>">
	<i class="fas fa-paperclip"></i>
</a>
