<?php
/**
 * La liste des commentaires
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0.0
 * @version 1.0.1
 * @copyright 2017 Evarisk
 * @package DigiRisk_EPI
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="comment-container">
	<?php
	if ( ! empty( $comments ) ) :
		foreach ( $comments as $comment ) :
			if ( 0 !== $comment->id ) :
				\eoxia\View_Util::exec( 'digirisk-epi', 'epi', 'comment/item', array(
					'comment' => $comment,
					'userdata' => $userdata,
					'epi' => $epi,
				) );
			endif;
		endforeach;
	endif;

	\eoxia\View_Util::exec( 'digirisk-epi', 'epi', 'comment/item-edit', array(
		'comment' => $comment_schema,
		'userdata' => $userdata,
		'epi' => $epi,
	) );
	?>
</ul>
