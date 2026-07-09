<!--
	/********************************************************************************
	* File: marketprofilter.filterform.electric-scooters.tpl
	* Extension: plugin 'marketprofilter'
	* Description: HTML template формы фильтрации товаров для категории с кодом 'electric-scooters'.
	* Compatibility: CMF/CMS Cotonti v.1+ (https://github.com/Cotonti/Cotonti)
	* Dependencies: 
	* 		 Bootstrap 5.3.+       (https://getbootstrap.com/); 
	* 		 Font Awesome Free 7.1 (https://fontawesome.com/)
	* Theme: cotcp 
	* Version: 1.0.5 
	* Created: 01 Feb 2026 
	* Updated: 17 May 2026 
	* Copyright (c) 2026 webitproff | https://github.com/webitproff
	* License: BSD
	********************************************************************************/
-->

<!-- BEGIN: FILTER_FORM -->

<div class="card p-3 mb-4 rounded-2 border border-success-subtle position-relative">
	<div class="position-absolute top-0 end-0">	
		<a type="button"
		class="" 
		data-bs-toggle="modal" 
		data-bs-target="#marketFilterHelpModal"
		title="{PHP.L.Help}">
			<i class="fa-solid fa-circle-question fa-2xl"></i>
		</a>
	</div>
	<form action="{SEARCH_ACTION_URL}" method="get" class="mb-4">
		<input type="hidden" name="c" value="{PHP.c}" />
		<input type="hidden" name="e" value="market" />
		<input type="hidden" name="l" value="{PHP.lang}" />
		<input type="hidden" name="saveFilter" value="1" />
		
		<!-- BEGIN: ERROR -->
		<div class="alert alert-warning">{FILTER_ERROR}</div>
		<!-- END: ERROR -->
		
		<!-- BEGIN: FILTER_PARAM -->
		<div class="mb-3">
			<!-- Заголовок показываем только если параметр НЕ сворачивается в аккордеон -->
			<!-- IF !{FILTER_PARAM_HIDELIST} -->
			<div class="d-flex align-items-center mb-1">
				<!-- IF {FILTER_PARAM_HELP} -->
				<a href="#" data-bs-toggle="modal" data-bs-target="#helpModal_{FILTER_PARAM_NAME}" class="me-2" title="{PHP.L.Help}">
					<i class="fa-solid fa-circle-question text-info"></i>
				</a>
				<!-- ENDIF -->
				<label class="form-label mb-0"><strong>{FILTER_PARAM_TITLE}</strong></label>
			</div>
			<!-- ENDIF -->
			
			<!-- BEGIN: ERROR -->
			<div class="alert alert-warning">{FILTER_PARAM_ERROR}</div>
			<!-- END: ERROR -->
			
			<!-- ================= RANGE ================= -->
			<!-- IF {FILTER_PARAM_TYPE} == "range" -->
			<div class="range-inputs">
				<div class="row row-cols-auto g-2 mb-3">			
					<div class="col">
						<label class="form-label small">{PHP.L.marketprofilter_from}</label>
						<input type="number" 
						id="num_min_{FILTER_PARAM_NAME}" 
						value="{FILTER_PARAM_VALUE_MIN}" 
						min="{FILTER_PARAM_MIN}" 
						max="{FILTER_PARAM_MAX}" 
						class="form-control form-control-sm range-num" 
						data-target="min">
					</div>
					<div class="col">
						<label class="form-label small">{PHP.L.marketprofilter_to}</label>
						<input type="number" 
						id="num_max_{FILTER_PARAM_NAME}" 
						value="{FILTER_PARAM_VALUE_MAX}" 
						min="{FILTER_PARAM_MIN}" 
						max="{FILTER_PARAM_MAX}" 
						class="form-control form-control-sm range-num" 
						data-target="max">
					</div>
					<!-- IF {FILTER_PARAM_OPTION_COUNT} > 0 -->
					<div class="col">  <span class="badge rounded-pill text-bg-warning ms-2">{FILTER_PARAM_OPTION_COUNT}</span></div>
					<!-- ENDIF -->
				</div>
			</div>
			
			<div class="range-slider-container">
				<div class="range-slider" id="slider_{FILTER_PARAM_NAME}">
					<div class="progress" id="progress_{FILTER_PARAM_NAME}"></div>
					<input type="range" 
					class="range-min" 
					id="range_min_{FILTER_PARAM_NAME}" 
					min="{FILTER_PARAM_MIN}" 
					max="{FILTER_PARAM_MAX}" 
					value="{FILTER_PARAM_VALUE_MIN}">
					<input type="range" 
					class="range-max" 
					id="range_max_{FILTER_PARAM_NAME}" 
					min="{FILTER_PARAM_MIN}" 
					max="{FILTER_PARAM_MAX}" 
					value="{FILTER_PARAM_VALUE_MAX}">
				</div>
				<input type="hidden" 
				name="filter_{FILTER_PARAM_NAME}" 
				id="hidden_{FILTER_PARAM_NAME}" 
				value="{FILTER_PARAM_HIDDEN_VALUE}">
			</div>
			<script>
				(function(){
					var name = '{FILTER_PARAM_NAME}';
					var sliderMin = document.getElementById('range_min_' + name);
					var sliderMax = document.getElementById('range_max_' + name);
					var numMin = document.getElementById('num_min_' + name);
					var numMax = document.getElementById('num_max_' + name);
					var hidden = document.getElementById('hidden_' + name);
					var progress = document.getElementById('progress_' + name);
					
					var absoluteMin = parseFloat(sliderMin.min);
					var absoluteMax = parseFloat(sliderMax.max);
					
					function updateProgress() {
						var minVal = parseFloat(sliderMin.value);
						var maxVal = parseFloat(sliderMax.value);
						var leftPercent = ((minVal - absoluteMin) / (absoluteMax - absoluteMin)) * 100;
						var rightPercent = ((maxVal - absoluteMin) / (absoluteMax - absoluteMin)) * 100;
						progress.style.left = leftPercent + '%';
						progress.style.width = (rightPercent - leftPercent) + '%';
						numMin.value = minVal;
						numMax.value = maxVal;
						// Если ползунки находятся в крайних положениях — скрытое поле очищаем
						if (minVal === absoluteMin && maxVal === absoluteMax) {
							hidden.value = '';
							} else {
							hidden.value = minVal + '-' + maxVal;
						}
					}
					
					sliderMin.addEventListener('input', function() {
						var minVal = parseFloat(sliderMin.value);
						var maxVal = parseFloat(sliderMax.value);
						if (minVal > maxVal) {
							sliderMin.value = maxVal;
						}
						updateProgress();
					});
					
					sliderMax.addEventListener('input', function() {
						var minVal = parseFloat(sliderMin.value);
						var maxVal = parseFloat(sliderMax.value);
						if (maxVal < minVal) {
							sliderMax.value = minVal;
						}
						updateProgress();
					});
					
					numMin.addEventListener('change', function() {
						var val = parseFloat(numMin.value);
						if (isNaN(val)) val = absoluteMin;
						val = Math.min(Math.max(val, absoluteMin), absoluteMax);
						sliderMin.value = val;
						updateProgress();
					});
					
					numMax.addEventListener('change', function() {
						var val = parseFloat(numMax.value);
						if (isNaN(val)) val = absoluteMax;
						val = Math.min(Math.max(val, absoluteMin), absoluteMax);
						sliderMax.value = val;
						updateProgress();
					});
					
					// Инициализируем только если фильтр уже активен
					if (hidden.value !== '') {
						updateProgress();
					}
				})();
			</script>		
			<!-- ENDIF -->
			
			<!-- ================= SELECT ================= -->
			<!-- IF {FILTER_PARAM_TYPE} == "select" -->
			<!-- IF {FILTER_PARAM_HIDELIST} -->
			<div class="accordion" id="accordion_{FILTER_PARAM_NAME}">
				<div class="accordion-item">
					<h2 class="accordion-header">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{FILTER_PARAM_NAME}">
							{FILTER_PARAM_TITLE}
						</button>
					</h2>
					<div id="collapse_{FILTER_PARAM_NAME}" class="accordion-collapse collapse" data-bs-parent="#accordion_{FILTER_PARAM_NAME}">
						<div class="accordion-body">
							<select name="filter_{FILTER_PARAM_NAME}" class="form-select">
								<option value="">{PHP.L.marketprofilter_select_param_value_not_selected}</option>
								{FILTER_PARAM_LIST_HTML}
							</select>
						</div>
					</div>
				</div>
			</div>
			<!-- ELSE -->
			<select name="filter_{FILTER_PARAM_NAME}" class="form-select">
				<option value="">📌 {PHP.L.marketprofilter_select_param_value_not_selected}</option>
				{FILTER_PARAM_LIST_HTML}
			</select>
			<!-- ENDIF -->
			<!-- ENDIF -->
			
			<!-- ================= CHECKBOX ================= -->
			<!-- IF {FILTER_PARAM_TYPE} == "checkbox" -->
			<!-- IF {FILTER_PARAM_IS_COLOR} -->
			<div class="filter-color-list">{FILTER_PARAM_LIST_HTML}</div>
			<!-- ELSE -->
			<!-- IF {FILTER_PARAM_HIDELIST} -->
			<div class="d-flex align-items-center mb-1">
				<!-- IF {FILTER_PARAM_HELP} -->
				<a href="#" data-bs-toggle="modal" data-bs-target="#helpModal_{FILTER_PARAM_NAME}" class="me-2" title="{PHP.L.marketprofilter_param_helpinfo}">
					<i class="fa-solid fa-circle-question text-info"></i>
				</a>
				<!-- ENDIF -->
				<label class="form-label mb-0"><strong>{FILTER_PARAM_TITLE}</strong></label>
			</div>
			<div class="accordion" id="accordion_{FILTER_PARAM_NAME}">
				<div class="accordion-item">
					<h2 class="accordion-header">
						<button class="accordion-button collapsed"
						type="button"
						data-bs-toggle="collapse"
						data-bs-target="#collapse_{FILTER_PARAM_NAME}"
						data-unfold-text="{PHP.L.marketprofilter_unfoldall}"
						data-fold-text="{PHP.L.marketprofilter_foldall}">
							{PHP.L.marketprofilter_unfoldall}
						</button>
					</h2>
					<div id="collapse_{FILTER_PARAM_NAME}" class="accordion-collapse collapse" data-bs-parent="#accordion_{FILTER_PARAM_NAME}">
						<div class="accordion-body">
							<div class="form-check-list">{FILTER_PARAM_LIST_HTML}</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ELSE -->
			<div class="form-check-list">{FILTER_PARAM_LIST_HTML}</div>
			<!-- ENDIF -->
			<!-- ENDIF -->
			<!-- ENDIF -->
			
			<!-- ================= RADIO ================= -->
			<!-- IF {FILTER_PARAM_TYPE} == "radio" -->
			<!-- IF {FILTER_PARAM_IS_COLOR} -->
			<div class="filter-color-list">{FILTER_PARAM_LIST_HTML}</div>
			<!-- ELSE -->
			<!-- IF {FILTER_PARAM_HIDELIST} -->
			<div class="accordion" id="accordion_{FILTER_PARAM_NAME}">
				<div class="accordion-item">
					<h2 class="accordion-header">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{FILTER_PARAM_NAME}">
							{FILTER_PARAM_TITLE}
						</button>
					</h2>
					<div id="collapse_{FILTER_PARAM_NAME}" class="accordion-collapse collapse" data-bs-parent="#accordion_{FILTER_PARAM_NAME}">
						<div class="accordion-body">
							<div class="form-check-list">{FILTER_PARAM_LIST_HTML}</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ELSE -->
			<div class="form-check-list">{FILTER_PARAM_LIST_HTML}</div>
			<!-- ENDIF -->
			<!-- ENDIF -->
			<!-- ENDIF -->
		</div>
		<!-- Модальное окно для подсказки параметра -->
		<!-- IF {FILTER_PARAM_HELP} -->
		<div class="modal fade" id="helpModal_{FILTER_PARAM_NAME}" tabindex="-1" aria-labelledby="helpModalLabel_{FILTER_PARAM_NAME}" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content context-tools-js">
					<div class="modal-header">
						<h5 class="modal-title">{PHP.L.marketprofilter_param_helpinfo}</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" id="protected-block">
						{FILTER_PARAM_HELP}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{PHP.L.Close}</button>
					</div>
				</div>
			</div>
		</div>
		<!-- ENDIF -->
		<hr>
		<!-- END: FILTER_PARAM -->
		
		<div class="mt-5">
			<div class="row">
				<div class="col-12 mb-4">
					<button type="submit" class="btn btn-modern-blue w-100">
						{PHP.L.marketprofilter_apply}
					</button>			
				</div>
				<div class="col-12 mb-2">
					<a class="btn btn-modern-red w-100" href="{FILTER_RESET_URL}">
						<i class="fa-solid fa-filter-circle-xmark"></i> {PHP.L.marketprofilter_reset}
					</a>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Находим все collapse-элементы аккордеонов
		var collapseElements = document.querySelectorAll('.accordion .accordion-collapse');
		collapseElements.forEach(function (collapseEl) {
			// Вешаем обработчики событий Bootstrap на сам collapse-элемент
			collapseEl.addEventListener('show.bs.collapse', function () {
				updateButtonText(collapseEl, true);
			});
			collapseEl.addEventListener('hide.bs.collapse', function () {
				updateButtonText(collapseEl, false);
			});
			
			// При загрузке страницы сразу установить правильный текст
			var triggerBtn = document.querySelector('[data-bs-toggle="collapse"][data-bs-target="#' + collapseEl.id + '"]');
			if (triggerBtn) {
				// Если изначально развёрнут (нет класса 'collapsed' у кнопки) – ставим fold
				if (!triggerBtn.classList.contains('collapsed')) {
					triggerBtn.textContent = triggerBtn.getAttribute('data-fold-text');
				}
			}
		});
		
		function updateButtonText(collapseEl, isShown) {
			var triggerBtn = document.querySelector('[data-bs-toggle="collapse"][data-bs-target="#' + collapseEl.id + '"]');
			if (!triggerBtn) return;
			if (isShown) {
				// Аккордеон открыт – показываем "fold"
				triggerBtn.textContent = triggerBtn.getAttribute('data-fold-text');
				} else {
				// Аккордеон закрыт – показываем "unfold"
				triggerBtn.textContent = triggerBtn.getAttribute('data-unfold-text');
			}
		}
	});
