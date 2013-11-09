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
    'org_tubepress_api_const_js_TubePressGalleryInit',
    'org_tubepress_api_const_options_names_Embedded',
    'org_tubepress_api_exec_ExecutionContext',
    'org_tubepress_impl_log_Log'
));

/**
 * Writes the video sequence to JavaScript.
 */
class org_tubepress_impl_plugin_filters_galleryinitjs_GalleryInitJsSequencer
{
    private static $_logPrefix = 'Gallery Init JS Sequencer';

    /**
     * Modify the name-value pairs sent to TubePressGallery.init().
     *
     * @param array $args An associative array (name => value) of args to send to TubePressGallery.init();
     *
     * @return array The (possibly modified) array. Never null.
     *
     */
    public function alter_galleryInitJavaScript($args)
    {
        if (!is_array($args)) {

            org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Filter invoked with a non-array argument :(');
            return $args;
        }

        $ioc      = org_tubepress_impl_ioc_IocContainer::getInstance();
        $context  = $ioc->get(org_tubepress_api_exec_ExecutionContext::_);
        $sequence = $context->get(org_tubepress_api_const_options_names_Embedded::SEQUENCE);
        $autoNext = $context->get(org_tubepress_api_const_options_names_Embedded::AUTONEXT) ? 'true' : 'false';

        $args[org_tubepress_api_const_js_TubePressGalleryInit::NAME_PARAM_AUTONEXT] = $autoNext;
        $args[org_tubepress_api_const_js_TubePressGalleryInit::NAME_PARAM_SEQUENCE] = "[ $sequence ]";

        return $args;
    }
}