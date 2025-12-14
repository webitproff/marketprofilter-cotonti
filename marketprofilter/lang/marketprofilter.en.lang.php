<?php
/**
 * English Language File for Market PRO Filter plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: marketprofilter.en.lang.php
 * Purpose: English localization for the Market PRO Filter plugin. Defines admin interface and forms strings.
 * Date: 2025-12-14
 * @package marketprofilter
 * @version 2.2.8
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 https://github.com/webitproff/
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */

$L['cfg_marketprofilter_log_enable'] = 'Enable logging and journal recording';

/**
 * Plugin Info
 */
$L['info_name'] = 'Market PRO Filter';
$L['info_desc'] = 'Flexible filtering of products and services in category lists by custom parameters or characteristics, within a specific category or across the entire catalog';
$L['info_notes'] = 'Required: <code>Market PRO v.5+ by webitproff</code> module, PHP 8.4+, MySQL 8.0+, Cotonti Siena v.0.9.26 +';


$L['marketprofilter_admin_title'] = 'Filter parameters management';
$L['marketprofilter_param_name'] = 'Parameter code';
$L['marketprofilter_add_param'] = 'Add parameter';
$L['marketprofilter_edit_param'] = 'Edit parameter';
$L['marketprofilter_param_name_hint'] = 'Unique code (e.g., power, battery_capacity)';
$L['marketprofilter_param_title'] = 'Parameter title';
$L['marketprofilter_param_type'] = 'Parameter type';
$L['marketprofilter_param_values'] = 'Parameter values (JSON)';
$L['marketprofilter_param_values_hint'] = 'For range: {"min":0,"max":100}; for list/checkboxes: ["value1","value2"]';
$L['marketprofilter_param_active'] = 'Active';
$L['marketprofilter_param_category'] = 'Assign category to parameter';
$L['marketprofilter_param_category_hint'] = 'Category selection is optional';
$L['marketprofilter_existing_params'] = 'Existing parameters';
$L['marketprofilter_id'] = 'ID';
$L['marketprofilter_actions'] = 'Actions';
$L['marketprofilter_confirm_delete'] = 'Are you sure you want to delete this parameter?';
$L['marketprofilter_range'] = 'Range';
$L['marketprofilter_radio'] = 'Radio buttons';
$L['marketprofilter_select'] = 'Dropdown list';
$L['marketprofilter_checkbox'] = 'Checkboxes';
$L['marketprofilter_from'] = 'From';
$L['marketprofilter_to'] = 'To';
$L['marketprofilter_reset'] = 'Reset filters';
$L['marketprofilter_apply'] = 'Apply filters';
$L['marketprofilter_price'] = 'Price range';
$L['marketprofilter_cats'] = 'Categories';
$L['marketprofilter_sort'] = 'Sort by';
$L['marketprofilter_examples'] = 'Examples';
$L['market_mostrelevant'] = 'Most relevant';
$L['market_costasc'] = 'Price: low to high';
$L['market_costdesc'] = 'Price: high to low';
$L['marketprofilter_paramsItem'] = 'Specifications and properties';
$L['marketprofilter_translations'] = 'Translations';
$L['marketprofilter_param_values_translated'] = 'Translated values';
$L['marketprofilter_i18n_values_hint'] = 'Format: {"key":"translation","key2":"translation2"}. Keys must match param_values';
$L['marketprofilter_error_invalid_data'] = 'Invalid parameter data';
$L['marketprofilter_error_range_format'] = 'For type "Range", JSON is required: {"min":X,"max":Y}';
$L['marketprofilter_error_values_format'] = 'Values must be an array: ["value1","value2"]';
$L['marketprofilter_param_added'] = 'Parameter successfully added';
$L['marketprofilter_param_updated'] = 'Parameter successfully updated';
$L['marketprofilter_param_deleted'] = 'Parameter deleted';

// ADDED STRINGS FOR MULTI-LANGUAGE SUPPORT
$L['marketprofilter_i18n_title_ru'] = 'Parameter title (RU)';
$L['marketprofilter_i18n_title_en'] = 'Parameter title (EN)';
$L['marketprofilter_i18n_title_ua'] = 'Parameter title (UA)';
$L['marketprofilter_i18n_values_ru'] = 'Values translation (RU)';
$L['marketprofilter_i18n_values_en'] = 'Values translation (EN)';
$L['marketprofilter_i18n_values_ua'] = 'Values translation (UA)';

$L['marketprofilter_found_items'] = 'Found {COUNT} items';
$L['marketprofilter_no_items'] = 'No products found for the selected parameters';

$L['marketprofilter_adminTitle'] = 'Market PRO Filter – Product Filter Plugin for Cotonti CMF';
$L['marketprofilter_adminHelp'] = 'Detailed instructions for filling in filter parameter fields:
<ul>
<li><b>Parameter code</b> — a unique system identifier of the parameter. Use only Latin letters, digits, and underscores, without spaces. For example: <i>power</i>, <i>battery_capacity</i>. This code is used in the database and in the code, so duplicates are not allowed.</li>
<li><b>Parameter title</b> — a human-readable name that users will see in the site interface. For example: <i>Power</i>, <i>Battery capacity</i>.</li>
<li><b>Parameter type</b> — select the value type:
    <ul>
        <li><i>Range</i> — for numeric parameters with minimum and maximum values, such as price or weight;</li>
        <li><i>Dropdown list</i> — for selecting one option from a fixed list of values;</li>
        <li><i>Checkboxes</i> — for selecting one or multiple options from a list.</li>
    </ul>
</li>
<li><b>Parameter values (JSON)</b> — this field defines the allowed parameter values in JSON format:
    <ul>
        <li>For the <i>Range</i> type, specify an object with two properties <code>min</code> and <code>max</code>, for example: <code>{"min":0,"max":100}</code>. Values must be numeric, and <code>min</code> must be less than or equal to <code>max</code>.</li>
        <li>For the <i>Dropdown list</i> and <i>Checkboxes</i> types, specify an array of strings with possible options, for example: <code>["Red","Green","Blue"]</code>. Each array element represents a separate value.</li>
    </ul>
    <p><b>Important:</b> JSON must be strictly valid:
        <ul>
            <li>Use double quotes for keys and string values;</li>
            <li>Do not add trailing commas after the last element;</li>
            <li>The structure must exactly match the examples above.</li>
        </ul>
        To validate JSON correctness, use online validators such as <a href="https://jsonlint.com" target="_blank" rel="noopener noreferrer">jsonlint.com</a>. Invalid JSON will cause errors when saving or using the filter.</p>
</li>
<li><b>Active</b> — a toggle that enables or disables the filter parameter on the site. If the parameter is inactive, it will not be displayed to users.</li>
</ul>';