</script>
<style>
	/* Стили двухползункового диапазона */
	.range-slider-container {
	position: relative;
	width: 100%;
	margin: 10px 0 20px;
	}
	.range-slider {
	position: relative;
	width: 100%;
	height: 6px;
	background: #ddd;
	border-radius: 3px;
	}
	.range-slider .progress {
	position: absolute;
	height: 100%;
	background: #007bff;
	border-radius: 3px;
	}
	.range-slider input[type=range] {
	position: absolute;
	width: 100%;
	height: 6px;
	top: 0;
	left: 0;
	background: none;
	pointer-events: none;
	-webkit-appearance: none;
	appearance: none;
	margin: 0;
	}
	.range-slider input[type=range]::-webkit-slider-thumb {
	pointer-events: all;
	width: 20px;
	height: 20px;
	background: #ffc107;
	border-radius: 50%;
	cursor: pointer;
	-webkit-appearance: none;
	margin-top: -7px;
	}
	.range-slider input[type=range]::-moz-range-thumb {
	pointer-events: all;
	width: 20px;
	height: 20px;
	background: #ffc107;
	border-radius: 50%;
	cursor: pointer;
	border: none;
	}
	.range-inputs {
	display: flex;
	align-items: center;
	gap: 10px;
	margin-bottom: 10px;
	}
	.range-inputs input[type=number] {
	width: 100px;
	text-align: center;
	}
</style>
<style>
	.filter-color-list {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
	}
	.filter-color-i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #dee2e6;
    border-radius: 4px;
    padding: 4px;
    cursor: pointer;
    position: relative;
	}
	.filter-color-i:hover {
    border-color: #000;
	}
	.filter-color-i:has(input:checked) {
    border-color: #ff5100;
	}
	.filter-color-i:has(input:checked):hover {
    border-color: #ff5100;
	}
	.filter-color-b {
    display: block;
    width: 32px;
    height: 32px;
    border-radius: 3px;
	}
</style>

<!-- Модальное окно общей справки -->
<div class="modal fade" id="marketFilterHelpModal" tabindex="-1" aria-labelledby="marketFilterHelpModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{PHP.L.Help}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				{PHP.L.marketprofilter_market_list_help}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{PHP.L.Close}</button>
			</div>
		</div>
	</div>
</div>

<!-- END: FILTER_FORM -->