<?php

/**
 * Copyright 2012-2023 Christoph M. Becker
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

use Syntaxhighlighter\Dic;
use Syntaxhighlighter\Infra\ThemeRepo;

const SYNTAXHIGHLIGHTER_VERSION = "1.1-dev";

/** @return list<string> */
function syntaxhighlighter_themes(): array
{
    global $pth;

    $repo = new ThemeRepo("{$pth['folder']['plugins']}syntaxhighlighter/");
    return $repo->all();
}

/**
 * @var string $edit
 */

if (!$edit) {
    Dic::makeInitHighlighter()()->trigger();
}
