<?php
/**
 * Market PRO Filter Plugin: Core Functions
 * Plugin for CMF Cotonti v.1+, PHP v.8.5+, MySQL v.8.0+
 * Полная мультиязычность + правильная (работоспособная) архитектура
 * Filename: marketprofilter.functions.php
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
 

defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('marketprofilter', 'plug');
require_once cot_incfile('market', 'module');

// Регистрация таблиц
Cot::$db->registerTable('marketprofilter_params');
Cot::$db->registerTable('marketprofilter_params_values');
Cot::$db->registerTable('marketprofilter_i18n');

// Языки, поддерживаемые плагином (те, для которых есть переводы в админке)
$marketprofilter_supported_langs = ['ua', 'ru', 'en'];

// Язык по умолчанию для фильтра (из настроек плагина или из конфига сайта)
$marketprofilter_default_lang = Cot::$cfg['plugin']['marketprofilter']['marketprofilter_defaultlang'] 
    ?? Cot::$cfg['defaultlang'] 
    ?? 'ua';

/**
 * Определяет язык для вывода фильтра:
 * - если текущий язык пользователя есть среди поддерживаемых — используем его
 * - иначе используем язык по умолчанию (ua)
 */
function marketprofilter_get_lang()
{
    global $marketprofilter_supported_langs, $marketprofilter_default_lang;
    
    $user_lang = Cot::$usr['lang'] ?? Cot::$cfg['defaultlang'] ?? 'ua';
    if (strlen($user_lang) > 2) $user_lang = substr($user_lang, 0, 2);
    
    return in_array($user_lang, $marketprofilter_supported_langs) 
        ? $user_lang 
        : $marketprofilter_default_lang;
}

/**
 * Проверяет, является ли текущий пользователь администратором (группа 5)
 * Используется для фильтрации суперадминских параметров
 */
function marketprofilter_is_admin()
{
    global $db, $db_groups_users, $usr;
    
    static $is_admin = null;
    if ($is_admin !== null) return $is_admin;
    
    if (!Cot::$usr['id']) {
        $is_admin = false;
    } else {
        $sql = $db->query("SELECT 1 FROM $db_groups_users WHERE gru_userid = " . (int)Cot::$usr['id'] . " AND gru_groupid = 5 LIMIT 1");
        $is_admin = $sql->fetchColumn() > 0;
    }
    return $is_admin;
}


/**
 * Возвращает переведённый заголовок параметра.
 * Если язык пользователя не поддерживается — используется дефолтный язык.
 * Если перевода нет ни на одном языке — возвращается технический ключ.
 * Пустые строки не возвращаются.
 */
function marketprofilter_get_title($param_id, $lang = null)
{
    global $db, $db_x;
    // Если язык не передан — определяем через marketprofilter_get_lang()
    // Эта функция уже вернёт либо язык пользователя (если он ua/ru/en), либо дефолтный
    if (!$lang) $lang = marketprofilter_get_lang();

    static $cache = [];
    $cache_key = "$param_id|$lang";

    // Проверяем кеш — если уже загружали для этого параметра и языка, возвращаем сразу
    if (isset($cache[$cache_key])) return $cache[$cache_key];

    // Пытаемся получить перевод на текущем языке (язык пользователя или уже дефолтный)
    $sql = "SELECT i18n_title FROM {$db_x}marketprofilter_i18n 
            WHERE i18n_param_id = ? AND i18n_locale = ? LIMIT 1";
    $title = $db->query($sql, [$param_id, $lang])->fetchColumn();

    // Если перевод найден и не пустой — кешируем и возвращаем
    if (!empty($title)) {
        $cache[$cache_key] = $title;
        return $title;
    }

    // Если перевода нет — пробуем дефолтный язык
    global $marketprofilter_default_lang;
    if ($lang !== $marketprofilter_default_lang) {
        $sql = "SELECT i18n_title FROM {$db_x}marketprofilter_i18n 
                WHERE i18n_param_id = ? AND i18n_locale = ? LIMIT 1";
        $title = $db->query($sql, [$param_id, $marketprofilter_default_lang])->fetchColumn();

        // Если нашли на дефолтном — кешируем и возвращаем
        if (!empty($title)) {
            $cache[$cache_key] = $title;
            return $title;
        }
    }

    // Если нет нигде — возвращаем технический ключ (НЕ пустую строку)
    $cache[$cache_key] = "Param #$param_id";
    return $cache[$cache_key];
}

