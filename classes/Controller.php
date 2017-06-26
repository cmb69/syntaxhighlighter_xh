<?php

/**
 * Copyright 2012-2017 Christoph M. Becker
 *
 * This file is part of Syntaxhighlighter_XH.
 *
 * Syntaxhighlighter_XH is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Syntaxhighlighter_XH is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Syntaxhighlighter_XH.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Syntaxhighlighter;

class Controller
{
    /**
     * @return void
     */
    public function dispatch()
    {
        global $edit;
        
        if (!$edit) {
            $this->init();
        }
        if (XH_ADM) {
            XH_registerStandardPluginMenuItems(false);
            if (XH_wantsPluginAdministration('syntaxhighlighter')) {
                $this->handleAdministration();
            }
        }
    }

     /**
     * @return void
     */
    private function handleAdministration()
    {
        global $o, $admin, $action;

        $o .= print_plugin_admin('off');
        switch ($admin) {
            case '':
                $o .= $this->version() . tag('hr') . $this->systemCheck();
                break;
            default:
                $o .= plugin_admin_common($action, $admin, 'syntaxhighlighter');
        }
    }
    
    /**
     * @return string
     */
    private function getBrushes()
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
     * @return void
     */
    private function init()
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
     * @return string
     */
    private function version()
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
            . '<p>Copyright &copy; 2012-2017 <a href="http://3-magi.net">'
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
     * @return string
     */
    private function systemCheck()
    {
        $check = new SystemCheck();
        return $check->render();
    }
}
