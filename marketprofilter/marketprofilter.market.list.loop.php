<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.list.loop
 * Tags=market.list.tpl:{LIST_ROW_FILTER_PARAMS_HTML}
 * [END_COT_EXT]
 */

/**
 * Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.market.list.loop.php
 * Purpose: выводим значения и параметры в карточку товара в списках в шаблоне market.list.tpl
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


 
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('marketprofilter', 'plug');

global $L, $db, $db_x;

$filter_params_html = '';
$has_filter_params = false;  // Объявляем флаг наличия у товара в списке заполненных параметров фильтра
if (!empty($item['fieldmrkt_id'])) {

    $db_params        = $db_x . 'marketprofilter_params';
    $db_params_values = $db_x . 'marketprofilter_params_values';

    $fieldmrkt_id = (int)$item['fieldmrkt_id'];

    // Получаем активные параметры
    $params = $db->query("
        SELECT p.param_id, p.param_name, p.param_type, p.param_values
        FROM $db_params p
        WHERE p.param_active = 1
        ORDER BY p.param_id ASC
    ")->fetchAll();

    if (!empty($params)) {

        // Получаем значения для товара (простой query — без prepare)
        $values_res = $db->query("
            SELECT param_id, param_value
            FROM $db_params_values
            WHERE fieldmrkt_id = ?
        ", [$fieldmrkt_id]);

        $saved_values = [];
        while ($row = $values_res->fetch()) {
            $saved_values[$row['param_id']][] = $row['param_value'];
        }

        $filter_params_html .= '<div class="market-filter-params">';

        foreach ($params as $param) {
            $param_id   = (int)$param['param_id'];
            $param_name = $param['param_name'];
            $param_type = $param['param_type'];

            // Переведённый заголовок
            $title = marketprofilter_get_title($param_id, Cot::$usr['lang'] ?? 'ru');

            $values = $saved_values[$param_id] ?? [];

            $formatted = marketprofilter_format_param_value($param_type, $values, $param_name);

            if ($formatted !== '') {
			    $has_filter_params = true; // Устанавливаем флаг, если есть хотя бы один заполненный параметр
                $filter_params_html .= '
                    <div class="row mb-1">
                        <div class="col-5 fw-bold">' . htmlspecialchars($title) . '</div>
                        <div class="col-7">' . htmlspecialchars($formatted) . '</div>
                    </div>';
            }
        }

        $filter_params_html .= '</div>';
    }
}

$t->assign('LIST_ROW_FILTER_PARAMS_HTML', $filter_params_html);
$t->assign('LIST_ROW_FILTER_PARAMS_EXIST', $has_filter_params);