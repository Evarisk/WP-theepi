<?php
/**
 * La vue principale de la page "EPI".
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com>
 * @copyright 2017 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
if ( ! empty( $controls ) ) :
	foreach ( $controls as $control ) :
		\eoxia\View_Util::exec(
			'theepi', 'control', 'item', array(
				'control'    => $control,
			)
		);
	endforeach;
endif;
