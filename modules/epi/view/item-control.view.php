<?php
/**
 * La vue des contrôles d'un item de la page "EPI"
 *
 * @author Nicolas Domenech <nicolas@eoxia.com>
 * @since 0.1.0
 * @version 0.5.0
 * @copyright 2019 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php if (( $number_days < 0 )) : ?>

	<div class="epi-item-control-black">
		<?php esc_html_e( 'EXCEEDED', 'theepi' ); ?>
		<div class="epi-item-control-white-text"><?php esc_html_e( abs( $number_days ) ); ?></div>
		<?php esc_html_e( 'DAYS', 'theepi' ); ?>
	</div>

<?php elseif (( $number_days >=0 ) && ( $number_days <= 15 )) : ?>

	<div class="epi-item-control-red">
		<?php esc_html_e( 'STAYS', 'theepi' ); ?>
		<div class="epi-item-control-white-text"><?php esc_html_e( abs( $number_days ) ); ?></div>
		<?php esc_html_e( 'DAYS', 'theepi' ); ?>
	</div>

<?php elseif (( $number_days > 15 ) && ( $number_days <= 30 )) : ?>

	<div class="epi-item-control-orange">
		<?php esc_html_e( 'STAYS', 'theepi' ); ?>
		<div class="epi-item-control-white-text"><?php esc_html_e( abs( $number_days ) ); ?></div>
		<?php esc_html_e( 'DAYS', 'theepi' ); ?>
	</div>

<?php else : ?>

	<div class="epi-item-control-white">
		<?php esc_html_e( 'STAYS', 'theepi' ); ?>
		<div class="epi-item-control-black-text"><?php esc_html_e( abs( $number_days ) ); ?></div>
		<?php esc_html_e( 'DAYS', 'theepi' ); ?>
	</div>

<?php endif; ?>

<style>

.epi-item-control-black {
	text-align: center;
	background-color: black;
	color : white;

}

.epi-item-control-red {
	text-align: center;
	background-color: red;
	color: white;
}

.epi-item-control-orange{
	text-align: center;
	background-color: orange;
	color: white;
}

.epi-item-control-white {
	text-align: center;
	background-color: white;
	color: black;
}

.epi-item-control-white-text {
	font-weight: bold;
	font-size: 25px;
}

.epi-item-control-black-text {
	font-weight: bold;
	font-size: 25px;
}

</style>
