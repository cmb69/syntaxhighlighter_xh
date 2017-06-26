<?php

/**
 * Front-end of Syntaxhighlighter_XH.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Syntaxhighlighter
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2017 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Syntaxhighlighter_XH
 */

/**
 * The plugin version.
 */
define('SYNTAXHIGHLIGHTER_VERSION', '@SYNTAXHIGHLIGHTER_VERSION@');

$temp = new Syntaxhighlighter_Controller();
$temp->dispatch();

?>
