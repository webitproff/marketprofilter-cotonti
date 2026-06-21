<?php
/**
 * English Language File for Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.en.lang.php
 * Purpose: English localization for the Market PRO Filter plugin. Defines admin interface and forms strings.
 * Date=May 11Th, 2026
 *
 * ReadMeMore:              https://abuyfile.com/market/cotonti/plugs/market-pro-filter 
 * Support:                 https://abuyfile.com/forums/cotonti/custom/plugs/marketprofilter
 *
 * Plugin Market PRO Filter (Source code):  https://github.com/webitproff/marketprofilter-cotonti
 * Module Market PRO (Source code):         https://github.com/webitproff/marketpro-cotonti
 *
 * @package marketprofilter
 * @version 3.3.36
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 https://github.com/webitproff/
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */

$L['cfg_marketprofilter_defaultlang'] = 'Default filter language code';
$L['cfg_marketprofilter_log_enable'] = 'Enable logging and journaling';

/**
 * Plugin Info
 */
$L['info_name'] = 'Market PRO Filter';
$L['info_desc'] = 'Flexible filtering of products and services in category lists by individual parameters or characteristics, within a specific category or the entire catalog';
$L['info_notes'] = '<span class="text-danger fw-bold">Before installing the plugin, be sure to create a product category with the code <code>electric-scooters</code> so that the demo filter data is inserted correctly</span>';


// ADMIN PANEL.
$L['marketprofilter_admin_title'] = 'Filter Parameter Management';
$L['marketprofilter_param_name'] = 'Parameter code';
$L['marketprofilter_add_param'] = 'Add parameter';
$L['marketprofilter_edit_param'] = 'Edit parameter';
$L['marketprofilter_param_name_hint'] = 'Unique code (e.g., power, battery_capacity)';
$L['marketprofilter_param_title'] = 'Parameter name';
$L['marketprofilter_param_type'] = 'Parameter type';
$L['marketprofilter_param_values'] = 'Parameter values (JSON)';
$L['marketprofilter_param_values_hint'] = 'For range: {"min":0,"max":100}; for list/checkboxes: ["value1","value2"]';
$L['marketprofilter_param_active'] = 'Active';
$L['marketprofilter_param_category'] = 'Set category for the parameter';
$L['marketprofilter_param_category_hint'] = 'Selecting a category is optional';
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
$L['marketprofilter_paramsItem'] = 'Characteristics and properties';
$L['marketprofilter_translations'] = 'Translations';
$L['marketprofilter_param_values_translated'] = 'Value translations';
$L['marketprofilter_i18n_values_hint'] = 'Format: {"key":"translation","key2":"translation2"}. Keys must match param_values';
$L['marketprofilter_error_invalid_data'] = 'Invalid parameter data';
$L['marketprofilter_error_range_format'] = 'For the "Range" type, JSON must be: {"min":X,"max":Y}';
$L['marketprofilter_error_values_format'] = 'Values must be an array: ["value1","value2"]';
$L['marketprofilter_param_added'] = 'Parameter added successfully';
$L['marketprofilter_param_updated'] = 'Parameter updated successfully';
$L['marketprofilter_param_deleted'] = 'Parameter deleted';
$L['marketprofilter_Hide_Filter'] = 'Hide Filter';
$L['marketprofilter_Show_Filter'] = 'Show Filter';
// ==== admin tpl ===
$L['marketprofilter_tab_list'] = 'Список';
$L['marketprofilter_tab_add']  = 'Добавить';
$L['marketprofilter_tab_edit'] = 'Редактировать';
$L['marketprofilter_filter']   = 'Фильтр';
$L['marketprofilter_all_categories'] = 'Все категории';
$L['marketprofilter_uncategorized']  = 'Без категории';
// ==== admin tpl ===
$L['marketprofilter_param_superadmin'] = 'Admin only';
$L['marketprofilter_param_superadmin_hint'] = 'If checked, this parameter will be visible and available for filtering only to users with administrator rights (group 5).';
$L['marketprofilter_param_helpinfo'] = 'Hint / Explanation';
$L['marketprofilter_param_helpinfo_hint'] = 'A short explanatory text that will be shown next to the parameter in the filter form.';
$L['marketprofilter_param_superadmin_short'] = '🔒 Admin';
$L['marketprofilter_param_helpinfo_short'] = 'Hint';
$L['marketprofilter_foldall'] = 'foldall';
$L['marketprofilter_unfoldall'] = 'unfold';
$L['marketprofilter_select_param_value_not_selected'] = 'Not selected';

