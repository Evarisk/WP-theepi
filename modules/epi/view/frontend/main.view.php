<?php
/**
 * La vue principale de la page "EPI".
 *
 * @package   TheEPI
 * @author    Evarisk <dev@evarisk.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-cell table-200" style="text-align : center;" data-title="<?php echo esc_attr_e( 'Status', 'theepi' ); ?>">
	<?php if ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "OK" ) ) : ?>
		<i class="fas fa-check-circle fa-3x" style="color: mediumspringgreen;"></i>
	<?php elseif ( ( EPI_Class::g()->get_days( $epi ) >= 0 ) && ( Audit_Class::g()->get_status( $epi ) == "rebut" ) ) : ?>
		<i class="fas fa-trash fa-3x" style="color: black;"></i>
	<?php else : ?>
		<i class="fas fa-exclamation-circle fa-3x" style="color: red;"></i>
	<?php endif; ?>
</div>
