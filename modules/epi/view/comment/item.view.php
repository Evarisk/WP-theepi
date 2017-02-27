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

<li class="comment">
	<span class="user"><?php echo ! empty( $userdata->display_name ) ? $userdata->display_name : 'Indéfini'; ?>, </span>
	<span class="date"><?php echo $comment->date; ?> : </span>
	<span class="content"><?php echo $comment->content; ?></span>
	<span></span>
</li>
