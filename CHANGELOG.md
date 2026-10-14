# Changelog

[//]: <> (
Types of changes
    Added for new Addeds.
    Changed for changes in existing functionality.
    Deprecated for soon-to-be removed Addeds.
    Removed for now removed Addeds.
    Fixed for any bug fixes.
    Security in case of vulnerabilities.
)

## [2.0.0](https://github.com/contao-themes-net/theme-components-bundle/tree/2.0.0) – unreleased

- [Changed] Content Box, Teaser Box, Price Table, Feature Element and Slider Element are now fragment controllers with Twig templates (`content_element/ct_*`) for Contao 5.7 and 6, modelled on the core elements
- [Changed] New markup with BEM classes (`.content-box`, `.teaser-box`, `.price-box`, `.feature-element`, `.slider-element`); themes have to adjust their styles
- [Changed] The template selection uses the core field "customTpl" with Twig variants; legacy selections (`ce_cthemes_*`) are migrated as soon as the Twig variant exists
- [Changed] The "Content wrapper" start/stop elements are replaced by the core "element_group" element; existing wrappers incl. nested ones are converted by a migration (child elements are moved into the group, stop elements are deleted)
- [Changed] The modal module (`ct_modal`) is now a frontend module controller with the Twig template `frontend_module/ct_modal` based on the native `<dialog>` element (`.ct-modal` BEM block, `public/js/modal.js`); legacy templates selected in "customTpl" keep working, the former selection field "modal_customTpl" is migrated
- [Added] Delay classes `reveal-delay-1` to `reveal-delay-3` for the scroll animations
- [Changed] All values of the scroll animations are defined as custom properties on `:root` (`--reveal-duration`, `--reveal-distance`, `--reveal-delay-1` etc.), so themes only have to override these tokens
- [Added] Minimal base styling in the `theme-components` cascade layer (`public/css/elements.css`)
- [Added] Image support for the Content Box palette
- [Fixed] The accessibility tools (high contrast, font size) and the scroll animations also work in page layouts of the type "modern": the new `PageAssetsListener` uses the `generatePage` hook for legacy layouts and the `LayoutEvent` for modern layouts and adds the scripts via `TL_HEAD`/`TL_BODY` instead of the `parseFrontendTemplate` hook
- [Fixed] The stylesheets of the high contrast mode, the Feature Section and the Icon Tile are shipped as compiled CSS (`public/css/theme-components.css`, `feature_section.css`, `icon_tile.css`), because modern layouts do not compile SCSS files and browsers cannot use a linked SCSS file (Icon Tile was unstyled in every layout type)
- [Changed] The Feature Section loads its stylesheet and script in the template (`style`/`script` blocks) instead of the controller
- [Fixed] The page hooks were registered twice (attribute and named service), so the scripts could be added twice
- [Removed] Legacy element classes in `src/Element` and their `.html5` templates
- [Removed] Content elements `ct_wrapperStart` and `ct_wrapperStop`
- [Removed] Legacy module class `src/Module/ModalModule.php`
- [Fixed] Headlines with the "subline" override no longer fail in debug mode (`strict_variables`) for frontend modules

## [1.10.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.10.0) – 2026-08-27

- [Added] Allow Contao 6
- [Fixed] Render the breadcrumb in page layouts of type "modern" (the placeholder is now replaced in a response listener instead of the `modifyFrontendPage` hook)

## [1.9.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.9.0) – 2026-07-22

- [Added] New content element "Feature Section"
- [Added] New content element "Icon Tile" (based on the hyperlink element with image and customized template)

## [1.8.3](https://github.com/contao-themes-net/theme-components-bundle/tree/1.8.3) – 2026-01-05

- [Fixed] Remove warning `Attempt to read property "rootId" on null`

## [1.8.2](https://github.com/contao-themes-net/theme-components-bundle/tree/1.8.2) – 2025-12-05

- [Fixed] Adjusted the BreadcrumbController so the active page title is correctly displayed in the breadcrumb.

## [1.8.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.8.1) – 2025-12-05

- [Fixed] The automatic contrast mode is now set to false by default. It can be manually enabled in the root page settings.

## [1.8.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.8.0) – 2025-11-27

- [Fixed] Updated CSS to include :focus states in addition to :hover for better keyboard accessibility
- [Added] Optional automatic contrast mode switching based on the system dark mode setting

## [1.7.3](https://github.com/contao-themes-net/theme-components-bundle/tree/1.7.3) – 2025-10-10

- [Added] Add link title field to price box element

## [1.7.2](https://github.com/contao-themes-net/theme-components-bundle/tree/1.7.2) – 2025-08-08

- [Added] Set data-contrast-mode attribute on document root

## [1.7.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.7.1) – 2025-07-18

