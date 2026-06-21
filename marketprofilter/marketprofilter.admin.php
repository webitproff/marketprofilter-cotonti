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
$tab      = cot_import('tab', 'G', 'ALP') ?: 'list';   // новая переменная для вкладок
$filter_cat = cot_import('filter_cat', 'G', 'ALP') ?? '';
list($pg, $d, $durl) = cot_import_pagenav('d', Cot::$cfg['maxrowsperpage']);

$main_lang   = Cot::$cfg['defaultlang'] ?? 'ua';
$extra_langs = ['en', 'ru'];
$all_langs   = array_unique(array_merge([$main_lang], $extra_langs));

$tpl_PartExt = 'admin';
$mskin = cot_tplfile(['marketprofilter', $tpl_PartExt], 'plug');
$t = new XTemplate($mskin);

$adminTitle = Cot::$L['marketprofilter_adminTitle'] ?? '';
$adminHelp  = Cot::$L['marketprofilter_adminHelp'] ?? '';

$edit_mode = false;

// --- Определяем, какую форму показывать ---
if ($tab === 'edit' && $param_id > 0) {
    $row = $db->query("SELECT * FROM $db_params WHERE param_id = ?", [$param_id])->fetch();
    if ($row) {
        $edit_mode = true;
        $form_values = $row;
    } else {
        cot_die();
    }
} elseif ($tab === 'add') {
    $form_values = [
        'param_id'         => '',
        'param_name'       => '',
        'param_type'       => 'select',
        'param_values'     => '[]',
        'param_category'   => '',
        'param_active'     => 1,
        'param_superadmin' => 0,
        'param_helpinfo'   => '',
        'param_hidelistitem' => 0,
    ];
} else {
    // вкладка list или другие
    $form_values = [];
}

// === СОХРАНЕНИЕ (POST) ===
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
        'param_hidelistitem' => cot_import('param_hidelistitem', 'P', 'BOL') ? 1 : 0,
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
            foreach ($all_langs as $lang) {
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

            cot_redirect(cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'tab' => 'list']));
        }
    }
}

// === УДАЛЕНИЕ ===
if ($action === 'delete' && $param_id > 0) {
    $db->delete($db_i18n, 'i18n_param_id = ?', [$param_id]);
    $db->delete($db_params, 'param_id = ?', [$param_id]);
    cot_message($L['marketprofilter_param_deleted']);
    cot_redirect(cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'tab' => 'list']));
}

// === ФОРМА (генерируем только если нужна) ===
$form_fields = '';
if ($tab === 'add' || $tab === 'edit') {
    $form_fields = marketprofilter_form_fields($form_values);
    // мультиязычность
    if ($tab === 'edit') {
        $i18n = [];
        $res = $db->query("SELECT i18n_locale, i18n_title, i18n_values, i18n_helpinfo FROM $db_i18n WHERE i18n_param_id = ?", [$param_id]);
        while ($row = $res->fetch()) {
            $i18n[$row['i18n_locale']] = $row;
        }
    } else {
        $i18n = [];
    }

    $form_fields .= '<hr><h5>' . $L['marketprofilter_translations'] . '</h5>';
    foreach ($all_langs as $lang) {
        $title  = $i18n[$lang]['i18n_title'] ?? '';
        $values = $i18n[$lang]['i18n_values'] ?? '';
        $helpinfo = $i18n[$lang]['i18n_helpinfo'] ?? '';

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

        $form_fields .= '<div class="mb-3">';
        $form_fields .= '  <label class="form-label">' . $L['marketprofilter_param_helpinfo'] . ' (' . strtoupper($lang) . ')</label>';
        $form_fields .= '  <textarea name="i18n_helpinfo_' . $lang . '" class="form-control" rows="2">' . htmlspecialchars($helpinfo) . '</textarea>';
        $form_fields .= '</div>';
    }
}

