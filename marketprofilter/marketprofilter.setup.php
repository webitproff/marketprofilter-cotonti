<?php
/* ====================
[BEGIN_COT_EXT]
Code=marketprofilter
Name=Market PRO Filter
Description=Dynamic filter parameters for Market PRO module
Version=3.3.36
Date=May 11Th, 2026
Author=webitproff
Copyright=(c) webitproff <a href="https://github.com/webitproff?tab=repositories" target="_blank" rel="noopener noreferrer"><strong>See on GitHub</strong></a>
Notes=
Auth_guests=R
Lock_guests=W12345
Auth_members=R
Lock_members=W12345
Requires_modules=market
Requires_plugins=
Recommends_modules=
Recommends_plugins=
[END_COT_EXT]
[BEGIN_COT_EXT_CONFIG]
marketprofilter_defaultlang=01:select:ru,ua,en:en:Код языка по умолчанию для фильтра
marketprofilter_log_enable=11:radio::0:Использовать функцию логирования 
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');

/**
 * Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.setup.php
 * Purpose: Registers metadata of the marketprofilter plugin in the DB Cotonti.
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
