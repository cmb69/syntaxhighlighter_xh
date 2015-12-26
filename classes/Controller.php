<?php

/**
 * The syntaxhighlighter controllers.
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

/**
 * The syntaxhighlighter controllers.
 *
 * @category CMSimple_XH
 * @package  Syntaxhighlighter
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Syntaxhighlighter_XH
 */
class Syntaxhighlighter_Controller
{
    /**
     * Dispatches on plugin related requests.
     *
     * @return void
     *
     * @global bool   Whether we're in edit mode.
     * @global bool   Whether the plugin administration is requested.
     * @global string The value of the 'admin' GP parameter.
     * @global string The value of the 'action' GP parameter.
     * @global string The content of the main output.
     */
    public function dispatch()
    {
        global $edit, $syntaxhighlighter, $admin, $action, $o;
        
        if (!$edit) {
            $this->init();
        }
        if (defined('XH_ADM') && XH_ADM
            && isset($syntaxhighlighter) && $syntaxhighlighter == 'true'
        ) {
            $o .= print_plugin_admin('off');
            switch ($admin) {
            case '':
                $o .= $this->version() . tag('hr')
                    . $this->systemCheck();
                break;
            default:
                $o .= plugin_admin_common($action, $admin, 'syntaxhighlighter');
            }
        }
    }
    
    /**
     * Returns the brush definitions for the autoloader.
     *
     * @return string
     *
     * @global array The paths of system files and folders.
     */
    protected function getBrushes()
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
    protected function init()
    {
        global $pth, $hjs, $plugin_cf, $plugin_tx;
    
        $brushes = $this->getBrushes();
    
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
	var aboutDialog = SyntaxHighlighter.config.strings.aboutDialog;
	SyntaxHighlighter.autoloader($brushes);
	SyntaxHighlighter.config.strings = $strings;
	SyntaxHighlighter.config.strings.aboutDialog = aboutDialog;
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

    /**
     * Returns the plugin version information view.
     *
     * @return string (X)HTML.
     *
     * @global array The paths of system files and folders.
     */
    protected function version()
    {
        global $pth;
    
        return '<h1><a href="http://3-magi.net/?CMSimple_XH/Syntaxhighlighter_XH">'
            . 'Syntaxhighlighter_XH</a></h1>' . "\n"
            . tag(
                'img src="' . $pth['folder']['plugins']
                . 'syntaxhighlighter/syntaxhighlighter.png"'
                . ' style="float: left; margin: 0 16px 16px 0"'
            )
            . '<p>Version: '.SYNTAXHIGHLIGHTER_VERSION.'</p>'."\n"
            . '<p>Copyright &copy; 2012-2015 <a href="http://3-magi.net">'
            . 'Christoph M. Becker</a></p>'."\n"
            . '<p>Powered by <a href="http://alexgorbatchev.com/SyntaxHighlighter/">'
            . 'Alex Gorbatchev\'s SyntaxHighlighter</a></p>'
            . '<p style="text-align: justify">'
            . 'This program is free software: you can redistribute it and/or modify'
            . ' it under the terms of the GNU General Public License as published by'
            . ' the Free Software Foundation, either version 3 of the License, or'
            . ' (at your option) any later version.</p>' . "\n"
            . '<p style="text-align: justify">'
            . 'This program is distributed in the hope that it will be useful,'
            . ' but WITHOUT ANY WARRANTY; without even the implied warranty of'
            . ' MERCHAN&shy;TABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the'
            . ' GNU General Public License for more details.</p>' . "\n"
            . '<p style="text-align: justify">'
            . 'You should have received a copy of the GNU General Public License'
            . ' along with this program.  If not, see'
            . ' <a href="http://www.gnu.org/licenses/">'
            . 'http://www.gnu.org/licenses/</a>.</p>' . "\n";
    }
    
    
    /**
     * Returns the requirements information view.
     *
     * @return string (X)HTML.
     *
     * @global array The paths of system files and folders.
     * @global array The localization of the core.
     * @global array The localization of the plugins.
     */
    protected function systemCheck()
    {
        global $pth, $tx, $plugin_tx;
    
        $phpVersion = '5.2.0';
        $ptx = $plugin_tx['syntaxhighlighter'];
        $imgdir = $pth['folder']['plugins'] . 'syntaxhighlighter/images/';
        $ok = tag('img src="' . $imgdir . 'ok.png" alt="ok"');
        $warn = tag('img src="' . $imgdir . 'warn.png" alt="warning"');
        $fail = tag('img src="' . $imgdir . 'fail.png" alt="failure"');
        $o = '<h4>' . $ptx['syscheck_title'] . '</h4>'
            . (version_compare(PHP_VERSION, $phpVersion) >= 0 ? $ok : $fail)
            . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_phpversion'], $phpVersion)
            . tag('br') . "\n";
        foreach (array('pcre') as $ext) {
            $o .= (extension_loaded($ext) ? $ok : $fail)
                . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_extension'], $ext)
                . tag('br') . "\n";
        }
        $o .= (!get_magic_quotes_runtime() ? $ok : $fail)
            . '&nbsp;&nbsp;' . $ptx['syscheck_magic_quotes']
            . tag('br') . tag('br') . "\n";
        $o .= (strtoupper($tx['meta']['codepage']) == 'UTF-8' ? $ok : $fail)
            . '&nbsp;&nbsp;' . $ptx['syscheck_encoding'] . tag('br') . "\n";
        $folders = array();
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $pth['folder']['plugins'] . 'syntaxhighlighter/' . $folder;
        }
        foreach ($folders as $folder) {
            $o .= (is_writable($folder) ? $ok : $warn)
                . '&nbsp;&nbsp;' . sprintf($ptx['syscheck_writable'], $folder)
                . tag('br') . "\n";
        }
        return $o;
    }
}

?>
