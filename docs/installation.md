## Systemvoraussetzungen

### Kompatibel mit folgenden OXID eShop Versionen

- EE 5.0.x
- EE 5.1.x
- EE 5.2.x
- EE 5.3.x
- CE/PE 4.10.x

#### Ggf. kompatibel jedoch nicht getestet

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

1. Modul aus OXID eXchange laden.
1. Modul entpacken und in das Shopverzeichnis kopieren/hochladen.

## Modul aktivieren und konfigurieren

- Im OXID eShop Admin-Bereich in der Modul-Verwaltung das 8select-Modul auswählen und "Aktivieren"

![activate](./docs/oxid-activate.png)

- Unter dem Reiter "Einstell." müssen nun noch die API-ID und Feed-ID eingegeben werden


## Deinstallation

1. Das Modul im OXID eSHOP Admin-Bereich in der Modul-Verwaltung deaktivieren
2. Das Verzechnis "modules/asign/8select" löschen
3. Folgende Datenbank-Tabellen löschen:

   - eightselect_log

## Changelog

Siehe [CHANGELOG](https://github.com/8select/oxid-plugin-sob/blob/master/CHANGELOG.md).
