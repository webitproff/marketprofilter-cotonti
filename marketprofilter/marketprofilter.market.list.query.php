<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.list.query
 * [END_COT_EXT]
 */
// marketprofilter.market.list.query.php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('marketprofilter', 'plug');

global $db, $db_x, $db_market, $join_condition, $where, $sql_item_count, $sql_item_string, $orderby, $d, $maxItemRowsPerPage, $join_columns, $list_url_path, $L, $c;

$db_params = $db_x . 'marketprofilter_params';
$db_params_values = $db_x . 'marketprofilter_params_values';

marketprofilter_log("marketprofilter.market.list.query.php started");

// 1. ДОБАВЛЯЕМ FILTER_* В ПАГИНАЦИЮ (КРИТИЧНО!)
foreach ($_GET as $key => $value) {
    if (strpos($key, 'filter_') === 0 && $value !== '' && $value !== null) {
        $list_url_path[$key] = $value;
    }
}

// Текущая категория
$current_cat = (isset($c) && is_string($c)) ? trim($c) : '';

// Загружаем активные параметры
$cat_cond = $current_cat !== '' 
    ? "(param_category = " . $db->quote($current_cat) . " OR param_category = '')" 
    : "param_category = ''";

$filter_params = $db->query("
    SELECT param_id, param_name, param_type
    FROM $db_params
    WHERE param_active = 1 AND $cat_cond
    ORDER BY param_id ASC
")->fetchAll();

if (empty($filter_params)) {
    marketprofilter_log("No active params");
    // Важно: очищаем сообщение, если параметров нет
    $L['marketprofilter_message'] = '';
    $L['marketprofilter_message_class'] = '';
    return;
}

$additional_joins = '';
$additional_where = [];
$filter_index = 0;

foreach ($filter_params as $param) {
    $param_id   = (int)$param['param_id'];
    $param_name = $param['param_name'];
    $param_type = $param['param_type'];
    $get_key    = "filter_$param_name";

    if (!isset($_GET[$get_key]) || $_GET[$get_key] === '') continue;

    $value = $_GET[$get_key];
    $alias = "fpv$filter_index";

    $additional_joins .= " INNER JOIN $db_params_values AS $alias ON $alias.fieldmrkt_id = p.fieldmrkt_id AND $alias.param_id = $param_id";

    if ($param_type === 'range') {
        $val = trim($value);
        if (strpos($val, '-') !== false) {
            [$min, $max] = array_map('floatval', explode('-', $val));
        } else {
            $max = floatval($val);
            $min = 0;
        }
        if ($max <= 0) continue;

        $additional_where[] = "CAST(SUBSTRING_INDEX($alias.param_value, '-', 1) AS DECIMAL(12,2)) >= $min 
                               AND CAST(SUBSTRING_INDEX($alias.param_value, '-', -1) AS DECIMAL(12,2)) <= $max";
        marketprofilter_log("Range: $param_name $min-$max");

    } elseif ($param_type === 'checkbox') {
        if (!is_array($value)) $value = [$value];
        $value = array_filter($value);
        if (empty($value)) continue;
        $escaped = implode(',', array_map([$db, 'quote'], $value));
        $additional_where[] = "$alias.param_value IN ($escaped)";
        marketprofilter_log("Checkbox: $param_name = " . implode(',', $value));

    } else { // select/radio
        $value = trim($value);
        if ($value === '') continue;
        $escaped = $db->quote($value);
        $additional_where[] = "$alias.param_value = $escaped";
        marketprofilter_log("Select/Radio: $param_name = $value");
    }

    $filter_index++;
}

// КЛЮЧЕВОЕ ИСПРАВЛЕНИЕ: выполняем только если есть активные фильтры
// И делаем это ТОЛЬКО ОДИН РАЗ, чтобы не перезаписывать много раз
if ($filter_index > 0) {
    $join_condition .= $additional_joins;

    foreach ($additional_where as $i => $cond) {
        $where["profilter_$i"] = $cond;
    }

    $where_sql = 'WHERE ' . implode(' AND ', $where);

    $sql_item_count = "SELECT COUNT(DISTINCT p.fieldmrkt_id)
                       FROM $db_market AS p
                       $join_condition
                       LEFT JOIN $db_users AS u ON u.user_id = p.fieldmrkt_ownerid
                       $where_sql";

    $sql_item_string = "SELECT p.*, u.* $join_columns
                        FROM $db_market AS p
                        $join_condition
                        LEFT JOIN $db_users AS u ON u.user_id = p.fieldmrkt_ownerid
                        $where_sql
                        GROUP BY p.fieldmrkt_id
                        ORDER BY $orderby
                        LIMIT $d, $maxItemRowsPerPage";

    // Считаем ТОЛЬКО ОДИН РАЗ!
    $total_filtered = (int)$db->query($sql_item_count)->fetchColumn();


/* if ($total_filtered > 0) {
    $L['marketprofilter_message'] = "Найдено $total_filtered позиций";
    $L['marketprofilter_message_class'] = 'alert-success';
} else {
    $L['marketprofilter_message'] = "Товаров не найдено";
    $L['marketprofilter_message_class'] = 'alert-warning';
} */
$total_filtered = (int)$db->query($sql_item_count)->fetchColumn();

if ($total_filtered > 0) {
    $L['marketprofilter_message'] = str_replace('{COUNT}', $total_filtered, $L['marketprofilter_found_items']);
    $L['marketprofilter_message_class'] = 'alert-success';
} else {
    $L['marketprofilter_message'] = $L['marketprofilter_no_items'];
    $L['marketprofilter_message_class'] = 'alert-warning';
}

marketprofilter_log("Applied filters. Found: $total_filtered");





} else {
    // Если фильтров нет — просто очищаем сообщение (чтобы не дублировалось)
    $L['marketprofilter_message'] = '';
    $L['marketprofilter_message_class'] = '';
}