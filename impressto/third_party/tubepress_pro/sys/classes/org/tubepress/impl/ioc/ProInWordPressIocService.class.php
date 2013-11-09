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

class_exists('org_tubepress_impl_classloader_ClassLoader') || require dirname(__FILE__) . '/../classloader/ClassLoader.class.php';
org_tubepress_impl_classloader_ClassLoader::loadClasses(array(
    'org_tubepress_impl_ioc_FreeWordPressPluginIocService',
    'org_tubepress_api_bootstrap_Bootstrapper',
    'org_tubepress_api_factory_VideoFactory',
    'org_tubepress_api_provider_Provider',
    'org_tubepress_api_shortcode_ShortcodeHtmlGenerator',
    'org_tubepress_api_options_OptionValidator'
));

/**
 * Dependency injector for TubePress Pro in a WordPress environment
 */
class org_tubepress_impl_ioc_ProInWordPressIocService extends org_tubepress_impl_ioc_FreeWordPressPluginIocService
{
    function __construct()
    {
        parent::__construct();

        $this->bind(org_tubepress_api_bootstrap_Bootstrapper::_)          ->to('org_tubepress_impl_bootstrap_ProTubePressBootstrapper');
        $this->bind(org_tubepress_api_factory_VideoFactory::_)            ->to('org_tubepress_impl_factory_ProVideoFactoryChain');
        $this->bind(org_tubepress_api_provider_Provider::_)               ->to('org_tubepress_impl_provider_MultipleSourcesVideoFeedProvider');
        $this->bind(org_tubepress_api_shortcode_ShortcodeHtmlGenerator::_)->to('org_tubepress_impl_shortcode_ProShortcodeHtmlGeneratorChain');
        $this->bind(org_tubepress_api_options_OptionValidator::_)         ->to('org_tubepress_impl_options_ProOptionValidator');
    }
}
