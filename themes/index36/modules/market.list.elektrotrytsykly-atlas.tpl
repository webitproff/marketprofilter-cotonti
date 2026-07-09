<!-- BEGIN: MAIN -->
<!-- IF {PHP.usr.maingrp} == 5 -->
<div class="container-fluid text-center my-2">
	<div class="alert bg-grad-purple-violet position-relative overflow-hidden">
		<div class="alert-hex-mask"></div>
		<div class="alert-hex-mask-left"></div>
		<h2 class="fs-5 my-0 text-white">market.list.elektrotrytsykly-atlas.tpl</h2>
	</div>
</div>
<!-- ENDIF -->

<div class="container-fluid px-xxl-5 py-5">

    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	
    <!-- Breadcrumbs -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{PHP|cot_url('index')}" itemprop="item"><span itemprop="name">{PHP.L.Home}</span></a>
                        <meta itemprop="position" content="1" />
					</li>
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{PHP|cot_url('market')}" itemprop="item"><span itemprop="name">{PHP.L.market_categories}</span></a>
                        <meta itemprop="position" content="2" />
					</li>
                    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="name">{LIST_CAT_TITLE_LISTITEMS_SCHEMAORG_LANG_LINE}</span>
                        <meta itemprop="position" content="3" />
					</li>
				</ol>
			</nav>
		</div>
	</div>
	
    <div class="row align-items-center mb-4">
        <div class="col-md-8 col-lg-9 col-12">
            <!-- IF {PHP.c} == '' -->
            <h1 class="h3 mt-0">{PHP.cfg.market.marketlist_default_title}</h1>
            <!-- ELSE -->
            <h1 class="h3 mb-0" itemprop="name">
                <!-- IF {LIST_CAT_TITLE_LANG_LINE} -->{LIST_CAT_TITLE_LANG_LINE}<!-- ELSE -->{LIST_CAT_TITLE}<!-- ENDIF -->
			</h1>
            <!-- ENDIF -->
		</div>
		
		<!-- IF {PHP|cot_auth('market', 'any', 'W')} -->
		<div class="col-md-4 col-lg-3 col-12 text-md-end mt-3 mt-md-0">
			<a class="btn btn-outline-success" href="{PHP|cot_url('market', 'm=add&c={LIST_CAT_CODE}')}">{PHP.L.market_addtitle}</a>
		</div>
		<!-- ENDIF -->
	</div>
    <div class="category-description mb-5" itemprop="description">
		<div class="card position-relative overflow-hidden rounded-3 bg-grad-sky-blue text-white bg-border-gradient">
            <div class="card-body">
				<!-- IF {PHP.L.market_metadesc_elektrotrytsykly-atlas} --> 
				<div class="mb-0">
					<p class="fs-5 opacity-75">{PHP.L.market_metadesc_elektrotrytsykly-atlas}</p>
				</div>	
				<!-- ELSE -->
				<!-- IF {LIST_CAT_DESCRIPTION} -->				
				<div class="mb-0">
					<p class="fs-5 fw-light">
						{LIST_CAT_DESCRIPTION}
					</p>
				</div>
				<!-- ENDIF -->
				<!-- ENDIF -->	
			</div>
			<div class="hex-mask"></div>
		</div>
	</div>
	
	<div class="col-12 position-relative" id="promo-block-top">
		<button type="button"
		class="promo-close-btn"
		title="{PHP.L.Close}"
		aria-label="{PHP.L.Close}"
		data-close-promo="promo-block-top">&times;</button>
		<!-- IF {PHP.i18n_locale} == 'ru' -->
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/inc/elektrotrytsykly-atlas/top-ru.tpl"}
		<!-- ENDIF -->
		<!-- IF {PHP.i18n_locale} == 'ua' -->
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/inc/elektrotrytsykly-atlas/top-ua.tpl"}
		<!-- ENDIF -->
	</div>
	
	
	<div class="col-12">
		<div id="aurorawave">
			<button class="btn btn-sm btn-warning-hot text-uppercase mb-4" type="button" id="filterToggleBtn">
				{PHP.L.marketprofilter_Hide_Filter}
			</button>
		</div>
		<!-- IF {PHP|cot_plugin_active('marketprofilter')} AND {MARKETFILTER_MESSAGE} -->
		<div class="alert {MARKETFILTER_MESSAGE_CLASS}"> {MARKETFILTER_MESSAGE} </div>
		<!-- ENDIF --> 
	</div>
	<div class="row px-0">
		<!-- IF {PHP|cot_plugin_active('marketprofilter')} --> 
		<div class="col-12 col-lg-4 col-xl-3" id="marketFilterCol">
			{MARKET_FILTER_FORM}
		</div>
		<!-- ENDIF -->
		<div class="col-12 col-lg-8 col-xl-9" id="marketListCol">
			
			<div class="card card-body mb-3">
				<form action="{MARKET_SEARCH_ACTION_URL}" method="get" class="row g-2">
					<input type="hidden" name="e" value="market">
					<input type="hidden" name="l" value="{PHP.lang}" />
					
					<div class="col-md-6">
						{MARKET_SEARCH_SQ}
					</div>
					
					<div class="col-md-4">
						{MARKET_SEARCH_CAT_SELECT2}
					</div>
					
					<div class="col-md-2">
						<div class="row">
							<div class="col-6">
								<button type="submit" title="{PHP.L.Search}" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
							</div>
							<div class="col-6">
								<!-- IF {LIST_CAT_CODE} -->
								<a class="btn btn-outline-danger" title="{PHP.L.marketprofilter_reset}" href="{PHP|cot_url('market', 'c={LIST_CAT_CODE}')}"><i class="fa-solid fa-filter-circle-xmark"></i></a>
								<!-- ELSE -->
								<a class="btn btn-outline-danger" title="{PHP.L.marketprofilter_reset}" href="{PHP|cot_url('market')}"><i class="fa-solid fa-filter-circle-xmark"></i></a>
								<!-- ENDIF -->
							</div>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class="col-12">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="search_in" id="search_in_title" value="title" <!-- IF {PHP.search_in} == '' OR {PHP.search_in} == 'title' -->checked="checked"<!-- ENDIF -->>
								<label class="form-check-label" for="search_in_title">{PHP.L.market_search_in_title}</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="search_in" id="search_in_full" value="full" <!-- IF {PHP.search_in} == 'full' -->checked="checked"<!-- ENDIF -->>
								<label class="form-check-label" for="search_in_full">{PHP.L.market_search_in_title_and_descr}</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="search_in" id="search_in_pcod" value="pcod" <!-- IF {PHP.search_in} == 'pcod' -->checked="checked"<!-- ENDIF -->>
								<label class="form-check-label" for="search_in_pcod">{PHP.L.market_search_in_pcod}</label>
							</div>
						</div>
					</div>
					<!-- IF {MARKET_SEARCH_RESULT_MSG} --> 
					<div class="alert alert-info" role="alert">
						{MARKET_SEARCH_RESULT_MSG}
					</div>
					<!-- ENDIF -->
				</form>
			</div>
			
			<!-- Список товаров -->
			<div class="row g-3 g-lg-4" id="market-items-container" itemscope itemtype="https://schema.org/ItemList">
				<!-- BEGIN: LIST_ROW -->
				<div class="col-md-12 col-lg-6 col-xl-4">
					<div class="card h-100 border-0 shadow-sm overflow-hidden" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
						<meta itemprop="position" content="{LIST_ROW_ABS_NUM}" />
						
						<div class="row g-0 flex-lg-row">
							<div class="col-12 position-relative">
								<!-- IF {LIST_ROW_FILTER_PARAMS_EXIST} -->
								<div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
									<span class="text-warning-hot" title="{PHP.L.marketprofilter_market_list_exist_param_title}"><i class="fa-solid fa-sliders fa-xl"></i></span>
								</div>
								<!-- ENDIF -->
								<!-- IF {LIST_ROW_YOUTUBE_ID} -->
								<div class="position-absolute top-0 end-0 m-2" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="{PHP.L.market_youtube_id_tooltip}" style="z-index: 10;">
									<a 
									data-fancybox="video-{LIST_ROW_ID}"
									data-type="iframe"
									data-src="https://www.youtube.com/watch?v={LIST_ROW_YOUTUBE_ID}"
									data-caption="{PHP.L.market_youtube_id_datacaption}"
									href="javascript:void(0);"
									class="btn btn-common btn-video px-0 mx-0"
									
									>
										<i class="fa-brands fa-square-youtube fa-2xl"></i>
									</a>
								</div>
								<!-- ENDIF -->
								<div class="ratio ratio-1x1 ratio-lg-1x1 image-container">
									<!-- IF {PHP|cot_plugin_active('attacher')} -->
									<!-- IF {LIST_ROW_ID|att_count('market', $this, '', 'images')} > 0 -->
									{LIST_ROW_ID|att_display('market',$this,'','attacher.display.marketlistfirst','images',1)}
									<!-- ELSE -->
									<img src="{PHP.R.page_default_image}" class="card-img object-fit-cover" alt="{LIST_ROW_TITLE}" loading="lazy">
									<!-- ENDIF -->
									<!-- ELSE -->
									<img src="{PHP.R.page_default_image}" class="card-img object-fit-cover" alt="{LIST_ROW_TITLE}" loading="lazy">
									<!-- ENDIF -->
									<!-- IF {PHP.item.fieldmrkt_product_status} == 'instock' -->
									<div class="col-12 position-relative">
										<div class="position-absolute bottom-0 start-50 translate-middle-x" style="z-index: 10;">
											<span class="px-2 fw-bold bg-success text-white rounded-2">{LIST_ROW_PRODUCT_STATUS}</span>
										</div>
									</div>
									<!-- ENDIF -->
								</div>
							</div>
							<div class="col-12">
								<div class="card-body d-flex flex-column h-100 p-4">
									<div class="d-flex justify-content-between align-items-center mb-2">
										<!-- IF {PHP.usr.isadmin} -->
										<span class="badge bg-info-subtle text-info px-2 py-1">{LIST_ROW_HITS}</span><span class="badge bg-info-subtle text-info px-2 py-1">{LIST_ROW_UPDATED}</span>
										<!-- ENDIF -->
										<!-- IF {PHP.usr.isadmin} OR {PHP.usr.id} === {LIST_ROW_OWNER_ID} -->
										<div class="dropdown">
											<button class="btn btn-outline-warning btn-lg rounded-circle d-flex align-items-center justify-content-center shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width:32px;height:32px;">
												<i class="fa-solid fa-ellipsis-v"></i>
											</button>
											<ul class="dropdown-menu dropdown-menu-end border shadow-sm py-2" style="min-width:280px;">
												<!-- IF {LIST_ROW_ADMIN_EDIT} -->
												<li>
													<a class="dropdown-item py-2 px-4" 
													href="{LIST_ROW_ADMIN_EDIT_URL}">
														{PHP.L.Edit}
													</a>
												</li>
												<!-- ENDIF -->
												<!-- IF {LIST_ROW_ADMIN_DELETE} -->
												<li>
													<a class="dropdown-item py-2 px-4" 
													href="{LIST_ROW_ADMIN_DELETE_URL}">
														{PHP.L.Delete}
													</a>
												</li>
												<!-- ENDIF -->
												<!-- IF {LIST_ROW_ADMIN_UNVALIDATE} -->
												<li>
													<a class="dropdown-item py-2 px-4" 
													href="{LIST_ROW_ADMIN_UNVALIDATE_URL}">
														{PHP.L.Putinvalidationqueue}
													</a>
												</li>
												<!-- ENDIF -->
											</ul>
										</div>
										<!-- ENDIF -->
									</div>
									
									<h5 class="card-title mb-2">
										<a href="{LIST_ROW_URL}" class="text-decoration-none" itemprop="url">{LIST_ROW_TITLE}</a>
									</h5>
									
									<!-- IF {LIST_ROW_DESCRIPTION} -->
									<div class="card-text text-muted small flex-grow-1">
										{LIST_ROW_DESCRIPTION}
									</div>
									<!-- ELSE -->
									<div class="card-text text-muted small flex-grow-1">
										{LIST_ROW_TEXT_CUT|strip_tags($this)}
									</div>
									<!-- ENDIF -->
									
									<!-- IF {LIST_ROW_PCOD} AND {PHP.usr.isadmin} -->
									<p class="mb-3">{PHP.L.Code}: <span class="badge bg-warning text-black">{LIST_ROW_PCOD}</span></p>
									<!-- ENDIF -->
									
									<!-- IF {LIST_ROW_COSTDFLT} > 0 -->
									<div class="d-flex align-items-center my-0">
										<hr class="flex-grow-1">
										<span class="mx-2 h3 fw-bold text-success market-price"
										data-usd-price="{LIST_ROW_COST_USD_RAW}"
										data-rate="{PHP.cfg.market.market_rate_value_to_uah}">
											{LIST_ROW_COSTDFLT}
										</span> {PHP.cfg.market.market_currency}
										<hr class="flex-grow-1 py-0">
									</div>
									<!-- ENDIF -->
									
									
									<div class="d-flex align-items-center small text-muted mt-3">
										<!-- IF {PHP|cot_plugin_active('userimages')} -->
										<!-- IF {LIST_ROW_OWNER_AVATAR_SRC} -->
										<img src="{LIST_ROW_OWNER_AVATAR_SRC}" alt="{LIST_ROW_OWNER_NICKNAME}" class="img-fluid rounded-circle" width="36" height="36" loading="lazy">
										<!-- ELSE -->
										<img src="{PHP.R.userimg_default_avatar}" alt="{LIST_ROW_OWNER_NICKNAME}" class="img-fluid rounded-circle" width="36" height="36" loading="lazy">
										<!-- ENDIF -->
										<!-- ENDIF -->
										<span class="mx-2">·</span>
										<span>{LIST_ROW_OWNER_NAME}</span>
									</div>
									
									<hr>
									<div class="row mt-3">
										<!-- IF {PHP|cot_plugin_active('mrsmorder')} -->
										<div class="col text-start">
											<a href="{MARKET_ROW_ORDER_LINK}" class="btn btn-sm btn-primary text-uppercase">{PHP.L.mrsmorder_market_order_btn}</a>
										</div>
										<!-- ENDIF -->
										<div class="col text-end">
											<a href="{LIST_ROW_URL}" class="btn btn-sm btn-outline-primary text-uppercase">{PHP.L.More}</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END: LIST_ROW -->
			</div>
			
			<!-- Пагинация -->
			<!-- IF {PAGINATION} -->
			<nav class="mt-5">
				<div class="pagination-scroll">
					<ul class="pagination justify-content-center flex-nowrap mb-0">
						{PREVIOUS_PAGE}
						{PAGINATION}
						{NEXT_PAGE}
					</ul>
				</div>
			</nav>
			<div class="text-center mt-3">
				{PHP.L.Page} {CURRENT_PAGE} {PHP.L.Of} {TOTAL_PAGES}
			</div>
			<!-- ENDIF -->
		</div>
	</div>
	<div class="col-12 position-relative" id="promo-block-bottom">
		<button type="button"
		class="promo-close-btn"
		title="{PHP.L.Close}"
		aria-label="{PHP.L.Close}"
		data-close-promo="promo-block-bottom">&times;</button>
		<!-- IF {PHP.i18n_locale} == 'ru' -->
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/inc/elektrotrytsykly-atlas/bottom-ru.tpl"}
		<!-- ENDIF -->
		<!-- IF {PHP.i18n_locale} == 'ua' -->
		{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/inc/elektrotrytsykly-atlas/bottom-ua.tpl"}
		<!-- ENDIF -->
		<!-- IF {PHP.L.market_promo_bottom_elektrotrytsykly-atlas} -->
		<div class="col-12 mb-4 mt-5">
			<p class="mb-3"><span>{PHP.L.market_promo_bottom_elektrotrytsykly-atlas} </span></p>
		</div>
		<!-- ENDIF -->
	</div>	
</div>


<script>
	(function() {
		var filterCol = document.getElementById('marketFilterCol');
		var listCol = document.getElementById('marketListCol');
		var toggleBtn = document.getElementById('filterToggleBtn');
		if (!filterCol || !listCol || !toggleBtn) return;
		
		var hideText = '{PHP.L.marketprofilter_Hide_Filter}';
		var showText = '{PHP.L.marketprofilter_Show_Filter}';
		
		function applyFilterState(visible) {
			if (visible) {
				filterCol.classList.remove('d-none');
				listCol.classList.remove('col-lg-12', 'col-xl-12');
				listCol.classList.add('col-lg-8', 'col-xl-9');
				toggleBtn.textContent = hideText;
				} else {
				filterCol.classList.add('d-none');
				listCol.classList.remove('col-lg-8', 'col-xl-9');
				listCol.classList.add('col-lg-12', 'col-xl-12');
				toggleBtn.textContent = showText;
			}
			localStorage.setItem('marketFilterHidden', visible ? 'false' : 'true');
		}
		
		// Стартовое состояние (по умолчанию фильтр видим)
		var stored = localStorage.getItem('marketFilterHidden');
		var initiallyVisible = stored !== 'true';
		applyFilterState(initiallyVisible);
		
		toggleBtn.addEventListener('click', function() {
			var isVisible = !filterCol.classList.contains('d-none');
			applyFilterState(!isVisible);
		});
	})();
</script>

<style>
	/* Гарантированное переопределение Bootstrap – основной цвет #ff5100 */
	.promo-close-btn {
    position: absolute !important;   /* принудительно absolute */
    right: 0 !important;
    top: -5px !important;           /* кнопка на 5px выше верхней границы блока */
    z-index: 1000 !important;
    width: 32px;
    height: 32px;
    padding: 0;
    border: none;
    border-radius: 50%;
    background-color: #ff5100;
    color: #fff;
    font-size: 22px;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.25);
    transition: background-color 0.2s ease, transform 0.1s ease;
    /* сброс любых браузерных и Bootstrap-стилей */
    font-family: Arial, sans-serif;
    font-weight: bold;
    text-transform: none;
    letter-spacing: normal;
    text-shadow: none;
    outline: none !important;
    box-sizing: border-box;
	}
	
	.promo-close-btn:hover,
	.promo-close-btn:focus-visible {
    background-color: #e64700;       /* затемнение основного цвета */
    transform: scale(1.08);
	}
	
	.promo-close-btn:active {
    background-color: #cc3f00;
    transform: scale(0.95);
	}
	
	/* Для уверенности, что родитель будет reference */
	.position-relative {
    position: relative;
	}
