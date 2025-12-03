<?php

declare(strict_types=1);

/*
 * theme components bundle for Contao Open Source CMS
 *
 * Copyright (C) 2023 pdir / digital agentur <develop@pdir.de>
 *
 * @package    contao-themes-net/theme-components-bundle
 * @link       https://github.com/contao-themes-net/theme-components-bundle
 * @license    LGPL-3.0+
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$GLOBALS['TL_LANG']['tl_page']['wcag_legend'] = 'Paramètres WCAG (Lignes directrices sur l\'accessibilité du contenu web)';

$GLOBALS['TL_LANG']['tl_page']['enable_high_contrast'] = ['Autoriser le passage en mode contraste élevé', 'Permet de passer en mode de contraste élevé. Cette option est activée par défaut.'];
$GLOBALS['TL_LANG']['tl_page']['enable_auto_high_contrast'] = ['Commutation automatique en mode à contraste élevé', 'Bascule automatiquement en mode à contraste élevé lorsque les paramètres du système changent, par exemple lorsque le mode sombre est activé ou désactivé.'];
$GLOBALS['TL_LANG']['tl_page']['enable_font_size'] = ['Autoriser l\'affichage de l\'icône de modification de la taille des caractères', 'Permet d\'afficher l\'icône de modification de la taille de la police. Cette fonction est réalisée ici par le biais d\'un lien vers une page contenant des informations sur la modification de la taille de la police. La taille de la police elle-même n\'est pas modifiée.'];
$GLOBALS['TL_LANG']['tl_page']['enable_font_size_switcher'] = ['Autoriser l\'affichage du basculement de la taille de la police (-A A A+) pour modifier la taille de la police', 'Permet d\'afficher la bascule de la taille de la police pour modifier la taille de la police. Cette fonction modifie directement la taille de la police.'];
$GLOBALS['TL_LANG']['tl_page']['font_size_comment_page'] = ['Sélectionnez ici la page sur laquelle vous souhaitez expliquer la taille des caractères.', 'Étant donné que tous les navigateurs modernes prennent en charge le changement de la taille des caractères, cette fonction ne devrait plus être réalisée par Javascript ou des feuilles de style. Au lieu de cela, il est plus simple de proposer des informations sur la modification de la taille de la police sur une page séparée.'];
