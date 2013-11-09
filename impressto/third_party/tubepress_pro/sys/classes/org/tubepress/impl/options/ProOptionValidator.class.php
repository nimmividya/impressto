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

class_exists('org_tubepress_impl_classloader_ClassLoader') || require(dirname(__FILE__) . '/../classloader/ClassLoader.class.php');
org_tubepress_impl_classloader_ClassLoader::loadClasses(array(
    'org_tubepress_api_const_options_names_Output',
    'org_tubepress_api_const_options_values_GallerySourceValue',
    'org_tubepress_impl_options_DefaultOptionValidator',
));

/**
 * Performs validation on Pro option values
 */
class org_tubepress_impl_options_ProOptionValidator extends org_tubepress_impl_options_DefaultOptionValidator
{
    private static $_logPrefix = 'Pro Option Validator';

    private static $_optionsWeCareAbout = array(

        org_tubepress_api_const_options_names_Output::GALLERY_SOURCE,
        org_tubepress_api_const_options_values_GallerySourceValue::YOUTUBE_FAVORITES,
        org_tubepress_api_const_options_values_GallerySourceValue::YOUTUBE_PLAYLIST,
        org_tubepress_api_const_options_values_GallerySourceValue::YOUTUBE_SEARCH,
        org_tubepress_api_const_options_values_GallerySourceValue::YOUTUBE_USER,
        org_tubepress_api_const_options_values_GallerySourceValue::VIMEO_ALBUM,
        org_tubepress_api_const_options_values_GallerySourceValue::VIMEO_APPEARS_IN,
        org_tubepress_api_const_options_values_GallerySourceValue::VIMEO_CHANNEL,
        org_tubepress_api_const_options_values_GallerySourceValue::VIMEO_CREDITED,
        org_tubepress_api_const_options_values_GallerySourceValue::VIMEO_GROUP,
        org_tubepress_api_const_options_values_GallerySourceValue::VIMEO_LIKES,
        org_tubepress_api_const_options_values_GallerySourceValue::VIMEO_SEARCH,
        org_tubepress_api_const_options_values_GallerySourceValue::VIMEO_UPLOADEDBY
    );

    /**
     * Gets the failure message of a name/value pair that has failed validation.
     *
     * @param string       $optionName The option name
     * @param unknown_type $candidate  The candidate option value
     *
     * @return unknown Null if the option passes validation, otherwise a string failure message.
     */
    function getProblemMessage($optionName, $candidate)
    {
        $parentProblemMessage = parent::getProblemMessage($optionName, $candidate);

        /** If the parent doesn't have a problem, or we don't know about this option... */
        if ($parentProblemMessage === null || ! $this->_isOptionThatWeHandle($optionName)) {

            return null;
        }

        return $this->_getProblemMessage($optionName, $candidate);
    }

    private function _getProblemMessage($optionName, $candidate)
    {
        if ($optionName === org_tubepress_api_const_options_names_Output::GALLERY_SOURCE) {

            return $this->_getProblemMessageForMode($candidate);
        }

        return $this->_getProblemMessageForSourceValue($optionName, $candidate);
    }

    private function _getProblemMessageForSourceValue($optionName, $candidate)
    {
        $ioc        = org_tubepress_impl_ioc_IocContainer::getInstance();
        $odr        = $ioc->get(org_tubepress_api_options_OptionDescriptorReference::_);
        $descriptor = $odr->findOneByName(org_tubepress_api_const_options_names_Output::GALLERY_SOURCE);
        $regex      = "/(?:\w)(?:\s*\+\s*\w)*/";

        return $this->_matchesRegex($optionName, $regex, $candidate);
    }

    private function _getProblemMessageForMode($candidate)
    {
        $ioc                    = org_tubepress_impl_ioc_IocContainer::getInstance();
        $odr                    = $ioc->get(org_tubepress_api_options_OptionDescriptorReference::_);
        $descriptor             = $odr->findOneByName(org_tubepress_api_const_options_names_Output::GALLERY_SOURCE);
        $acceptableValues       = $descriptor->getAcceptableValues();
        $acceptableValuesString = implode('|', $acceptableValues);
        $regex                  = "/(?:$acceptableValuesString)(?:\s*\+\s*(?:$acceptableValuesString))*/";

        return $this->_matchesRegex(org_tubepress_api_const_options_names_Output::GALLERY_SOURCE, $regex, $candidate);
    }

    private function _matchesRegex($optionName, $regex, $candidate)
    {
        if (preg_match_all($regex, $candidate, $matches) === 1) {

            return null;
        }

        return sprintf('%s must match %s. You supplied %s', $optionName, $regex, $candidate);
    }

    private function _isOptionThatWeHandle($optionName)
    {
        return in_array($optionName, self::$_optionsWeCareAbout);
    }
}