/**
 * Возвращает переведённое значение параметра по ключу.
 * Если язык пользователя не поддерживается — используется дефолтный язык.
 * Если перевода нет ни на одном языке — возвращается технический ключ.
 * Пустые строки не возвращаются.
 */
function marketprofilter_get_value($param_id, $key, $lang = null)
{
    global $db, $db_x;
    // Если язык не передан — определяем через marketprofilter_get_lang()
    if (!$lang) $lang = marketprofilter_get_lang();

    static $cache = [];
    $cache_key = "$param_id|$lang";

    // Загружаем все переводы для текущего языка, если ещё не загружены
    if (!isset($cache[$cache_key])) {
        $sql = "SELECT i18n_values FROM {$db_x}marketprofilter_i18n 
                WHERE i18n_param_id = ? AND i18n_locale = ? LIMIT 1";
        $json = $db->query($sql, [$param_id, $lang])->fetchColumn();
        // Декодируем JSON в массив. Если нет данных — пустой массив
        $cache[$cache_key] = $json ? json_decode($json, true) : [];
    }

    // Если перевод найден и не пустой — возвращаем
    if (!empty($cache[$cache_key][$key])) {
        return $cache[$cache_key][$key];
    }

    // Если перевода нет — пробуем дефолтный язык
    global $marketprofilter_default_lang;
    if ($lang !== $marketprofilter_default_lang) {
        $default_cache_key = "$param_id|$marketprofilter_default_lang";
        if (!isset($cache[$default_cache_key])) {
            $sql = "SELECT i18n_values FROM {$db_x}marketprofilter_i18n 
                    WHERE i18n_param_id = ? AND i18n_locale = ? LIMIT 1";
            $json = $db->query($sql, [$param_id, $marketprofilter_default_lang])->fetchColumn();
            $cache[$default_cache_key] = $json ? json_decode($json, true) : [];
        }

        // Если нашли на дефолтном — возвращаем
        if (!empty($cache[$default_cache_key][$key])) {
            return $cache[$default_cache_key][$key];
        }
    }

    // Если нет нигде — возвращаем технический ключ (НЕ пустую строку)
    return $key;
}

/**
 * Возвращает переведённую подсказку для параметра
 */
function marketprofilter_get_helpinfo($param_id, $lang = null)
{
    global $db, $db_x;
    if (!$lang) $lang = marketprofilter_get_lang();
    
    static $cache = [];
    $cache_key = "$param_id|$lang";
    if (isset($cache[$cache_key])) return $cache[$cache_key];
    
    $sql = "SELECT i18n_helpinfo FROM {$db_x}marketprofilter_i18n 
            WHERE i18n_param_id = ? AND i18n_locale = ? LIMIT 1";
    $help = $db->query($sql, [$param_id, $lang])->fetchColumn();
    if (!empty($help)) {
        $cache[$cache_key] = $help;
        return $help;
    }
    
    // fallback на дефолтный язык
    global $marketprofilter_default_lang;
    if ($lang !== $marketprofilter_default_lang) {
        $sql = "SELECT i18n_helpinfo FROM {$db_x}marketprofilter_i18n 
                WHERE i18n_param_id = ? AND i18n_locale = ? LIMIT 1";
        $help = $db->query($sql, [$param_id, $marketprofilter_default_lang])->fetchColumn();
        if (!empty($help)) {
            $cache[$cache_key] = $help;
            return $help;
        }
    }
    
    // иначе берём из основной таблицы
    $sql = "SELECT param_helpinfo FROM {$db_x}marketprofilter_params WHERE param_id = ? LIMIT 1";
    $help = $db->query($sql, [$param_id])->fetchColumn();
    $cache[$cache_key] = $help ?: '';
    return $cache[$cache_key];
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
        //$lang = Cot::$usr['lang'] ?? (Cot::$cfg['lang'] ?? 'ru');
		$lang = marketprofilter_get_lang();
    }
    if (strlen($lang) > 2) $lang = substr($lang, 0, 2);

