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
    'org_tubepress_api_const_options_names_Embedded',
    'org_tubepress_api_exec_ExecutionContext',
    'org_tubepress_api_provider_ProviderResult',
    'org_tubepress_impl_ioc_IocContainer',
));


/**
 * Records the order of the videos into the context so that it can be placed into
 * the DOM later down the road...
 */
class org_tubepress_impl_plugin_filters_providerresult_SequenceLogger
{
	public function alter_providerResult(org_tubepress_api_provider_ProviderResult $providerResult)
	{
	    $ioc           = org_tubepress_impl_ioc_IocContainer::getInstance();
	    $context       = $ioc->get(org_tubepress_api_exec_ExecutionContext::_);

	    if ($context->get(org_tubepress_api_const_options_names_Embedded::SEQUENCE) != '') {

	        return $providerResult;
	    }

		$videos        = $providerResult->getVideoArray();
		$videoIds      = $this->_getVideoIds($videos);
		$videoIdString = $this->_getVideoIdString($videoIds);

        $context->set(org_tubepress_api_const_options_names_Embedded::SEQUENCE, $videoIdString);

		return $providerResult;
	}

	private function _getVideoIdString($videoIds)
	{
	    return '\'' . implode("', '", $videoIds) . '\'';
	}

	private function _getVideoIds($videos)
	{
	    $toReturn = array();

	    foreach ($videos as $video) {

	        $toReturn[] = $video->getId();
	    }

	    return $toReturn;
	}
}