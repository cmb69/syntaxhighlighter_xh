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
 * Returns the brushes necessary to highlight the given $content.
 *
 * @param string $content A text to scan for brushes.
 * 
 * @return array
 */
function Syntaxhighlighter_brushes($content)
{
    $aliases = array(
        'applescript' => 'shBrushAppleScript',
        'actionscript3' => 'shBrushAS3',
        'as3' => 'shBrushAS3',
        'bash' => 'shBrushBash',
        'shell' => 'shBrushBash',
        'coldfusion' => 'shBrushColdFusion',
        'cf' => 'shBrushColdFusion',
        'cpp' => 'shBrushCpp',
        'c' => 'shBrushCpp',
        'c#' => 'shBrushCSharp',
        'c-sharp' => 'shBrushCSharp',
        'csharp' => 'shBrushCSharp',
        'css' => 'shBrushCSS',
        'delphi' => 'shBrushDelphi',
        'pascal' => 'shBrushDelphi',
        'pas' => 'shBrushDelphi',
        'diff' => 'shBrushDiff',
        'patch' => 'shBrushPatch',
        'erl' => 'shBrushErlang',
        'erlang' => 'shBrushErlang',
        'groovy' => 'shBrushGroovy',
        'java' => 'shBrushJava',
        'jfx' => 'shBrushJavaFX',
        'javafx' => 'shBrushJavaFX',
        'js' => 'shBrushJScript',
        'jscript' => 'shBrushJScript',
        'javascript' => 'shBrushJScript',
        'perl' => 'shBrushPerl',
        'pl' => 'shBrushPerl',
        'php' => 'shBrushPhp',
        'text' => 'shBrushPlain',
        'plain' => 'shBrushPlain',
        'py' => 'shBrushPython',
        'python' => 'shBrushPython',
        'ruby' => 'shBrushRuby',
        'rails' => 'shBrushRuby',
        'ror' => 'shBrushRuby',
        'rb' => 'shBrushRuby',
        'sass' => 'shBrushSass',
        'scss' => 'shBrushSass',
        'scala' => 'shBrushScala',
        'sql' => 'shBrushSql',
        'vb' => 'shBrushVb',
        'vbnet' => 'shBrushVb',
        'xml' => 'shBrushXml',
        'xhtml' => 'shBrushXml',
        'xslt' => 'shBrushXml',
        'html' => 'shBrushXml'
    );

    preg_match_all('/<pre.*?class=["\'](.*?)["\'].*?>/isu', $content, $matches);
    $brushes = array();
    foreach ($matches[1] as $class) {
        $opts = explode(';', $class);
        foreach ($opts as $opt) {
            $opt = array_map('trim', explode(':', $opt));
            if ($opt[0] == 'brush'
                && !array_key_exists($aliases[$opt[1]], $brushes)
            ) {
                $brushes[] = $aliases[$opt[1]];
            }
        }
    }
    return $brushes;
}


/**
 * Writes the necessary JS and CSS to the head element.
 *
 * @param string $content A text to scan for brushes.
 * 
 * @return void
 * 
 * @global array  The paths of system files and folders.
 * @global string Elements to be inserted in the head element.
 * @global array  The configuration of the plugins.
 * @global array  The localization of the plugins.
 */
function syntaxhighlighter($content)
{
    global $pth, $hjs, $plugin_cf, $plugin_tx;

    $brushes = syntaxhighlighter_brushes($content);
    if (empty($brushes)) {
        return;
    }

    $pcf = $plugin_cf['syntaxhighlighter'];
    $ptx = $plugin_tx['syntaxhighlighter'];
    $dir = $pth['folder']['plugins'].'syntaxhighlighter/';

    foreach (array('shCore', 'shBrushXml') as $f) {
        $fn = $dir . 'lib/scripts/' . $f . '.js';
        $hjs .= '<script type="text/javascript" src="' . $fn . '"></script>'
            . "\n";
    }
    foreach ($brushes as $brush) {
        $fn = $dir . 'lib/scripts/' . $brush . '.js';
        $hjs .= '<script type="text/javascript" src="' . $fn. '"></script>'
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
SyntaxHighlighter.config.strings = $strings;
SyntaxHighlighter.all();
/* ]]> */
</script>

SCRIPT;
}


/*
 * Include the necessary JS and CSS.
 */
if (!$edit && $pd_s >= 0) {
    Syntaxhighlighter($c[$pd_s]);
}

?>
