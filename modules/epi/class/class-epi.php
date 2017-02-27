<?php
/**
 * Les EPI
 *
 * @since 0.0.0.1
 * @version 0.0.0.1
 */

namespace evarisk_epi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les EPI
 */
class EPI_Class extends Post_Class {

	/**
	 * Le nom du modèle
	 *
	 * @var string
	 */
	protected $model_name   = '\evarisk_epi\epi_model';

	/**
	 * Le post type
	 *
	 * @var string
	 */
	protected $post_type    = 'digi-epi';

	/**
	 * La clé principale du modèle
	 *
	 * @var string
	 */
	protected $meta_key    	= '_wpdigi_epi';

	/**
	 * La route pour accéder à l'objet dans la rest API
	 *
	 * @var string
	 */
	protected $base = 'digirisk/epi';

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
	protected $before_post_function = array( '\digi\construct_identifier' );

	/**
	 * La fonction appelée automatiquement après la récupération de l'objet dans la base de donnée
	 *
	 * @var array
	 */
	protected $after_get_function = array( '\digi\get_identifier', '\evarisk_epi\update_remaining_time' );

	/**
	 * Le préfixe de l'objet dans DigiRisk
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
	protected $post_type_name = 'Équipements de protection individuelle';

	/**
	 * Le constructeur
	 *
	 * @since 0.0.0.1
	 * @version 0.0.0.1
	 */
	protected function construct() {
		parent::construct();
		add_filter( 'json_endpoints', array( $this, 'callback_register_route' ) );
	}

	public function display_epi_list() {
		$epi_list = EPI_Class::g()->get();
		View_Util::exec( 'epi', 'list', array( 'epi_list' => $epi_list ) );
	}
}

EPI_Class::g();
