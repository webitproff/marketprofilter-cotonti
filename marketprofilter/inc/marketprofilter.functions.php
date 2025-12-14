<?php
/**
 * Market PRO Filter Plugin: Core Functions
 * Полная мультиязычность + правильная архитектура
 *
 * @package Market PRO Filter
 * @copyright (c) webitproff
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('marketprofilter', 'plug');
require_once cot_incfile('market', 'module');

// Регистрация таблиц
Cot::$db->registerTable('marketprofilter_params');
Cot::$db->registerTable('marketprofilter_params_values');
Cot::$db->registerTable('marketprofilter_i18n');
/**
 * Возвращает переведённый заголовок параметра
 */
function marketprofilter_get_title($param_id, $lang = null)
{
    global $db, $db_x;
    if (!$lang) $lang = Cot::$cfg['defaultlang'] ?? 'ru';
    if (strlen($lang) > 2) $lang = substr($lang, 0, 2);

    static $cache = [];
    $cache_key = "$param_id|$lang";
    if (isset($cache[$cache_key])) return $cache[$cache_key];

    $sql = "SELECT i18n_title FROM {$db_x}marketprofilter_i18n 
            WHERE i18n_param_id = ? AND i18n_locale = ? LIMIT 1";
    $res = $db->query($sql, [$param_id, $lang])->fetchColumn();
    $title = $res ?: "Param #$param_id";

    $cache[$cache_key] = $title;
    return $title;
}

/**
 * Возвращает переведённое значение по ключу
 */
function marketprofilter_get_value($param_id, $key, $lang = null)
{
    global $db, $db_x;
    if (!$lang) $lang = Cot::$cfg['defaultlang'] ?? 'ru';
    if (strlen($lang) > 2) $lang = substr($lang, 0, 2);

    static $cache = [];
    $cache_key = "$param_id|$lang";
    if (!isset($cache[$cache_key])) {
        $sql = "SELECT i18n_values FROM {$db_x}marketprofilter_i18n 
                WHERE i18n_param_id = ? AND i18n_locale = ? LIMIT 1";
        $json = $db->query($sql, [$param_id, $lang])->fetchColumn();
        $cache[$cache_key] = $json ? json_decode($json, true) : [];
    }

    $translations = $cache[$cache_key];
    return $translations[$key] ?? $key;
}

/**
 * Форматирует значение параметра с учётом перевода
 * Добавлен параметр $lang для работы без авторизации
 */
function marketprofilter_format_param_value($param_type, $values, $param_name = '', $param_id = 0, $lang = null)
{
    if (empty($values)) return '';

    // Определяем язык: сначала из параметра, потом из пользователя, потом из конфига
    if (!$lang) {
        $lang = Cot::$usr['lang'] ?? (Cot::$cfg['lang'] ?? 'ru');
    }
    if (strlen($lang) > 2) $lang = substr($lang, 0, 2);

    if ($param_type === 'range') {
        if (!empty($values[0]) && strpos($values[0], '-') !== false) {
            [$min, $max] = explode('-', $values[0]);
            return trim("$min — $max");
        }
        return '';
    }

    if ($param_type === 'checkbox') {
        $out = [];
        foreach ((array)$values as $key) {
            $out[] = marketprofilter_get_value($param_id, $key, $lang);
        }
        return implode(', ', $out);
    }

    // select / radio
    $key = $values[0] ?? '';
    return $key !== '' ? marketprofilter_get_value($param_id, $key, $lang) : '';
}



function marketprofilter_form_fields(array $values): string
{
    global $L;

    $types = [
        'range'    => $L['marketprofilter_range'],
        'select'   => $L['marketprofilter_select'],
        'checkbox' => $L['marketprofilter_checkbox'],
        'radio'    => $L['marketprofilter_radio'],
    ];

    $html = '';

    // param_name
    $html .= '<div class="mb-3">';
    $html .= '<label for="param_name" class="form-label">' . $L['marketprofilter_param_name'] . '</label>';
    $html .= '<input type="text" name="param_name" id="param_name" class="form-control" value="' . htmlspecialchars($values['param_name'] ?? '') . '" required>';
    $html .= '</div>';

    // param_title
    $html .= '<div class="mb-3">';
    $html .= '<label for="param_title" class="form-label">' . $L['marketprofilter_param_title'] . '</label>';
    $html .= '<input type="text" name="param_title" id="param_title" class="form-control" value="' . htmlspecialchars($values['param_title'] ?? '') . '" required>';
    $html .= '</div>';

    // param_type
    $html .= '<div class="mb-3">';
    $html .= '<label for="param_type" class="form-label">' . $L['marketprofilter_param_type'] . '</label>';
    $html .= '<select name="param_type" id="param_type" class="form-select">';
    foreach ($types as $key => $label) {
        $selected = ($values['param_type'] ?? '') === $key ? ' selected' : '';
        $html .= "<option value=\"$key\"$selected>$label</option>";
    }
    $html .= '</select>';
    $html .= '</div>';

    // param_category — выпадающий список категорий Market
    $html .= '<div class="mb-3">';
    $html .= '<label for="param_category" class="form-label">' . $L['marketprofilter_param_category'] . '</label>';
    $html .= cot_selectbox_structure(
        'market',
        $values['param_category'] ?? '',
        'param_category',
        '',
        true,
        true,
        true,                           // разрешаем пустое значение (без категории)
        'class="form-select"'
    );
    $html .= '<div class="form-text">' . $L['marketprofilter_param_category_hint'] . '</div>';
    $html .= '</div>';

    // param_values
    $html .= '<div class="mb-3">';
    $html .= '<label for="param_values" class="form-label">' . $L['marketprofilter_param_values'] . '</label>';
    $html .= '<textarea name="param_values" id="param_values" class="form-control" rows="4" required>' . htmlspecialchars($values['param_values'] ?? '') . '</textarea>';
    $html .= '<div class="form-text">' . $L['marketprofilter_param_values_hint'] . '</div>';
    $html .= '</div>';

    // param_active
    $checked = !empty($values['param_active']) ? ' checked' : '';
    $html .= '<div class="form-check mb-3">';
    $html .= '<input type="checkbox" name="param_active" id="param_active" class="form-check-input" value="1"' . $checked . '>';
    $html .= '<label for="param_active" class="form-check-label">' . $L['marketprofilter_param_active'] . '</label>';
    $html .= '</div>';

    return $html;
}