- [Added] Add faqlist template (_bf) to avoid multiple identical links
- [Added] Add custom template field to slider element

## [1.7.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.7.0) – 2025-06-18

- [Added] Add new templates for accessibility (_bf) to avoid multiple identical links
- [Fixed] Fix warning: Attempt to read property "rootId" on null [#64](https://github.com/contao-themes-net/odd-theme-bundle/issues/64)

## [1.6.3](https://github.com/contao-themes-net/theme-components-bundle/tree/1.6.3) – 2025-02-03

- [Fixed] Change contrast switcher from link to button to improve seo score

## [1.6.2](https://github.com/contao-themes-net/theme-components-bundle/tree/1.6.2) – 2025-01-24

- [Fixed] Fix redundant title text (font size switcher)
- [Fixed] Fix device dependent event handler (contrast switcher)

## [1.6.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.6.1) – 2024-04-30

- [Added] Add link title field to feature element

## [1.6.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.6.0) – 2024-02-26

- [Added] Add subheadline

## [1.5.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.5.1) – 2023-10-11

- [Fixed] encode emails in elements and modules

## [1.5.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.5.0) – 2023-06-12

- [Added] Contrast and size switcher

# [1.4.4](https://github.com/contao-themes-net/theme-components-bundle/tree/1.4.4) – 2023-03-09

- [Fixed] warning in debug mode in slider template

## [1.4.3](https://github.com/contao-themes-net/theme-components-bundle/tree/1.4.3) – 2023-02-15

- [Added] Add custom template to wrapper start and stop element

## [1.4.2](https://github.com/contao-themes-net/theme-components-bundle/tree/1.4.2) – 2022-12-22

- [Fixed] Fix advances classes settings for content elements

## [1.4.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.4.1) – 2022-10-13

- [Fixed] add use statement in dca

## [1.4.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.4.0) – 2022-09-02

- [Changed] Set Contao 5 as minimum requirement

## [1.3.15](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.15) – 2023-10-11

- [Fixed] encode emails in elements and modules

## [1.3.14](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.14) – 2023-03-09

- [Fixed] warning in debug mode in slider template

## [1.3.13](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.13) – 2023-02-15

- [Added] Add custom template to wrapper start and stop element

## [1.3.12](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.12) – 2022-04-19

- [Fixed] backend wilcard

## [1.3.11](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.11) – 2022-04-05

- [Fixed] meta info bug in slider element
- [Changed] code styling and back end optimizations

## [1.3.10](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.10) – 2022-04-04

- [Fixed] bug fixed when no image is set

## [1.3.9](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.9) – 2022-03-25

- [Added] add visibility legend for content box and teaser box
- [Added] add protected legend and guests field in dca
- [Removed] remove unused line in TeaserBoxElement.php

## [1.3.8](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.8) – 2021-05-10

- [Removed] remove link for image in slider element

## [1.3.7](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.7) – 2021-05-05

- [Fixed] fix php 8 undefined array index errors

## [1.3.6](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.6) – 2021-01-29

- [Fixed] fix translations

## [1.3.5](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.5) – 2020-02-28

- [Fixed] add missing translations

## [1.3.4](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.4) – 2020-02-04

- [Fixed] hide slider text if class "only-image" is active

## [1.3.3](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.3) – 2020-01-22

- [Fixed] fix links in price, simplebox and feature element

## [1.3.2](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.2) – 2019-10-24

- [Changed] update feature icon field

## [1.3.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.1) – 2019-10-19

- [Added] add custom template for feature element

## [1.3.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.3.0) – 2019-10-09

- [Added] add slider element

## [1.2.2](https://github.com/contao-themes-net/theme-components-bundle/tree/1.2.2) – 2019-07-15

- [Fixed] fix image in teaser box

## [1.2.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.2.1) – 2019-07-12

- [Added] add image to content box

## [1.2.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.2.0) – 2019-06-28

- [Added] add module translation

## [1.1.3](https://github.com/contao-themes-net/theme-components-bundle/tree/1.1.3) – 2019-03-21

- [Changed] update teaserbox and contentbox backend wildcard

## [1.1.2](https://github.com/contao-themes-net/theme-components-bundle/tree/1.1.2) – 2019-03-20

- [Changed] update advances classes version in composer.json

## [1.1.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.1.1) – 2019-01-15

- [Fixed] fix bug: can't select custom template for teaserbox

## [1.1.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.1.0) – 2019-01-07

- [Added] add link title for teaserbox and contentbox

## [1.0.1](https://github.com/contao-themes-net/theme-components-bundle/tree/1.0.1) – 2019-01-07

- [Changed] update template for teaserbox and contentbox

## [1.0.0](https://github.com/contao-themes-net/theme-components-bundle/tree/1.0.0) – 2018-12-13

- first stable release
