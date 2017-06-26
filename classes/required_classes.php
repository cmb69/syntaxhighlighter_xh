<?php

/**
 * The autoloader.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Syntaxhighlighter
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2015-2017 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Syntaxhighlighter_XH
 */

spl_autoload_register(function ($className) {
    $parts = explode('_', $className);
    if ($parts[0] == 'Syntaxhighlighter') {
        include_once dirname(__FILE__) . '/' . $parts[1] . '.php';
    }
});

?>
