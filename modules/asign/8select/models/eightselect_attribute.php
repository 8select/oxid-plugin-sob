<?php

/**
 * Attributes manager
 *
 */
class eightselect_attribute extends oxI18n
{
    /**
     * Current class name
     *
     * @var string
     */
    protected $_sClassName = 'eightselect_attribute';

    /**
     * Core database table name. $sCoreTable could be only original data table name and not view name.
     *
     * @var string
     */
    protected $_sCoreTable = 'eightselect_attributes';

    /**
     * All fields with additional data
     *
     * @var array
     */
    protected $_aEightselectFields = [
        'sku'            => [
            'labelName'    => 'SKU',
            'labelDescr'   => 'Die Sku ist einzigartig, sie enthält Modell, Farbe und Größe',
            'required'     => true,
            'configurable' => false,
        ],
        'mastersku'      => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'status'         => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'ean'            => [
            'labelName'    => 'EAN-Code',
            'labelDescr'   => 'Standardisierte eindeutige Materialnummer nach EAN (European Article Number) oder UPC (Unified Product Code).',
            'required'     => false,
            'configurable' => true,
        ],
        'model'          => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'name1'          => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'name2'          => [
            'labelName'    => 'Alternative Artikelbezeichnung',
            'labelDescr'   => 'Oft als Kurzbezeichnung in Listenansichten verwendet (z.B. "Freizeit-Hemd") oder für Google mit mehr Infos zur besseren Suche',
            'required'     => false,
            'configurable' => true,
        ],
        'kategorie1'     => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'kategorie2'     => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'kategorie3'     => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'streich_preis'  => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'angebots_preis' => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'groesse'        => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'marke'          => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'bereich'        => [
            'labelName'    => 'Bereich',
            'labelDescr'   => 'Damit können Teilsortimente bezeichnet sein (z.B. Outdoor, Kosmetik, Trachten, Lifestyle)',
            'required'     => false,
            'configurable' => true,
        ],
        'rubrik'         => [
            'labelName'    => 'Produktkategorie',
            'labelDescr'   => 'Bezeichnung der Artikelgruppen, die meist so in der Shopnavigation verwendet werden (z.B. Hosen, Jacken, Accessoires, Schuhe)',
            'required'     => false,
            'configurable' => true,
        ],
        'abteilung'      => [
            'labelName'    => 'Abteilung',
            'labelDescr'   => 'Einteilung der Sortimente nach Zielgruppen (z.B. Damen, Herren, Kinder)',
            'required'     => false,
            'configurable' => true,
        ],
        'kiko'           => [
            'labelName'    => 'KIKO',
            'labelDescr'   => 'Speziell für Kindersortimente: Einteilung nach Zielgruppen (z.B. Mädchen, Jungen, Baby)',
            'required'     => false,
            'configurable' => true,
        ],
        'typ'            => [
            'labelName'    => 'Produkttyp / Unterkategorie',
            'labelDescr'   => 'Verfeinerung der Ebene PRODUKTKATEGORIE (z.B. PRODUKTKATEGORIE = Jacken; PRODUKTTYP = Lederjacken, Parkas, Blousons)',
            'required'     => false,
            'configurable' => true,
        ],
        'farbe'          => [
            'labelName'    => 'Farbe',
            'labelDescr'   => 'Die exakte Farbbezeichnung des Artikels (z.B. Gelb; Himbeerrot; Rosenrot)',
            'required'     => false,
            'configurable' => true,
        ],
        'farbspektrum'   => [
            'labelName'    => 'Farbspektrum',
            'labelDescr'   => 'Farben sind einem Farbspektrum zugeordnet (z.B. Farbe: Himbeerrot > Farbspektrum: Rot)',
            'required'     => false,
            'configurable' => true,
        ],
        'absatzhoehe'    => [
            'labelName'    => 'Absatzhöhe',
            'labelDescr'   => 'speziell bei Schuhen: Höhe des Absatzes (Format mit oder ohne Maßeinheit z.B. 5,5 cm oder 5,5)',
            'required'     => false,
            'configurable' => true,
        ],
        'muster'         => [
            'labelName'    => 'Muster',
            'labelDescr'   => 'Farbmuster des Artikels (z.B. uni, einfarbig,  kariert, gestreift, Blumenmuster, einfarbig-strukturiert)',
            'required'     => false,
            'configurable' => true,
        ],
        'aermellaenge'   => [
            'labelName'    => 'Ärmellänge',
            'labelDescr'   => 'speziell bei Oberbekleidung: Länge der Ärmel (z.B. normal, extra-lange Ärmel, ärmellos, 3/4 Arm)',
            'required'     => false,
            'configurable' => true,
        ],
        'kragenform'     => [
            'labelName'    => 'Kragenform',
            'labelDescr'   => 'speziell bei Oberbekleidung: Beschreibung des Kragens oder Ausschnitts (z.B. Rollkragen, V-Ausschnitt, Blusenkragen, Haifischkragen)',
            'required'     => false,
            'configurable' => true,
        ],
        'obermaterial'   => [
            'labelName'    => 'Art Obermaterial',
            'labelDescr'   => 'wesentliches Material des Artikels (z.B. Wildleder, Denim,  Edelstahl, Gewebe, Strick, Jersey, Sweat, Crash)',
            'required'     => false,
            'configurable' => true,
        ],
        'passform'       => [
            'labelName'    => 'Passform',
            'labelDescr'   => 'in Bezug auf die Körperform, wird häufig für Hemden, Sakkos und Anzüge verwendet (z.B. schmal, bequeme Weite, slim-fit, regular-fit, comfort-fit, körpernah)',
            'required'     => false,
            'configurable' => true,
        ],
        'schnitt'        => [
            'labelName'    => 'Schnitt',
            'labelDescr'   => 'in Bezug auf die Form des Artikels (z.B. Bootcut, gerades Bein, Oversized, spitzer Schuh)',
            'required'     => false,
            'configurable' => true,
        ],
        'waschung'       => [
            'labelName'    => 'Waschung',
            'labelDescr'   => 'optische Wirkung des Materials (bei Jeans z.B.  used, destroyed, bleached, vintage)',
            'required'     => false,
            'configurable' => true,
        ],
        'stil'           => [
            'labelName'    => 'Stil',
            'labelDescr'   => 'Stilrichtung des Artikels (z.B.  Business, Casual,  Ethno, Retro)',
            'required'     => false,
            'configurable' => true,
        ],
        'sportart'       => [
            'labelName'    => 'Sportart',
            'labelDescr'   => 'speziell bei Sportartikeln (z.B. Handball, Bike, Bergsteigen)',
            'required'     => false,
            'configurable' => true,
        ],
        'detail'         => [
            'labelName'    => 'Detail',
            'labelDescr'   => 'erwähnenswerte Details an Artikeln (z.B. Reißverschluss seitlich am Saum, Brusttasche, Volants, Netzeinsatz, Kragen in Kontrastfarbe)',
            'required'     => false,
            'configurable' => true,
        ],
        'auspraegung'    => [
            'labelName'    => 'Ausführung & Maßangaben',
            'labelDescr'   => 'speziell für Sport und Outdoor. Wichtige Informationen, die helfen, den Artikel in das Sortiment einzuordnen (Beispiele: bei Rucksäcken: Volumen "30-55 Liter"; bei Skistöcken: Größenangaben in Maßeinheit "Körpergröße 160 bis 175cm")',
            'required'     => false,
            'configurable' => true,
        ],
        'baukasten'      => [
            'labelName'    => 'Baukasten',
            'labelDescr'   => 'SKU für eine direkte Verbindung zu 1:1  zusammengehörigen Artikeln',
            'required'     => false,
            'configurable' => true,
        ],
        'eigenschaft'    => [
            'labelName'    => 'Eigenschaft / Einsatzbereich',
            'labelDescr'   => 'speziell für Sport und Outdoor. Hinweise zum Einsatzbereich (Bsp. Schlafsack geeignet für Temparaturbereich 1 °C bis -16 °C, kratzfest, wasserdicht)',
            'required'     => false,
            'configurable' => true,
        ],
        'fuellmenge'     => [
            'labelName'    => 'Füllmenge',
            'labelDescr'   => 'bezieht sich auf die Menge des Inhalts des Artikels (z.B. 200ml; 0,5 Liter, 3kg, 150 Stück)',
            'required'     => false,
            'configurable' => true,
        ],
        'funktion'       => [
            'labelName'    => 'Funktion',
            'labelDescr'   => 'beschreibt Materialfunktionen und -eigenschaften (z.b. schnelltrocknend, atmungsaktiv, 100% UV-Schutz;  pflegeleicht, bügelleicht, körperformend)',
            'required'     => false,
            'configurable' => true,
        ],
        'gruppe'         => [
            'labelName'    => 'Gruppe / Baukausten',
            'labelDescr'   => 'bezeichnet direkt zusammengehörige Artikel (z.B. Bikini-Oberteil "Aloha" und Bikini-Unterteil "Aloha" = Gruppe 1002918; Baukasten-Sakko "Ernie" und Baukasten-Hose "Bert" = Gruppe "E&B"). Dabei können auch mehr als 2 Artikel eine Gruppe bilden (z.B. Mix & Match: Gruppe "Hawaii" = 3 Bikini-Oberteile können mit 2 Bikini-Unterteilen frei kombiniert werden). Der Wert für eine Gruppe kann eine Nummer oder ein Name sein.',
            'required'     => false,
            'configurable' => true,
        ],
        'material'       => [
            'labelName'    => 'Material',
            'labelDescr'   => 'bezeichnet die genaue Materialzusammensetzung (z.B. 98% Baumwolle, 2% Elasthan)',
            'required'     => false,
            'configurable' => true,
        ],
        'saison'         => [
            'labelName'    => 'Saison',
            'labelDescr'   => 'Beschreibt zu welcher Saison bzw. saisonalen Kollektion der Artikel gehört (z.B. HW18/19; Sommer 2018; Winter)',
            'required'     => false,
            'configurable' => true,
        ],
        'serie'          => [
            'labelName'    => 'Serie',
            'labelDescr'   => 'Hier können Bezeichnungen für Serien übergeben werden, um Artikelfamilien oder Sondereditionen zu kennzeichnen (z.B. Expert Line, Mountain Professional)',
            'required'     => false,
            'configurable' => true,
        ],
        'verschluss'     => [
            'labelName'    => 'Verschluss',
            'labelDescr'   => 'beschreibt Verschlussarten (z.B: Geknöpft, Reißverschluss,  Druckknöpfe, Klettverschluss; Haken & Öse)',
            'required'     => false,
            'configurable' => true,
        ],
        'produkt_url'    => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'bilder'         => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'beschreibung'   => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'beschreibung1'  => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'beschreibung2'  => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
        'sonstiges'      => [
            'labelName'    => '',
            'labelDescr'   => '',
            'required'     => true,
            'configurable' => false,
        ],
    ];

    /**
     * Return all CSV field names in correct order
     *
     * @return array
     */
    public function getFields()
    {
        return $this->_aEightselectFields;
    }
}