# theme-components-bundle

A collection of elements without styling for our Contao Themes.
Contained Elements:

- Contentbox
- Teaserbox
- Price Table
- Feature Element
- Slider Element
- Content Wrapper
- Contrast switcher icon
- Size icon insert tag with backlink

## Available insert tags

    {{comp::contrast}}
    {{comp::size::barrierefreiheit.html#fontSize}}

Where **_link_** can be replaced by a _**alias**_ or a _**Uri**_ in the comp::size::link insert tag.
If no **_link_** is specified, the tag generates a link to the root page.

The insert tags can be placed anywhere you like, and the appearance depends on your theme or styling.

This symbol stands for _**switch between high and low contrast**_:

![img.png](https://user-images.githubusercontent.com/13376233/224686641-3b85ab24-8e71-497a-b480-511e4d06f1b0.png)

and this for _**change font size**_:

![img_1.png](https://user-images.githubusercontent.com/13376233/224646586-0caf797b-51bd-4cc9-b95d-6e339487bc60.png)

But these are only two examples. The appearance depends on your theme and styling.

The SVG icons are taken from: https://github.com/google/material-design-icons (See also the enclosed license under [LICENSE_MATERIAL_DESIGN_ICONS](LICENSE_MATERIAL_DESIGN_ICONS)).

## Available CSS classes
The bundle provides several CSS classes for high contrast mode:

    # excerpt

    .hc-invert,
    .hc-invert-pictures img,
    .hc-invert-pictures svg {
        filter: invert(1);
    }

    .hc-greyscale,
    .hc-greyscale-pictures img,
    .hc-greyscale-pictures svg {
        filter: grayscale(1);
    }

    .hc-bg-black {
        background: black !important;
        color: white !important;
    }

These classes can be used to control how the website behaves when high contrast is applied.
All classes can be found [here](public/scss/theme-components.scss).

## Configuration
You have the option to configure the use of _**high contrast**_ and _**font size**_ to a small extent.
This is done in the start point of the website for the entire page tree below.
You can find the options under ► _**pages**_ ► _**website start page**_ under the legend ► _**WCAG settings (Web Content Accessibility Guidelines)**_.
WCAG here stands for the official [Web Content Accessibility Guide](https://www.w3.org/Translations/WCAG20-de/).
![img_3.png](https://user-images.githubusercontent.com/13376233/224686701-6c18b41f-d869-4653-9d18-295124b9f593.png)

Here you can de/activate features (i.e. insert tags) individually and define the assignment between the _**page explaining the
font size change**_ and the icon.

# German

Dieses Bundle bringt verschiedene Elemente mit Templates (ohne Styling) für unsere Contao Themes mit.
Enthaltene Elemente:

- Contentbox
- Teaserbox
- Preistabelle
- Feature-Element
- Slider-Element
- Inhaltscontainer
- Kontrastwechsler Icon
- Insert Tag für Schriftgröße mit Backlink-Funktion

## Verfügbare Insert-Tags
Das Bundle stellt die zwei Insert-Tags bereit:

    {{comp::contrast}}
    {{comp::size::link}}

Wobei **_link_** beim Insert-Tag comp::size::link durch einen _**alias**_ oder eine _**Uri**_ ersetzt werden kann.
Wird kein **_link_** angegeben, so generiert das Tag einen Link auf die Root-Page. Die Insert-Tags können beliebig
platziert werden, wobei das Aussehen von Ihrem Theme oder Styling abhängig ist.

Dabei steht dieses Symbol für _**hohen Kontrast umschalten**_:

![img.png](https://user-images.githubusercontent.com/13376233/224686641-3b85ab24-8e71-497a-b480-511e4d06f1b0.png)

und dieses für _**Schriftgröße ändern**_:

![img_1.png](https://user-images.githubusercontent.com/13376233/224646586-0caf797b-51bd-4cc9-b95d-6e339487bc60.png)

Das sind aber nur zwei Beispiele. Die Darstellung ist von Deinem Theme und vom Styling abhängig.

The SVG icons stammen aus: https://github.com/google/material-design-icons (Siehe dazu auch die beiliegende Lizenz unter
[LICENSE_MATERIAL_DESIGN_ICONS](LICENSE_MATERIAL_DESIGN_ICONS)).

## Verfügbare CSS-Klassen
Das Bundle stellt mehrere CSS Klassen für den hohen Kontrast Modus bereit:

    # Auszug

    .hc-invert,
    .hc-invert-pictures img,
    .hc-invert-pictures svg {
        filter: invert(1);
    }

    .hc-greyscale,
    .hc-greyscale-pictures img,
    .hc-greyscale-pictures svg {
        filter: grayscale(1);
    }

    .hc-bg-black {
        background: black !important;
        color: white !important;
    }

Mit diesen Klassen kann gesteuert werden, wie sich die Website bei der Anwendung von hohem Kontrast verhält.
Alle Klassen sind [hier](public/scss/theme-components.scss) zu finden.

## Konfiguration
Es gibt die die Möglichkeit, die Verwendung von _**hohem Kontrast**_ und _**Schriftgröße**_ in geringen Umfang zu
konfigurieren.
Das geschieht im Startpunkt der Website für den gesamten darunter liegenden Seitenbaum.
Die Optionen ist unter ► _**Seiten**_ ► _**Website-Startseite**_ unter der Legende ► _**WCAG-Einstellungen
(Web Content Accessibility Guidelines)**_ zu finden.
WCAG steht hier für die offiziellen [Richtlinien zur barrierefreihen Gestaltung von Websites](https://www.w3.org/Translations/WCAG20-de/).

![img_2.png](https://user-images.githubusercontent.com/13376233/224686682-556eda31-d828-486e-b17d-a16b242dcfa2.png)

Hier können Sie Features (sprich Insert-Tags) einzeln de/aktivieren und die Zuordnung zwischen der _**Seite zur Erläuterung
der Schriftgrößenänderung**_ und dem Icon festlegen.

# DEV
## run before commit

    vendor/bin/ecs check src tests
