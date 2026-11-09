# theme-components-bundle

A collection of elements with a minimal base styling for our Contao Themes.
Contained Elements:

- Contentbox
- Teaserbox
- Price Table
- Feature Element
- Slider Element
- Contrast switcher icon
- Size icon insert tag with backlink

## Content elements for themes

The content elements are fragment controllers with Twig templates (Contao 5.7 and 6):

| Element | Template | BEM block |
|---|---|---|
| Content Box | `content_element/ct_content_box` | `.content-box` |
| Teaser Box | `content_element/ct_teaser_box` | `.teaser-box` |
| Price Table | `content_element/ct_price_box` | `.price-box` |
| Feature Element | `content_element/ct_feature_element` | `.feature-element` |
| Slider Element | `content_element/ct_slider_element` | `.slider-element` |
| Modal (frontend module) | `frontend_module/ct_modal` | `.ct-modal` |

A theme can either style these classes or ship template variants, e.g.
`contao/templates/content_element/ct_content_box/my_theme.html.twig`, that are selectable in the
"customTpl" field. The minimal base styling (`public/css/elements.css`) lives in the
`theme-components` cascade layer and can be adjusted with `--tc-*` custom properties; to drop it,
override the `style` block in a variant.

The modal module uses the native `<dialog>` element and `public/js/modal.js`: the button opens the
dialog, links to `#ct-modal-<id>` do so as well, and without a link text the dialog opens on page load
(set `remember_dismissal` to `true` in a variant to open it only once). Legacy `mod_cthemes_modal_*`
templates selected in the "customTpl" field are still rendered with their former variables.

The former "Content Wrapper" start/stop elements are converted into core "Element group" elements
(`content_element/element_group`, `.content-element-group`) by `contao:migrate`: the elements in
between become child elements of the group, CSS ID/classes are kept and the name is moved to the
"title" field.

Legacy template selections (e.g. `ce_cthemes_contentbox_my_theme`) are migrated to the
corresponding Twig variant (`content_element/ct_content_box/my_theme`) by `contao:migrate` as soon
as that variant exists.

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

## Animations
Elements can slide in when they are scrolled into view. Enable the option _**Enable scroll animation effects (slide-in)**_
under ► _**pages**_ ► _**website start page**_ ► _**Theme component settings**_; the required CSS and JavaScript files are then
loaded for the entire page tree below.

Afterwards, add one of the following classes to an element, e.g. in the field ► _**CSS ID/class**_:

| Class | Effect |
|---|---|
| `reveal` | Slide in when scrolling (from below) |
| `reveal-left` | Slide in when scrolling (from the left) |
| `reveal-up` | Slide in when scrolling (from above) |
| `reveal-right` | Slide in when scrolling (from the right) |

The effect can be adjusted with additional classes:

| Class | Effect |
|---|---|
| `reveal-fast` / `reveal-slow` | Shorter (400 ms) or longer (1200 ms) animation, default 500 ms |
| `reveal-soft` / `reveal-strong` | Distance of 20 px or 80 px, default 10 px |
| `reveal-delay-1` / `-2` / `-3` | Start the animation after 150, 300 or 450 ms, e.g. to let the boxes of a row appear one after another |
| `reveal-repeat` | Animate again each time the element is scrolled into view |

Example: `reveal-left reveal-slow reveal-strong reveal-delay-1`. For visitors who prefer reduced motion
(`prefers-reduced-motion`), the elements are shown without animation.

All values are defined once as custom properties in [reveal.css](public/css/reveal.css), so a theme only has to override the
tokens it wants to change:

    :root {
        --reveal-duration: 500ms;         /* default */
        --reveal-duration-fast: 400ms;    /* reveal-fast */
        --reveal-duration-slow: 1200ms;   /* reveal-slow */
        --reveal-distance: 10px;          /* default */
        --reveal-distance-soft: 20px;     /* reveal-soft */
        --reveal-distance-strong: 80px;   /* reveal-strong */
        --reveal-delay-1: 150ms;          /* reveal-delay-1 */
        --reveal-delay-2: 300ms;          /* reveal-delay-2 */
        --reveal-delay-3: 450ms;          /* reveal-delay-3 */
        --reveal-easing: ease;
    }

