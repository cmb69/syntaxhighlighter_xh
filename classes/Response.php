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

class Response
{
    /** @var string */
    private $hjs = "";

    /**
     * @param mixed $value
     * @return void
     */
    public function addMetaJson(string $name, $value)
    {
        $content = (string) json_encode($value, JSON_HEX_APOS | JSON_UNESCAPED_SLASHES);
        $this->hjs .= "<meta name=\"{$name}\" content='{$content}'>\n";
    }

    /** @return void */
    public function addStylesheet(string $filename)
    {
        $this->hjs .= "<link rel=\"stylesheet\" href=\"{$filename}\" type=\"text/css\">\n";
    }

    /** @return void */
    public function addScript(string $filename)
    {
        $this->hjs .= "<script type=\"text/javascript\" src=\"{$filename}\"></script>\n";
    }

    /** @return void */
    public function trigger()
    {
        global $hjs;

        $hjs .= $this->hjs;
    }

    public function hjs(): string
    {
        return $this->hjs;
    }
}
