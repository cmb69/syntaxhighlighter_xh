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


/**
 * Returns the brush definitions for the autoloader.
 *
 * @return string
 *
 * @global array The paths of system files and folders.
 */
function Syntaxhighlighter_brushes()
{
    global $pth;
    
    $dir = $pth['folder']['plugins'] . 'syntaxhighlighter/lib/scripts/';
    $brushes = array(
        array('applescript', $dir . 'shBrushAppleScript.js'),
        array('actionscript3', 'as3', $dir . 'shBrushAS3.js'),
        array('bash', 'shell', $dir . 'shBrushBash.js'),
        array('coldfusion', 'cf', $dir . 'shBrushColdFusion.js'),
        array('cpp', 'c', $dir . 'shBrushCpp.js'),
        array('c#', 'c-sharp', 'csharp', $dir . 'shBrushCSharp.js'),
        array('css', $dir . 'shBrushCSS.js'),
        array('delphi', 'pascal', 'pas', $dir . 'shBrushDelphi.js'),
        array('diff', $dir . 'shBrushDiff.js'),
        array('patch', $dir . 'shBrushPatch.js'),
        array('erl', 'erlang', $dir . 'shBrushErlang.js'),
        array('groovy', $dir . 'shBrushGroovy.js'),
        array('java', $dir . 'shBrushJava.js'),
        array('jfx', 'javafx', $dir . 'shBrushJavaFX.js'),
        array('js', 'jscript', 'javascript', $dir . 'shBrushJScript.js'),
        array('perl', 'pl', $dir . 'shBrushPerl.js'),
        array('php', $dir . 'shBrushPhp.js'),
        array('text', 'plain', $dir . 'shBrushPlain.js'),
        array('py', 'python', $dir . 'shBrushPython.js'),
        array('ruby', 'rails', 'ror', 'rb', $dir . 'shBrushRuby.js'),
        array('sass', 'scss', $dir . 'shBrushSass.js'),
        array('scala', $dir . 'shBrushScala.js'),
        array('sql', $dir . 'shBrushSql.js'),
        array('vb', 'vbnet', $dir . 'shBrushVb.js'),
        array('xml', 'xhtml', 'xslt', 'html', $dir . 'shBrushXml.js'),
    );
    return implode(',', array_map('json_encode', $brushes));
}


/**
 * Writes the necessary JS and CSS to the head element.
 *
 * @return void
 * 
 * @global array  The paths of system files and folders.
 * @global string Elements to be inserted in the head element.
 * @global array  The configuration of the plugins.
 * @global array  The localization of the plugins.
 */
function syntaxhighlighter()
{
    global $pth, $hjs, $plugin_cf, $plugin_tx;

    $brushes = syntaxhighlighter_brushes();

    $pcf = $plugin_cf['syntaxhighlighter'];
    $ptx = $plugin_tx['syntaxhighlighter'];
    $dir = $pth['folder']['plugins'] . 'syntaxhighlighter/';

    foreach (array('shCore', 'shAutoloader') as $f) {
        $fn = $dir . 'lib/scripts/' . $f . '.js';
        $hjs .= '<script type="text/javascript" src="' . $fn . '"></script>'
            . "\n";
    }
    foreach (array('shCore', 'shTheme') as $f) {
        $fn = $dir . '/lib/styles/' . $f . $pcf['theme'] . '.css';
        $hjs .= tag('link rel="stylesheet" href="' . $fn . '" type="text/css"')
            . "\n";
    }

    $strings = array();
    $keys = array('expand_source', 'help', 'alert', 'no_brush',
        'brush_not_html_script');
    foreach ($keys as $key) {
        $jskey = substr($key, 0, 1)
            . substr(implode('', array_map('ucfirst', explode('_', $key))), 1);
        $strings[$jskey] = $ptx[$key];
    }
    $strings = json_encode($strings);

    $hjs .= <<<SCRIPT
<script type="text/javascript">
/* <![CDATA[ */
(function () {
    function init() {
	SyntaxHighlighter.autoloader($brushes);
	SyntaxHighlighter.config.strings = $strings;
	SyntaxHighlighter.all();
    }
    if (typeof window.addEventListener != "undefined") {
	window.addEventListener("load", init, false);
    } else if (typeof window.attachEvent != "undefined") {
	window.attachEvent("onload", init);
    }
}());
/* ]]> */
</script>

SCRIPT;
}


/*
 * Include the necessary JS and CSS.
 */
if (!$edit) {
    syntaxhighlighter();
}

?>
