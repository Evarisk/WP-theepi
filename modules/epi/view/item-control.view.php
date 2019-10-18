<?php
/**
 * La vue des contrôles d'un item de la page "EPI".
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ( $number_days < 0 ) ) :
	$control_class = 'red';
elseif ( ( $number_days >= 0 ) && ( $number_days <= 15 ) ) :
	$control_class = 'orange';
elseif ( ( $number_days > 15 ) && ( $number_days <= 30 ) ) :
	$control_class = 'yellow';
else :
	$control_class = 'green';
endif;
?>

<div class="epi-item-control <?php echo esc_attr( $control_class ); ?>">
	<span class="control-days"><?php echo esc_html( $number_days ); ?></span>
	<span class="control-label"><?php esc_html_e( 'days', 'theepi' ); ?></span>
</div>
