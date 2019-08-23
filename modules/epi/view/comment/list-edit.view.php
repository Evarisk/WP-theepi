<?php
/**
 * La liste des commentaires
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com>
 * @copyright 2017 Evarisk
 * @since     0.1.0
 * @version   0.2.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<ul class="comment-container">
	<?php
	if ( ! empty( $comments ) ) :
		foreach ( $comments as $comment ) :
			\eoxia\View_Util::exec(
				'theepi', 'epi', 'comment/item', array(
					'comment'  => $comment,
					'userdata' => $userdata,
					'epi'      => $epi,
				)
			);
		endforeach;
	endif;

	\eoxia\View_Util::exec(
		'theepi', 'epi', 'comment/item-edit', array(
			'comment'  => $comment_schema,
			'userdata' => $userdata,
			'epi'      => $epi,
		)
	);
	?>
</ul>
