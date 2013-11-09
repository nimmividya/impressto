<?php
/**
 * Copyright 2006 - 2012 Eric D. Hough (http://ehough.com)
 *
 * This file is part of TubePress (http://tubepress.org)
 *
 * TubePress is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * TubePress is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with TubePress.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

class_exists('org_tubepress_impl_classloader_ClassLoader') || require dirname(__FILE__) . '/../../../classloader/ClassLoader.class.php';
org_tubepress_impl_classloader_ClassLoader::loadClasses(array(
    'org_tubepress_api_const_options_names_Advanced',
    'org_tubepress_api_const_template_Variable',
    'org_tubepress_api_exec_ExecutionContext',
    'org_tubepress_impl_log_Log'
));

/**
 * Optionally forces the embedded player to load over HTTPS.
 */
class org_tubepress_impl_plugin_filters_embeddedtemplate_EmbeddedPlayerHttpsFilter
{
    private static $_logPrefix = 'Embedded Player HTTPS Filter';

    /**
     * Modify the embedded player template.
     *
     * @param org_tubepress_api_template_Template $template          The template to modify.
     * @param string                              $videoId           The video ID currently being loaded into the embedded player.
     * @param string                              $videoProviderName The name of the video provider ("vimeo" or "youtube")
     * @param org_tubepress_api_url_Url           $dataUrl           The embedded data URL.
     * @param string                              $embeddedImplName  The name of the embedded implementation ("youtube", "longtail", or "vimeo")
     *
     * @return org_tubepress_api_template_Template The (possibly modified) template. Never null.
     */
     function alter_embeddedTemplate(org_tubepress_api_template_Template $template, $videoId, $videoProviderName,
      								   org_tubepress_api_url_Url $dataUrl, $embeddedImplName)
     {
         $ioc     = org_tubepress_impl_ioc_IocContainer::getInstance();
         $context = $ioc->get(org_tubepress_api_exec_ExecutionContext::_);

         /**
          * If the user wants HTTPS...
          */
         if ($context->get(org_tubepress_api_const_options_names_Advanced::HTTPS)) {

             $dataUrl->setScheme('https');

             $template->setVariable(org_tubepress_api_const_template_Variable::EMBEDDED_DATA_URL, $dataUrl->toString());
         }

         return $template;
     }
}