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

namespace Syntaxhighlighter\Infra;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class ThemeRepoTest extends TestCase
{
    /** @var ThemeRepo */
    private $sut;

    public function setUp(): void
    {
        vfsStream::setup("root/");
        mkdir(vfsStream::url("root/lib/styles/"), 0777, true);
        $this->sut = new ThemeRepo(vfsStream::url("root/"));
    }

    public function testFindsAllThemes(): void
    {
        touch(vfsStream::url("root/lib/styles/shThemeSpecial.css"));
        touch(vfsStream::url("root/lib/styles/shThemeDefault.css"));
        touch(vfsStream::url("root/lib/styles/shThemeDefault.txt"));
        touch(vfsStream::url("root/lib/styles/ThemeDefault.css"));
        $actual = $this->sut->all();
        $this->assertEquals(["Default", "Special"], $actual);
    }

    public function testFindsNoThemesInEmptyFolder(): void
    {
        $actual = $this->sut->all();
        $this->assertEmpty($actual);
    }
}
