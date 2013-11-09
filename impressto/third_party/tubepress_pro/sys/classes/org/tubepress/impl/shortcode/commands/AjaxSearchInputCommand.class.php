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

class_exists('org_tubepress_impl_classloader_ClassLoader') || require dirname(__FILE__) . '/../../classloader/ClassLoader.class.php';
org_tubepress_impl_classloader_ClassLoader::loadClasses(array(
    'org_tubepress_api_const_options_names_Output',
    'org_tubepress_api_const_options_names_Thumbs',
    'org_tubepress_api_const_options_values_OutputValue',
    'org_tubepress_api_const_template_Variable',
    'org_tubepress_api_theme_ThemeHandler',
    'org_tubepress_impl_log_Log',
    'org_tubepress_impl_shortcode_commands_SearchInputCommand',
    'org_tubepress_impl_util_StringUtils',
));

/**
 * HTML generation strategy that generates HTML for a single video + meta info.
 */
class org_tubepress_impl_shortcode_commands_AjaxSearchInputCommand extends org_tubepress_impl_shortcode_commands_SearchInputCommand
{
    private static $_logPrefix = 'Ajax Search Input Command';

    /**
     * Returns true if this strategy is able to handle
     *  the request.
     *
     * @return boolean True if the strategy can handle the request, false otherwise.
     */
    public function execute($context)
    {
        $ioc         = org_tubepress_impl_ioc_IocContainer::getInstance();
        $execContext = $ioc->get(org_tubepress_api_exec_ExecutionContext::_);
        $galleryId   = $execContext->get(org_tubepress_api_const_options_names_Advanced::GALLERY_ID);

        if ($execContext->get(org_tubepress_api_const_options_names_Output::OUTPUT) !== org_tubepress_api_const_options_values_OutputValue::AJAX_SEARCH_INPUT) {

            org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Not set for output.');

            return false;
        }

        if ($galleryId == '') {

            $galleryId = mt_rand();
        }

        org_tubepress_impl_log_Log::log(self::$_logPrefix, 'Handling execution');

        $th       = $ioc->get(org_tubepress_api_theme_ThemeHandler::_);
        $pm       = $ioc->get(org_tubepress_api_plugin_PluginManager::_);
        $template = $th->getTemplateInstance($this->getTemplatePath());

        $customOptions = $execContext->getCustomOptions();
        $customOptions[org_tubepress_api_const_options_names_Output::OUTPUT] = org_tubepress_api_const_options_values_OutputValue::SEARCH_RESULTS;
        $customOptions[org_tubepress_api_const_options_names_Thumbs::AJAX_PAGINATION] = true;
        $execContext->setCustomOptions($customOptions);

        $template->setVariable(org_tubepress_api_const_template_Variable::SHORTCODE, urlencode($execContext->toShortcode()));
        $template->setVariable(org_tubepress_api_const_template_Variable::SEARCH_TARGET_DOM_ID, $execContext->get(org_tubepress_api_const_options_names_InteractiveSearch::SEARCH_RESULTS_DOM_ID));
        $template->setVariable(org_tubepress_api_const_template_Variable::GALLERY_ID, $galleryId);

        $template = $pm->runFilters(org_tubepress_api_const_plugin_FilterPoint::TEMPLATE_SEARCHINPUT, $template);
        $html     = $pm->runFilters(org_tubepress_api_const_plugin_FilterPoint::HTML_SEARCHINPUT, $template->toString());

        $context->returnValue = $html;

        /** Signal that we've handled execution */
        return true;
    }


    protected function getTemplatePath()
    {
        return 'search/ajax_search_input.tpl.php';
    }
}
