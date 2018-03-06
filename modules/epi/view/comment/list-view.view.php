<?php
/**
 * La liste des commentaires
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1.0
 * @version 0.2.0
 * @copyright 2017 Evarisk
 * @package TheEPI
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="comment-container">
	<?php
	if ( ! empty( $comments ) ) :
		foreach ( $comments as $comment ) :
			\eoxia\View_Util::exec( 'theepi', 'epi', 'comment/item', array(
				'comment' => $comment,
			) );
		endforeach;
	endif;
	?>
</ul>
