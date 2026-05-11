<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=tools
[END_COT_EXT]
==================== */

/**
 * Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.admin.php
 * Purpose: создание и редактирование групп характеристик, а также значений для фильтра товаров.
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

require_once cot_incfile('market', 'module');
require_once cot_incfile('forms');

cot_block(Cot::$usr['isadmin']);

global $db, $db_x, $cfg, $L;

Cot::$db->registerTable('marketprofilter_params');
Cot::$db->registerTable('marketprofilter_params_values');
Cot::$db->registerTable('marketprofilter_i18n');

$db_params = $db_x . 'marketprofilter_params';
$db_i18n   = $db_x . 'marketprofilter_i18n';

$action   = cot_import('a', 'G', 'ALP');
$param_id = cot_import('id', 'G', 'INT');
list($pg, $d, $durl) = cot_import_pagenav('d', Cot::$cfg['maxrowsperpage']); //добавил пагинацию. Cot::$cfg['maxrowsperpage'] по умолчанию равно 15
$main_lang   = Cot::$cfg['defaultlang'] ?? 'ua';
$extra_langs = ['en', 'ru'];

$all_langs   = array_unique(array_merge([$main_lang], $extra_langs));

// присваиваем шаблону имя части или локации расширения
$tpl_PartExt = 'admin';

// Загружаем шаблон для админки плагина marketprofilter
$mskin = cot_tplfile(['marketprofilter', $tpl_PartExt], 'plug');
// объект шаблона создаем после загрузки всего, что "прицепилось" на "main", если мы писали этот хук в этом файле

// заголовок браузера на странице администрирования плагина https://supersite.com/admin/other?p=marketprofilter
$adminTitle = Cot::$L['marketprofilter_adminTitle'] ?? '';

// текст справки по администрированию плагина, если такая строка есть в файле локализации
$adminHelp = Cot::$L['marketprofilter_adminHelp'] ?? ''; 

// Создаём объект шаблона XTemplate с указанным файлом шаблона
$t = new XTemplate($mskin);


$edit_mode = false;

// === РЕДАКТИРОВАНИЕ ===
if ($action === 'edit' && $param_id > 0) {
    $row = $db->query("SELECT * FROM $db_params WHERE param_id = ?", [$param_id])->fetch();
    if ($row) {
        $edit_mode = true;
        $form_values = $row;
    } else {
        cot_die();
    }
} else {
    $form_values = [
        'param_id'         => '',
        'param_name'       => '',
        'param_type'       => 'select',
        'param_values'     => '[]',
        'param_category'   => '',
        'param_active'     => 1,
        'param_superadmin' => 0,      
        'param_helpinfo'   => '',     
    ];
}

// === СОХРАНЕНИЕ ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($action, ['add', 'edit'])) {
    $data = [
        'param_name'       => cot_import('param_name', 'P', 'ALP'),
        'param_title'      => cot_import('param_title', 'P', 'TXT'),
        'param_type'       => cot_import('param_type', 'P', 'ALP'),
        'param_values'     => cot_import('param_values', 'P', 'TXT'),
        'param_category'   => cot_import('param_category', 'P', 'ALP') ?: '',
        'param_active'     => cot_import('param_active', 'P', 'BOL') ? 1 : 0,
        'param_superadmin' => cot_import('param_superadmin', 'P', 'BOL') ? 1 : 0,   
        'param_helpinfo'   => cot_import('param_helpinfo', 'P', 'TXT'),             
    ];

    if (!$data['param_name'] || !in_array($data['param_type'], ['range','select','checkbox','radio'])) {
        cot_error($L['marketprofilter_error_invalid_data']);
    } else {
        $decoded = json_decode($data['param_values'], true);
        if ($data['param_type'] === 'range' && (!isset($decoded['min']) || !isset($decoded['max']))) {
            cot_error($L['marketprofilter_error_range_format']);
        } elseif (in_array($data['param_type'], ['select','checkbox','radio']) && !is_array($decoded)) {
            cot_error($L['marketprofilter_error_values_format']);
        } else {
            if ($action === 'add') {
                $db->insert($db_params, $data);
                $param_id = $db->lastInsertId();
                cot_message($L['marketprofilter_param_added']);
            } else {
                $db->update($db_params, $data, 'param_id = ?', [$param_id]);
                cot_message($L['marketprofilter_param_updated']);
            }

            // i18n
            $db->delete($db_i18n, 'i18n_param_id = ?', [$param_id]);
            foreach ($all_langs  as $lang) {
                $title  = cot_import("i18n_title_$lang", 'P', 'TXT');
                $values = cot_import("i18n_values_$lang", 'P', 'TXT');
                $helpinfo = cot_import("i18n_helpinfo_$lang", 'P', 'TXT');   
                if ($title !== '') {
                    $db->insert($db_i18n, [
                        'i18n_param_id' => $param_id,
                        'i18n_locale'   => $lang,
                        'i18n_title'    => $title,
                        'i18n_values'   => $values ?: null,
                        'i18n_helpinfo' => $helpinfo,                         
                    ]);
                }
            }

            cot_redirect(cot_url('admin', 'm=other&p=marketprofilter', '', true));
        }
    }
}

// === УДАЛЕНИЕ ===
if ($action === 'delete' && $param_id > 0) {
    $db->delete($db_i18n, 'i18n_param_id = ?', [$param_id]);
    $db->delete($db_params, 'param_id = ?', [$param_id]);
    cot_message($L['marketprofilter_param_deleted']);
    cot_redirect(cot_url('admin', 'm=other&p=marketprofilter', '', true));
}

// === ФОРМА ===
$form_fields = marketprofilter_form_fields($form_values);

// === МУЛЬТИЯЗЫЧНОСТЬ ===
if ($edit_mode) {
    $i18n = [];
    $res = $db->query("SELECT i18n_locale, i18n_title, i18n_values, i18n_helpinfo FROM $db_i18n WHERE i18n_param_id = ?", [$param_id]);
    while ($row = $res->fetch()) {
        $i18n[$row['i18n_locale']] = $row;
    }
} else {
    $i18n = $all_langs;
}

$form_fields .= '<hr><h5>' . $L['marketprofilter_translations'] . '</h5>';

foreach ($all_langs as $lang) {
    $title  = $i18n[$lang]['i18n_title'] ?? '';
    $values = $i18n[$lang]['i18n_values'] ?? '';
    $helpinfo = $i18n[$lang]['i18n_helpinfo'] ?? '';   // подсказка по параметру

    $form_fields .= '<div class="mb-3">';
    $form_fields .= '  <label class="form-label">' . $L['marketprofilter_param_title'] . ' (' . strtoupper($lang) . ')</label>';
    $form_fields .= '  <input type="text" name="i18n_title_' . $lang . '" class="form-control" value="' . htmlspecialchars($title) . '" required>';
    $form_fields .= '</div>';

    if ($form_values['param_type'] !== 'range') {
        $form_fields .= '<div class="mb-3">';
        $form_fields .= '  <label class="form-label">' . $L['marketprofilter_param_values_translated'] . ' (JSON)</label>';
        $form_fields .= '  <textarea name="i18n_values_' . $lang . '" class="form-control" rows="6">' . htmlspecialchars($values) . '</textarea>';
        $form_fields .= '  <small class="text-muted">' . $L['marketprofilter_i18n_values_hint'] . '</small>';
        $form_fields .= '</div>';
    }

    // поле для перевода подсказки
    $form_fields .= '<div class="mb-3">';
    $form_fields .= '  <label class="form-label">' . $L['marketprofilter_param_helpinfo'] . ' (' . strtoupper($lang) . ')</label>';
    $form_fields .= '  <textarea name="i18n_helpinfo_' . $lang . '" class="form-control" rows="2">' . htmlspecialchars($helpinfo) . '</textarea>';
    $form_fields .= '</div>';
}

// === СПИСОК ===
$total_params = $db->query("SELECT COUNT(*) FROM $db_params")->fetchColumn();
$lang_alias = 'i_' . $main_lang;
$lang_literal = $db->quote($main_lang);

$parameters = $db->query("
    SELECT p.*, COALESCE({$lang_alias}.i18n_title, p.param_name) AS display_title
    FROM $db_params p
    LEFT JOIN $db_i18n {$lang_alias} 
        ON {$lang_alias}.i18n_param_id = p.param_id 
        AND {$lang_alias}.i18n_locale = {$lang_literal}
    ORDER BY p.param_id DESC
    LIMIT $d, " . Cot::$cfg['maxrowsperpage']
)->fetchAll();


// === ВЫВОД ===
$t->assign([
    'FORM_ACTION'   => $edit_mode ? cot_url('admin', "m=other&p=marketprofilter&a=edit&id=$param_id") : cot_url('admin', 'm=other&p=marketprofilter&a=add'),
    'FORM_FIELDS'   => $form_fields,
    'CANCEL_URL'    => cot_url('admin', 'm=other&p=marketprofilter'),
    'FORM_PARAM_ID' => $edit_mode ? $form_values['param_id'] : '',
]);

foreach ($parameters as $param) {
    $t->assign([
        'PARAM_ID'       => $param['param_id'],
        'PARAM_NAME'     => htmlspecialchars($param['param_name']),
        'PARAM_TITLE'    => htmlspecialchars($param['display_title']),
        'PARAM_TYPE'     => $param['param_type'],
        'PARAM_VALUES'   => '<code>' . htmlspecialchars($param['param_values']) . '</code>',
        'PARAM_CATEGORY' => $param['param_category'] ?: '—',
        'PARAM_ACTIVE'   => $param['param_active'] ? $L['Yes'] : $L['No'],
		'PARAM_SUPERADMIN' => $param['param_superadmin'] ? $L['Yes'] : '',
		'PARAM_HELPINFO_SHORT' => htmlspecialchars(mb_substr($param['param_helpinfo'] ?? '', 0, 50)),
        'PARAM_EDIT_URL' => cot_url('admin', "m=other&p=marketprofilter&a=edit&id={$param['param_id']}"),
        'PARAM_DELETE_URL' => cot_confirm_url(cot_url('admin', "m=other&p=marketprofilter&a=delete&id={$param['param_id']}")),
    ]);
    $t->parse('MAIN.PARAM_ROW');
}

$pagenav = cot_pagenav(
    'admin',
    'm=other&p=marketprofilter',
    $d,
    $total_params,
    Cot::$cfg['maxrowsperpage'],
    'd',
    '',
    Cot::$cfg['jquery'] && Cot::$cfg['turnajax']
);

$t->assign(cot_generatePaginationTags($pagenav));
cot_display_messages($t);

if ($edit_mode) {
    $t->parse('MAIN.EDIT_FORM');
} else {
    $t->parse('MAIN.ADD_FORM');
}

$t->parse('MAIN');
$adminMain = $t->text('MAIN');
