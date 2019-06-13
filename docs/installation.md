## Systemvoraussetzungen

### Kompatibel mit folgenden OXID eShop Versionen

- EE 5.0.x
- EE 5.1.x
- EE 5.2.x
- EE 5.3.x
- CE/PE 4.10.x/5.x

Ggf. kompatibel, jedoch nicht getestet:

- CE/PE 4.7.x
- CE/PE 4.8.x
- CE/PE 4.9.x

### Anforderungen an Webserver / MySQL / PHP / PHP Erweiterungen

Voraussetzung ist PHP 5.5.x.

Weitere Voraussetzungen ergeben sich aus denen der Oxid Version:

- [Oxid EE](https://docs.oxid-esales.com/eshop/de/5.3/installation/neu-installation/systemvoraussetzungen/systemvoraussetzungen-ee.html)
- [Oxid CE](https://docs.oxid-esales.com/eshop/de/5.3/installation/neu-installation/systemvoraussetzungen/systemvoraussetzungen-ce.html)
- [Oxid PE](https://docs.oxid-esales.com/eshop/de/5.3/installation/neu-installation/systemvoraussetzungen/systemvoraussetzungen-pe.html)

## Installation

1. Modul aus [OXID eXchange](https://exchange.oxid-esales.com/index.php?cl=search&searchparam=8select) laden.
2. Modul entpacken und in das Shopverzeichnis source/modules/asign/8select kopieren/hochladen

## Modul aktivieren und konfigurieren

- Im OXID eShop Admin-Bereich in der Modul-Verwaltung das 8select-Modul auswählen und "Aktivieren"

![activate](./docs/oxid-activate.png)

- Unter dem Reiter "Einstell." im Abschnitt "Allgemeine Konfiguration" die API-ID und Feed-ID eingeben
- Ausspielung der 8select-Widgets aktivieren:
  - entweder im Vorschau-Modus (für einen Testbetrieb - dann werden die Widgets nur ausgespielt wenn an die URL ein Parameter `8s_preview=1` angehängt wird, z.B. `https://www.my-shop.com/page?8s_preview=1`): dazu das Häkchen bei "Vorschau aktiv" setzen
  - oder immer, d.h. für den Produktivbetrieb: dazu das Häkchen "Im Frontend aktiv" setzen
- Ihren Oxid Shop im 8select-System registrieren: dazu den Button "Mit CSE verbinden" klicken
- Im Anschluss in der 8select Management Console einloggen und die Konfiguration Ihrer Produktdaten vornehmen - dies funktioniert exakt [wie für unser Shopware Plugin](https://knowledge.8select.com/knowledge/konfiguration-shopware-plugin)


## Deinstallation

1. Das Modul im OXID eSHOP Admin-Bereich in der Modul-Verwaltung deaktivieren
2. Das Verzechnis "modules/asign/8select" löschen
3. Folgende Datenbank-Tabellen löschen:

   - eightselect_log

## Changelog

Siehe [CHANGELOG](https://github.com/8select/oxid-plugin-sob/blob/master/CHANGELOG.md).
