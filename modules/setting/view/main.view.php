<?php
/**
 * Gestion des onglets dans la page "theepi-setting".
 *
 * @package   TheEPI
 * @author    Jimmy Latour <jimmy@evarisk.com> && Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.2.0
 * @version   0.7.0
 */

namespace theepi;

use eoxia\View_Util;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Documentation des variables utilisées dans la vue.
 *
 * @var string $page                       La page active.
 * @var integer $default_periodicity       La donnée par défaut périodicité d'un EPI.
 * @var integer $default_lifetime          La donnée par défaut durée de vie d'un EPI.
 * @var boolean $default_purchase_date     La donnée par défaut date d'achat d'un EPI.
 * @var integer $default_manufacture_date  La donnée par défaut date de fabrication d'un EPI.
 * @var string $default_acronym_site       La donnée par défaut pour l'acronyme du Site actif.
 * @var string $default_acronym_epi        La donnée par défaut pour l'acronyme d'un EPI.
 * @var string $default_acronym_control    La donnée par défaut pour l'acronyme d'un contrôle EPI.
 */
?>

<div class="wpeo-tab setting">
	<h1><?php esc_html_e( 'TheEPI settings', 'theepi' ); ?></h1>

	<ul class="tab-list tab-redirect" data-message="<?php echo esc_html_e( "Warning !!! You didn't save your data" ); ?>">
		<li class="tab-element <?php echo 'capability' === $page ? 'tab-active' : ''; ?>" data-tab="capability" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi-setting&tab=capability' ) ); ?>"> <?php esc_html_e( 'Capability', 'theepi' ); ?></li>
		<li class="tab-element <?php echo 'default-data' === $page ? 'tab-active' : ''; ?>" data-tab="default-data" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi-setting&tab=default-data' ) ); ?>"> <?php esc_html_e( 'Default Data', 'theepi' ); ?></li>
		<li class="tab-element <?php echo 'date-management' === $page ? 'tab-active' : ''; ?>" data-tab="date-management" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi-setting&tab=date-management' ) ); ?>"> <?php esc_html_e( 'Date Management', 'theepi' ); ?></li>
		<li class="tab-element <?php echo 'acronym' === $page ? 'tab-active' : ''; ?>" data-tab="acronym" data-url="<?php echo esc_attr( admin_url( 'admin.php?page=theepi-setting&tab=acronym' ) ); ?>"> <?php esc_html_e( 'Acronym', 'theepi' ); ?></li>
	</ul>

	<div class="digirisk-wrap">

		<div class="tab-content <?php echo 'capability' === $page ? 'active' : 'hidden'; ?>">
			<?php
			View_Util::exec(
				'theepi',
				'setting',
				'capability/main',
				array(
					'page' => $page,
				)
			);
			?>
		</div>

		<div class="tab-content <?php echo 'default-data' === $page ? 'active' : 'hidden'; ?>">
			<?php
			View_Util::exec(
				'theepi',
				'setting',
				'default-data/main',
				array(
					'page'                => $page,
					'default_periodicity' => $default_periodicity,
					'default_lifetime'    => $default_lifetime,
				)
			);
			?>
		</div>

		<div class="tab-content <?php echo 'date-management' === $page ? 'active' : 'hidden'; ?>">
			<?php
			View_Util::exec(
				'theepi',
				'setting',
				'date-management/main',
				array(
					'page'                     => $page,
					'default_purchase_date'    => $default_purchase_date,
					'default_manufacture_date' => $default_manufacture_date,
				)
			);
			?>
		</div>

		<div class="tab-content <?php echo 'acronym' === $page ? 'active' : 'hidden'; ?>">
			<?php
			View_Util::exec(
				'theepi',
				'setting',
				'acronym/main',
				array(
					'page'                    => $page,
					'default_acronym_site'    => $default_acronym_site,
					'default_acronym_epi'     => $default_acronym_epi,
					'default_acronym_control' => $default_acronym_control,
				)
			);
			?>
		</div>
	</div>
</div>
