<?php
/**
 * Handle EPI.
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
}

/**
 * Handle EPI
 */
class EPI_Class extends \eoxia\Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name = '\theepi\EPI_Model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type = 'theepi-epi';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key = '_theepi_epi';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'theepi/epi';

	/**
	 * La version de l'objet
	 *
	 * @var string
	 */
	protected $version = '0.1';

	/**
	 * La fonction appelée automatiquement avant la création de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $before_post_function = array( '\theepi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\theepi\get_identifier', '\theepi\update_remaining_time' );

	/**
	 * Le préfixe de l'objet dans TheEPI.
	 *
	 * @var string
	 */
	public $element_prefix = 'EPI';

	/**
	 * La limite des risques a affiché par page
	 *
	 * @var integer
	 */
	protected $limit_epi = 10;

	/**
	 * Le nombre d'EPI par page.
	 *
	 * @var integer
	 */
	public $option_name = 'epi_per_page';

	/**
	 * Le nom pour le register post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Personal protective equipment';

	/**
	 * Appel la vue principale pour afficher le tableau HTML contenant les EPI.
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 *
	 * @param integer $current_page The current page.
	 *
	 * @return void
	 */
	public function display( $current_page = 1 ) {
		$epi_schema = self::g()->get( array(
			'schema' => true,
		), true );

		$count_epi = count( self::g()->get( array(
			'fields' => array( 'ID' ),
		) ) );

		$per_page = get_user_meta( get_current_user_id(), $this->option_name, true );

		if ( empty( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_epi;
		}

		$number_page = ceil( $count_epi / $per_page );

		\eoxia\View_Util::exec( 'theepi', 'epi', 'main', array(
			'count_epi'    => $count_epi,
			'number_page'  => $number_page,
			'current_page' => $current_page,
			'epi_schema'   => $epi_schema,
		) );
	}

	/**
	 * Initialise les options d'écrans.
	 *
	 * @since 0.2.0
	 * @version 0.2.0
	 *
	 * @return void
	 */
	public function callback_add_screen_option() {
		add_screen_option(
			'per_page',
			array(
				'label'   => __( 'EPI per page', 'theepi' ),
				'default' => self::g()->limit_epi,
				'option'  => self::g()->option_name,
			)
		);
	}

	/**
	 * Charges et affiches la liste des EPI
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 *
	 * @param integer $current_page The current page.
	 *
	 * @return void
	 */
	public function display_epi_list( $current_page = 1 ) {
		$per_page = get_user_meta( get_current_user_id(), $this->option_name, true );

		if ( empty( $per_page ) || $per_page < 1 ) {
			$per_page = $this->limit_epi;
		}

		$args = array(
			'offset'         => ( $current_page - 1 ) * $per_page,
			'posts_per_page' => $per_page,
		);

		$epi_list = self::g()->get( $args );

		\eoxia\View_Util::exec( 'theepi', 'epi', 'list', array(
			'epi_list' => $epi_list,

		) );
	}
}

EPI_Class::g();
