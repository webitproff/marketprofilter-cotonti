<!-- BEGIN: MAIN -->
<!--  ваш код  -->
	
	{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"} 
<!--  ваш код  -->
	<div class="col-12">
		<div id="aurorawave">
			<button class="btn btn-sm btn-warning-hot text-uppercase mb-4" type="button" id="filterToggleBtn">
				{PHP.L.marketprofilter_Hide_Filter}
			</button>
		</div>
	</div>
	<!-- IF {PHP|cot_plugin_active('marketprofilter')} AND {MARKETFILTER_MESSAGE} -->
	<div class="col-12">
		<div class="alert {MARKETFILTER_MESSAGE_CLASS}"> {MARKETFILTER_MESSAGE} </div>
	</div>
	<!-- ENDIF --> 
	<div class="row px-0">
<!--  ваш код  -->	
	
<!--  форма фильтра  -->
		<!-- IF {PHP|cot_plugin_active('marketprofilter')} --> 
		<div class="col-12 col-lg-4 col-xl-3" id="marketFilterCol">
			{MARKET_FILTER_FORM}
		</div>
		<!-- ENDIF -->
<!--  форма фильтра  -->


<!--  ваш код  -->

<style>
	#marketFilterCollapse.collapsing {
	transition: width 0.35s ease, margin 0.35s ease;
	}
	#marketFilterCollapse.collapse-horizontal:not(.show) {
	width: 0 !important;
	margin-left: auto;  /* смещает блок вправо */
	}
</style>
<!--  ваш код  -->

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
<!--  ваш код  -->
<!-- END: MAIN -->
