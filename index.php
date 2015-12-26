<?php

/**
 * Front-end of Syntaxhighlighter_XH.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Syntaxhighlighter
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2015 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Syntaxhighlighter_XH
 */


/*
 * Prevent direct access.
 */
if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}


/**
 * The plugin version.
 */
define('SYNTAXHIGHLIGHTER_VERSION', '@SYNTAXHIGHLIGHTER_VERSION@');

require_once $pth['folder']['plugin_classes'] . 'Controller.php';

$temp = new Syntaxhighlighter_Controller();
$temp->dispatch();

?>
