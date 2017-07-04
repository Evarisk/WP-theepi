<?php
/**
 * La liste des commentaires
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

<ul class="comment-container">
	<?php
	if ( ! empty( $comments ) ) :
		foreach ( $comments as $comment ) :
			\eoxia\View_Util::exec( 'digirisk-epi', 'epi', 'comment/item', array(
				'comment' => $comment,
			) );
		endforeach;
	endif;
	?>
</ul>
