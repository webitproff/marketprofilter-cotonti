<!-- BEGIN: MAIN -->
<!-- IF {PHP.usr.maingrp} == 5 -->
<div class="container-fluid text-center my-2">
	<div class="alert alert-info"><h2 class="fs-5 my-0">market.electric-tricycle.tpl</h2></div>
</div>
<!-- ENDIF -->
<div class="border-bottom py-3">
	<div class="container-fluid">
		<nav aria-label="breadcrumb">
			<div class="breadcrumb-scroll">
				<ol class="breadcrumb mb-0 fs-6">
					{MARKET_BREADCRUMBS_ITEM}
				</ol>
			</div>		
		</nav>
	</div>
</div>
<div class="container-fluid px-xxl-5 py-5"> 
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"} 
	<!-- BEGIN: MARKET_ADMIN -->				
	<nav class="row row-cols-auto g-2 mb-3">
		<div class="col">
			<a href="{MARKET_ADMIN_EDIT_URL}" type="button" class="btn btn-primary p-3" title="{PHP.L.market_edit_product}"
			title="{PHP.L.market_edit_product}"
			data-bs-toggle="tooltip">
				<i class="fa-solid fa-edit  fa-xl"></i>
			</a>
		</div>
		<div class="col">
			<a href="{MARKET_ADMIN_CLONE_URL}" type="button" class="btn btn-primary p-3" title="{PHP.L.market_clone}"
			title="{PHP.L.market_clone}"
			data-bs-toggle="tooltip">
				<i class="fa-solid fa-clone fa-xl"></i>
			</a>
		</div>
		
		<div class="col">
			<a href="{MARKET_ADMIN_DELETE_URL}" type="button" class="btn btn-primary p-3" title="{PHP.L.Delete}"
			title="{PHP.L.Delete}"
			data-bs-toggle="tooltip">
				<i class="fa-solid fa-trash-can fa-xl"></i>
			</a>
		</div>
		<div class="col">
			<a href="{MARKET_ADMIN_UNVALIDATE_URL}" type="button" class="btn btn-primary p-3" title="{PHP.L.Putinvalidationqueue}"
			title="{PHP.L.Putinvalidationqueue}"
			data-bs-toggle="tooltip">
				<i class="fa-solid fa-thumbtack-slash fa-xl"></i>
			</a>
		</div>
		<div class="col">
			<a href="{MARKET_CAT|cot_url('market', 'm=add&c=$this')}" type="button" class="btn btn-primary p-3" title="{PHP.L.market_addtitle}"
			title="{PHP.L.market_addtitle}"
			data-bs-toggle="tooltip">
				<i class="fa fa-plus fa-lg fa-xl"></i>
			</a>
		</div>	
		<!-- IF {PHP|cot_plugin_active('i18n4marketpro')} -->
		<!-- IF {MARKET_I18N4MARKETPRO_ADMIN_EDIT_URL} -->
		<div class="col">
			<a href="{MARKET_I18N4MARKETPRO_ADMIN_EDIT_URL}" type="button" class="btn btn-warning p-3" title="{PHP.L.i18n4marketpro_editing}"
			title="{PHP.L.i18n4marketpro_editing}"
			data-bs-toggle="tooltip">
				<i class="fa-solid fa-user-pen fa-xl"></i>
			</a>
		</div>
		<!-- ENDIF -->
		<!-- IF {MARKET_I18N4MARKETPRO_TRANSLATE_URL} -->
		<div class="col">
			<a href="{MARKET_I18N4MARKETPRO_TRANSLATE_URL}" type="button" class="btn btn-success p-3" title="{PHP.L.i18n4marketpro_translate}"
			title="{PHP.L.i18n4marketpro_translate}"
			data-bs-toggle="tooltip">
				<i class="fa-solid fa-language fa-xl"></i>
			</a>
		</div>
		<!-- ENDIF -->
		<!-- IF {MARKET_I18N4MARKETPRO_ADMIN_DELETE_URL} -->
		<div class="col">
			<a href="{MARKET_I18N4MARKETPRO_ADMIN_DELETE_URL}" type="button" class="btn btn-danger p-3" title="{PHP.L.i18n4marketpro_delete}"
			title="{PHP.L.i18n4marketpro_delete}"
			data-bs-toggle="tooltip">
				<i class="fa-regular fa-trash-can fa-xl"></i>
			</a>
		</div>
		<!-- ENDIF -->
		<!-- ENDIF -->
	</nav>
	<!-- END: MARKET_ADMIN -->
	<!-- IF {PHP.usr.isadmin} OR {PHP.usr.id} == {MARKET_OWNER_ID} -->
	<div class="row text-center mb-5">
		<div class="col-12 col-md-6 col-lg-3">
			<p class="mb-1">
				<strong>{PHP.L.Status}:</strong>
				<span class="badge bg-warning text-black">{MARKET_LOCAL_STATUS}</span>
			</p>
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<!-- IF {MARKET_HITS} -->
			<span class="badge bg-primary rounded-pill px-3 py-2 fs-6 shadow" 
			title="{PHP.L.Views}"
			data-bs-toggle="tooltip">
				<i class="fa-solid fa-thumbs-up"></i>
				{MARKET_HITS}
			</span>
			<!-- ENDIF -->
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<!-- IF {MARKET_PCOD} -->	
			<p class="mb-3">{PHP.L.Code}
				<span class="badge bg-warning text-black">{MARKET_PCOD}</span>
			</p>
			<!-- ENDIF -->
		</div>
		<div class="col-12 col-md-6 col-lg-3">
			<!-- IF {PHP|cot_plugin_active('xtradbrowmarket')} -->
			<!-- IF {MARKET_XTRA_LINK_ITEM_DROP} -->
			<a href="{MARKET_XTRA_LINK_ITEM_DROP}" target="_blank">{MARKET_XTRA_LINK_ITEM_DROP_TITLE}</a>
			<!-- ENDIF -->
			<!-- ENDIF -->
		</div>
	</div>	
	<!-- ENDIF -->
	<div class="row align-items-center mb-4">
		<div class="col-md-6 col-xl-9 col-12 col-auto">
			<!-- IF {PHP.item.fieldmrkt_product_status} == 'instock' -->
			<div class="mb-3"><span class="px-2 fw-bold bg-success text-white rounded-2">{MARKET_PRODUCT_STATUS}</span></div>
			<!-- ENDIF -->
			<!-- IF {PHP.item.fieldmrkt_product_status} == 'onorder' -->
			<span class="fw-bold text-warning-hot">{MARKET_PRODUCT_STATUS}</span>
			<!-- ENDIF -->
			<div class="card p-3 mb-5 position-relative overflow-hidden rounded-3 bg-grad-light-metallic  border-1 border-warning">
				<h1>
					<!-- IF {I18N_MXTRA_PAGE_H1} -->
					{I18N_MXTRA_PAGE_H1}
					<!-- ELSE -->
					<!-- IF {MARKET_XTRA_PAGE_H1} AND {PHP.i18n_locale} == {PHP.cfg.defaultlang} -->
					{MARKET_XTRA_PAGE_H1}
					<!-- ELSE -->
					{MARKET_TITLE}
					<!-- ENDIF -->
					<!-- ENDIF -->
				</h1>
			</div>
		</div>
		
		<div class="col-md-6 col-xl-3 col-12 mt-3 mt-md-0 text-lg-end px-lg-4">
			<!-- IF {MARKET_COSTDFLT} > 0 -->
			<span class="price-label">{PHP.L.market_price_supplier_coverted}</span>
			<div class="d-flex align-items-center my-4">
				<hr class="flex-grow-1">
				<span class="ms-2 h3 fw-bold text-success market-price"
				data-usd-price="{MARKET_COST_USD_RAW}"
				data-rate="{PHP.cfg.market.market_rate_value_to_uah}">
					{MARKET_COSTDFLT} 
				</span> <span class="mx-2 fw-bold">{PHP.cfg.market.market_currency}</span> 
				<hr class="flex-grow-1">
			</div>			
			<!-- ENDIF -->
			
			<!-- IF {PHP.usr.isadmin} OR {PHP.usr.id} == {MARKET_OWNER_ID} -->
			<!-- IF {MARKET_COST_USD} > 0 -->
			<div class="text-muted small">
				{PHP.L.market_price_supplier}: {MARKET_COST_USD_FORMATTED} USD
			</div>
			<!-- ENDIF -->
			<!-- ENDIF -->
			
			<!-- IF {MARKET_PRODUCT_STATUS} -->
			
			<!-- IF {PHP.item.fieldmrkt_product_status} == 'unknown' -->
			<div class="p-2 mb-3 bg-secondary-subtle text-secondary-emphasis text-center rounded-3" title="{MARKET_PRODUCT_STATUS_TITLE}">{MARKET_PRODUCT_STATUS}</div>
			<!-- ENDIF -->
			
			<!-- IF {PHP.item.fieldmrkt_product_status} == 'outofstock' -->
			<div class="p-2 mb-3 bg-secondary text-white text-center rounded-3" title="{MARKET_PRODUCT_STATUS_TITLE}">{MARKET_PRODUCT_STATUS}</div>
			<!-- ENDIF -->
			
			<!-- IF {PHP.item.fieldmrkt_product_status} == 'ending' -->
			<div class="p-2 mb-3 bg-warning text-dark text-center rounded-3" title="{MARKET_PRODUCT_STATUS_TITLE}">{MARKET_PRODUCT_STATUS}</div>
			<!-- ENDIF -->
			
			<!-- ENDIF -->
			
			<!-- IF {PHP|cot_plugin_active('mrsmorder')} -->
			<div class="position-relative">
				<!-- IF {PHP.usr.maingrp} == 5 -->
				<div class="position-absolute top-0 start-0 translate-middle">
					<a type="button" class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" data-bs-toggle="modal" data-bs-target="#marketOrderBtnHelpModal" title="{PHP.L.Help}">
						<i class="fa-solid fa-triangle-exclamation fa-2xl text-secondary"></i>
					</a>
				</div>
				<!-- ENDIF -->
				<div class="m-2">
					<!-- IF {PHP.item.fieldmrkt_product_status} == 'instock' -->
					<a href="{MARKET_ORDER_LINK}" class="btn btn-modern-green w-100 text-uppercase px-4 py-3" title="{PHP.L.mrsmorder_market_order_btn}" style="letter-spacing: 2px;">
						{PHP.L.mrsmorder_market_order_btn}
					</a>
					<!-- ELSE -->
					<button type="button" class="btn btn-outline-secondary w-100 text-uppercase px-4 py-3" title="{PHP.L.mrsmorder_market_order_btn}" disabled >
						{PHP.L.mrsmorder_market_order_btn}
					</button>
					<!-- ENDIF -->
				</div>
			</div>
			<!-- ENDIF -->
			<div class="mt-5">
				<button class="btn btn-sm btn-outline-secondary copy-btn w-100"
				onclick="copyProductLink(this)"
				data-title="{PHP|htmlspecialchars({PHP.item.fieldmrkt_title})}"
				data-metatitle="{PHP|htmlspecialchars({PHP.item.fieldmrkt_metatitle})}"
				data-url="{PHP.cfg.mainurl}/{PHP.item.fieldmrkt_pageurl}"
				data-bs-toggle="tooltip"
				data-bs-placement="top"
				data-bs-title="{PHP.langSkStr.tools_copy_link_title}">
					<i class="fa-regular fa-copy me-2"></i> {PHP.langSkStr.tools_copy_link} <i class="fa-solid fa-link ms-2"></i>
				</button>		
			</div>	
		</div>	
	</div>
	
	
	<!-- IF {MARKET_DESCRIPTION} -->
	<div class="mb-3"><p class="font-monospace fs-5">{MARKET_DESCRIPTION}</p></div>	
	<!-- ENDIF -->
	<!-- IF {PHP.i18n4marketpro_locale} !== {PHP.cfg.defaultlang} -->
	<div class="mb-3">
		<a href="{MARKET_I18N_ORIGINAL_URL_FULL}" title="Читати українською мовою опис товару {MARKET_I18N_ORIGINAL_TITLE}">
			<div class="text-bg-info p-3">Українською</div>
			<div class="text-bg-warning p-3"> мовою</div>
		</a>
	</div>
	<!-- ENDIF -->
	<div class="d-flex align-items-center my-4">
		<hr class="flex-grow-1">
		<span class="px-2 small text-uppercase">{PHP.cfg.maintitle}</span>
		<hr class="flex-grow-1">
	</div>
	<!-- IF {PHP.pag_i18n4marketpro_locales} > 1 -->
	<!-- BEGIN: I18N4MARKETPRO_LANG -->
	<p class="mb-3"><i class="fa-solid fa-hands-asl-interpreting fa-xl me-2 text-success"></i><strong>{PHP.L.i18n4marketpro_translations_items}:</strong></p>
	<div class="row row-cols-auto">
		<!-- BEGIN: I18N4MARKETPRO_LANG_ROW -->
		<!-- IF {PHP.i18n4marketpro_locale} != {I18N4MARKETPRO_LANG_ROW_CODE} -->
		<div class="col">
			<a href="{I18N4MARKETPRO_LANG_ROW_URL_MODIFIED}" title="{I18N4MARKETPRO_LANG_ROW_ALTTITLE_MODIFIED}" class="btn btn-sm btn-custom-hot-outline text-uppercase">
				<i class="fa-solid fa-language me-2"></i>{I18N4MARKETPRO_LANG_ROW_TITLE}
			</a>
		</div>
		<!-- ENDIF -->
		<!-- END: I18N4MARKETPRO_LANG_ROW -->
	</div>
	<!-- END: I18N4MARKETPRO_LANG -->
	<!-- ENDIF -->
	<div class="card position-relative overflow-hidden rounded-3 bg-grad-blue-cyan text-white border-0 my-4" id="notificationCard">
		<div class="position-absolute top-0 start-0">
			<button type="button" title="{PHP.L.Close}" class="m-3 p-3 btn-close btn btn-dander close-notificationCard" aria-label="Close"></button>
		</div>
		<div class="card-body text-center">
			<i class="fa-solid fa-baby fa-2xl mb-5" title="{PHP.langSkStr.telegram_icon_title_just_born}"></i>
			<p class="fs-5 fw-light opacity-75">{PHP.langSkStr.telegram_alert_text}</p>
		</div>
		<div class="hex-mask"></div>
	</div>
	<div class="row pt-5">
		<div class="col-12 col-md-8 mx-auto pb-5">
			<div class="mb-5 col-12">
				<div class="position-relative">
					<div class="position-absolute top-0 start-50 translate-middle">
						<a type="button" class="link-info link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" data-bs-toggle="modal" data-bs-target="#marketFotoHelpModal" title="{PHP.L.Help}">
							<i class="fa-solid fa-circle-question fa-2xl"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="context-tools-js">
				<div class="mb-4">
					<!-- IF {PHP|cot_plugin_active('attacher')} -->
					<!-- IF {MARKET_ID|att_count('market', $this, '', 'images')} > 0 -->
					<div class="mb-3">{MARKET_ID|att_display('market', $this, '', 'attacher.display.marketgrid.first', 'images', '0')}</div>
					<!-- ENDIF -->
					<!-- ELSE -->
					<div class="position-relative overflow-hidden rounded-5 shadow-bottom" style="aspect-ratio: 2 / 1; background-image: url('{PHP.R.page_default_image}'); background-size: cover; background-position: center;"></div>
					<!-- ENDIF -->
				</div>
				<!-- IF {PHP|cot_plugin_active('marketprofilter')} AND {PARAM_VALUE} -->
				<div class="mb-4">
					<p class="mt-5">
						<!-- IF {I18N_MXTRA_META_TITLE} --><span class="fw-semibold text-primary">{I18N_MXTRA_META_TITLE}</span>,<!-- ELSE--><span class="fw-semibold text-warning-hot">{MARKET_METATITLE}</span>,<!-- ENDIF --> 	
						<span>{PHP.L.marketprofilter_market_paramsItem_desc}</span>
					</p>
					<div class="card mb-5 position-relative overflow-hidden rounded-3 bg-grad-light-metallic text-white border-1 border-warning">
						<div class="list-group list-group-striped list-group-flush">
							<!-- BEGIN: MARKET_FILTER_PARAMS -->
							<div class="list-group-item {PARAM_NAME}">
								<div class="row g-3">
									<div class="col-12 col-md-6">
										<!-- IF {PARAM_HELP} -->
										<a href="#" data-bs-toggle="modal" data-bs-target="#helpModal_{PARAM_NAME}" class="me-2" title="{PHP.L.marketprofilter_param_helpinfo}">
											<i class="fa-solid fa-circle-question text-info"></i>
										</a>
										<div class="modal fade" id="helpModal_{PARAM_NAME}" tabindex="-1" aria-labelledby="helpModalLabel_{PARAM_NAME}" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">{PARAM_TITLE}</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">{PARAM_HELP}</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{PHP.L.Close}</button>
													</div>
												</div>
											</div>
										</div>
										<!-- ENDIF -->
										{PARAM_TITLE}
									</div>
									<div class="col-12 col-md-6">
										<mark> <span class="px-2 font-monospace">{PARAM_VALUE}</span> </mark>
									</div>
								</div>
							</div>
							<!-- END: MARKET_FILTER_PARAMS -->
							<div class="list-group-item">
								<div class="row g-3">
									<div class="col-12 col-md-6">
										<span class="px-2">{PHP.L.market_date_published} </span> 
									</div>
									<div class="col-12 col-md-6">
										<mark> <span class="px-2">						
											<span class="font-monospace">{MARKET_CREATED}</span>
										</span> </mark>
									</div>
								</div>
							</div>
							<!-- IF {MARKET_UPDATED} -->
							<div class="list-group-item">
								<div class="row g-3">
									<div class="col-12 col-md-6">
										<span class="px-2">{PHP.L.market_latest_update}</span> 
									</div>
									<div class="col-12 col-md-6">
										<mark> <span class="px-2">						
											<span class="font-monospace">{MARKET_UPDATED}</span>
										</span> </mark>
									</div>
								</div>
							</div>
							<!-- ENDIF -->	
							<div class="list-group-item">
								<div class="row g-3">
									<div class="col-12 col-md-6">
										<span class="px-2">{PHP.L.market_main_category}</span> 
									</div>
									<div class="col-12 col-md-6">
										<mark> 
											<span class="px-2">
												<a href="{MARKET_CAT_URL}" title="{PHP.L.market_electric-tricycle_link_cat_title_in_filter}">
													<span class="fw-semibold font-monospace">{MARKET_CAT_TITLE}</span>
												</a>
											</span>
										</mark>
									</div>
								</div>
							</div>
							<div class="list-group-item">
								<div class="row g-3">
									<div class="col-12 col-md-6">
										<span class="px-2">{PHP.L.market_point_of_trade}</span> 
									</div>
									<div class="col-12 col-md-6">
										<mark> 
											<span class="px-2">
												<a href="{PHP.cfg.mainurl}<!-- IF {PHP.i18n_locale} !== {PHP.cfg.defaultlang} -->/{PHP.i18n_locale}/<!-- ENDIF -->" title="{PHP.L.market_point_of_trade_link_title}">
													<span class="fw-semibold font-monospace">{PHP.L.market_point_of_trade_name}</span>
												</a>
											</span>
										</mark>
									</div>
								</div>
							</div>
						</div>
						<div class="hex-mask"></div>
					</div>
				</div>
				<!-- ENDIF -->
				<!-- Навигация вкладками (pills) -->
				<ul class="nav nav-pills flex-column flex-sm-row mb-4 gap-2" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="btn btn-outline-success w-100 active" 
						id="pills-text-tab" 
						data-bs-toggle="pill" 
						data-bs-target="#pills-text" 
						type="button" 
						role="tab" 
						aria-controls="pills-text" 
						aria-selected="true">
							<i class="fa-regular fa-file-alt me-1"></i> {PHP.L.market_tab_text_title}
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="btn btn-outline-info w-100" 
						id="pills-cost-tab" 
						data-bs-toggle="pill" 
						data-bs-target="#pills-cost" 
						type="button" 
						role="tab" 
						aria-controls="pills-cost" 
						aria-selected="false">
							<i class="fa-solid fa-money-bill-trend-up me-1"></i> {PHP.L.market_tab_cost_title}
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="btn btn-outline-secondary w-100" 
						id="pills-dostavka-tab" 
						data-bs-toggle="pill" 
						data-bs-target="#pills-dostavka" 
						type="button" 
						role="tab" 
						aria-controls="pills-dostavka" 
						aria-selected="false">
							<i class="fa-solid fa-truck me-1"></i> {PHP.L.market_tab_delivery_title}
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="btn btn-outline-secondary w-100" 
						id="pills-oplata-tab" 
						data-bs-toggle="pill" 
						data-bs-target="#pills-oplata" 
						type="button" 
						role="tab" 
						aria-controls="pills-oplata" 
						aria-selected="false">
							<i class="fa-solid fa-credit-card me-1"></i> {PHP.L.market_tab_payment_title}
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="btn btn-outline-secondary w-100" 
						id="pills-return-tab" 
						data-bs-toggle="pill" 
						data-bs-target="#pills-return" 
						type="button" 
						role="tab" 
						aria-controls="pills-return" 
						aria-selected="false">
							<i class="fa-solid fa-person-walking-arrow-loop-left me-1"></i> {PHP.L.market_tab_return_title}
						</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="btn btn-outline-warning-hot text-uppercase w-100" 
						id="pills-warranty-tab" 
						data-bs-toggle="pill" 
						data-bs-target="#pills-warranty" 
						type="button" 
						role="tab" 
						aria-controls="pills-warranty" 
						aria-selected="false">
							<i class="fa-solid fa-shield-halved me-1"></i> {PHP.L.market_tab_warranty_title}
						</button>
					</li>
					<!-- Новая кнопка (не таб) -->
					<!-- IF {MARKET_YOUTUBE_ID} -->
					<li class="nav-item" role="presentation">
						<div data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="{PHP.L.market_youtube_id_tooltip}">
							<a href="https://www.youtube.com/watch?v={MARKET_YOUTUBE_ID}" 
							data-fancybox="video" 
							data-type="iframe" 
							data-caption="{PHP.L.market_youtube_id_datacaption}" 
							class="btn btn-common btn-video w-100">
								<i class="fa-brands fa-square-youtube mx-2"></i>
								<span>{MARKET_YOUTUBE_ID_TITLE}</span>
							</a>
							
						</div>
					</li>
					<!-- ENDIF -->
					<!-- Новая кнопка (не таб) -->
					<!-- IF {MARKET_FORUM_LINK} -->
					<li class="nav-item" role="presentation">
						
						<div data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="{PHP.L.market_forum_link_tooltip}">
							<a 
							href="{MARKET_FORUM_LINK}"
							class="btn btn-common btn-forum w-100"
							>
								<i class="fa-solid fa-person-circle-question mx-2"></i>
								<span>{MARKET_FORUM_LINK_TITLE}</span>
							</a>
						</div>
					</li>
					<!-- ENDIF -->	
				</ul>
				<!-- Контент вкладок -->
				<div class="tab-content mb-5" id="pills-tabContent">
					<!-- text -->
					<div class="tab-pane fade show active" 
					id="pills-text" 
					role="tabpanel" 
					aria-labelledby="pills-text-tab">
						<div class="card mb-4 border-0">
							<div class="card-body message-body">  
								<div class="mb-3" id="protected-block">
									
									{MARKET_TEXT}
									<!-- IF {MARKET_BUY_DESCRIPTION} -->
									{MARKET_BUY_DESCRIPTION}
									<!-- ENDIF -->
								</div>
								<div class="d-flex align-items-center my-4">
									<hr class="flex-grow-1">
									<span class="px-2 small text-uppercase">{PHP.cfg.maintitle}</span>
									<hr class="flex-grow-1">
								</div>
								{PHP.L.market_electric-mopeds_promo_bottom} 
								<!-- IF {PHP|cot_plugin_active('marketreviews')} -->
								<div><span class="small">{PHP.L.marketreviews_pageRatingValue}:</span> <span class="review-stars">{MARKET_REVIEWS_AVG_STARS_HTML}</span></div>
								<div><span class="small">{PHP.L.marketreviews_pageCountStarsTotalValue}:</span> {MARKET_REVIEWS_STARS_SUMM}</div>
								<div><span class="small">{PHP.L.marketreviews_pageCountReviewsTotalValue}:</span> {MARKET_REVIEWS_TOTAL_COUNT}</div>
								<div><span class="small">{PHP.L.marketreviews_pageAverageRatingValue}:</span> {MARKET_REVIEWS_AVG_STARS}</div>
								<!-- ENDIF -->
							</div>	
						</div>
					</div>
					<!-- cost -->
					<div class="tab-pane fade" 
					id="pills-cost" 
					role="tabpanel" 
					aria-labelledby="pills-cost-tab">
						<div class="card mb-4 border-0">
							<div class="card-body message-body">
								{PHP.L.market_tab_cost_content}
							</div>
						</div>
					</div>
					<!-- dostavka -->
					<div class="tab-pane fade" 
					id="pills-dostavka" 
					role="tabpanel" 
					aria-labelledby="pills-dostavka-tab">
						<div class="card mb-4 border-0">
							<div class="card-body message-body">
								{PHP.L.market_tab_delivery_content}
							</div>
						</div>
					</div>
					<!-- oplata -->
					<div class="tab-pane fade" 
					id="pills-oplata" 
					role="tabpanel" 
					aria-labelledby="pills-oplata-tab">
						<div class="card mb-4 border-0">
							<div class="card-body message-body">
								{PHP.L.market_tab_payment_content}
							</div>
						</div>
					</div>
					<!-- return -->
					<div class="tab-pane fade" 
					id="pills-return" 
					role="tabpanel" 
					aria-labelledby="pills-return-tab">
						<div class="card mb-4 border-0">
							<div class="card-body message-body">
								{PHP.L.market_tab_return_content}
							</div>
						</div>
					</div>
					<div class="tab-pane fade" 
					id="pills-warranty" 
					role="tabpanel" 
					aria-labelledby="pills-warranty-tab">
						<div class="card mb-4 border-0">
							<div class="card-body message-body">
								{PHP.L.market_tab_warranty_content}
							</div>
						</div>
					</div>
				</div>
				
				
				
				<!-- IF {PHP|cot_plugin_active('attacher')} -->
				<!-- IF {MARKET_ID|att_count('market', $this, '', 'files')} > 0 -->
				<div class="mb-4" data-att-downloads="download">
					<h5>{PHP.L.att_attachments} {PHP.L.att_downloads}</h5> 
					{MARKET_ID|att_downloads('market', $this)}
				</div>
				<!-- ENDIF -->
				<!-- ENDIF -->
				<!-- IF {PHP|cot_plugin_active('marketreviews')} -->
				{MARKET_REVIEWS} 
				<hr />
				<!-- ENDIF --> 
				<!-- IF {PHP|cot_plugin_active('comments')} --> 
				{MARKET_COMMENTS}
				<!-- ENDIF -->
			</div>
		</div>
		<div class="col-12 col-md-4">
			<!-- IF {PHP|cot_plugin_active('payordersmarket')} AND {PHP.usr.id} -->
			<!-- IF !{MARKET_ORDER_IN_CART} -->
			<a href="javascript:void(0)" class="btn btn-success add-to-cart" data-id="{MARKET_ID}">
				{PHP.L.payordersmarket_add_to_cart}
			</a>
			<span class="cart-added-msg text-success ms-2" style="display:none;">{PHP.L.payordersmarket_added_to_cart}</span>
			<!-- ELSE -->
			<span class="btn btn-secondary">{PHP.L.payordersmarket_in_cart}</span>
			<!-- ENDIF -->
			<!-- ENDIF -->
			
			<!-- IF {PHP|cot_plugin_active('payordersmarket')} AND {PHP|cot_auth('plug', 'payordersmarket', 'R')} AND {PHP.usr.id} == 0 -->
			<a class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#authModal">{PHP.L.payordersmarket_add_to_cart}</a>
			<!-- ENDIF -->
			
			<!-- IF {MARKET_ORDER_FILE_LOCALSTATUS} -->
			<p class="text-truncate"><span class="badge bg-info small">{MARKET_ORDER_FILE_LOCALSTATUS}</span></p>
			
			<!-- ENDIF -->
			<!-- IF {MARKET_ORDER_FILE_NAME} -->
			<p><span class="badge bg-info small text-truncate text-black">{MARKET_ORDER_FILE_NAME}</span></p>
			<p>{PHP.L.payordersmarket_product_file_count_of_downloads} <span class="badge bg-info text-black">{MARKET_ORDER_DOWNLOAD_COUNT}</span></p>
			<!-- ENDIF -->	
			
			<!-- IF {MARKET_STATE} == 0 -->
			<!-- IF {PHP|cot_plugin_active('payordersmarket')} AND {PHP|cot_auth('plug', 'payordersmarket', 'R')} -->
			<!-- IF {MARKET_ORDER_ID} -->
			<div class="alert alert-info">
				<h3 class="h5 mb-2"><a href="{MARKET_ORDER_URL}"><i class="fa-solid fa-paperclip fa-lg"></i> {PHP.L.payordersmarket_product_order_num} {MARKET_ORDER_ID}</a></h3>
				<p> <span class="badge bg-warning text-black">{MARKET_ORDER_LOCALSTATUS}</span></p>	
				<!-- IF {MARKET_ORDER_DOWNLOAD} -->
				<p><a class="btn btn-success" href="{MARKET_ORDER_DOWNLOAD}">{PHP.L.payordersmarket_product_file_download}</a></p>
				<!-- ENDIF -->
			</div>
			<!-- ENDIF -->
			<!-- Если есть последний заказ для товара -->
			<!-- Проверяем наличие тега ORDER_ORDER_LAST_ID -->
			<!-- IF {MARKET_ORDER_ORDER_LAST_ID} -->
			<div class="alert alert-info">
				<h3 class="h5 mb-2">
					<a href="{MARKET_ORDER_ORDER_LAST_URL}">
						<i class="fa-solid fa-paperclip fa-lg"></i> 
						{PHP.L.payordersmarket_product_last_order_num} {MARKET_ORDER_ORDER_LAST_ID}
					</a>
				</h3>
			</div>
			<!-- ENDIF -->	
			<!-- ENDIF -->
			<!-- ENDIF -->
			
			<!-- IF {PHP|cot_plugin_active('marketprice')} -->
			{MARKETPRICE_PRICES}
			<hr>
			<!-- ENDIF -->
			
			<!-- BEGIN: MARKET_MULTI -->
			<div class="card mb-4">
				<div class="card-header">
					<h2 class="h5 mb-0">{PHP.L.Summary}</h2>
				</div>
				<div class="card-body"> 
					{MARKET_MULTI_TABTITLES} 
					<nav class="my-4" aria-label="Article pagination">
						<ul class="pagination justify-content-center pagination-md">
							{MARKET_MULTI_TABNAV}
						</ul>
					</nav>
				</div>
			</div>
			<!-- END: MARKET_MULTI -->
			
			
			<div class="card mb-4">
				<h2 class="h5 card-header">{PHP.L.market_seller}</h2>
				<div class="card-body">
					<div data-user-id="{MARKET_OWNER_ID}" class="user-details-header-insmall d-flex flex-column flex-sm-row text-sm-start text-center mb-3">
						<div class="flex-shrink-0 mx-sm-0 mx-auto">
							<!-- IF {PHP|cot_plugin_active('userimages')} -->
							<!-- IF {MARKET_OWNER_AVATAR_SRC} -->
							<img src="{MARKET_OWNER_AVATAR_SRC}"
							alt="{MARKET_OWNER_NICKNAME}"
							class="d-block h-auto rounded-4 user-details-img"
							width="96"
							height="96" loading="lazy" />
							<!-- ELSE -->
							<img src="{PHP.R.userimg_default_avatar}"
							alt="{MARKET_OWNER_NICKNAME}"
							class="d-block h-auto rounded-4 user-details-img"
							width="96"
							height="96" />
							<!-- ENDIF -->
							<!-- ENDIF -->
						</div>
						<div class="flex-grow-1 mt-3">
							<div
							class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-3 flex-md-row flex-column">
								<div class="user-details-info">
									<a href="{MARKET_OWNER_DETAILS_URL}">
										<!-- IF {MARKET_OWNER_FIRSTNAME} -->
										<h4 class="mb-2">
											<!-- IF {MARKET_OWNER_FIRSTNAME} -->{MARKET_OWNER_FIRSTNAME}<!-- ENDIF --> 
											<!-- IF {MARKET_OWNER_LASTNAME} -->{MARKET_OWNER_LASTNAME}<!-- ENDIF -->
										</h4>
										<!-- ELSE -->
										<h4 class="mb-2">
											{MARKET_OWNER_NICKNAME}
										</h4>
										<!-- ENDIF -->
									</a>
									<ul
									class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
										<li class="list-inline-item">
											<i class="fas fa-calendar me-2 icon-24px"></i><span class="fw-medium">{PHP.langSkStr.usersJoined} {MARKET_OWNER_REGDATE_STAMP|cot_date('F Y', $this)}</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row justify-content-between">
						<div class="col-md-auto text-center text-md-start">
							<!-- IF {PHP|cot_plugin_active('whosonline')} -->
							<!-- IF {MARKET_OWNER_ONLINE} -->
							<p class="my-2">
								<span class="badge text-bg-success">{PHP.L.Online}</span>
							</p>
							<!-- ELSE -->
							<p class="my-2">
								<span class="badge text-bg-secondary">{PHP.L.Offline}</span>
							</p>
							<!-- ENDIF -->
							<!-- ENDIF -->
						</div>
						<div class="col-md-auto text-center text-md-end">
							<p class="small">{PHP.L.Lastlogged}: {MARKET_OWNER_LASTLOG}</p>
						</div>
					</div>
					<!-- IF {PHP|cot_plugin_active('userfields')} -->						
					<div class="row mb-3">
						<div class="list-group list-group-striped list-group-flush mb-4">
							<!-- IF {USERFIELDS_PROMO_TEXT} -->
							<li class="list-group-item list-group-item-action ">
								<div class="row g-3">
									<div class="col-12">
										<h5 class="mb-0 fs-6 text-secondary fw-semibold">
											{USERFIELDS_PROMO_TEXT_TITLE}
										</h5>
									</div>
									<div class="col-12">
										<div>
											<p><i class="fa-solid fa-list-check fa-lg me-2"></i><small class="text-wrap text-hyphen">{USERFIELDS_PROMO_TEXT}</small></p>
										</div>
									</div>
								</div>
							</li>
							<!-- ENDIF -->
							<!-- IF {USERFIELDS_GITHUB} -->
							<li class="list-group-item list-group-item-action ">
								<div class="row g-3">
									<div class="col-12">
										<h5 class="mb-0 fs-6 text-secondary">
											{USERFIELDS_GITHUB_TITLE}
										</h5>
									</div>
									<div class="col-12">
										<div>
											<a rel="noopener noreferrer" href="https://github.com/{USERFIELDS_GITHUB}" target="_blank" class="fw-semibold">
												<i class="fa-brands fa-square-github fa-xl me-2"></i>{PHP.L.userfields_github_details}
											</a>
										</div>
									</div>
								</div>
							</li>
							<!-- ENDIF -->
							<!-- IF {USERFIELDS_TELEGRAM} -->
							<li class="list-group-item list-group-item-action ">
								<div class="row g-3">
									<div class="col-12">
										<h5 class="mb-0 fs-6 text-secondary">
											{USERFIELDS_TELEGRAM_TITLE}
										</h5>
									</div>
									<div class="col-12">
										<div>
											<a rel="noopener noreferrer" href="https://t.me/{USERFIELDS_TELEGRAM}" target="_blank" class="fw-semibold">
												<i class="fa-brands fa-telegram fa-xl me-2"></i>{PHP.L.userfields_telegram_details}
											</a>
										</div>
									</div>
								</div>
							</li>
							<!-- ENDIF -->
						</div>
					</div>
					<!-- ENDIF -->
					<ul class="list-group list-group-flush">
						<!-- IF {PHP|cot_module_active('pm')} AND {PHP.usr.id} > 0 AND {PHP.usr.id} != {MARKET_OWNER_ID} -->
						<li class="list-group-item px-0">
							<a href="{PHP.item.user_id|cot_url('pm','m=send&to=$this', '', 1)}"><i class="fa-regular fa-envelope fa-xl me-3"></i> {PHP.L.users_sendpm}</a>
						</li>
						<!-- ENDIF -->
						
						
						<!-- IF {PHP.usr.id} == {MARKET_OWNER_ID} -->
						<!-- IF {PHP.usr.id|cot_auth('market', '', 'W')} -->
						<!-- IF {PHP.usr.auth_write} -->
						<li class="list-group-item px-0">
							<a href="{MARKET_CAT|cot_url('market', 'm=add&c=$this')}">{PHP.L.market_addtitle}</a>
						</li>
						<!-- ENDIF -->
						<li class="list-group-item px-0">
							<a href="{MARKET_ID|cot_url('market', 'm=edit&id=$this')}">{PHP.L.Edit}</a>
						</li>
						<!-- IF {MARKET_I18N4MARKETPRO_ADMIN_EDIT_URL} -->
						<li class="list-group-item">
							<a href="{MARKET_I18N4MARKETPRO_ADMIN_EDIT_URL}" class="btn btn-warning">{PHP.L.i18n4marketpro_editing}</a>
						</li>
						<!-- ENDIF -->
						
						<!-- IF {MARKET_I18N4MARKETPRO_TRANSLATE_URL} -->
						<li class="list-group-item">
							<a href="{MARKET_I18N4MARKETPRO_TRANSLATE_URL}" class="btn btn-danger">{PHP.L.i18n4marketpro_translate}</a>
						</li>
						<!-- ENDIF -->
						<!-- ENDIF -->
						<!-- ENDIF -->
						<!-- ENDIF -->
					</ul>			
				</div>
			</div>
			<!-- IF {PHP|cot_plugin_active('featuredproducts')} AND {FEATURED_PRODUCTS_TRUE} -->
			{FEATURED_PRODUCTS_PAGES}
			<!-- ENDIF -->
			
			<!-- IF {PHP|cot_plugin_active('featuredpagesmarket')} AND {FEATUREDPRO_ARTICLES_TRUE} -->
			{FEATUREDPRO_ARTICLES_PAGES}
			<!-- ENDIF -->
			
		</div>
		<!-- IF {PHP|cot_plugin_active('tgm4market')} AND {PHP.chat_id} -->
		<div class="row justify-content-center">
			<div class="col-12 col-md-10 col-lg-8 mx-auto">
				<div class="card mb-4 position-relative overflow-hidden rounded-3 bg-grad-lime-green text-white border-0 bg-border-gradient">
					<div class="card-body  p-3 text-center">
						<i class="fa-brands fa-telegram fa-2xl mb-3"></i> 
						<h4 class="h5 mb-0 fw-medium opacity-75 mb-3">{PHP.L.tgm4market_discussion_title}</h4>
						<div class="overflow-hidden rounded-3 bg-light">{TGM4MARKET_DISCUSSION}</div>
					</div>
					<div class="hex-mask"></div>
				</div>
			</div>
		</div>
		<!-- ENDIF -->
	</div>
	<!-- IF {PHP|cot_plugin_active('featuredtopicsmarket')} AND {RECOMMENDED_FR_TOPIC_MARKET_TOPICS_TRUE} -->
	<div class="row justify-content-center">
		<div class="col-12 col-md-10 col-lg-8 mx-auto">
			{RECOMMENDED_FR_TOPIC_MARKET_TOPICS}
		</div>
	</div>
	<!-- ENDIF -->
	<blockquote>
		<p>{PHP.cfg.market.marketlist_default_title}</p>
		<p>{PHP.cfg.market.marketlist_default_desc}</p>
	</blockquote>
