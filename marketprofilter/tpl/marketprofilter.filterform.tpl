<!-- BEGIN: FILTER_FORM -->
<div class="p-3 mb-4 rounded-2 border border-warning-subtle">
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
            <label class="form-label"><strong>{FILTER_PARAM_TITLE}</strong></label>

            <!-- BEGIN: ERROR -->
            <div class="alert alert-warning">{FILTER_PARAM_ERROR}</div>
            <!-- END: ERROR -->

            <!-- RANGE -->
            <!-- IF {FILTER_PARAM_TYPE} == "range" -->
            <div class="w-100">
                <div class="d-flex justify-content-between mb-2">
                    <span>От {FILTER_PARAM_MIN} и До: <span id="value_{FILTER_PARAM_NAME}"><strong>{FILTER_PARAM_VALUE_MAX}</strong></span></span>
                </div>
                <input type="range"
                       name="filter_{FILTER_PARAM_NAME}"
                       id="range_{FILTER_PARAM_NAME}"
                       min="0"
                       max="{FILTER_PARAM_MAX}"
                       value="{FILTER_PARAM_VALUE_MAX}"
                       class="form-range"
                       oninput="updateRangeValue('{FILTER_PARAM_NAME}', this.value)">
            </div>
            <!-- ENDIF -->

            <!-- SELECT -->
            <!-- IF {FILTER_PARAM_TYPE} == "select" -->
            <select name="filter_{FILTER_PARAM_NAME}" class="form-select">
                <option value="">-- Выберите --</option>
                <!-- BEGIN: SELECT_LIST -->
                <option value="{FILTER_PARAM_OPTION_VALUE}" {FILTER_PARAM_OPTION_SELECTED}>
                    {FILTER_PARAM_OPTION_TEXT} ({FILTER_PARAM_OPTION_COUNT})
                </option>
                <!-- END: SELECT_LIST -->
            </select>
            <!-- ENDIF -->

            <!-- CHECKBOX -->
            <!-- IF {FILTER_PARAM_TYPE} == "checkbox" -->
            <div class="form-check-list">
                <!-- BEGIN: CHECKBOX_LIST -->
                <div class="form-check">
                    <input type="checkbox"
                           name="filter_{FILTER_PARAM_NAME}[]"
                           value="{FILTER_PARAM_OPTION_VALUE}"
                           class="form-check-input"
                           {FILTER_PARAM_CHECKED}>
                    <label class="form-check-label">
                        <!-- IF {FILTER_PARAM_OPTION_COUNT} > 0 --><span class="badge rounded-pill text-bg-warning me-1">{FILTER_PARAM_OPTION_COUNT}</span><!-- ENDIF -->{FILTER_PARAM_OPTION_TEXT} 
                    </label>
                </div>
                <!-- END: CHECKBOX_LIST -->
            </div>
            <!-- ENDIF -->

            <!-- RADIO -->
            <!-- IF {FILTER_PARAM_TYPE} == "radio" -->
            <div class="form-check-list">
                <!-- BEGIN: RADIO_LIST -->
                <div class="form-check">
                    <input type="radio"
                           name="filter_{FILTER_PARAM_NAME}"
                           value="{FILTER_PARAM_OPTION_VALUE}"
                           class="form-check-input"
                           {FILTER_PARAM_CHECKED}>
                    <label class="form-check-label">
                        {FILTER_PARAM_OPTION_TEXT} ({FILTER_PARAM_OPTION_COUNT})
                    </label>
                </div>
                <!-- END: RADIO_LIST -->
            </div>
            <!-- ENDIF -->
        </div>
        <!-- END: FILTER_PARAM -->

        <div class="row">
            <div class="col-12 mb-2">
                <input type="submit" name="search" class="btn btn-primary w-100" value="{PHP.L.marketprofilter_apply}" />
            </div>
            <div class="col-12 mb-2">
                <a class="btn btn-outline-danger w-100" href="{FILTER_RESET_URL}">
                    <i class="fa-solid fa-filter-circle-xmark"></i> {PHP.L.marketprofilter_reset}
                </a>
            </div>
        </div>
    </form>
</div>

<script>
function updateRangeValue(paramName, value) {
    const display = document.getElementById(`value_${paramName}`);
    if (display) display.textContent = value;
    const rangeInput = document.getElementById(`range_${paramName}`);
    if (rangeInput) {
        const max = parseFloat(rangeInput.max);
        const current = parseFloat(value);
        const percentage = (current / max) * 100;
        rangeInput.style.setProperty('--value-percentage', `${percentage}%`);
    }
}
</script>

<style>
.form-range {
    width: 100%;
    height: 6px;
    background: #ddd;
    border-radius: 5px;
    outline: none;
    -webkit-appearance: none;
}
.form-range::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    background: #007bff;
    border-radius: 50%;
    cursor: pointer;
}
.form-range::-moz-range-thumb {
    width: 20px;
    height: 20px;
    background: #007bff;
    border-radius: 50%;
    cursor: pointer;
}
.form-range::-webkit-slider-runnable-track {
    background: linear-gradient(to right, #ffc107 calc(var(--value-percentage, 0%)), #ddd calc(var(--value-percentage, 0%)), #ddd 100%);
}
</style>
<!-- END: FILTER_FORM -->