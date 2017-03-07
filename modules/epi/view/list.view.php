<?php
/**
 * La vue principale de la page "EPI"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0.0.0
 * @version 1.0.0.0
 * @copyright 2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php $i = 1; ?>
<?php if ( !empty( $epi_list ) ) : ?>
	<?php foreach ( $epi_list as $epi ) : ?>
		<?php View_Util::exec( 'epi', 'item', array( 'epi' => $epi ) ); ?>
	<?php endforeach; ?>
<?php endif; ?>
