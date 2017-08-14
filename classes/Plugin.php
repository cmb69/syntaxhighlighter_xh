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

class Plugin
{
    const VERSION = '@SYNTAXHIGHLIGHTER_VERSION@';

    /**
     * @return void
     */
    public function run()
    {
        global $edit;

        if (!$edit) {
            $this->initHighlighter();
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
                $o .= $this->renderInfo();
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
            array('powershell', $dir . 'shBrushPowershell.js'),
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
    private function initHighlighter()
    {
        global $pth, $hjs, $bjs, $plugin_cf, $plugin_tx;

        $brushes = $this->getBrushes();

        $pcf = $plugin_cf['syntaxhighlighter'];
        $ptx = $plugin_tx['syntaxhighlighter'];
        $dir = $pth['folder']['plugins'] . 'syntaxhighlighter/';

        foreach (array('shCore', 'shAutoloader') as $f) {
            $fn = $dir . 'lib/scripts/' . $f . '.js';
            $bjs .= '<script type="text/javascript" src="' . $fn . '"></script>'
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
(function () {
    if (!("addEventListener" in document)) {
        return;
    }
    document.addEventListener("DOMContentLoaded", function () {
        var aboutDialog = SyntaxHighlighter.config.strings.aboutDialog;
        SyntaxHighlighter.autoloader($brushes);
        SyntaxHighlighter.config.strings = $strings;
        SyntaxHighlighter.config.strings.aboutDialog = aboutDialog;
        SyntaxHighlighter.all();
    });
}());
</script>

SCRIPT;
    }

    /**
     * @return string
     */
    private function renderInfo()
    {
        global $pth;

        $view = new View('info');
        $view->logo = "{$pth['folder']['plugins']}syntaxhighlighter/syntaxhighlighter.png";
        $view->version = self::VERSION;
        $view->checks = (new SystemCheckService)->getChecks();
        return (string) $view;
    }
}
