<?php

/**
 * Copyright 2017-2022 Christoph M. Becker
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

class SystemCheckService
{
    /**
     * @var string
     */
    private $pluginFolder;

    /**
     * @var array<string,string>
     */
    private $lang;

    public function __construct()
    {
        global $pth, $plugin_tx;

        $this->pluginFolder = "{$pth['folder']['plugins']}syntaxhighlighter";
        $this->lang = $plugin_tx['syntaxhighlighter'];
    }

    /**
     * @return array<SystemCheck>
     */
    public function getChecks(): array
    {
        return [
            $this->checkPhpVersion('7.1.0'),
            $this->checkExtension('json'),
            $this->checkXhVersion('1.7.0'),
            $this->checkWritability("$this->pluginFolder/config/"),
            $this->checkWritability("$this->pluginFolder/css/"),
            $this->checkWritability("$this->pluginFolder/languages/")
        ];
    }

    private function checkPhpVersion(string $version): SystemCheck
    {
        $state = version_compare(PHP_VERSION, $version, 'ge') ? 'success' : 'fail';
        $label = sprintf($this->lang['syscheck_phpversion'], $version);
        $stateLabel = $this->lang["syscheck_$state"];
        return new SystemCheck($state, $label, $stateLabel);
    }

    private function checkExtension(string $extension, bool $isMandatory = true): SystemCheck
    {
        $state = extension_loaded($extension) ? 'success' : ($isMandatory ? 'fail' : 'warning');
        $label = sprintf($this->lang['syscheck_extension'], $extension);
        $stateLabel = $this->lang["syscheck_$state"];
        return new SystemCheck($state, $label, $stateLabel);
    }

    private function checkXhVersion(string $version): SystemCheck
    {
        $state = version_compare(CMSIMPLE_XH_VERSION, "CMSimple_XH $version", 'ge') ? 'success' : 'fail';
        $label = sprintf($this->lang['syscheck_xhversion'], $version);
        $stateLabel = $this->lang["syscheck_$state"];
        return new SystemCheck($state, $label, $stateLabel);
    }

    private function checkWritability(string $folder): SystemCheck
    {
        $state = is_writable($folder) ? 'success' : 'warning';
        $label = sprintf($this->lang['syscheck_writable'], $folder);
        $stateLabel = $this->lang["syscheck_$state"];
        return new SystemCheck($state, $label, $stateLabel);
    }
}