/**
 * Загрузка параметров из БД
 */
function marketprofilter_load_item_params($fieldmrkt_id)
{
    global $db, $db_x;

    $db_marketprofilter_params = $db_x . 'marketprofilter_params';
    $db_marketprofilter_params_values = $db_x . 'marketprofilter_params_values';

    $sql = $db->query("SELECT v.param_id, p.param_name, p.param_type, v.param_value, p.param_values
        FROM $db_marketprofilter_params_values v
        INNER JOIN $db_marketprofilter_params p ON p.param_id = v.param_id
        WHERE v.fieldmrkt_id = ?", [$fieldmrkt_id]);

    $result = [];

    foreach ($sql->fetchAll() as $row) {
        $name = $row['param_name'];
        $type = $row['param_type'];
        $val = $row['param_value'];

        if ($type === 'checkbox') {
            $result[$name][] = $val;
        } elseif ($type === 'range') {
            [$min, $max] = explode('-', $val);
            $result[$name]['min'] = (int)$min;
            $result[$name]['max'] = (int)$max;
        } else {
            $result[$name] = $val;
        }
    }

    marketprofilter_log("Загружены параметры из БД для fieldmrkt_id=$fieldmrkt_id: " . print_r($result, true));
    return $result;
}

/**
 * Sanitizes price input to ensure valid float value
 *
 * @param string $price
 * @return float
 */
function cot_market_sanitize_price($price)
{
    $price = str_replace(',', '.', $price);
    return (float)preg_replace('/[^0-9.]/', '', $price);
}

/**
 * Gets max price from market items
 *
 * @return float
 */
function cot_market_filter_maxprice()
{
    global $db, $db_market;
    $max = $db->query("SELECT MAX(msitem_cost) FROM $db_market")->fetchColumn();
    return $max ? ceil($max) : 1000000;
}




/* 
logs/
├── marketprofilter.log                             ← текущий лог
├── marketprofilter_2025-12-07_15-30-45.log         ← архивированный лог
├── marketprofilter_2025-12-04_12-00-00.log
└── .last_archive_marketprofilter                   ← скрытый маркер (не трогаем) 
*/
function marketprofilter_log($message, $file = 'marketprofilter.log')
{
    global $cfg;

    // Пишем лог только если включено и значение строго '1'
    if (!isset($cfg['plugin']['marketprofilter']['marketprofilter_log_enable'])
        || $cfg['plugin']['marketprofilter']['marketprofilter_log_enable'] !== '1') {
        return;
    }

    $log_dir = $cfg['plugins_dir'] . '/marketprofilter/logs';
    if (!is_dir($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }

    $log_file = $log_dir . '/' . $file;

    // Маркер последней архивации
    $marker_file = $log_dir . '/.last_archive_' . pathinfo($file, PATHINFO_FILENAME);

    $archive_interval = 72 * 3600; // 72 часа = 3 суток

    // Проверяем, пора ли архивировать
    $need_archive = !is_file($marker_file) || (time() - filemtime($marker_file)) > $archive_interval;

    if ($need_archive && is_file($log_file) && filesize($log_file) > 0) {
        $archive_name = $log_dir . '/' . 
                        pathinfo($file, PATHINFO_FILENAME) . 
                        '_' . date('Y-m-d_H-i-s') . 
                        '.log';

        // Архивируем (просто копируем с новым именем)
        @copy($log_file, $archive_name);

        // Очищаем текущий лог
        @file_put_contents($log_file, "=== ЛОГ АРХИВИРОВАН И ОЧИЩЕН " . date('Y-m-d H:i:s') . " ===\n", LOCK_EX);

        // Обновляем маркер времени
        @file_put_contents($marker_file, time());
    }

    // Записываем новую строку в конец (быстро и надёжно)
    $datetime = date('Y-m-d H:i:s');
    $log_entry = "[$datetime] $message" . PHP_EOL;

    @file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}