</style>
<script>
	(function() {
		'use strict';
		
		// Функция для получения чистого пути (без query-параметров и хеша)
		function getCleanPath() {
			return window.location.pathname.replace(/\/$/, '') || '/';
		}
		
		// Обработка всех кнопок закрытия
		document.querySelectorAll('[data-close-promo]').forEach(function(btn) {
			var blockId = btn.getAttribute('data-close-promo');
			var block = document.getElementById(blockId);
			if (!block) return;
			
			// Уникальный ключ: путь + ID блока
			var storageKey = 'promo-closed-' + getCleanPath() + '-' + blockId;
			
			// При загрузке: если ключ есть — сразу скрываем
			if (localStorage.getItem(storageKey)) {
				block.style.display = 'none';
			}
			
			// Клик по кнопке: скрываем и сохраняем в localStorage
			btn.addEventListener('click', function() {
				block.style.display = 'none';
				localStorage.setItem(storageKey, '1');
			});
		});
	})();
</script>
<!-- IF {SEARCH_HIGHLIGHT_ACTIVE} -->
<style>
	.search-highlight {
	font-weight: bold;
	letter-spacing: 1px;
	padding: 2px;
	color: #000 !important;
	background-color: #ffc107 !important;
	border-radius: 5px;
	}
</style>
<script>
	try {
		function highlightWords(node, regex, excludeElements) {
			if (node === null) return;
			excludeElements || (excludeElements = ['script', 'style', 'iframe', 'canvas', 'pre']);
			let child = node.firstChild;
			const callback = function(match) {
				let span = document.createElement('mark');
				span.className = 'search-highlight';
				span.textContent = match;
				return span;
			};
			while (child) {
				switch (child.nodeType) {
					case 1:
					if (excludeElements.indexOf(child.tagName.toLowerCase()) > -1) break;
					highlightWords(child, regex, excludeElements);
					break;
					case 3:
					let bk = 0;
					child.data.replace(regex, function(all) {
						let args = [].slice.call(arguments);
						let offset = args[args.length - 2];
						let newTextNode = child.splitText(offset + bk);
						let tag;
						bk -= child.data.length + all.length;
						newTextNode.data = newTextNode.data.substring(all.length);
						tag = callback.apply(window, [args[0]]);
						child.parentNode.insertBefore(tag, newTextNode);
						child = newTextNode;
					});
					regex.lastIndex = 0;
					break;
				}
				child = child.nextSibling;
			}
		}
		
		document.addEventListener('DOMContentLoaded', function() {
			var words = {SEARCH_HIGHLIGHT_WORDS};
			var scope = '{SEARCH_HIGHLIGHT_SCOPE}';
			if (words && Array.isArray(words) && words.length && scope) {
				var escapedWords = words.map(function(w) {
					if (typeof w !== 'string') return '';
					return w.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
				}).filter(function(w) { return w.length > 0; });
				if (escapedWords.length === 0) return;
				var regex = new RegExp(escapedWords.join('|'), 'gi');
				var elements = document.querySelectorAll(scope);
				elements.forEach(function(el) {
					highlightWords(el, regex);
				});
			}
		});
		} catch (e) {
		console.error('Ошибка подсветки, поиск продолжает работать:', e);
	}
</script>
<!-- ENDIF -->
<!-- END: MAIN -->

