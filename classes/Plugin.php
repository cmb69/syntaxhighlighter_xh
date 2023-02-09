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
    public const VERSION = '1.0';

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

    private function initHighlighter(): void
    {
        global $pth, $plugin_cf, $plugin_tx;

        $controller = new InitHighlighter(
            "{$pth["folder"]["plugins"]}syntaxhighlighter/",
            $plugin_cf["syntaxhighlighter"],
            $plugin_tx["syntaxhighlighter"]
        );
        $controller();
    }

    private function renderInfo(): string
    {
        global $pth, $plugin_tx;

        $pluginInfo = new PluginInfo(
            "{$pth['folder']['plugins']}syntaxhighlighter/",
            $plugin_tx['syntaxhighlighter'],
            new SystemChecker(),
            new View("{$pth['folder']['plugins']}syntaxhighlighter/views/", $plugin_tx['syntaxhighlighter'])
        );
        return $pluginInfo();
    }
}
