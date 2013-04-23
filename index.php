<?php

/**
 * Front-End of Syntaxhighlighter_XH.
 *
 * Copyright (c) 2012 Christoph M. Becker (see license.txt)
 */


if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}


define('SYNTAXHIGHLIGHTER_VERSION', '1beta1');


/**
 * Returns the brushes necessary to highlight the given $cnt.
 *
 * @param string $cnt
 * @return array
 */
function Syntaxhighlighter_brushes($cnt)
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

    preg_match_all('/<pre.*?class=["\'](.*?)["\'].*?>/isu', $cnt, $matches);
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
 * Writes the necessary JS and CSS to <head>.
 *
 * @global string $hjs
 * @param string $cnt
 * @return void
 */
function Syntaxhighlighter($cnt)
{
    global $pth, $hjs, $plugin_cf, $plugin_tx;

    $brushes = syntaxhighlighter_brushes($cnt);
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

    $strs = array();
    $keys = array('expand_source', 'help', 'alert', 'no_brush',
	'brush_not_html_script');
    foreach ($keys as $key) {
	$jskey = substr($key, 0, 1)
	    . substr(implode('', array_map('ucfirst', explode('_', $key))), 1);
	$strs[] = $jskey . " = '"
	    . addcslashes($ptx[$key], "\0..\37\"\'\\") . "';";
    }
    $strs = implode("\n        ", $strs);

    $defs = array();
    foreach ($pcf as $opt => $val) {
	list($cat, $key) = explode('_', $opt, 2);
	if ($cat == 'shd') {
	    $defs[] = "defaults['" . str_replace('_', '-', $key) . "'] = 3;";
	}
    }
    $defs = implode("\n    ", $defs);

    $hjs .= <<<SCRIPT
<script src="{$dir}syntaxhighlighter.js" type="text/javascript"></script>
<script type="text/javascript">
/* <![CDATA[ */
with (SyntaxHighlighter) {
    with (config.strings) {
	$strs
    }
    $defs
    all()
}
/* ]]> */
</script>

SCRIPT;
}


if (!$edit) {
    Syntaxhighlighter($c[$pd_s]);
}

?>
