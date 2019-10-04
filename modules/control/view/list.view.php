<?php
/**
 * La vue pour lister les contrôles.
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.7.0
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
				'frontend'   => $frontend,
			)
		);
	endforeach;
endif;
