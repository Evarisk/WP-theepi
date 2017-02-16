<?php
/**
 * Ajout le champ status "OK/KO".
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.0.1.0
 * @version 0.0.1.0
 * @copyright 2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<select name="list_comment[<?php echo esc_attr( $comment->id ); ?>][state]">
	<option>OK</option>
	<option>KO</option>
</select>
