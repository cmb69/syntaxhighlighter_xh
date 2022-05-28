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

(new Syntaxhighlighter\Plugin())->run();

/**
 * @return array<string>
 */
function Syntaxhighlighter_themes(): array
{
    global $pth;

    $themeFolder = "{$pth['folder']['plugins']}syntaxhighlighter/lib/styles/";
    $themes = [];
    $filenames = scandir($themeFolder);
    if ($filenames === false) {
        return $themes;
    }
    foreach ($filenames as $filename) {
        if (preg_match('/shTheme(\w+)\.css/', $filename, $matches)) {
            $themes[] = $matches[1];
        }
    }
    sort($themes);
    return $themes;
}
