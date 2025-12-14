<?php
/* ====================
[BEGIN_COT_EXT]
Code=marketprofilter
Name=Market PRO Filter
Description=Dynamic filter parameters for Market PRO module
Version=2.2.1
Date=2025-12-14
Author=webitproff
Copyright=(c) webitproff <a href="https://github.com/webitproff?tab=repositories" target="_blank" rel="noopener noreferrer"><strong>See on GitHub</strong></a>
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
marketprofilter_log_enable=01:radio::0:Использовать функцию логирования 
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');

/**
 * Market PRO Filter plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.admin.php
 * Purpose: Registers metadata of the marketprofilter plugin in the DB Cotonti.
 * Date=2025-12-14
 * @package marketprofilter
 * @version 2.2.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 https://github.com/webitproff/
 * @license BSD
 */
