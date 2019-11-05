<?php
/**
 * La vue service d'un EPI.
 *
 * @package   TheEPI
 * @author    Nicolas Domenech <nicolas@eoxia.com>
 * @copyright 2019 Evarisk
 * @since     0.6.0
 * @version   0.7.0
 */

namespace theepi;

if ( ! defined('ABSPATH') ) {
    exit;
}

global $eo_search; ?>

<?php $eo_search->display( 'theepi' ); ?>
