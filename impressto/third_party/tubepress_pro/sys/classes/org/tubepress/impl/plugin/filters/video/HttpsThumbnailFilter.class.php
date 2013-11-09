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
    'org_tubepress_api_provider_ProviderCalculator',
    'org_tubepress_api_provider_Provider',
    'org_tubepress_impl_log_Log'
));

/**
 * Optionally forces thumbnails to load over HTTPS.
 */
class org_tubepress_impl_plugin_filters_video_HttpsThumbnailFilter
{
    private static $_logPrefix = 'HTTPS Thumbnails Filter';

    /**
     * Modify an invididual TubePress video (YouTube or Vimeo).
     *
     * To use this filter point, create a class that includes a function with the method signature defined below.
     * Then in your plugin file (tubepress-content/plugins/yourplugin/yourplugin.php), register the class with:
     *
     *     TubePress::registerFilter('video', $yourClassInstance);
     *
     *
     * @param org_tubepress_api_video_Video $video             The video to modify.
     * @param string                        $videoProviderName The name of the video provider ("vimeo" or "youtube")
     *
     * @return org_tubepress_api_video_Video The (possibly modified) video. Never null.
     */
     function alter_video(org_tubepress_api_video_Video $video, $videoProviderName)
     {
         $ioc     = org_tubepress_impl_ioc_IocContainer::getInstance();
         $context = $ioc->get(org_tubepress_api_exec_ExecutionContext::_);
         $pc      = $ioc->get(org_tubepress_api_provider_ProviderCalculator::_);
         /**
          * If the user doesn't want HTTPS, or this is Vimeo...
          */
         if (! $context->get(org_tubepress_api_const_options_names_Advanced::HTTPS) || $pc->calculateProviderOfVideoId($video->getId()) === org_tubepress_api_provider_Provider::VIMEO) {

             return $video;
         }

         $url = $video->getThumbnailUrl();

         /**
          * If, on the off chance, the URL doesn't begin with "http://" then just bail.
          */
         if (substr($url, 0, 7) !== 'http://') {

             return $video;
         }


         $url = str_replace('http://', 'https://', $url, $count = 1);

         $video->setThumbnailUrl($url);

         return $video;
     }
}