// ADMIN PANEL. STRINGS FOR MULTILINGUAL SUPPORT
$L['marketprofilter_i18n_title_ru'] = 'Parameter name (RU)';
$L['marketprofilter_i18n_title_en'] = 'Parameter name (EN)';
$L['marketprofilter_i18n_title_ua'] = 'Parameter name (UA)';
$L['marketprofilter_i18n_values_ru'] = 'Value translation (RU)';
$L['marketprofilter_i18n_values_en'] = 'Value translation (EN)';
$L['marketprofilter_i18n_values_ua'] = 'Value translation (UA)';

$L['marketprofilter_adminTitle'] = 'Market PRO Filter Plugin for Cotonti CMF';
$L['marketprofilter_adminHelp'] = 'Detailed guide to filling in filter parameter fields:
<ul>
<li><b>Parameter code</b> — a unique system identifier for the parameter. Use only Latin letters, numbers, and underscores without spaces. For example: <i>power</i>, <i>battery_capacity</i>. This code will be used in the database and in the code, so there must be no duplicates.</li>
<li><b>Parameter name</b> — a readable name that users will see in the site interface. For example: <i>Power</i>, <i>Battery capacity</i>.</li>
<li><b>Parameter type</b> — select the value type:
    <ul>
        <li><i>Range</i> — for numeric parameters with a minimum and maximum value, e.g., price, weight;</li>
        <li><i>Dropdown list</i> — for selecting one option from a list of fixed values;</li>
        <li><i>Checkboxes</i> — for selecting one or more options from a list.</li>
    </ul>
</li>
<li><b>Parameter values (JSON)</b> — this field specifies the allowed values for the parameter in JSON format:
    <ul>
        <li>For the <i>Range</i> type, provide an object with two properties <code>min</code> and <code>max</code>, e.g.: <code>{"min":0,"max":100}</code>. Values must be numbers, and <code>min</code> must be less than or equal to <code>max</code>.</li>
        <li>For <i>Dropdown list</i> and <i>Checkboxes</i>, provide an array of strings with the possible options, e.g.: <code>["Red","Green","Blue"]</code>. Each element of the array is a separate value.</li>
    </ul>
    <p><b>Important:</b> The JSON must be strictly valid:
        <ul>
            <li>Use double quotes for keys and string values;</li>
            <li>Do not add extra commas after the last element;</li>
            <li>The structure must exactly match the examples above.</li>
        </ul>
        To validate JSON, use online validators such as <a href="https://jsonlint.com" target="_blank" rel="noopener noreferrer">jsonlint.com</a>. Invalid JSON will cause errors when saving or during filter operation.</p>
</li>
<li><b>Active</b> — a toggle to enable or disable the filter parameter on the site. If inactive, it will not be displayed to users.</li>
</ul>';

// FRONTEND. Public site part
$L['marketprofilter_found_items'] = 'Found {COUNT} items';
$L['marketprofilter_no_items'] = 'No items found matching the specified parameters';
$L['marketprofilter_market_paramsItem_desc'] = 'and its characteristics, parameter names and values in the product filter, for searching on the site within its main category.';
$L['marketprofilter_market_list_help'] = '<strong>Strict match filter for parameter combinations.</strong>
<ul>
<li><strong>Do not select too many parameters at once.</strong></li>
<li>If many parameters are set at once, there may simply be no product that exactly and simultaneously matches all selected parameters.</li>
<li><strong>Recommended approach:</strong>
    <ul>
        <li>Select one <code>main parameter for you</code></li>
        <li>apply the filter and review the results</li>
        <li>then add the <code>next parameter</code> and filter again.</li>
        <li>If needed, use the <i><strong>Reset filter</strong></i> button and start over.</li>
    </ul>
</li>
</ul>';
$L['marketprofilter_market_list_exist_param_title'] = 'Product has properties and parameters for filter search';
