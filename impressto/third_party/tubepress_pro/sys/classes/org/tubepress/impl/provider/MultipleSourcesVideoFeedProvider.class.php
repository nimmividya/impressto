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
    'org_tubepress_api_const_options_names_Output',
    'org_tubepress_api_exec_ExecutionContext',
    'org_tubepress_api_provider_ProviderResult',
    'org_tubepress_impl_ioc_IocContainer',
    'org_tubepress_impl_log_Log',
    'org_tubepress_impl_options_OptionsReference',
    'org_tubepress_impl_provider_SimpleProvider',
));

/**
 * Video provider that can handle multiple sources.
 */
class org_tubepress_impl_provider_MultipleSourcesVideoFeedProvider extends org_tubepress_impl_provider_SimpleProvider
{
    private static $_logPrefix = 'Multiple Sources Video Provider';

    const DELIM = ' + ';

    /**
     * Get the video feed result.
     *
     * @return org_tubepress_video_feed_FeedResult The feed result.
     */
    protected function collectMultipleVideos()
    {
        $ioc         = org_tubepress_impl_ioc_IocContainer::getInstance();
        $execContext = $ioc->get(org_tubepress_api_exec_ExecutionContext::_);

        /** See if we're using multiple modes */
        if (! $this->_usingMultipleModes($execContext)) {

            org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Multiple video sources not detected.');

            return parent::collectMultipleVideos();
        }

        org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Multiple video sources detected.');

        return $this->_getVideosFromMultipleSources($execContext);
    }

    private function _getVideosFromMultipleSources(org_tubepress_api_exec_ExecutionContext $execContext)
    {
    	/** Save a copy of the original options. */
        $originalCustomOptions = $execContext->getCustomOptions();

        /** Build the result. */
        $result = $this->_buildCombinedProviderResult($execContext);

        /** Restore the original options. */
        $execContext->setCustomOptions($originalCustomOptions);

        return $result;
    }

    private function _buildCombinedProviderResult(org_tubepress_api_exec_ExecutionContext $execContext)
    {
    	/** Figure out which modes we're gonna run. */
    	$suppliedModeValue = $execContext->get(org_tubepress_api_const_options_names_Output::GALLERY_SOURCE);
    	$modesToRun        = $this->_splitByPlusSurroundedBySpaces($suppliedModeValue);
    	$modeCount         = count($modesToRun);
    	$index             = 1;

    	$result = new org_tubepress_api_provider_ProviderResult();

    	org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Detected %d modes (%s)', $modeCount, implode(', ', $modesToRun));

    	/** Iterate over each mode and collect the videos */
    	foreach ($modesToRun as $mode) {

    		org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Start collecting videos for mode %s (%d of %d modes)', $mode, $index, $modeCount);

    		try {

    			$result = $this->_appendModeResultToCombinedResult($mode, $result);

    		} catch (Exception $e) {

    			org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Caught exception getting videos: ' . $e->getMessage());
    		}

    		org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Done collecting videos for mode %s (%d of %d modes)', $mode, $index++, $modeCount);
    	}

    	org_tubepress_impl_log_Log::log(self::$_logPrefix, 'After full collection, we now have %d videos', count($result->getVideoArray()));

    	return $result;
    }

    private function _appendModeResultToCombinedResult($mode, org_tubepress_api_provider_ProviderResult $resultToAppendTo)
    {
    	$ioc         = org_tubepress_impl_ioc_IocContainer::getInstance();
    	$odr         = $ioc->get(org_tubepress_api_options_OptionDescriptorReference::_);
    	$execContext = $ioc->get(org_tubepress_api_exec_ExecutionContext::_);

        $execContext->set(org_tubepress_api_const_options_names_Output::GALLERY_SOURCE, $mode);

        /** Some modes, like 'mobile', don't really take a parameter */
        if ($odr->findOneByName($mode . 'Value') === null) {

        	$modeResult = $this->_collectedValuelessModeResult($execContext, $mode);

        } else {

        	$modeResult = $this->_collectedValuefulModeResult($execContext, $mode);
        }

        $newCombinedResult = $this->_combineFeedResults($resultToAppendTo, $modeResult);

        return $newCombinedResult;
    }

    private function _collectedValuelessModeResult(org_tubepress_api_exec_ExecutionContext $execContext, $mode)
    {
         org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Now collecting videos for value-less "%s" mode', $mode);

         $result = parent::collectMultipleVideos();

         $this->_logIteration($result, $mode);

         return $result;
    }

    private function _collectedValuefulModeResult(org_tubepress_api_exec_ExecutionContext $execContext, $mode)
    {
    	$rawModeValue   = $execContext->get($mode . 'Value');
    	$modeValueArray = $this->_splitByPlusSurroundedBySpaces($rawModeValue);
    	$modeValueCount = count($modeValueArray);
    	$index          = 1;

    	$resultToReturn = new org_tubepress_api_provider_ProviderResult();

        foreach ($modeValueArray as $modeValue) {

        	org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Start collecting videos for mode %s with value %s (%d of %d values for mode %s)', $mode, $modeValue, $index, $modeValueCount, $mode);

            $execContext->set($mode . 'Value', $modeValue);

            try {

                $modeResult = parent::collectMultipleVideos();

                $this->_logIteration($modeResult, $mode, $modeValue);

                $resultToReturn = $this->_combineFeedResults($resultToReturn, $modeResult);

            } catch (Exception $e) {

                org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Problem collecting videos for mode "%s" and value "%s": %s', $mode, $modeValue, $e->getMessage());
            }

            org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Done collecting videos for mode %s with value %s (%d of %d values for mode %s)', $mode, $modeValue, $index++, $modeValueCount, $mode);
        }

        return $resultToReturn;
    }

    private function _combineFeedResults(org_tubepress_api_provider_ProviderResult $first, org_tubepress_api_provider_ProviderResult $second)
    {
        $result = new org_tubepress_api_provider_ProviderResult();

        /** Merge the two video arrays into a single one */
        $result->setVideoArray(array_merge($first->getVideoArray(), $second->getVideoArray()));

        /** The total result count is the max of the two total result counts */
        $result->setEffectiveTotalResultCount(max($first->getEffectiveTotalResultCount(), $second->getEffectiveTotalResultCount()));

        return $result;
    }

    private function _usingMultipleModes(org_tubepress_api_exec_ExecutionContext $execContext)
    {
        $mode = $execContext->get(org_tubepress_api_const_options_names_Output::GALLERY_SOURCE);

        if (count($this->_splitByPlusSurroundedBySpaces($mode)) > 1) {

            return true;
        }

        $ioc = org_tubepress_impl_ioc_IocContainer::getInstance();
        $odf = $ioc->get(org_tubepress_api_options_OptionDescriptorReference::_);

        if ($odf->findOneByName($mode . 'Value') !== null) {

            $modeValue = $execContext->get($mode . 'Value');

            return strpos($modeValue, self::DELIM) !== false;
        }

        return false;
    }

    private function _logIteration(org_tubepress_api_provider_ProviderResult $result, $mode, $value = '')
    {
    	org_tubepress_impl_log_Log::log(self::$_logPrefix, 'After collecting videos for mode "%s" with value "%s", we now have %d video(s)',
    		$mode, $value, sizeof($result->getVideoArray()));
    }

    private function _splitByPlusSurroundedBySpaces($string)
    {
    	return preg_split('/\s*\+\s*/', $string);
    }
}
