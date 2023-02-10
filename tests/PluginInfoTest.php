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

namespace Syntaxhighlighter;

use PHPUnit\Framework\TestCase;
use ApprovalTests\Approvals;

use Syntaxhighlighter\Infra\SystemChecker;
use Syntaxhighlighter\Infra\View;

class PluginInfoTest extends TestCase
{
    public function testRendersPluginInfo(): void
    {
        $plugin_tx = XH_includeVar("./languages/en.php", 'plugin_tx');
        $lang = $plugin_tx['syntaxhighlighter'];
        $systemChecker = $this->createStub(SystemChecker::class);
        $systemChecker->method('checkVersion')->willReturn(false);
        $systemChecker->method('checkExtension')->willReturn(false);
        $systemChecker->method('checkWritability')->willReturn(false);
        $view = new View("./views/", $lang);
        $sut = new PluginInfo("./", $lang, $systemChecker, $view);
        $response = $sut();
        Approvals::verifyHtml($response);
    }
}
