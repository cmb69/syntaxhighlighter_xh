<?php

/**
 * Copyright 2012-2022 Christoph M. Becker
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
    private const VERSION = '1.0';

    public function run(): void
    {
        global $edit;

        if (!$edit) {
            $this->initHighlighter();
        }
        if (XH_ADM) { // @phpstan-ignore-line
            XH_registerStandardPluginMenuItems(false);
            if (XH_wantsPluginAdministration('syntaxhighlighter')) {
                $this->handleAdministration();
            }
        }
    }

    private function handleAdministration(): void
    {
        global $o, $admin;

        $o .= print_plugin_admin('off');
        switch ($admin) {
            case '':
                $o .= $this->renderInfo();
                break;
            default:
                $o .= plugin_admin_common();
        }
    }

    private function getBrushes(): string
    {
        global $pth;

        $dir = $pth['folder']['plugins'] . 'syntaxhighlighter/lib/scripts/';
        $brushes = [
            ['applescript', $dir . 'shBrushAppleScript.js'],
            ['actionscript3', 'as3', $dir . 'shBrushAS3.js'],
            ['bash', 'shell', $dir . 'shBrushBash.js'],
            ['coldfusion', 'cf', $dir . 'shBrushColdFusion.js'],
            ['cpp', 'c', $dir . 'shBrushCpp.js'],
            ['c#', 'c-sharp', 'csharp', $dir . 'shBrushCSharp.js'],
            ['css', $dir . 'shBrushCss.js'],
            ['delphi', 'pascal', 'pas', $dir . 'shBrushDelphi.js'],
            ['diff', $dir . 'shBrushDiff.js'],
            ['patch', $dir . 'shBrushPatch.js'],
            ['erl', 'erlang', $dir . 'shBrushErlang.js'],
            ['groovy', $dir . 'shBrushGroovy.js'],
            ['java', $dir . 'shBrushJava.js'],
            ['jfx', 'javafx', $dir . 'shBrushJavaFX.js'],
            ['js', 'jscript', 'javascript', $dir . 'shBrushJScript.js'],
            ['perl', 'pl', $dir . 'shBrushPerl.js'],
            ['php', $dir . 'shBrushPhp.js'],
            ['powershell', $dir . 'shBrushPowershell.js'],
            ['text', 'plain', $dir . 'shBrushPlain.js'],
            ['py', 'python', $dir . 'shBrushPython.js'],
            ['ruby', 'rails', 'ror', 'rb', $dir . 'shBrushRuby.js'],
            ['sass', 'scss', $dir . 'shBrushSass.js'],
            ['scala', $dir . 'shBrushScala.js'],
            ['sql', $dir . 'shBrushSql.js'],
            ['vb', 'vbnet', $dir . 'shBrushVb.js'],
            ['xml', 'xhtml', 'xslt', 'html', $dir . 'shBrushXml.js'],
        ];
        return json_encode($brushes, JSON_HEX_APOS|JSON_UNESCAPED_SLASHES);
    }

    private function initHighlighter(): void
    {
        global $pth, $hjs, $bjs, $plugin_cf, $plugin_tx;

        $hjs .= "<meta name=\"syntaxhighlighter.brushes\" content='{$this->getBrushes()}'>\n";

        $pcf = $plugin_cf['syntaxhighlighter'];
        $ptx = $plugin_tx['syntaxhighlighter'];
        $dir = $pth['folder']['plugins'] . 'syntaxhighlighter/';

        foreach (['shCore', 'shAutoloader'] as $f) {
            $fn = $dir . 'lib/scripts/' . $f . '.js';
            $bjs .= '<script type="text/javascript" src="' . $fn . '"></script>' . "\n";
        }
        foreach (['shCore', 'shTheme'] as $f) {
            $fn = $dir . 'lib/styles/' . $f . $pcf['theme'] . '.css';
            $hjs .= '<link rel="stylesheet" href="' . $fn . '" type="text/css">' . "\n";
        }

        $strings = [];
        $keys = ['expand_source', 'help', 'alert', 'no_brush',
            'brush_not_html_script'];
        foreach ($keys as $key) {
            $jskey = substr($key, 0, 1)
                . substr(implode('', array_map('ucfirst', explode('_', $key))), 1);
            $strings[$jskey] = $ptx[$key];
        }
        $strings = json_encode($strings, JSON_HEX_APOS|JSON_UNESCAPED_SLASHES);

        $hjs .= "<meta name=\"syntaxhighlighter.strings\" content='{$strings}'>\n";

        $script = "{$pth["folder"]["plugins"]}syntaxhighlighter/syntaxhighlighter.min.js";
        $hjs .= "<script type=\"text/javascript\" src=\"$script\"</script>\n";
    }

    private function renderInfo(): string
    {
        global $pth, $plugin_tx;

        $view = new View("{$pth['folder']['plugins']}syntaxhighlighter/views/", $plugin_tx["syntaxhighlighter"]);
        return $view->render('info', [
            "version" => self::VERSION,
            "checks" => (new SystemCheckService())->getChecks(),
        ]);
    }
}
