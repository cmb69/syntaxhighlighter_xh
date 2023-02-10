# Syntaxhighlighter_XH

Syntaxhighligher_XH ermöglicht eine verbesserte Darstellung von Codeschnipseln
im Inhalt, für Besucher, die JavaScript aktiviert haben.
Die eigentliche Arbeit wird erledigt von
[Syntaxhighlighter von Alex Gorbatchev](https://github.com/syntaxhighlighter/syntaxhighlighter);
Syntaxhighlighter_XH dient lediglich der vereinfachten Integration in CMSimple_XH.
Für einige Inhaltseditoren stehen Plugins zur Verfügung,
die das Editieren noch komfortabler machen.

- [Voraussetzungen](#voraussetzungen)
- [Download](#download)
- [Installation](#installation)
  - [TinyMCE4](#tinymce4)
  - [TinyMCE5](#tinymce5)
  - [CKEditor](#ckeditor)
- [Einstellungen](#einstellungen)
- [Verwendung](#verwendung)
- [Einschränkungen](#einschränkungen)
- [Problembehebung](#problembehebung)
- [Lizenz](#lizenz)
- [Danksagung](#danksagung)

## Voraussetzungen

Syntaxhighligher_XH ist ein Plugin for CMSimple_XH.
Es benötigt CMSimple_XH ≥ 1.7.0 und PHP ≥ 7.1.0 mit der *json* Extension.

## Download

Das [aktuelle Release](https://github.com/cmb69/syntaxhighlighter_xh/releases/latest)
kann von Github herunter geladen werden.

## Installation

The Installation erfolgt wie bei vielen anderen CMSimple_XH Plugins auch. Im
[CMSimple_XH Wiki](https://wiki.cmsimple-xh.org/de/?fuer-anwender/arbeiten-mit-dem-cms/plugins)
finden Sie weitere Informationen.

1. **Sichern Sie die Daten auf Ihrem Server.**
1. Entpacken Sie die ZIP-Datei auf Ihrem Computer.
1. Laden Sie das gesamte Verzeichnis `syntaxhighlighter/` auf Ihren Server in das `plugins/`
   Verzeichnis von CMSimple_XH hoch.
1. Vergeben Sie Schreibrechte für die Unterverzeichnisse `css/`, `config/`
   und `languages/`.
1. Navigieren Sie zu `Plugins` → `Syntaxhighlighter`, und
   prüfen Sie, ob alle Voraussetzungen für den Betrieb erfüllt sind.

Für eine verbesserte Benutzererfahrung in den Editoren müssen Sie
*möglicherweise* etwas zusätzlich einrichten. Für neuere Versionen von TinyMCE4
und TinyMCE5 ist dies nicht erforderlich.

### TinyMCE4

1. Fügen Sie die folgende Zeile in `external_plugins` ein:

        "syntaxhl": "%CMSIMPLE_ROOT%plugins/syntaxhighlighter/editors/tinymce4/syntaxhl/plugin.min.js"

1. Fügen Sie den `syntaxhl` Schalter zu `toolbarN` hinzu, wo Sie es möchten.

### TinyMCE5

1. Fügen Sie die folgende Zeile in `external_plugins` ein:

        "syntaxhl": "%CMSIMPLE_ROOT%plugins/syntaxhighlighter/editors/tinymce5/syntaxhl/plugin.min.js"

1. Fügen Sie den `syntaxhl` Schalter zu `toolbar` hinzu, wo Sie es möchten.

### CKEditor

1. Kopieren Sie `plugins/syntaxhighlighter/editors/ckeditor/syntaxhighlight/`
   nach    `plugins/ckeditor/plugins_external/`.

## Einstellungen

Die Konfiguration des Plugins erfolgt wie bei vielen anderen
CMSimple_XH-Plugins auch im Administrationsbereich der Homepage.
Wählen Sie `Plugins` → `Syntaxhighlighter`.

Sie können die Original-Einstellungen von Syntaxhighlighter_XH unter `Konfiguration`
ändern. Beim Überfahren der Hilfe-Icons mit der Maus werden Hinweise zu den
Einstellungen angezeigt.

Die Lokalisierung wird unter `Sprache` vorgenommen. Sie können die
Zeichenketten in Ihre eigene Sprache übersetzen (falls keine entsprechende
Sprachdatei zur Verfügung steht), oder sie entsprechend Ihren Anforderungen
anpassen.

Das Aussehen von Syntaxhighlighter_XH kann unter `Stylesheet` angepasst werden.

## Verwendung

Fügen Sie Ihren Seiten Codeschnipsel hinzu, die Sie gerne mit Syntaxhervorhebung
präsentieren möchten, indem Sie sie in ein `<pre>`-Element mit einer Klasse einschließen, wie im
[Handbuch von Syntaxhighlighter](https://github.com/syntaxhighlighter/syntaxhighlighter/wiki/Configuration)
beschrieben.

Für TinyMCE 4 und 5 kann das Einfügen und Bearbeiten der Codeschnipsel
durch Betätigen des `Codebeispiel einfügen/bearbeiten` Schalters durchgeführt werden,
wo die Codeschnipsel bearbeitet werden können, und die gewünschte Sprache
gewählt werden kann. Andere Einstellungen müssen manuell in der
HTML-Quellcodeansicht durchgeführt werden.

Für CKEditor kann das Einfügen und Bearbeiten der Codeschnipsel durch Betätigen des
`Einen Quelltextabschnitt einfügen oder aktualisieren` Schalters durchgeführt werden,
wo die Codeschnipsel und die Einstellungen bearbeitet werden können.

## Einschränkungen

Die Syntaxhervorhebung, Zeilennummerierung, usw., erfordert einen
zeitgemäßen Browser (z.B. wird IE nicht unterstützt), in dem JavaScript
aktiviert ist. In anderen Umgebungen werden die Codeschnipsel ohne weitere
Verbesserung angezeigt.

## Problembehebung

Melden Sie Programmfehler und stellen Sie Supportanfragen entweder auf
[Github](https://github.com/cmb69/syntaxhighlighter_xh/issues)
oder im [CMSimple_XH Forum](https://cmsimpleforum.com/).

## Lizenz

Syntaxhighlighter_XH ist freie Software. Sie können es unter den Bedingungen
der GNU General Public License, wie von der Free Software Foundation
veröffentlicht, weitergeben und/oder modifizieren, entweder gemäß
Version 3 der Lizenz oder (nach Ihrer Option) jeder späteren Version.

Die Veröffentlichung von Syntaxhighlighter_XH erfolgt in der Hoffnung, dass es
Ihnen von Nutzen sein wird, aber *ohne irgendeine Garantie*, sogar ohne
die implizite Garantie der *Marktreife* oder der *Verwendbarkeit für einen
bestimmten Zweck*. Details finden Sie in der GNU General Public License.

Sie sollten ein Exemplar der GNU General Public License zusammen mit
Syntaxhighlighter_XH erhalten haben. Falls nicht, siehe <https://www.gnu.org/licenses/>.

© 2012-2023 Christoph M. Becker

## Danksagung

Dieses Plugin wurde von *pmolik* inspiriert.

Syntaxhighlighter_XH wird angetrieben von
[Alex Gorbatchev’s Syntaxhighlighter](https://github.com/syntaxhighlighter/syntaxhighlighter);
vielen Dank für die Veröffentlichung diese großartigen Tools unter LGPL.

Die TinyMCE 4 und 5 Plugins basieren auf dem
[Codesample-Plugin](https://www.tinymce.com/docs/plugins/codesample/) von Ephox Corp.
Das [CKEditor-Plugin](https://github.com/dbrain/ckeditor-syntaxhighlight)
wurde von Daniel Brain entwickelt.
Vielen Dank für die Veröffentlichung dieser Plugins unter LGPL.

Das Pluginlogo wurde von [YellowIcon](https://www.everaldo.com/about) gestaltet.
Viele Dank für die Veröffentlichung dieses Icons unter GPL.

Vielen Dank an die Gemeinschaft im [CMSimple_XH Forum](https://www.cmsimpleforum.com/)
für Tipps, Vorschläge und das Testen.

Und zu guter letzt vielen Dank an [Peter Harteg](http://www.harteg.dk/),
den „Vater“ von CMSimple, und allen Entwicklern von
[CMSimple_XH](https://www.cmsimple-xh.org/de/) ohne die es dieses
phantastische CMS nicht gäbe.