/*     if ($param_type === 'range') {
        if (!empty($values[0]) && strpos($values[0], '-') !== false) {
            [$min, $max] = explode('-', $values[0]);
            return trim("$min — $max");
        }
        return '';
    } */
	if ($param_type === 'range') {
		// Возвращаем сохранённое число
		return isset($values[0]) ? $values[0] : '';
	}
	if ($param_type === 'checkbox') {
		$out = [];
		foreach ((array)$values as $key) {
			$display = marketprofilter_get_value($param_id, $key, $lang);
			$display = htmlspecialchars($display);
			$out[] = $display;
		}
		// ОДИН элемент → простая строка (как раньше)
		if (count($out) === 1) {
			return $out[0];
		}
		// НЕСКОЛЬКО элементов → HTML-список с точкой с запятой
		$listItems = '';
		$lastIdx = count($out) - 1;
		foreach ($out as $i => $item) {
			$suffix = ($i < $lastIdx) ? '; ' : '';
			$listItems .= '<li>' . $item . $suffix . '</li>';
		}
		return '<ul>' . $listItems . '</ul>';
	}
/*     if ($param_type === 'checkbox') {
        $out = [];
        foreach ((array)$values as $key) {
            $out[] = marketprofilter_get_value($param_id, $key, $lang);
        }
        return implode(', ', $out);
    } */
