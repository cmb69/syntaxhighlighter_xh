<?php

/**
 * The syntaxhighlighter system checks.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   Syntaxhighlighter
 * @author    Christoph M. Becker <cmbecker69@gmx.de>
 * @copyright 2012-2015 Christoph M. Becker <http://3-magi.net/>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://3-magi.net/?CMSimple_XH/Syntaxhighlighter_XH
 */

/**
 * The syntaxhighlighter system checks.
 *
 * @category CMSimple_XH
 * @package  Syntaxhighlighter
 * @author   Christoph M. Becker <cmbecker69@gmx.de>
 * @license  http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link     http://3-magi.net/?CMSimple_XH/Syntaxhighlighter_XH
 */
class Syntaxhighlighter_SystemCheck
{
    /**
     * Returns the requirements information view.
     *
     * @return string (X)HTML.
     *
     * @global array The paths of system files and folders.
     * @global array The localization of the core.
     * @global array The localization of the plugins.
     */
    public function render()
    {
        global $pth, $tx, $plugin_tx;
    
        $ptx = $plugin_tx['syntaxhighlighter'];
        $imgdir = $pth['folder']['plugins'] . 'syntaxhighlighter/images/';
        $ok = tag('img src="' . $imgdir . 'ok.png" alt="ok"');
        $fail = tag('img src="' . $imgdir . 'fail.png" alt="failure"');
        $o = '<h4>' . $ptx['syscheck_title'] . '</h4>'
            . $this->checkPHPVersion('5.2.0') . tag('br') . "\n";
        foreach (array('pcre') as $ext) {
            $o .= $this->checkExtension($ext) . tag('br') . "\n";
        }
        $o .= $this->checkMagicQuotesRuntime() . tag('br') . tag('br') . "\n";
        $o .= (strtoupper($tx['meta']['codepage']) == 'UTF-8' ? $ok : $fail)
            . '&nbsp;&nbsp;' . $ptx['syscheck_encoding'] . tag('br') . "\n";
        $folders = array();
        foreach (array('config/', 'css/', 'languages/') as $folder) {
            $folders[] = $pth['folder']['plugins'] . 'syntaxhighlighter/' . $folder;
        }
        foreach ($folders as $folder) {
            $o .= $this->checkWritability($folder) . tag('br') . "\n";
        }
        return $o;
    }
    
    /**
     * Renders the PHP version check.
     *
     * @param string $version Required PHP version.
     *
     * @return string (X)HTML
     *
     * @global array The localization of the plugins.
     */
    protected function checkPHPVersion($version)
    {
        global $plugin_tx;
        
        $kind = version_compare(PHP_VERSION, $version) >= 0 ? 'ok' : 'fail';
        return $this->renderCheckIcon($kind) . '&nbsp;&nbsp;'
            . sprintf(
                $plugin_tx['syntaxhighlighter']['syscheck_phpversion'], $version
            );
    }
    
    /**
     * Renders the extension availability check.
     *
     * @param string $name An extension name.
     *
     * @return string (X)HTML
     *
     * @global array The localization of the plugins.
     */
    protected function checkExtension($name)
    {
        global $plugin_tx;
        
        $kind = extension_loaded($name) ? 'ok' : 'fail';
        return $this->renderCheckIcon($kind) . '&nbsp;&nbsp;'
            . sprintf(
                $plugin_tx['syntaxhighlighter']['syscheck_extension'], $name
            );
    }
    
    /**
     * Renders the magic_quotes_runtime check.
     *
     * @return string (X)HTML
     *
     * @global array The localization of the plugins.
     */
    protected function checkMagicQuotesRuntime()
    {
        global $plugin_tx;
        
        $kind = get_magic_quotes_runtime() ? 'fail' : 'ok';
        return $this->renderCheckIcon($kind). '&nbsp;&nbsp;'
            . $plugin_tx['syntaxhighlighter']['syscheck_magic_quotes'];
    }
    
    /**
     * Renders a writability check.
     *
     * @param string $filename A filename.
     *
     * @return string (X)HTML
     *
     * @global array The localization of the plugins.
     */
    protected function checkWritability($filename)
    {
        global $plugin_tx;
        
        $kind = is_writable($filename) ? 'ok' : 'warn';
        return $this->renderCheckIcon($kind) . '&nbsp;&nbsp;'
            . sprintf(
                $plugin_tx['syntaxhighlighter']['syscheck_writable'], $filename
            );
    }
    
    /**
     * Renders a check icon.
     *
     * @param string $kind A kind.
     *
     * @return string (X)HTML
     *
     * @global array The paths of system files and folders.
     * @global array The localization of the plugins.
     */
    protected function renderCheckIcon($kind)
    {
        global $pth, $plugin_tx;
        
        $path = $pth['folder']['plugins'] . 'syntaxhighlighter/images/'
            . $kind . '.png';
        $alt = $plugin_tx['syntaxhighlighter']['syscheck_alt_' . $kind];
        return tag('img src="' . $path  . '" alt="' . $alt . '"');
    }
}

?>
