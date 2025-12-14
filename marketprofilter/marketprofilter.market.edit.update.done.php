<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.edit.update.done
[END_COT_EXT]
==================== */
// файл marketprofilter.market.edit.update.done.php
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('market', 'module');
require_once cot_incfile('marketprofilter', 'plug');
// Tables and extras
Cot::$db->registerTable('marketprofilter_params');
Cot::$db->registerTable('marketprofilter_params_values');
global $db, $db_x;

$db_marketprofilter_params = $db_x . 'marketprofilter_params';
$db_marketprofilter_params_values = $db_x . 'marketprofilter_params_values';

$fieldmrkt_id = (int)cot_import('id', 'G', 'INT');
if (!$fieldmrkt_id && !empty($r['fieldmrkt_id'])) {
    $fieldmrkt_id = (int)$r['fieldmrkt_id'];
}
if (!$fieldmrkt_id && !empty($item['fieldmrkt_id'])) {
    $fieldmrkt_id = (int)$item['fieldmrkt_id'];
}

function flatten_checkbox_values($values) {
    $flat = [];
    foreach ($values as $v) {
        if (is_array($v)) {
            $flat = array_merge($flat, flatten_checkbox_values($v));
        } else {
            if ($v !== 'nullval' && $v !== '' && $v !== null) {
                $flat[] = $v;
            }
        }
    }
    return $flat;
}

marketprofilter_log('Начало сохранения параметров. fieldmrkt_id=' . $fieldmrkt_id);
marketprofilter_log('POST marketprofilter=' . print_r($_POST['marketprofilter'], true));

if ($fieldmrkt_id > 0 && isset($_POST['marketprofilter']) && is_array($_POST['marketprofilter'])) {
    $db->delete($db_marketprofilter_params_values, "fieldmrkt_id = ?", [$fieldmrkt_id]);
    marketprofilter_log("Удалены старые параметры для fieldmrkt_id=$fieldmrkt_id");

    $params = $db->query("SELECT param_id, param_name, param_type, param_values FROM $db_marketprofilter_params WHERE param_active = 1")->fetchAll();
    marketprofilter_log("Получено " . count($params) . " активных параметров");

    foreach ($params as $param) {
        $param_id = (int)$param['param_id'];
        $param_name = $param['param_name'];
        $param_type = $param['param_type'];
        $param_values_raw = $param['param_values'];

        if (!isset($_POST['marketprofilter'][$param_name]) || empty($_POST['marketprofilter'][$param_name])) {
            marketprofilter_log("Пропущен параметр $param_name (нет в POST)");
            continue;
        }

        $param_value = $_POST['marketprofilter'][$param_name];
        marketprofilter_log("Обработка $param_name ($param_type) = " . print_r($param_value, true));

        if ($param_type === 'range') {
            $min = isset($param_value['min']) && $param_value['min'] !== '' ? (int)$param_value['min'] : null;
            $max = isset($param_value['max']) && $param_value['max'] !== '' ? (int)$param_value['max'] : null;
            if (($min !== null && $min >= 0) || ($max !== null && $max >= 0)) {
                $range_val = ($min !== null ? $min : '') . '-' . ($max !== null ? $max : '');
                $db->insert($db_marketprofilter_params_values, [
                    'fieldmrkt_id' => $fieldmrkt_id,
                    'param_id' => $param_id,
                    'param_value' => $range_val
                ]);
                marketprofilter_log("Сохранён range $param_name: $range_val");
            } else {
                marketprofilter_log("Неверный диапазон для $param_name: min=$min max=$max");
            }
        } 
elseif ($param_type === 'checkbox') {
    if (is_array($param_value)) {
        $valid_values = json_decode($param_values_raw, true);
        if (!is_array($valid_values)) $valid_values = [];

        $flat_values = flatten_checkbox_values($param_value);
        $filtered_values = array_filter($flat_values, fn($v) => is_scalar($v) && in_array($v, $valid_values));

        foreach ($filtered_values as $value) {
            $db->insert($db_marketprofilter_params_values, [
                'fieldmrkt_id' => $fieldmrkt_id,
                'param_id' => $param_id,
                'param_value' => (string)$value
            ], true); // true = ON DUPLICATE KEY UPDATE
            marketprofilter_log("Сохранён checkbox $param_name: $value");
        }
    } else {
        marketprofilter_log("Ожидался массив для checkbox $param_name");
    }
}


		
		/* elseif ($param_type === 'checkbox') {
            if (is_array($param_value)) {
                $valid_values = json_decode($param_values_raw, true);
                if (!is_array($valid_values)) {
                    $valid_values = [];
                }
                $flat_values = flatten_checkbox_values($param_value);
                foreach ($flat_values as $value) {
                    if (is_scalar($value) && in_array($value, $valid_values)) {
                        $db->insert($db_marketprofilter_params_values, [
                            'fieldmrkt_id' => $fieldmrkt_id,
                            'param_id' => $param_id,
                            'param_value' => (string)$value
                        ]);
                        marketprofilter_log("Сохранён checkbox $param_name: $value");
                    } else {
                        marketprofilter_log("Пропущен checkbox $param_name: $value");
                    }
                }
            } else {
                marketprofilter_log("Ожидался массив для checkbox $param_name");
            }
        } */ elseif ($param_type === 'select') {
            if (is_scalar($param_value) && !empty($param_value)) {
                $valid_values = json_decode($param_values_raw, true);
                if (!is_array($valid_values)) {
                    $valid_values = [];
                }
                if (in_array($param_value, $valid_values)) {
                    $db->insert($db_marketprofilter_params_values, [
                        'fieldmrkt_id' => $fieldmrkt_id,
                        'param_id' => $param_id,
                        'param_value' => (string)$param_value
                    ]);
                    marketprofilter_log("Сохранён select $param_name: $param_value");
                } else {
                    marketprofilter_log("Недопустимое значение select $param_name: $param_value");
                }
            } else {
                marketprofilter_log("Ожидалось скалярное значение для select $param_name");
            }
        } elseif ($param_type === 'radio') {
            if (is_scalar($param_value) && !empty($param_value)) {
                $valid_values = json_decode($param_values_raw, true);
                if (!is_array($valid_values)) {
                    $valid_values = [];
                }
                if (in_array($param_value, $valid_values)) {
                    $db->insert($db_marketprofilter_params_values, [
                        'fieldmrkt_id' => $fieldmrkt_id,
                        'param_id' => $param_id,
                        'param_value' => (string)$param_value
                    ]);
                    marketprofilter_log("Сохранён radio $param_name: $param_value");
                } else {
                    marketprofilter_log("Недопустимое значение radio $param_name: $param_value");
                }
            } else {
                marketprofilter_log("Ожидалось скалярное значение для radio $param_name");
            }
        } else {
            marketprofilter_log("Неизвестный тип параметра $param_name: $param_type");
        }
    }
} else {
    marketprofilter_log('fieldmrkt_id <= 0 или marketprofilter не передан');
}
?>

