<?php

/**
 * Copyright 2023 Christoph M. Becker
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

namespace Syntaxhighlighter\Infra;

class SystemChecker
{
    public function checkVersion(string $actual, string $minimum): bool
    {
        return version_compare($actual, $minimum) >= 0;
    }

    public function checkExtension(string $extension): bool
    {
        return extension_loaded($extension);
    }

    public function checkWritability(string $path): bool
    {
        return is_writable($path);
    }
}
