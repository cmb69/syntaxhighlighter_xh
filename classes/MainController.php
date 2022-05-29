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

class MainController
{
    /** @var string */
    private $pluginFolder;

    /** @var array<string,string> */
    private $conf;

    /** @var array<string,string> */
    private $lang;

    /**
     * @param array<string,string> $conf
     * @param array<string,string> $lang
     */
    public function __construct(string $pluginFolder, array $conf, array $lang)
    {
        $this->pluginFolder = $pluginFolder;
        $this->conf = $conf;
        $this->lang = $lang;
    }

    public function invoke(): void
    {
        $this->addMetaJson("syntaxhighlighter.brushes", $this->getBrushes());
        foreach (['shCore', 'shAutoloader'] as $f) {
            $this->addScript("{$this->pluginFolder}lib/scripts/{$f}.js");
        }
        foreach (['shCore', 'shTheme'] as $f) {
            $this->addStylesheet("{$this->pluginFolder}lib/styles/{$f}{$this->conf['theme']}.css");
        }
        $this->addMetaJson("syntaxhighlighter.strings", $this->getStrings());
        $this->addScript("{$this->pluginFolder}syntaxhighlighter.min.js");
    }

    /**
     * @param mixed $value
     */
    private function addMetaJson(string $name, $value): void
    {
        global $hjs;

        $content = (string) json_encode($value, JSON_HEX_APOS | JSON_UNESCAPED_SLASHES);
        $hjs .= "<meta name=\"{$name}\" content='{$content}'>\n";
    }

    private function addStylesheet(string $filename): void
    {
        global $hjs;

        $hjs .= "<link rel=\"stylesheet\" href=\"{$filename}\" type=\"text/css\">\n";
    }

    private function addScript(string $filename): void
    {
        global $hjs;

        $hjs .= "<script type=\"text/javascript\" src=\"{$filename}\"></script>\n";
    }

    /**
     * @return mixed
     */
    private function getBrushes()
    {
        $dir = $this->pluginFolder . 'lib/scripts/';
        return [
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
    }

    /**
     * @return mixed
     */
    private function getStrings()
    {
        $strings = [];
        foreach (['expand_source', 'help', 'alert', 'no_brush', 'brush_not_html_script'] as $key) {
            $strings[$this->camelCase($key)] = $this->lang[$key];
        }
        return $strings;
    }

    private function camelCase(string $string): string
    {
        return lcfirst(implode('', array_map('ucfirst', explode('_', $string))));
    }
}