</div>

<script>
	function copyProductLink(btn) {
		var title = btn.dataset.title;
		var metaTitle = btn.dataset.metatitle;
		var url = btn.dataset.url;
		var langString = '{PHP.langSkStr.tools_copy_preff_title}';
		
		// Экранирование только для атрибутов
		function escapeAttr(str) {
			if (!str) return '';
			return str.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#39;');
		}
		
		var plainTitle = title;
		if (!plainTitle || plainTitle.trim() === '') {
			var slug = url.split('/').pop();
			plainTitle = decodeURIComponent(slug.replace(/[-_]/g, ' '));
		}
		var plainMeta = metaTitle || plainTitle;
		
		// Текст ссылки НЕ экранируем
		var html = '<a href="' + escapeAttr(url) + '" title="' + escapeAttr(langString + (metaTitle || '')) + '">' + title + '</a>';
		var plain = '<a href="' + escapeAttr(url) + '" title="' + escapeAttr(langString + plainMeta) + '">' + plainTitle + '</a>';
		
		if (navigator.clipboard && navigator.clipboard.write) {
			var clipboardItem = new ClipboardItem({
				'text/html': new Blob([html], { type: 'text/html' }),
				'text/plain': new Blob([plain], { type: 'text/plain' })
			});
			navigator.clipboard.write([clipboardItem]).then(success).catch(function() { fallback(plain); });
			} else {
			fallback(plain);
		}
		
		function success() {
			btn.innerText = '{PHP.langSkStr.tools_copy_done}';
			btn.classList.remove('btn-primary');
			btn.classList.add('btn-success');
			setTimeout(function() {
				btn.innerText = '{PHP.langSkStr.tools_copy_link}';
				btn.classList.remove('btn-success');
				btn.classList.add('btn-primary');
			}, 2000);
		}
		
		function fallback(text) {
			var textarea = document.createElement('textarea');
			textarea.value = text;
			document.body.appendChild(textarea);
			textarea.select();
			try {
				document.execCommand('copy');
				success();
				} catch (err) {
				btn.innerText = 'Ошибка копирования';
			}
			document.body.removeChild(textarea);
		}
	}
