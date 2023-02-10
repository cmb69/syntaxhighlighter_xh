# Syntaxhighlighter_XH

Syntaxhighligher_XH facilitates improved presentation of code snippets in
the content for users having JavaScript enabled. The actual work is done by
[Alex Gorbatchev’s Syntaxhighlighter](https://github.com/syntaxhighlighter/syntaxhighlighter);
Syntaxhighlighter_XH merely is meant to streamline
the integration in CMSimple_XH. For some content editors there are plugins
available, which make editing even more convenient.

- [Requirements](#requirements)
- [Download](#download)
- [Installation](#installation)
- [Settings](#settings)
- [Usage](#usage)
  - [TinyMCE4](#tinymce4)
  - [TinyMCE5](#tinymce5)
  - [CKEditor](#ckeditor)
- [Limitations](#limitations)
- [Troubleshooting](#troubleshooting)
- [License](#license)
- [Credits](#credits)

## Requirements

Syntaxhighligher_XH is a plugin for CMSimple_XH ≥ 1.7.0.
It requires PHP ≥ 7.1.0 with the JSON extension.

## Download

The [lastest release](https://github.com/cmb69/syntaxhighlighter_xh/releases/latest)
is available for download on Github.

## Installation

The installation is done as with many other CMSimple_XH plugins. See the
[CMSimple\_XH wiki](https://wiki.cmsimple-xh.org/doku.php/installation#plugins)
for further details.

1.  **Backup the data on your server.**
1.  Unzip the distribution on your computer.
1.  Upload the whole directory `syntaxhighlighter/` to your server into
    into the `plugins/` directory of CMSimple_XH.
1.  Set write permissions to the subdirectories `config/`, `css/` and
    `languages/`.
1.  Navigate to `Plugins` → `Syntaxhighlighter` in the back-end
    to check if all requirements are fulfilled.

For an improved user experience in the editors, you *may* need to do some
additional setup. This is not necessary for recent versions of TinyMCE4
and TinyMCE5.

### TinyMCE4

1. Add `"syntaxhl": "%CMSIMPLE_ROOT%plugins/syntaxhighlighter/editors/tinymce4/syntaxhl/plugin.min.js"`
   to `external_plugins`. 
1. Add the `syntaxhl` button to `toolbarN` wherever you prefer.

### TinyMCE5

1. Add `"syntaxhl": "%CMSIMPLE_ROOT%plugins/syntaxhighlighter/editors/tinymce5/syntaxhl/plugin.min.js"`
   to `external_plugins`. 
1. Add the `syntaxhl` button to `toolbar` wherever you prefer.

### CKEditor

1. Copy `plugins/syntaxhighlighter/editors/ckeditor/syntaxhighlight/` to
   `plugins/ckeditor/plugins_external/`.

## Settings

The configuration of the plugin is done as with many other CMSimple_XH plugins in
the back-end of the Website. Select `Plugins` → `Syntaxhighlighter`.

You can change the default settings of Syntaxhighlighter_XH under
`Config`. Hints for the options will be displayed when hovering over
the help icons with your mouse.

Localization is done under `Language`. You can translate the character
strings to your own language if there is no appropriate language file
available, or customize them according to your needs.

The look of Syntaxhighlighter_XH can be customized under `Stylesheet`.

## Usage

Add code you like to be presented with syntax highlighting to your pages by
enclosing it in a `<pre>` element with a class as described in
[the manual of Syntaxhighlighter](http://alexgorbatchev.com/SyntaxHighlighter/manual/configuration/#parameters)

For TinyMCE 4 and 5 inserting and editing the code can be done by pressing the
`Insert/Edit code sample` button, where you can edit the code and
choose the desired language. Other settings have to be done manually in the
HTML source code view.

For CKEditor inserting and editing the code can be done by pressing the
`Add or update a code snippet` button, where you can edit the code and
the settings.

## Limitations

The syntax highlighting, line numbering etc. requires a contemporary browser
(e.g. IE is not supported) with JavaScript enabled. In other environments the code
snippets are presented unenhanced.

## Troubleshooting

Report bugs and ask for support either on
[Github](https://github.com/cmb69/syntaxhighlighter_xh/issues)
or in the [CMSimple_XH Forum](https://cmsimpleforum.com/).

## License

Syntaxhighlighter_XH is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Syntaxhighlighter_XH is distributed in the hope that it will be useful,
but *without any warranty*; without even the implied warranty of
*merchantibility* or *fitness for a particular purpose*. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Syntaxhighlighter_XH.  If not, see <https://www.gnu.org/licenses/>.

Copyright 2012-2023 Christoph M. Becker

## Credits

This plugin was inspired by `pmolik`.

Syntaxhighlighter_XH is powered by
[Alex Gorbatchev’s Syntaxhighlighter](https://github.com/syntaxhighlighter/syntaxhighlighter);
many thanks for releasing this great tool under LGPL.

The TinyMCE 4 and 5 plugins are based on the
[codesample plugin](https://www.tinymce.com/docs/plugins/codesample/) by Ephox Corp.
The [CKEditor plugin](https://github.com/dbrain/ckeditor-syntaxhighlight)
is written by Daniel Brain.
Many thanks for releasing these plugins under LGPL.

The plugin logo has been designed by [YellowIcon](https://www.everaldo.com/about).
Many thanks for publishing this icon under GPL.

Many thanks to the community at the [CMSimple_XH-Forum](https://www.cmsimpleforum.com/)
for tips, suggestions and testing.

And last but not least many thanks to [Peter Harteg](httsp://www.harteg.dk),
the “father” of CMSimple,
and all developers of [CMSimple\_XH](https://www.cmsimple-xh.org)
without whom this amazing CMS would not exist.