// === СПИСОК (только для вкладки list) ===
if ($tab === 'list') {
    $where_cat = '';
    if ($filter_cat === '_uncategorized_') {
        $where_cat = " WHERE p.param_category = ''";
    } elseif ($filter_cat !== '') {
        $where_cat = " WHERE p.param_category = " . $db->quote($filter_cat);
    }

    $total_params = $db->query("SELECT COUNT(*) FROM $db_params p $where_cat")->fetchColumn();
    $lang_alias = 'i_' . $main_lang;
    $lang_literal = $db->quote($main_lang);

    $parameters = $db->query("
        SELECT p.*, COALESCE({$lang_alias}.i18n_title, p.param_name) AS display_title
        FROM $db_params p
        LEFT JOIN $db_i18n {$lang_alias} 
            ON {$lang_alias}.i18n_param_id = p.param_id 
            AND {$lang_alias}.i18n_locale = {$lang_literal}
        $where_cat
        ORDER BY p.param_id DESC
        LIMIT $d, " . Cot::$cfg['maxrowsperpage']
    )->fetchAll();

    $filter_cat_select = cot_selectbox_structure(
        'market',
        $filter_cat,
        'filter_cat',
        '',
        true,
        true,
        true,
        'class="form-select"'
    );
    $filter_cat_select = str_replace(
        '</select>',
        '<option value="_uncategorized_"' . ($filter_cat === '_uncategorized_' ? ' selected' : '') . '>Без категории</option></select>',
        $filter_cat_select
    );

    // пагинация
    $pagenav_url = 'm=other&p=marketprofilter&tab=list' . ($filter_cat !== '' ? '&filter_cat=' . urlencode($filter_cat) : '');
    $pagenav = cot_pagenav('admin', $pagenav_url, $d, $total_params, Cot::$cfg['maxrowsperpage'], 'd', '', Cot::$cfg['jquery'] && Cot::$cfg['turnajax']);
}

// === НАЗНАЧЕНИЕ ПЕРЕМЕННЫХ ШАБЛОНА ===
$t->assign([
    'TAB_LIST_ACTIVE'  => $tab === 'list' ? 'active' : '',
    'TAB_ADD_ACTIVE'   => $tab === 'add' ? 'active' : '',
    'TAB_EDIT_ACTIVE'  => $tab === 'edit' ? 'active' : '',
    'URL_LIST'         => cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'tab' => 'list']),
    'URL_ADD'          => cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'tab' => 'add']),
    'URL_EDIT'         => cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'tab' => 'edit']), // базовая без id
    'FORM_ACTION'      => ($tab === 'edit') ? cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'a' => 'edit', 'id' => $param_id, 'tab' => 'edit']) : cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'a' => 'add', 'tab' => 'add']),
    'FORM_FIELDS'      => $form_fields,
    'FORM_PARAM_ID'    => $edit_mode ? $form_values['param_id'] : '',
    'CANCEL_URL'       => cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'tab' => 'list']),
    'SHOW_LIST'        => ($tab === 'list'),
    'SHOW_ADD_FORM'    => ($tab === 'add'),
    'SHOW_EDIT_FORM'   => ($tab === 'edit'),
]);

if ($tab === 'list') {
    $t->assign([
        'FILTER_CAT_SELECT' => $filter_cat_select,
    ]);
    $t->parse('MAIN.FILTER_CAT');

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
            'PARAM_EDIT_URL' => cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'tab' => 'edit', 'a' => 'edit', 'id' => $param['param_id']]),
            'PARAM_DELETE_URL' => cot_confirm_url(cot_url('admin', ['m' => 'other', 'p' => 'marketprofilter', 'a' => 'delete', 'id' => $param['param_id'], 'tab' => 'list'])),
        ]);
        $t->parse('MAIN.PARAM_ROW');
    }

    $t->assign(cot_generatePaginationTags($pagenav));
}

// Служебный вывод сообщений
cot_display_messages($t);

$t->parse('MAIN');
$adminMain = $t->text('MAIN');