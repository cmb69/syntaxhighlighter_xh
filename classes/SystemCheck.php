<?php

/**
 * Copyright 2012-2017 Christoph M. Becker
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
     * @return string
     */
    public function render()
    {
        global $pth, $plugin_tx;
    
        $imgdir = $pth['folder']['plugins'] . 'syntaxhighlighter/images/';
        $html = '<h4>' . $plugin_tx['syntaxhighlighter']['syscheck_title'] . '</h4>'
            . $this->checkPHPVersion('5.4.0') . tag('br') . "\n";
        foreach (array('json') as $ext) {
            $html .= $this->checkExtension($ext) . tag('br') . "\n";
        }
        $html .= $this->checkXHVersion('1.6.3') . tag('br') . "\n";
        foreach ($this->getWritableFolders() as $folder) {
            $html .= $this->checkWritability($folder) . tag('br') . "\n";
        }
        return $html;
    }
    
    /**
     * @param string $version
     * @return string
     */
    private function checkPHPVersion($version)
    {
        global $plugin_tx;
        
        $kind = version_compare(PHP_VERSION, $version) >= 0 ? 'ok' : 'fail';
        return $this->renderCheckIcon($kind) . '&nbsp;&nbsp;'
            . sprintf($plugin_tx['syntaxhighlighter']['syscheck_phpversion'], $version);
    }
    
    /**
     * @param string $name
     * @return string
     */
    private function checkExtension($name)
    {
        global $plugin_tx;
        
        $kind = extension_loaded($name) ? 'ok' : 'fail';
        return $this->renderCheckIcon($kind) . '&nbsp;&nbsp;'
            . sprintf($plugin_tx['syntaxhighlighter']['syscheck_extension'], $name);
    }
    
    /**
     * @param string $version
     * @return string
     */
    private function checkXHVersion($version)
    {
        global $plugin_tx;
        
        $kind = $this->hasXHVersion($version) ? 'ok' : 'fail';
        return $this->renderCheckIcon($kind) . '&nbsp;&nbsp;'
            . sprintf($plugin_tx['syntaxhighlighter']['syscheck_xhversion'], $version);
    }
    
    /**
     * @param string $version
     * @return bool
     */
    private function hasXHVersion($version)
    {
        return defined('CMSIMPLE_XH_VERSION')
            && strpos(CMSIMPLE_XH_VERSION, 'CMSimple_XH') === 0
            && version_compare(CMSIMPLE_XH_VERSION, "CMSimple_XH {$version}", 'gt');
    }
    
    /**
     * @param string $filename
     * @return string
     */
    private function checkWritability($filename)
    {
        global $plugin_tx;
        
        $kind = is_writable($filename) ? 'ok' : 'warn';
        return $this->renderCheckIcon($kind) . '&nbsp;&nbsp;'
            . sprintf($plugin_tx['syntaxhighlighter']['syscheck_writable'], $filename);
    }
    
    /**
     * @param string $kind
     * @return string
     */
    private function renderCheckIcon($kind)
    {
        global $pth, $plugin_tx;
        
        $path = $pth['folder']['plugins'] . 'syntaxhighlighter/images/'
            . $kind . '.png';
        $alt = $plugin_tx['syntaxhighlighter']['syscheck_alt_' . $kind];
        return tag('img src="' . $path  . '" alt="' . $alt . '"');
    }
    
    /**
     * @return array
     */
    private function getWritableFolders()
    {
        global $pth;
        
        $folders = array();
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $pth['folder']['plugins'] . 'syntaxhighlighter/' . $folder;
        }
        return $folders;
    }
}