/* 	if ($param_type === 'checkbox') {
		$out = [];
		foreach ((array)$values as $key) {
			// Получаем переведённое название
			$display = marketprofilter_get_value($param_id, $key, $lang);
			// Экранируем от XSS (это текст внутри <li>)
			$display = htmlspecialchars($display);
			$out[] = $display;
		}
		// Формируем список: каждый пункт с точкой с запятой, кроме последнего
		$listItems = '';
		$lastIdx = count($out) - 1;
		foreach ($out as $i => $item) {
			$suffix = ($i < $lastIdx) ? ';' : '';   // точка с запятой кроме последнего
			$listItems .= '<li>' . $item . $suffix . '</li>';
		}
		return '<ul>' . $listItems . '</ul>';
	} */
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
    // param_superadmin
    $checked_superadmin = !empty($values['param_superadmin']) ? ' checked' : '';
    $html .= '<div class="form-check mb-3">';
    $html .= '<input type="checkbox" name="param_superadmin" id="param_superadmin" class="form-check-input" value="1"' . $checked_superadmin . '>';
    $html .= '<label for="param_superadmin" class="form-check-label">' . $L['marketprofilter_param_superadmin'] . '</label>';
    $html .= '<div class="form-text">' . $L['marketprofilter_param_superadmin_hint'] . '</div>';
    $html .= '</div>';

    // param_helpinfo
    $help_value = htmlspecialchars($values['param_helpinfo'] ?? '');
    $html .= '<div class="mb-3">';
    $html .= '<label for="param_helpinfo" class="form-label">' . $L['marketprofilter_param_helpinfo'] . '</label>';
    $html .= '<textarea name="param_helpinfo" id="param_helpinfo" class="form-control" rows="2">' . $help_value . '</textarea>';
    $html .= '<div class="form-text">' . $L['marketprofilter_param_helpinfo_hint'] . '</div>';
    $html .= '</div>';
    // param_hidelistitem
    $checked_hidelist = !empty($values['param_hidelistitem']) ? ' checked' : '';
    $html .= '<div class="form-check mb-3">';
    $html .= '<input type="checkbox" name="param_hidelistitem" id="param_hidelistitem" class="form-check-input" value="1"' . $checked_hidelist . '>';
    $html .= '<label for="param_hidelistitem" class="form-check-label">' . ($L['marketprofilter_param_hidelistitem'] ?? 'Свернуть список') . '</label>';
    $html .= '<div class="form-text">' . ($L['marketprofilter_param_hidelistitem_hint'] ?? 'Список опций будет скрыт под спойлер') . '</div>';
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
/*         } elseif ($type === 'range') {
            [$min, $max] = explode('-', $val);
            $result[$name]['min'] = (int)$min;
            $result[$name]['max'] = (int)$max; */
		} elseif ($type === 'range') {
			$result[$name] = (int)$val;
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

/**
 * Возвращает путь к директории кеша плагина, создаёт при необходимости
 * @return string Путь к директории
 */
function marketprofilter_cache_dir() {
    global $cfg;                                                // получаем основной конфиг Cotonti
    $dir = $cfg['cache_dir'] . '/marketprofilter';             // директория внутри системного кеша
    if (!is_dir($dir)) {                                       // если такой директории нет
        mkdir($dir, 0755, true);                               // создаём рекурсивно с правами
    }
    return $dir;                                               // возвращаем путь
}

/**
 * Читает данные из файлового кеша
 * @param string $key  Уникальный ключ
 * @param int    $ttl  Время жизни в секундах (по умолчанию 300)
 * @return mixed|null  Данные или null, если кеш отсутствует/просрочен
 */
function marketprofilter_cache_get($key, $ttl = 300) {
    $file = marketprofilter_cache_dir() . '/' . md5($key) . '.cache'; // полный путь к файлу кеша на основе хеша ключа
    if (file_exists($file) && (filemtime($file) + $ttl) > time()) {   // если файл есть и не просрочен
        return json_decode(file_get_contents($file), true);            // читаем JSON и раскодируем в массив
    }
    return null;                                             // иначе возвращаем null (кеш недействителен)
}

/**
 * Сохраняет данные в файловый кеш
 * @param string $key   Уникальный ключ
 * @param mixed  $data  Данные для сохранения (сериализуется в JSON)
 */
function marketprofilter_cache_set($key, $data) {
    $file = marketprofilter_cache_dir() . '/' . md5($key) . '.cache'; // формируем имя файла
    file_put_contents($file, json_encode($data), LOCK_EX);            // атомарно пишем JSON в файл
}

/**
 * Полностью очищает файловый кеш плагина
 */
function marketprofilter_cache_clear() {
    $dir = marketprofilter_cache_dir();                      // получаем директорию кеша
    $files = glob($dir . '/*.cache');                        // ищем все .cache файлы в ней
    foreach ($files as $file) {                              // обходим каждый
        unlink($file);                                       // удаляем
    }
}
/**
 * Зависимый (фасетный) подсчёт количества товаров для каждого значения параметра
 * с учётом других активных фильтров и выбранных значений самого параметра.
 * Использует файловый кеш.
 *
 * @param int    $param_id     ID параметра
 * @param string $current_cat  Код категории (или '' если без)
 * @return array  Ассоциативный массив [значение => количество товаров]
 */
function marketprofilter_get_faceted_counts($param_id, $current_cat = '') {
    global $db, $db_x;                                           // объекты БД

    // --- Кеш ---
    $get_sorted = $_GET;                                         // берём все GET-параметры
    ksort($get_sorted);                                          // сортируем для одинакового ключа при любом порядке
    $cache_key = "faceted|$param_id|$current_cat|" . http_build_query($get_sorted); // уникальный строковый ключ
    $cached = marketprofilter_cache_get($cache_key, 300);        // пробуем прочитать кеш (TTL 5 минут)
    if ($cached !== null) {                                      // если кеш есть и свеж
        return $cached;                                          // сразу возвращаем его
    }
    // --- конец кеша ---

    $table_params = $db_x . 'marketprofilter_params';            // имя таблицы параметров
    $table_values = $db_x . 'marketprofilter_params_values';     // имя таблицы значений
    $table_market = $db_x . 'market';                            // имя таблицы товаров

    // Получаем данные текущего параметра
    $param = $db->query("SELECT param_type, param_name, param_values FROM $table_params WHERE param_id = ?", [$param_id])->fetch();
    if (!$param) return [];                                      // если не найден — пустой массив
    $values_raw = json_decode($param['param_values'], true);     // декодируем JSON-список значений
    if (!is_array($values_raw)) return [];                       // если не массив — выход
    $param_type = $param['param_type'];                          // тип параметра (select/checkbox/radio/range)
    $param_name = $param['param_name'];                          // системное имя параметра

    // Собираем уже выбранные значения этого же параметра (для учёта внутри одной группы)
    $self_selected = [];                                         // здесь будут значения, применённые к текущему параметру
    $self_key = "filter_{$param_name}";                          // имя GET-параметра для текущего фильтра
    if (isset($_GET[$self_key]) && $_GET[$self_key] !== '') {    // если фильтр этого параметра задан
        $self_val = $_GET[$self_key];                            // получаем значение
        if ($param_type === 'checkbox') {                        // для чекбоксов это может быть массив
            $self_selected = is_array($self_val) ? array_filter($self_val) : [$self_val]; // превращаем в массив и чистим
        } elseif ($param_type === 'radio' || $param_type === 'select') { // для одиночного выбора
            $self_selected = [trim($self_val)];                  // берём одно значение
        }
        $self_selected = array_values($self_selected);           // переиндексируем массив
    }

    /*
    // FIX для 'range' - пока не применяли! Посмотрим как себя поведет текущий код выше.
    if (isset($_GET[$self_key]) && $_GET[$self_key] !== '') {
        if ($param_type !== 'range') {   // <-- исключаем range
            $self_val = $_GET[$self_key];
            if ($param_type === 'checkbox') {
                $self_selected = is_array($self_val) ? array_filter($self_val) : [$self_val];
            } elseif ($param_type === 'radio' || $param_type === 'select') {
                $self_selected = [trim($self_val)];
            }
            $self_selected = array_values($self_selected);
        }
    }
    */

    // Остальные активные фильтры (кроме текущего)
    $all_params = $db->query("SELECT param_id, param_name, param_type FROM $table_params WHERE param_active = 1")->fetchAll(); // все активные параметры
    $active_filters = [];                                        // контейнер для реально использованных фильтров
    foreach ($all_params as $p) {                                // перебираем каждый параметр
        if ($p['param_id'] == $param_id) continue;               // текущий параметр пропускаем
        $key = "filter_{$p['param_name']}";                      // ключ в $_GET
        $val = $_GET[$key] ?? null;                              // безопасно читаем (null если нет)
        if ($val === null || $val === '') continue;              // нет или пусто — не фильтруем
        if ($p['param_type'] === 'checkbox') {                   // если тип — чекбокс
            if (!is_array($val)) $val = [$val];                  // делаем массив
            $val = array_filter($val);                           // убираем пустые
            if (!$val) continue;                                 // если после очистки ничего — пропускаем
        } elseif ($p['param_type'] === 'range') {                // если диапазон
            $val = trim($val);                                   // обрезаем пробелы
            if ($val === '') continue;                           // пусто — мимо
        } else {                                                 // select или radio
            $val = trim($val);                                   // обрезаем
            if ($val === '') continue;                           // пусто — мимо
        }
        $active_filters[] = ['param_id' => $p['param_id'], 'type' => $p['param_type'], 'value' => $val]; // сохраняем активный фильтр
    }

    // Строим JOIN и WHERE для других фильтров
    $joins = '';                                                 // строка с JOIN'ами
    $where = [];                                                 // массив условий WHERE
    $i = 0;                                                      // счётчик для алиасов таблиц

    // Добавляем ограничение по категории, если она задана
    if ($current_cat !== '') {
        $cat_id = (int)$db->query("SELECT structure_id FROM {$db->structure} WHERE structure_code = " . $db->quote($current_cat) . " AND structure_area = 'market'")->fetchColumn();
        if ($cat_id > 0) {
            if (cot_plugin_active('multicatmarket')) {
                // Если активен плагин мультикатегорий, фильтруем по дополнительной таблице связей
                $db->registerTable('market_multicats');
                $db_multicats = $db->market_multicats ?: $db_x . 'market_multicats';
                $where[] = "m.fieldmrkt_id IN (SELECT pcat_page_id FROM $db_multicats WHERE pcat_cat_id = {$cat_id})";
            } else {
                // Стандартное дерево категорий с учётом подкатегорий
                $catsub = cot_structure_children('market', $current_cat, true);
                $catsub[] = $current_cat;
                $catsub_quoted = array_map([$db, 'quote'], $catsub);
                $where[] = "m.fieldmrkt_cat IN (" . implode(',', $catsub_quoted) . ")";
            }
        }
    }

    foreach ($active_filters as $f) {                            // обходим все активные посторонние фильтры
        $alias = "fpf_$i";                                       // уникальный алиас таблицы
        $joins .= " INNER JOIN $table_values AS $alias ON $alias.fieldmrkt_id = m.fieldmrkt_id AND $alias.param_id = {$f['param_id']}"; // соединяем с таблицей значений
        $i++;                                                     // увеличиваем счётчик алиасов
        if ($f['type'] === 'range') {                             // фильтр-диапазон
            if (strpos($f['value'], '-') !== false) {             // если есть дефис — разбираем min-max
                [$min, $max] = array_map('floatval', explode('-', $f['value']));
            } else {                                              // иначе только верхняя граница
                $min = 0;
                $max = floatval($f['value']);
            }
            if ($max > 0) {                                       // если верхняя граница положительная
                $where[] = "CAST(SUBSTRING_INDEX($alias.param_value, '-', 1) AS DECIMAL(12,2)) >= $min AND CAST(SUBSTRING_INDEX($alias.param_value, '-', -1) AS DECIMAL(12,2)) <= $max";
            }                                                      // добавляем условие попадания в диапазон
        } elseif ($f['type'] === 'checkbox') {                    // чекбокс
            $esc = implode(',', array_map([$db, 'quote'], (array)$f['value'])); // экранируем и объединяем выбранные значения
            $where[] = "$alias.param_value IN ($esc)";            // условие IN
        } else {                                                  // select/radio
            $where[] = "$alias.param_value = " . $db->quote($f['value']); // точное совпадение
        }
    }

    // Учёт выбранных значений текущего параметра (внутри группы)
    if (!empty($self_selected)) {                                 // если в текущем параметре что‑то выбрано
        $esc_self = implode(',', array_map([$db, 'quote'], $self_selected)); // экранируем
        $where[] = "EXISTS (SELECT 1 FROM $table_values sv WHERE sv.fieldmrkt_id = v.fieldmrkt_id AND sv.param_id = $param_id AND sv.param_value IN ($esc_self))"; // товар должен иметь хотя бы одно из этих значений
    }

    // Формируем итоговый запрос для подсчёта количества товаров по каждому значению
    $vals_esc = implode(',', array_map([$db, 'quote'], $values_raw)); // все значения текущего параметра для IN
    $sql = "SELECT v.param_value, COUNT(DISTINCT v.fieldmrkt_id) AS cnt
            FROM $table_values v
            INNER JOIN $table_market m ON m.fieldmrkt_id = v.fieldmrkt_id
            $joins
            WHERE v.param_id = $param_id AND v.param_value IN ($vals_esc)"
            . ($where ? ' AND ' . implode(' AND ', $where) : '')  // добавляем условия фильтров
            . " GROUP BY v.param_value";                          // группируем по значению параметра

    $res = $db->query($sql)->fetchAll(PDO::FETCH_KEY_PAIR);       // выполняем, получаем [значение => кол-во]
    $counts = [];                                                 // итоговый массив
    foreach ($values_raw as $v) {                                 // проходим по всем возможным значениям
        $counts[$v] = (int)($res[$v] ?? 0);                      // если нет — пишем 0
    }

    // Сохраняем в файловый кеш
    marketprofilter_cache_set($cache_key, $counts);               // записываем свежий результат
    return $counts;                                               // возвращаем массив
}

/**
 * Подсчитывает количество товаров для range-параметра, попадающих в заданный интервал,
 * с учётом других активных фильтров (кроме самого этого параметра).
 *
 * @param int    $param_id     ID параметра
 * @param float  $min          нижняя граница поиска
 * @param float  $max          верхняя граница поиска
 * @param string $current_cat  код категории (или '' если без)
 * @return int
 */
function marketprofilter_get_range_count($param_id, $min, $max, $current_cat = '') {
    global $db, $db_x;                                           // объекты БД

    $table_params = $db_x . 'marketprofilter_params';            // имя таблицы параметров
    $table_values = $db_x . 'marketprofilter_params_values';     // имя таблицы значений параметров
    $table_market = $db_x . 'market';                            // имя таблицы товаров

    // Собираем все активные фильтры, кроме текущего параметра
    $all_params = $db->query("SELECT param_id, param_name, param_type FROM $table_params WHERE param_active = 1")->fetchAll(); // все активные параметры
    $active_filters = [];                                        // контейнер для применённых фильтров
    foreach ($all_params as $p) {                                // перебираем все параметры
        if ($p['param_id'] == $param_id) continue;               // исключаем текущий range-параметр
        $key = "filter_{$p['param_name']}";                      // ключ в $_GET
        $val = $_GET[$key] ?? null;                              // читаем значение фильтра (null если нет)
        if ($val === null || $val === '') continue;              // пусто — пропускаем
        if ($p['param_type'] === 'checkbox') {                   // если тип чекбокс
            if (!is_array($val)) $val = [$val];                  // приводим к массиву
            $val = array_filter($val);                           // убираем пустые элементы
            if (!$val) continue;                                 // если массив пуст — пропускаем
        } elseif ($p['param_type'] === 'range') {                // если другой диапазон
            $val = trim($val);                                   // обрезаем пробелы
            if ($val === '') continue;                           // пусто — пропускаем
        } else {                                                 // select или radio
            $val = trim($val);                                   // обрезаем пробелы
            if ($val === '') continue;                           // пусто — пропускаем
        }
        $active_filters[] = ['param_id' => $p['param_id'], 'type' => $p['param_type'], 'value' => $val]; // сохраняем активный фильтр
    }

    // Строим JOIN и WHERE для других фильтров
    $joins = '';                                                 // строка с JOIN'ами
    $where = [];                                                 // массив условий WHERE
    $i = 0;                                                      // счётчик для уникальных алиасов

    // Ограничение по категории (аналогично первой функции)
    if ($current_cat !== '') {
        $cat_id = (int)$db->query("SELECT structure_id FROM {$db->structure} WHERE structure_code = " . $db->quote($current_cat) . " AND structure_area = 'market'")->fetchColumn();
        if ($cat_id > 0) {                                       // если категория найдена
            if (cot_plugin_active('multicatmarket')) {           // если активен плагин мультикатегорий
                $db->registerTable('market_multicats');          // регистрируем таблицу связей
                $db_multicats = $db->market_multicats ?: $db_x . 'market_multicats';
                $where[] = "m.fieldmrkt_id IN (SELECT pcat_page_id FROM $db_multicats WHERE pcat_cat_id = {$cat_id})"; // фильтр по дополнительной таблице
            } else {
                // Стандартная иерархия категорий с учётом подкатегорий
                $catsub = cot_structure_children('market', $current_cat, true); // все дочерние категории
                $catsub[] = $current_cat;                        // добавляем саму категорию
                $catsub_quoted = array_map([$db, 'quote'], $catsub); // экранируем
                $where[] = "m.fieldmrkt_cat IN (" . implode(',', $catsub_quoted) . ")"; // условие по категориям
            }
        }
    }

    foreach ($active_filters as $f) {                            // обходим все активные посторонние фильтры
        $alias = "rfc_$i";                                       // уникальный алиас таблицы (range filter count)
        $joins .= " INNER JOIN $table_values AS $alias ON $alias.fieldmrkt_id = m.fieldmrkt_id AND $alias.param_id = {$f['param_id']}"; // JOIN с таблицей значений
        $i++;                                                     // следующий алиас
        if ($f['type'] === 'range') {                             // фильтр-диапазон
            if (strpos($f['value'], '-') !== false) {             // формат "min-max"
                [$fmin, $fmax] = array_map('floatval', explode('-', $f['value'])); // разбираем границы
            } else {                                              // только верхняя граница
                $fmin = 0;
                $fmax = floatval($f['value']);
            }
            if ($fmax > 0) {                                      // если верхняя граница задана
                $where[] = "CAST($alias.param_value AS UNSIGNED) >= $fmin AND CAST($alias.param_value AS UNSIGNED) <= $fmax"; // условие попадания в диапазон
            }
        } elseif ($f['type'] === 'checkbox') {                    // чекбокс
            $esc = implode(',', array_map([$db, 'quote'], (array)$f['value'])); // экранируем список значений
            $where[] = "$alias.param_value IN ($esc)";            // условие IN
        } else {                                                  // select или radio
            $where[] = "$alias.param_value = " . $db->quote($f['value']); // точное совпадение
        }
    }

    // Основной запрос: считаем товары, у которых значение текущего параметра в [min, max]
    $sql = "SELECT COUNT(DISTINCT m.fieldmrkt_id)
            FROM $table_market m
            INNER JOIN $table_values v ON v.fieldmrkt_id = m.fieldmrkt_id AND v.param_id = $param_id
            $joins
            WHERE CAST(v.param_value AS UNSIGNED) >= $min AND CAST(v.param_value AS UNSIGNED) <= $max"
            . ($where ? ' AND ' . implode(' AND ', $where) : ''); // добавляем условия других фильтров

    return (int)$db->query($sql)->fetchColumn();                 // выполняем запрос и возвращаем целое число
}
/**
 * Проверяет, существует ли активный параметр фильтра с заданным именем
 * и содержит ли его JSON-поле param_values указанное значение.
 * Учитывает права доступа: если параметр помечен как суперадминский (param_superadmin=1),
 * то функция вернёт true только для администратора (группа 5).
 *
 * @param string $param_name Имя параметра (например, '001_01_samokat_brand')
 * @param string $value      Значение для проверки (например, 'kugoo')
 * @return bool
 */
function marketprofilter_has_value($param_name, $value)
{
    global $db, $db_x;

    static $cache = []; // кеш в памяти на время выполнения страницы
    $cache_key = $param_name . '|' . $value;

    if (array_key_exists($cache_key, $cache)) {
        return $cache[$cache_key];
    }

    // Получаем параметр из БД
    $sql = "SELECT param_values, param_superadmin 
            FROM {$db_x}marketprofilter_params 
            WHERE param_name = ? AND param_active = 1 
            LIMIT 1";
    $row = $db->query($sql, [$param_name])->fetch();

    if (!$row) {
        $cache[$cache_key] = false;
        return false;
    }

    // Проверка суперадминского доступа
    if (!empty($row['param_superadmin']) && !marketprofilter_is_admin()) {
        $cache[$cache_key] = false;
        return false;
    }

    // Декодируем JSON массив значений
    $values = json_decode($row['param_values'], true);
    if (!is_array($values)) {
        $cache[$cache_key] = false;
        return false;
    }

    $result = in_array($value, $values, true);
    $cache[$cache_key] = $result;
    return $result;
}
/**
 * Рекурсивно строит дерево всех категорий market с чекбоксами для выбора мультикатегорий
 */
function marketprofilter_admin_render_category_tree($parent, $selected, $code_to_id, $blacklist)
{
    global $structure, $L, $i18n_enabled, $i18n4marketpro_locale;

    if (empty($parent)) {
        $allcat = cot_structure_children('market', '');
        $children = [];
        foreach ($allcat as $code) {
            if (
                !isset($structure['market'][$code]['path']) ||
                mb_substr_count($structure['market'][$code]['path'], '.') != 0 ||
                in_array($code, $blacklist)
            ) {
                continue;
            }
            $children[] = $code;
        }
    } else {
        if (!isset($structure['market'][$parent]['subcats'])) {
            return '';
        }
        $children = array_filter($structure['market'][$parent]['subcats'], function($code) use ($blacklist) {
            return !in_array($code, $blacklist);
        });
    }

    if (empty($children)) {
        return '';
    }

    $html = '';
    foreach ($children as $code) {
        if (!cot_auth('market', $code, 'W')) continue;
        if (!isset($code_to_id[$code])) continue;

        $cat_id = $code_to_id[$code];
        $title = $structure['market'][$code]['title'] ?? $code;

        // Перевод через i18n, если активен
        if (cot_plugin_active('i18n4marketpro') && $i18n_enabled) {
            $translated = cot_i18n4marketpro_get_cat($code, $i18n4marketpro_locale);
            if ($translated && !empty($translated['title'])) {
                $title = $translated['title'];
            }
        }

        $checked = in_array($code, $selected) ? ' checked="checked"' : '';
        $id_attr = 'mcat_' . $cat_id;

        if (empty($parent) && $html !== '') {
            $html .= '<hr>';
        }

        $html .= '<li class="list-group-item bg-transparent border-0 py-0">';
        $html .= '<div class="form-check" style="margin: 0;">';
        $html .= '<input class="form-check-input" type="checkbox" name="param_multicats[]" value="' . htmlspecialchars($code) . '"' . $checked . ' id="' . $id_attr . '">';
        $html .= '<label class="form-check-label" for="' . $id_attr . '">' . htmlspecialchars($title) . '</label>';
        $html .= '</div>';

        $sub = marketprofilter_admin_render_category_tree($code, $selected, $code_to_id, $blacklist);
        if ($sub !== '') {
            $html .= '<ul>' . $sub . '</ul>';
        }
        $html .= '</li>';
    }
    return $html;
}