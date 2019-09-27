<?php
/**
 * La vue des contrôles d'un item de la page "EPI".
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.1.0
 * @version   0.5.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php if ( ( $number_days < 0 ) ) : ?>

	<div class="epi-item-control-red">
		<div class="epi-item-control-white-text">- <?php esc_html_e( abs( $number_days ) ); ?></div>
	</div>

<?php elseif ( ( $number_days >= 0 ) && ( $number_days <= 15 ) ) : ?>

	<div class="epi-item-control-orange">
		<div class="epi-item-control-black-text"><?= $number_days ?></div>
	</div>

<?php elseif ( ( $number_days > 15 ) && ( $number_days <= 30 ) ) : ?>

	<div class="epi-item-control-yellow">
		<div class="epi-item-control-white-text"><?php esc_html_e( $number_days ); ?></div>
	</div>

<?php else : ?>

	<div class="epi-item-control-green">
		<div class="epi-item-control-black-text"><?php esc_html_e(  $number_days ); ?></div>
	</div>

<?php endif; ?>

<style>

.epi-item-control-green {
	text-align: center;
	background-color: green;
	color : white;

}

.epi-item-control-yellow {
	text-align: center;
	background-color: yellow;
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
