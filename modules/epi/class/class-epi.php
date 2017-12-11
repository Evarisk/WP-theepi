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
	protected $limit_epi = -1;

	/**
	 * Le nom pour le resgister post type
	 *
	 * @var string
	 */
	protected $post_type_name = 'Personal protective equipment';

	/**
	 * Charges et affiches la liste des EPI
	 *
	 * @return void
	 *
	 * @since 0.1.0
	 * @version 0.1.0
	 */
	public function display_epi_list() {
		$epi_list = self::g()->get();
		\eoxia\View_Util::exec( 'theepi', 'epi', 'list', array(
			'epi_list' => $epi_list,
		) );
	}
}

EPI_Class::g();
