<?php
/**
 * La vue qui s'occupe de la pagination des EPI.
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.2.0
 * @version   0.6.0
 */

namespace theepi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php if( $number_pages > 0 ): ?>
	<ul class="wpeo-pagination epi" data-page="<?php echo esc_html( $page ) ?>">
		<?php if ( $pagination != 1 ) : ?>
			<!-- Bouton précédent -->
			<li class="pagination-element pagination-prev">
				<a href="#" class="action-attribute  epi-load-more"
					data-action="load_more_epi"
					data-page="<?php echo esc_html( $page ) ?>"
					data-pagination="<?php echo esc_html( $pagination - 1 ) ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_more_epi' ) ); ?>"
					data-offset= "<?php echo esc_attr( $offset - $per_page); ?>">
					<span><?php esc_html_e( 'Previous', 'theepi' ); ?></span>
					<i class="pagination-icon fas fa-long-arrow-alt-left fa-fw"></i>
				</a>
			</li>
		<?php endif; ?>

		<?php for( $i = 1; $i <= $number_pages; $i ++ ): ?>
			<!-- Element simple -->
			<li class="pagination-element <?php echo esc_html( $i == $pagination ? 'pagination-current' : '' ); ?>" style="cursor : pointer">
				<a href="#" class="action-attribute  epi-load-more"
					data-action="load_more_epi"
					data-page="<?php echo esc_html( $page ) ?>"
					data-pagination="<?php echo esc_html( $i ) ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_more_epi' ) ); ?>"
					<?php if ( $i > 0 ) : ?>
						data-offset="<?php echo esc_attr( ($per_page * ( $i - 1 ))); ?>"
					<?php else: ?>
						data-offset="<?php echo esc_attr( $offset ); ?>"
					<?php endif; ?>><?php echo esc_html( $i ); ?>
				</a>
			</li>
		<?php endfor; ?>
		</li>

		<?php if ( $number_pages != $pagination ) : ?>
			<!-- Bouton suivant -->
			<li class="pagination-element pagination-next">
				<a href="#" class="action-attribute  epi-load-more"
					data-action="load_more_epi"
					data-page="<?php echo esc_html( $page ) ?>"
					data-pagination="<?php echo esc_html( $pagination + 1 ) ?>"
					data-offset = "<?php echo esc_attr( $offset + $per_page); ?>"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_more_epi' ) ); ?>">
					<span><?php esc_html_e( 'Next', 'task-manager' ); ?></span>
					<i class="pagination-icon fas fa-long-arrow-alt-right fa-fw"  ></i>
				</a>
			</li>
		<?php endif; ?>
	</ul>
<?php endif; ?>
