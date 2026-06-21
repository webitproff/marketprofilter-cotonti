<!--
	/********************************************************************************
	* File: marketprofilter.admin.tpl
	* Extension: plugin 'marketprofilter'
	* Description: HTML template for ADMIN PANEL marketprofilter plugin.
	* Compatibility: CMF/CMS Cotonti v.1+ (https://github.com/Cotonti/Cotonti)
	* Dependencies: 
	* 		 Bootstrap 5.3.+       (https://getbootstrap.com/); 
	* 		 Font Awesome Free 7.1 (https://fontawesome.com/)
	* Theme: cotcp 
	* Version: 1.0.2 
	* Created: 01 Feb 2026 
	* Updated: 21 June 2026 
	* Copyright (c) 2026 webitproff | https://github.com/webitproff
	* Source: https://github.com/webitproff/cotcp
	* WebPage : https://abuyfile.com/market/cotonti/themes/cotcp
	* Help and support: https://abuyfile.com/ru/forums/cotonti/original/skins/cotcp
	* License: BSD (Free distribution with saving Copyright (c) 2026 webitproff)  
	********************************************************************************/
-->

<!-- BEGIN: MAIN -->
<div class="container-fluid">
    <h2>{PHP.L.marketprofilter_admin_title}</h2>
    {FILE "{PHP.cfg.themes_dir}/admin/{PHP.cfg.admintheme}/warnings.tpl"}

    <!-- НАВИГАЦИОННЫЕ ВКЛАДКИ -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {TAB_LIST_ACTIVE}" href="{URL_LIST}">{PHP.L.marketprofilter_tab_list}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {TAB_ADD_ACTIVE}" href="{URL_ADD}">{PHP.L.marketprofilter_tab_add}</a>
        </li>
        <!-- IF {SHOW_EDIT_FORM} -->
        <li class="nav-item">
            <a class="nav-link active" href="#">{PHP.L.marketprofilter_tab_edit} #{FORM_PARAM_ID}</a>
        </li>
        <!-- ENDIF -->
    </ul>

    <!-- ВКЛАДКА "СПИСОК" -->
    <!-- IF {SHOW_LIST} -->
    <h3 class="mt-3">{PHP.L.marketprofilter_existing_params}</h3>
    <!-- BEGIN: FILTER_CAT -->
    <form method="get" class="row g-2 mb-3">
        <input type="hidden" name="m" value="other">
        <input type="hidden" name="p" value="marketprofilter">
        <input type="hidden" name="tab" value="list">
        <div class="col-auto">
            {FILTER_CAT_SELECT}
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">{PHP.L.marketprofilter_filter}</button>
        </div>
    </form>
    <!-- END: FILTER_CAT -->

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>{PHP.L.marketprofilter_id}</th>
                    <th>{PHP.L.marketprofilter_param_name}</th>
                    <th>{PHP.L.marketprofilter_param_title}</th>
                    <th>{PHP.L.marketprofilter_param_type}</th>
                    <th>{PHP.L.marketprofilter_param_values}</th>
                    <th>{PHP.L.marketprofilter_param_category}</th>
                    <th>{PHP.L.marketprofilter_param_active}</th>
                    <th>{PHP.L.marketprofilter_param_superadmin_short}</th>
                    <th>{PHP.L.marketprofilter_param_helpinfo_short}</th>
                    <th>{PHP.L.marketprofilter_actions}</th>
                </tr>
            </thead>
            <tbody>
                <!-- BEGIN: PARAM_ROW -->
                <tr>
                    <td>{PARAM_ID}</td>
                    <td>{PARAM_NAME}</td>
                    <td>{PARAM_TITLE}</td>
                    <td>{PARAM_TYPE}</td>
                    <td>{PARAM_VALUES}</td>
                    <td>{PARAM_CATEGORY}</td>
                    <td>{PARAM_ACTIVE}</td>
                    <td>{PARAM_SUPERADMIN}</td>
                    <td>{PARAM_HELPINFO_SHORT}</td>
                    <td>
                        <a href="{PARAM_EDIT_URL}" class="btn btn-sm btn-primary">{PHP.L.Edit}</a>
                        <a href="{PARAM_DELETE_URL}" class="btn btn-sm btn-danger" onclick="return confirm('{PHP.L.marketprofilter_confirm_delete}')">{PHP.L.Delete}</a>
                    </td>
                </tr>
                <!-- END: PARAM_ROW -->
            </tbody>
        </table>
    </div>

    <!-- IF {PAGINATION} -->
    <nav aria-label="Marketprofilter pagination">
        <ul class="pagination justify-content-center mt-5">
            {PREVIOUS_PAGE}
            {PAGINATION}
            {NEXT_PAGE}
        </ul>
    </nav>
    <!-- ENDIF -->
    <!-- IF {TOTAL_ENTRIES} -->
    <p class="text-primary">
        <span>{PHP.L.Total}: {TOTAL_ENTRIES}, {PHP.L.Onpage}: {ENTRIES_ON_CURRENT_PAGE}</span>
    </p>
    <!-- ENDIF -->
    <!-- ENDIF -->

    <!-- ВКЛАДКА "ДОБАВИТЬ" -->
    <!-- IF {SHOW_ADD_FORM} -->
    <div class="p-3 mb-4 bg-primary-subtle text-primary-emphasis rounded">
        <h3>{PHP.L.marketprofilter_add_param}</h3>
        <form action="{FORM_ACTION}" method="post">
            {FORM_FIELDS}
            <button type="submit" class="btn btn-success">{PHP.L.Add}</button>
        </form>
    </div>
    <!-- ENDIF -->

    <!-- ВКЛАДКА "РЕДАКТИРОВАТЬ" -->
    <!-- IF {SHOW_EDIT_FORM} -->
    <div class="p-3 mb-4 bg-warning-subtle text-warning-emphasis rounded">
        <h3>{PHP.L.marketprofilter_edit_param} #{FORM_PARAM_ID}</h3>
        <form action="{FORM_ACTION}" method="post">
            <input type="hidden" name="id" value="{FORM_PARAM_ID}">
            {FORM_FIELDS}
            <button type="submit" class="btn btn-primary">{PHP.L.Save}</button>
            <a href="{CANCEL_URL}" class="btn btn-secondary">{PHP.L.Cancel}</a>
        </form>
    </div>
    <!-- ENDIF -->
</div>
<style>
	.table code { font-size: 0.85em; }
</style>
<!-- END: MAIN -->