</script>
<script>
	// Скрипт для переключения вкладок (если Bootstrap JS не используется или для надёжности)
	(function() {
		const tabs = document.querySelectorAll('#pills-tab .nav-link');
		const panes = document.querySelectorAll('.tab-pane');
		
		function activateTab(tabId) {
			// Убираем активные классы у всех кнопок
			tabs.forEach(tab => {
				tab.classList.remove('active');
				tab.setAttribute('aria-selected', 'false');
			});
			// Убираем активные классы у всех панелей
			panes.forEach(pane => {
				pane.classList.remove('show', 'active');
			});
			
			// Активируем выбранную кнопку
			const targetButton = document.querySelector(`#pills-tab .nav-link[data-bs-target="${tabId}"]`);
			if (targetButton) {
				targetButton.classList.add('active');
				targetButton.setAttribute('aria-selected', 'true');
			}
			// Активируем нужную панель
			const targetPane = document.querySelector(tabId);
			if (targetPane) {
				targetPane.classList.add('show', 'active');
			}
		}
		
		// Добавляем обработчики на каждую кнопку
		tabs.forEach(tab => {
			tab.addEventListener('click', function(e) {
				e.preventDefault();
				const target = this.getAttribute('data-bs-target');
				if (target) activateTab(target);
			});
		});
	})();
</script>
<script>
    (function() {
        // Ключ для localStorage
        const STORAGE_KEY = 'cardClosed';
		
        // Находим блок карточки
        const card = document.getElementById('notificationCard');
        if (!card) return;
		
        // Функция скрытия карточки
        function hideCard() {
            card.style.display = 'none';
		}
		
        // Проверяем localStorage при загрузке
        const isClosed = localStorage.getItem(STORAGE_KEY);
        if (isClosed === 'true') {
            hideCard();
		}
		
        // Находим кнопку внутри карточки
        const closeBtn = card.querySelector('.close-notificationCard');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                // Сохраняем в localStorage
                localStorage.setItem(STORAGE_KEY, 'true');
                // Скрываем карточку
                hideCard();
			});
		}
	})();
</script>
<!-- END: MAIN -->

