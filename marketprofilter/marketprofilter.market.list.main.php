<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.list.main
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL');

/* global $list_url_path;

// Сохраняем все filter_* параметры в URL пагинации
foreach ($_GET as $key => $value) {
    if (strpos($key, 'filter_') === 0 && $value !== '' && $value !== null) {
        // Если значение массив (checkbox) — Cotonti сам сериализует в URL как filter_name[]=val1&filter_name[]=val2
        $list_url_path[$key] = $value;
    }
} */