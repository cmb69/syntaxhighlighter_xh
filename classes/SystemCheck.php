<?php

/**
 * Copyright 2022 Christoph M. Becker
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

class SystemCheck
{
    /**
     * @readonly
     * @var string
     */
    public $state;

    /**
     * @readonly
     * @var string
     */
    public $label;

    /**
     * @readonly
     * @var string
     */
    public $stateLabel;

    /**
     * @param string $state
     * @param string $label
     * @param string $stateLabel
     */
    public function __construct($state, $label, $stateLabel)
    {
        $this->state = $state;
        $this->label = $label;
        $this->stateLabel = $stateLabel;
    }
}
