<?php
/**
 * La liste des commentaires
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0.0
 * @version 0.1.0.0
 * @copyright 2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<ul class="comment-container">

	<?php
	View_Util::exec( 'epi', 'comment/item-edit', array(
		'comment' => $comment_schema,
		'userdata' => $userdata,
		'epi' => $epi,
	) );
	?>
</ul>
