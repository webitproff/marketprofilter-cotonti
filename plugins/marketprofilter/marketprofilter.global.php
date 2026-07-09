<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=global
 * [END_COT_EXT]
 */

/**
 * Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.5+, MySQL v.8.0+
 * Filename: marketprofilter.global.php
 * Purpose: создание и редактирование групп характеристик, а также значений для фильтра товаров.
 * Date=July 9Th, 2026
 *
 * ReadMeMore:              https://abuyfile.com/market/cotonti/plugs/market-pro-filter 
 * Support:                 https://abuyfile.com/forums/cotonti/custom/plugs/marketprofilter
 *
 * Plugin Market PRO Filter (Source code):  https://github.com/webitproff/marketprofilter-cotonti
 * Module Market PRO (Source code):         https://github.com/webitproff/marketpro-cotonti
 *
 * @package marketprofilter
 * @version 3.5.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 https://github.com/webitproff/
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

require_once cot_incfile('marketprofilter', 'plug');
require_once cot_langfile('marketprofilter', 'plug');
require_once cot_incfile('market', 'module');

