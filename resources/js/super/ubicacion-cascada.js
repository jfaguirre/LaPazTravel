document.addEventListener('DOMContentLoaded', function () {
    // Inicialización de Tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (el) { return new bootstrap.Tooltip(el); });

    // Referencias al DOM
    const formFiltros = document.getElementById('filtroForm');
    const inputEstado = document.getElementById('input_estado');
    const selectDepto = document.getElementById('select_departamento');
    const selectMuni = document.getElementById('select_municipio');
    const selectDist = document.getElementById('select_distrito');
    const inputSearch = document.getElementById('search');

    const containerEstados = document.getElementById('container-estados');
    const tablaContainer = document.getElementById('tabla-sitios-container');
    const loadingOverlay = document.getElementById('loading-overlay');

    // Recuperar valores iniciales de la URL / Blade
    const urlParams = new URLSearchParams(window.location.search);
    const initMuniId = urlParams.get('municipio_id') || '';
    const initDistId = urlParams.get('distrito_id') || '';

    // --- FUNCIÓN PRINCIPAL AJAX PARA ACTUALIZAR LA TABLA ---
    function fetchResultados(url = null) {
        if (!formFiltros || !tablaContainer) return;

        const formData = new FormData(formFiltros);
        const params = new URLSearchParams(formData);

        const fetchUrl = url ? url : `${formFiltros.action}?${params.toString()}`;

        // Mostrar indicador de carga y bajar opacidad
        if (loadingOverlay) {
            loadingOverlay.classList.remove('d-none');
            loadingOverlay.classList.add('d-flex');
        }
        tablaContainer.style.opacity = '0.4';

        fetch(fetchUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.text())
        .then(html => {
            tablaContainer.innerHTML = html;

            // Re-inicializar Tooltips tras inyectar HTML
            var newTooltips = [].slice.call(tablaContainer.querySelectorAll('[data-bs-toggle="tooltip"]'));
            newTooltips.map(function (el) { return new bootstrap.Tooltip(el); });

            // Actualizar la URL sin recargar
            window.history.pushState({}, '', fetchUrl);
        })
        .catch(err => {
            console.error('Error al filtrar los resultados:', err);
        })
        .finally(() => {
            // Ocultar indicador de carga y restaurar opacidad siempre
            if (loadingOverlay) {
                loadingOverlay.classList.remove('d-flex');
                loadingOverlay.classList.add('d-none');
            }
            tablaContainer.style.opacity = '1';
        });
    }

    // --- MANEJO DE ESTADOS (Botones Pill) ---
    if (containerEstados) {
        containerEstados.addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-estado');
            if (!btn) return;

            containerEstados.querySelectorAll('.btn-estado').forEach(b => {
                const defaultClasses = b.dataset.defaultClass ? b.dataset.defaultClass.split(' ') : [];
                const activeClasses = b.dataset.activeClass ? b.dataset.activeClass.split(' ') : [];
                
                b.classList.remove(...activeClasses);
                b.classList.add(...defaultClasses);
            });

            const activeClasses = btn.dataset.activeClass.split(' ');
            const defaultClasses = btn.dataset.defaultClass.split(' ');

            btn.classList.remove(...defaultClasses);
            btn.classList.add(...activeClasses);

            inputEstado.value = btn.dataset.estado;
            fetchResultados();
        });
    }

    // --- CASCADA DE DESPLEGABLES (Departamento -> Municipio -> Distrito) ---

    // 1. Cambio de Departamento
    if (selectDepto) {
        selectDepto.addEventListener('change', function () {
            const deptoId = this.value;

            // Resetear selects inferiores
            selectMuni.innerHTML = '<option value="">Todos</option>';
            selectDist.innerHTML = '<option value="">Todos</option>';
            selectMuni.disabled = true;
            selectDist.disabled = true;

            if (deptoId) {
                cargarMunicipios(deptoId);
            }

            fetchResultados();
        });
    }

    // 2. Cambio de Municipio
    if (selectMuni) {
        selectMuni.addEventListener('change', function () {
            const muniId = this.value;

            // Resetear select de distrito
            selectDist.innerHTML = '<option value="">Todos</option>';
            selectDist.disabled = true;

            if (muniId) {
                cargarDistritos(muniId);
            }

            fetchResultados();
        });
    }

    // 3. Cambio de Distrito
    if (selectDist) {
        selectDist.addEventListener('change', function () {
            fetchResultados();
        });
    }

    // --- FUNCIONES AUXILIARES AJAX PARA SELECTS ---
    function cargarMunicipios(deptoId, targetMuniId = '') {
        fetch(`/super/get-municipios/${deptoId}`)
            .then(res => res.json())
            .then(municipios => {
                selectMuni.innerHTML = '<option value="">Todos</option>';
                municipios.forEach(m => {
                    const option = document.createElement('option');
                    option.value = m.id;
                    option.textContent = m.municipio + (m.estado === 'INACTIVO' ? ' (Próximamente)' : '');
                    if (m.estado === 'INACTIVO') option.disabled = true;
                    if (m.id == targetMuniId) option.selected = true;
                    selectMuni.appendChild(option);
                });

                selectMuni.disabled = false;

                if (targetMuniId) {
                    cargarDistritos(targetMuniId, initDistId);
                }
            });
    }

    function cargarDistritos(muniId, targetDistId = '') {
        fetch(`/super/get-distritos/${muniId}`)
            .then(res => res.json())
            .then(distritos => {
                selectDist.innerHTML = '<option value="">Todos</option>';
                distritos.forEach(d => {
                    const option = document.createElement('option');
                    option.value = d.id;
                    option.textContent = d.distrito;
                    if (d.id == targetDistId) option.selected = true;
                    selectDist.appendChild(option);
                });

                selectDist.disabled = false;
            });
    }

    // --- BÚSQUEDA POR TEXTO (Debounce) ---
    if (inputSearch) {
        let searchTimeout;
        inputSearch.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchResultados();
            }, 400);
        });
    }

    if (formFiltros) {
        formFiltros.addEventListener('submit', function (e) {
            e.preventDefault();
            fetchResultados();
        });
    }

    // --- PAGINACIÓN AJAX ---
    document.addEventListener('click', function (e) {
        const pageLink = e.target.closest('#tabla-sitios-container .pagination a');
        if (pageLink) {
            e.preventDefault();
            fetchResultados(pageLink.href);
        }
    });

    // --- CARGA INICIAL DE SELECTS SI HAY VALORES PREVIOS ---
    if (selectDepto && selectDepto.value) {
        cargarMunicipios(selectDepto.value, initMuniId);
    }
});