## Configuration
You have the option to configure the use of _**high contrast**_, _**auto high contrast**_ and _**font size**_ to a small extent.
This is done in the start point of the website for the entire page tree below.
You can find the options under ► _**pages**_ ► _**website start page**_ under the legend ► _**WCAG settings (Web Content Accessibility Guidelines)**_.
WCAG here stands for the official [Web Content Accessibility Guide](https://www.w3.org/Translations/WCAG20-de/).

The difference between _**High Contrast**_ and _**Auto High Contrast**_ is that High Contrast allows users to manually activate the contrast mode with a click, while Auto High Contrast automatically enables the contrast mode when the system’s dark mode is active.

![wcag-settings](https://github.com/user-attachments/assets/59f5cc3c-9e27-4826-9e6c-5a284b19b0c9)

Here you can de/activate features (i.e. insert tags) individually and define the assignment between the _**page explaining the
font size change**_ and the icon.

# German

Dieses Bundle bringt verschiedene Elemente mit Templates (mit minimalem Grundstyling) für unsere Contao Themes mit.
Enthaltene Elemente:

- Contentbox
- Teaserbox
- Preistabelle
- Feature-Element
- Slider-Element
- Kontrastwechsler Icon
- Insert Tag für Schriftgröße mit Backlink-Funktion

## Inhaltselemente für Themes

Die Inhaltselemente sind Fragment-Controller mit Twig-Templates (Contao 5.7 und 6). Ein Theme kann
die BEM-Klassen (`.content-box`, `.teaser-box`, `.price-box`, `.feature-element`, `.slider-element`, `.ct-modal`) stylen oder Template-Varianten mitbringen, z. B.
`contao/templates/content_element/ct_content_box/mein_theme.html.twig`, die im Feld
„Individuelles Template" auswählbar sind. Das minimale Grundstyling (`public/css/elements.css`) liegt
in der Cascade-Layer `theme-components` und kann über `--tc-*`-Variablen angepasst werden.

Das Modal-Modul nutzt das native `<dialog>`-Element; ohne Link-Text öffnet sich der Dialog beim
Laden der Seite. Alte `mod_cthemes_modal_*`-Templates funktionieren im Feld „Individuelles Template"
weiterhin.

Die bisherigen Inhaltscontainer (Anfang/Ende) werden per `contao:migrate` in Kern-Elemente
„Elementgruppe" (`content_element/element_group`) umgewandelt: Die Elemente dazwischen werden zu
Kind-Elementen der Gruppe, CSS-ID/-Klassen bleiben erhalten, die Bezeichnung landet im Feld „Titel".

Alte Template-Auswahlen (z. B. `ce_cthemes_contentbox_mein_theme`) werden per `contao:migrate` auf
die entsprechende Twig-Variante (`content_element/ct_content_box/mein_theme`) umgestellt, sobald diese
existiert.

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

## Animationen
Elemente können beim Scrollen in den sichtbaren Bereich einfliegen. Dazu die Option _**Animation-Effekte beim Scrollen aktivieren
(Einfliegen)**_ unter ► _**Seiten**_ ► _**Website-Startseite**_ ► _**Theme-Components-Einstellungen**_ aktivieren; die
benötigten CSS- und JavaScript-Dateien werden dann für den gesamten darunter liegenden Seitenbaum geladen.

Anschließend einem Element eine der folgenden Klassen zuweisen, z. B. im Feld ► _**CSS-ID/Klasse**_:

| Klasse | Wirkung |
|---|---|
| `reveal` | Animation: Einfliegen beim Scrollen (von unten) |
| `reveal-left` | Animation: Einfliegen beim Scrollen (von links) |
| `reveal-up` | Animation: Einfliegen beim Scrollen (von oben) |
| `reveal-right` | Animation: Einfliegen beim Scrollen (von rechts) |

Mit zusätzlichen Klassen lässt sich der Effekt anpassen:

| Klasse | Wirkung |
|---|---|
| `reveal-fast` / `reveal-slow` | Kürzere (400 ms) bzw. längere (1200 ms) Animation, Standard 500 ms |
| `reveal-soft` / `reveal-strong` | Strecke von 20 px bzw. 80 px, Standard 10 px |
| `reveal-delay-1` / `-2` / `-3` | Animation erst nach 150, 300 bzw. 450 ms starten, z. B. damit die Boxen einer Reihe nacheinander einfliegen |
| `reveal-repeat` | Bei jedem erneuten Hineinscrollen wieder animieren |

Beispiel: `reveal-left reveal-slow reveal-strong reveal-delay-1`. Für Besucher, die reduzierte Bewegung bevorzugen
(`prefers-reduced-motion`), werden die Elemente ohne Animation angezeigt.

Alle Werte sind einmalig als Custom Properties in [reveal.css](public/css/reveal.css) definiert. Ein Theme überschreibt nur
die Werte, die es ändern möchte:

    :root {
        --reveal-duration: 500ms;         /* Standard */
        --reveal-duration-fast: 400ms;    /* reveal-fast */
        --reveal-duration-slow: 1200ms;   /* reveal-slow */
        --reveal-distance: 10px;          /* Standard */
        --reveal-distance-soft: 20px;     /* reveal-soft */
        --reveal-distance-strong: 80px;   /* reveal-strong */
        --reveal-delay-1: 150ms;          /* reveal-delay-1 */
        --reveal-delay-2: 300ms;          /* reveal-delay-2 */
        --reveal-delay-3: 450ms;          /* reveal-delay-3 */
        --reveal-easing: ease;
    }

## Konfiguration
Es gibt die die Möglichkeit, die Verwendung von _**hohem Kontrast**_, _**automatischem hohem Kontrast**_ und _**Schriftgröße**_ in geringen Umfang zu
konfigurieren.
Das geschieht im Startpunkt der Website für den gesamten darunter liegenden Seitenbaum.
Die Optionen ist unter ► _**Seiten**_ ► _**Website-Startseite**_ unter der Legende ► _**WCAG-Einstellungen
(Web Content Accessibility Guidelines)**_ zu finden.
WCAG steht hier für die offiziellen [Richtlinien zur barrierefreihen Gestaltung von Websites](https://www.w3.org/Translations/WCAG20-de/).

Der Unterschied zwischen _**hohem Kontrast**_ und _**automatischem hohem Kontrast**_ besteht darin, dass High Contrast manuell per Mausklick aktiviert werden kann, während Auto High Contrast den Kontrastmodus automatisch einschaltet, sobald in den Systemeinstellungen der Dark Mode aktiviert ist.

![wcag-einstellungen](https://github.com/user-attachments/assets/6d8b8443-e0ae-471b-bd74-07e48253ac95)

Hier können Sie Features (sprich Insert-Tags) einzeln de/aktivieren und die Zuordnung zwischen der _**Seite zur Erläuterung
der Schriftgrößenänderung**_ und dem Icon festlegen.

# DEV
## run before commit

    vendor/bin/ecs check src tests

## rebuild the compiled stylesheets
The stylesheets in `public/css` (`theme-components.css`, `feature_section.css`, `icon_tile.css`) are compiled from the
SCSS sources in `public/scss`, so that they work in page layouts of the type "modern" as well (they do not compile SCSS
files). Rebuild them after changing an SCSS source:

    for f in theme-components feature_section icon_tile; do vendor/bin/pscss public/scss/$f.scss public/css/$f.css; done
