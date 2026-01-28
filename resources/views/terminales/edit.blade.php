@extends('layouts.layoutadmin')

@section('title', 'Edición de Terminal - BusTrak')

@section('content')

    {{-- 🛑 Mensajes de Sesión --}}
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- 📝 Contenedor Principal del Formulario --}}
    <div class="container px-0">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4">
                <header>
                    <h2 class="mb-0" style="color:#1e63b8; font-weight:600; font-size:1.8rem;">
                        <i class="fas fa-bus me-2"></i>Editar Terminal
                    </h2>
                </header>

                {{-- ➡️ Formulario de Edición --}}
                <div class="card-body p-4 p-md-5">
                    <form id="terminalForm" action="{{ route('terminales.update', $terminal->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- 1️⃣ DATOS DE UBICACIÓN --}}
                        <h5 class="mb-3 mt-2" style="color:#1e63b8; font-weight:600; font-size:1.5rem;">
                            <i class="fas fa-map-marker-alt me-2"></i>1. Datos de ubicación
                        </h5>
                        <hr class="mt-0 mb-4">
                        <div class="row g-4">
                            {{-- Fila 1: Nombre y Código --}}
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $terminal->nombre) }}" maxlength="100" required
                                       class="form-control @error('nombre') is-invalid @enderror">
                                @error('nombre')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                                <div id="error-nombre" class="error-message"></div>
                            </div>

                            {{-- Fila 2: Departamento y Municipio --}}
                            <div class="col-md-6">
                                <label for="departamento" class="form-label">Departamento</label>
                                <select id="departamento" name="departamento" required
                                        class="form-select @error('departamento') is-invalid @enderror">
                                    <option value="">-- Seleccione un departamento --</option>
                                    @foreach($departamentos as $depto)
                                        <option value="{{ $depto }}" {{ old('departamento', $terminal->departamento) == $depto ? 'selected' : '' }}>
                                            {{ $depto }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('departamento')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                                <div id="error-departamento" class="error-message"></div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="municipio" class="form-label">Municipio</label>
                                    <select id="municipio" name="municipio" required disabled
                                            class="form-select @error('municipio') is-invalid @enderror">
                                        <option value="">-- Seleccione primero un departamento --</option>
                                    </select>
                                    @error('municipio')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                    <div id="error-municipio" class="error-message"></div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $terminal->codigo) }}" maxlength="10" required readonly
                                           class="form-control bg-light @error('codigo') is-invalid @enderror">
                                    @error('codigo')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                    <div id="error-codigo" class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Fila 3: Dirección --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <textarea id="direccion" name="direccion" maxlength="150" required
                                              class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion', $terminal->direccion) }}</textarea>
                                    @error('direccion')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                    <div id="error-direccion" class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        {{-- 1.5 COORDENADAS (OPCIONAL) --}}
                        <h5 class="mb-3 mt-5" style="color:#1e63b8; font-weight:600; font-size:1.5rem;">
                            <i class="fas fa-map-marker-alt me-2"></i>1.5 Coordenadas (Opcional)
                        </h5>
                        <hr class="mt-0 mb-4">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitud" class="form-label">Latitud</label>
                                    <input type="text" id="latitud" name="latitud" value="{{ old('latitud', $terminal->latitud) }}"
                                           class="form-control @error('latitud') is-invalid @enderror"
                                           placeholder="Ej: 14.0821">
                                    @error('latitud')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitud" class="form-label">Longitud</label>
                                    <input type="text" id="longitud" name="longitud" value="{{ old('longitud', $terminal->longitud) }}"
                                           class="form-control @error('longitud') is-invalid @enderror"
                                           placeholder="Ej: -87.2063">
                                    @error('longitud')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Ejemplo: 14.0821, -87.2063 (Copiar de Google Maps)
                                </small>
                            </div>
                        </div>

                        {{-- 2️⃣ INFORMACIÓN DE CONTACTO --}}
                        <h5 class="mb-3 mt-5" style="color:#1e63b8; font-weight:600; font-size:1.5rem;">
                            <i class="fas fa-address-book me-2"></i>2. Información de contacto
                        </h5>
                        <hr class="mt-0 mb-4">
                        <div class="row g-4">
                            {{-- Fila 4: Teléfono y Correo --}}
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $terminal->telefono) }}" maxlength="8" required
                                           class="form-control @error('telefono') is-invalid @enderror">
                                    @error('telefono')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                    <div id="error-telefono" class="error-message"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo electrónico</label>
                                    <input type="email" id="correo" name="correo" value="{{ old('correo', $terminal->correo) }}" maxlength="50" required
                                           class="form-control @error('correo') is-invalid @enderror">
                                    @error('correo')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                    <div id="error-correo" class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        {{-- 3️⃣ HORARIOS Y DESCRIPCIÓN --}}
                        <h5 class="mb-3 mt-5" style="color:#1e63b8; font-weight:600; font-size:1.5rem;">
                            <i class="fas fa-clock me-2"></i>3. Horarios y detalles
                        </h5>
                        <hr class="mt-0 mb-4">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label for="horario_apertura_hora" class="form-label">Horario de apertura</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-sun text-warning"></i></span>
                                    <select id="horario_apertura_hora" required class="form-select">
                                        <option value="">Hora</option>
                                    </select>
                                    <span class="input-group-text">:</span>
                                    <select id="horario_apertura_minuto" required class="form-select">
                                        <option value="">Min</option>
                                    </select>
                                </div>
                                @error('horario_apertura')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                                <div id="error-horario_apertura" class="error-message"></div>
                            </div>

                            <div class="col-md-4">
                                <label for="horario_cierre_hora" class="form-label">Horario de cierre</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-moon text-secondary"></i></span>
                                    <select id="horario_cierre_hora" required class="form-select">
                                        <option value="">Hora</option>
                                    </select>
                                    <span class="input-group-text">:</span>
                                    <select id="horario_cierre_minuto" required class="form-select">
                                        <option value="">Min</option>
                                    </select>
                                </div>
                                @error('horario_cierre')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                                <div id="error-horario_cierre" class="error-message"></div>
                            </div>
                        </div>

                        {{-- CAMPOS OCULTOS para horarios --}}
                        <input type="hidden" name="horario_apertura" id="horario_apertura_hidden">
                        <input type="hidden" name="horario_cierre" id="horario_cierre_hidden">

                        {{-- Fila 6: Descripción --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <textarea id="descripcion" name="descripcion" required
                                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $terminal->descripcion) }}</textarea>
                                    @error('descripcion')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                    <div id="error-descripcion" class="error-message"></div>
                                </div>
                            </div>
                        </div>

                        {{-- ⚙️ Botones de Acción --}}
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('terminales.index') }}'">
                                <i class="fas fa-arrow-left me-2"></i> Volver a la lista
                            </button>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary submit-btn">
                                    <i class="fas fa-sync-alt me-2"></i> Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 🧠 Lógica JavaScript COMPLETA --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 🏷️ Referencias a Elementos del DOM
            const terminalForm = document.getElementById('terminalForm');
            const departamentoSelect = document.getElementById('departamento');
            const municipioSelect = document.getElementById('municipio');
            const codigoInput = document.getElementById('codigo');
            const nombreInput = document.getElementById('nombre');
            const telefonoInput = document.getElementById('telefono');
            const correoInput = document.getElementById('correo');
            const direccionTextarea = document.getElementById('direccion');
            const descripcionTextarea = document.getElementById('descripcion');

            // ⏰ Referencias de los SELECTS de Hora/Minuto
            const horarioAperturaHoraSelect = document.getElementById('horario_apertura_hora');
            const horarioAperturaMinutoSelect = document.getElementById('horario_apertura_minuto');
            const horarioCierreHoraSelect = document.getElementById('horario_cierre_hora');
            const horarioCierreMinutoSelect = document.getElementById('horario_cierre_minuto');
            const horarioAperturaHidden = document.getElementById('horario_apertura_hidden');
            const horarioCierreHidden = document.getElementById('horario_cierre_hidden');

            const terminal = @json($terminal);

            // 🗺️ Data de Municipios
            const municipiosData = {
                'Atlántida': ['La Ceiba', 'El Porvenir', 'Tela', 'San Francisco', 'Arizona', 'Esparta', 'Jutiapa', 'La Másica'],
                'Colón': ['Trujillo', 'Balfate', 'Iriona', 'Limón', 'Sabá', 'Santa Rosa de Aguán', 'Sonaguera', 'Tocoa', 'Bonito Oriental', 'Fe'],
                'Comayagua': ['Comayagua', 'Ajuterique', 'El Rosario', 'Esquías', 'Guanja', 'La Libertad', 'Lamaní', 'La Paz', 'Leyes', 'Meámbar', 'Minas de Oro', 'Ojo de Agua', 'San Jerónimo', 'San José de Comayagua', 'San José del Potrero', 'San Luis', 'San Sebastián', 'Siguatepeque', 'Taulabé', 'Villa de San Antonio', 'Las Lajas'],
                'Copán': ['Santa Rosa de Copán', 'Cabañas', 'Concepción', 'Copán Ruinas', 'Corquín', 'Dolores', 'Dulce Nombre', 'El Paraíso', 'Florida', 'La Unión', 'Leapaera', 'Lucerna', 'Nueva Arcadia', 'San Agustín', 'San Antonio', 'San Jerónimo', 'San José', 'San Juan de Opoa', 'San Nicolás', 'San Pedro de Copán', 'Santa Rita', 'Trinidad de Copán', 'Veracruz'],
                'Cortés': ['San Pedro Sula', 'Choloma', 'Puerto Cortés', 'La Lima', 'Omoa', 'San Antonio de Cortés', 'San Francisco de Yojoa', 'San Manuel', 'Villanueva', 'Potrerillos', 'Pimienta', 'Santa Cruz de Yojoa'],
                'Choluteca': ['Choluteca', 'Apacilagua', 'Concepción de María', 'El Corpus', 'El Triunfo', 'Marcovia', 'Morolica', 'Namasigüe', 'Orocuina', 'Pespire', 'San Antonio de Flores', 'San Isidro', 'San José', 'San Marcos de Colón', 'Santa Ana de Yusguare', 'Ciudad Choluteca'],
                'El Paraíso': ['Yuscarán', 'Alauca', 'Danlí', 'El Paraíso', 'Güinope', 'Jacaleapa', 'Liure', 'Morocelí', 'Oropolí', 'Potrerillos', 'San Antonio de Flores', 'San Lucas', 'San Matías', 'Soledad', 'Teupasenti', 'Vado Ancho', 'Trojes', 'Texiguat'],
                'Francisco Morazán': ['Distrito Central (Tegucigalpa y Comayagüela)', 'Alubarén', 'Cedros', 'Curarén', 'El Porvenir', 'Guaimaca', 'La Libertad', 'La Venta', 'Lepaterique', 'Maraita', 'Marale', 'Nueva Armenia', 'Ojojona', 'Orica', 'Reitoca', 'Sabana Grande', 'San Antonio de Oriente', 'San Buenaventura', 'San Ignacio', 'San Juan de Flores (Cantarranas)', 'San Miguelito', 'Santa Ana', 'Santa Lucía', 'Talanga', 'Tatumbla', 'Valle de Ángeles', 'Villa de San Francisco', 'Vallecillo'],
                'Gracias a Dios': ['Puerto Lempira', 'Brus Laguna', 'Ahuas', 'Juan Francisco Bulnes', 'Villeda Morales', 'Wampusirpi'],
                'Intibucá': ['La Esperanza', 'Camasca', 'Colomoncagua', 'Concepción', 'Dolores', 'Honduritas', 'Intibucá', 'Jesús de Otoro', 'Magdalena', 'Masaguara', 'San Antonio', 'San Francisco de Opalaca', 'San Isidro', 'San Juan', 'San Marco de la Sierra', 'San Miguelito', 'Santa Lucía', 'Yamaranguila', 'Yurique'],
                'Islas de la Bahía': ['Roatán', 'Guanaja', 'José Santos Guardiola', 'Utila'],
                'La Paz': ['La Paz', 'Aguanqueterique', 'Cabañas', 'Cane', 'Chinacla', 'Guajiquiro', 'Laura', 'Marcala', 'Mercedes de Oriente', 'Opatoro', 'San Antonio del Norte', 'San José', 'San Juan', 'San Pedro de Tutule', 'Santa Ana', 'Santa Elena', 'Santa María', 'Santiago de Puringla', 'Yarula'],
                'Lempira': ['Gracias', 'Belen', 'Candelaria', 'Cololaca', 'Erandique', 'Gualcince', 'Guarita', 'La Campa', 'La Iguala', 'Las Flores', 'La Unión', 'La Virtud', 'Lepaera', 'Mapulaca', 'Piraera', 'Rendero', 'San Andrés', 'San Francisco', 'San Juan de Cajacas', 'San Manuel Colohete', 'San Rafael', 'San Sebastián', 'Santa Cruz', 'Talgua', 'Tambla', 'Tomala', 'Tomala', 'Valladolid', 'Virginia', 'San Antonio'],
                'Ocotepeque': ['Ocotepeque', 'Belén Gualcho', 'Concepción', 'Dolores Merendón', 'Fraternidad', 'La Encarnación', 'La Labor', 'Lucerna', 'Mercedes', 'San Fernando', 'San Francisco del Valle', 'San Jorge', 'San Marcos', 'Santa Fe', 'Sinuapa', 'Sensenti'],
                'Olancho': ['Juticalpa', 'Campamento', 'Catacamas', 'Concordia', 'Dulce Nombre de Culmí', 'El Rosario', 'Esquipulas del Norte', 'Gualaco', 'Guarizama', 'Jano', 'La Unión', 'Mangulile', 'Manto', 'Salama', 'San Esteban', 'San Francisco de la Paz', 'Santa María del Real', 'Silca', 'Yocón', 'Patuca', 'Guayape'],
                'Santa Bárbara': ['Santa Bárbara', 'Azacualpa', 'Atima', 'Ceguaca', 'Concepción del Norte', 'Concepción del Sur', 'Chinda', 'El Níspero', 'Gualala', 'Ilama', 'Las Vegas', 'Macuelizo', 'Naranjito', 'Nueva Frontera', 'Petoa', 'Protección', 'Quimistán', 'San Francisco de Ojuera', 'San Luis', 'San Marcos', 'San Nicolás', 'San Pedro Zacapa', 'Santa Rita', 'Trinidad', 'Santa Cruz de Yojoa'],
                'Valle': ['Nacaome', 'Amapala', 'Alianza', 'Aramecina', 'Caridad', 'Goascorán', 'Langue', 'San Francisco de Coray', 'San Lorenzo'],
                'Yoro': ['Yoro', 'Arenal', 'El Negrito', 'El Progreso', 'Jocón', 'Morazán', 'Olanchito', 'Santa Rita', 'Sulaco', 'Victoria', 'Yorito']
            };

            // ❌ Funciones de Manejo de Errores
            function showError(field, message) {
                const fieldId = field.id;
                const errorId = fieldId.startsWith('horario_') ? fieldId.substring(0, fieldId.lastIndexOf('_')) : fieldId;
                const errorElement = document.getElementById(`error-${errorId}`);

                if (errorElement) {
                    if (fieldId.endsWith('_minuto')) {
                        errorElement.innerHTML = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                    } else if (!fieldId.startsWith('horario_')) {
                        errorElement.innerHTML = message.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
                    } else if (message === '') {
                        errorElement.textContent = '';
                    }

                    field.classList.add('is-invalid');
                }
            }

            function clearError(field) {
                const fieldId = field.id;
                const errorId = fieldId.startsWith('horario_') ? fieldId.substring(0, fieldId.lastIndexOf('_')) : fieldId;
                const errorElement = document.getElementById(`error-${errorId}`);

                field.classList.remove('is-invalid');

                if (fieldId.startsWith('horario_') && errorElement) {
                    const otherSelectId = fieldId.endsWith('_hora') ? fieldId.replace('_hora', '_minuto') : fieldId.replace('_minuto', '_hora');
                    const otherSelect = document.getElementById(otherSelectId);

                    if (field.value && otherSelect.value) {
                        errorElement.textContent = '';
                    }

                    if (!field.value) {
                        otherSelect.classList.remove('is-invalid');
                    }
                }

                if (!fieldId.startsWith('horario_') && errorElement) {
                    errorElement.textContent = '';
                }

                if (fieldId === 'departamento') {
                    municipioSelect.classList.remove('is-invalid');
                    document.getElementById('error-municipio').textContent = '';
                }
            }

            // 📐 Función para Auto-Redimensionar Textareas
            function autoResize() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            }

            // 🏙️ Funciones de Ubicación y Código
            function loadMunicipios() {
                const selectedDepto = departamentoSelect.value;
                municipioSelect.innerHTML = '';
                clearError(municipioSelect);

                const oldMunicipio = "{{ old('municipio', $terminal->municipio) }}";

                if (selectedDepto && municipiosData[selectedDepto]) {
                    municipioSelect.disabled = false;
                    municipioSelect.appendChild(new Option('-- Seleccione un municipio --', ''));

                    const municipios = municipiosData[selectedDepto].sort();

                    municipios.forEach(municipio => {
                        const isSelected = municipio === oldMunicipio;
                        const option = new Option(municipio, municipio, false, isSelected);
                        municipioSelect.appendChild(option);
                    });
                } else {
                    municipioSelect.disabled = true;
                    municipioSelect.appendChild(new Option('-- Seleccione primero un departamento --', ''));
                }
            }

            function updateCodigo() {
                clearError(codigoInput);
            }

            // ⏱️ Funciones de Horario
            function generateHourOptions() {
                const options = [];
                for (let h = 0; h < 24; h++) {
                    const hour24 = String(h).padStart(2, '0');
                    let hour12 = h % 12 || 12;
                    const ampm = h < 12 ? 'AM' : 'PM';
                    const text12 = `${String(hour12).padStart(2, '0')} ${ampm}`;
                    options.push({ value: hour24, text: text12 });
                }
                return options;
            }

            function generateMinuteOptions() {
                const options = [];
                for (let m = 0; m < 60; m += 5) {
                    const minute = String(m).padStart(2, '0');
                    options.push({ value: minute, text: minute });
                }
                return options;
            }

            function updateHiddenFields() {
                const ap_h = horarioAperturaHoraSelect.value;
                const ap_m = horarioAperturaMinutoSelect.value;
                const ci_h = horarioCierreHoraSelect.value;
                const ci_m = horarioCierreMinutoSelect.value;

                horarioAperturaHidden.value = (ap_h && ap_m) ? `${ap_h}:${ap_m}` : '';
                horarioCierreHidden.value = (ci_h && ci_m) ? `${ci_h}:${ci_m}` : '';
            }

            function populateTimeSelects() {
                const hourOptions = generateHourOptions();
                const minuteOptions = generateMinuteOptions();

                const oldApertura = "{{ old('horario_apertura', $terminal->horario_apertura) }}";
                const oldCierre = "{{ old('horario_cierre', $terminal->horario_cierre) }}";

                const oldAperturaHora = oldApertura.substring(0, 2);
                const oldAperturaMinuto = oldApertura.substring(3, 5);
                const oldCierreHora = oldCierre.substring(0, 2);
                const oldCierreMinuto = oldCierre.substring(3, 5);

                const fillSelect = (selectElement, options, oldValue, defaultText) => {
                    selectElement.innerHTML = `<option value="">${defaultText}</option>`;
                    options.forEach(option => {
                        const isSelected = option.value === oldValue;
                        const newOption = new Option(option.text, option.value, false, isSelected);
                        selectElement.appendChild(newOption);
                    });
                };

                fillSelect(horarioAperturaHoraSelect, hourOptions, oldAperturaHora, 'Hora');
                fillSelect(horarioAperturaMinutoSelect, minuteOptions, oldAperturaMinuto, 'Min');
                fillSelect(horarioCierreHoraSelect, hourOptions, oldCierreHora, 'Hora');
                fillSelect(horarioCierreMinutoSelect, minuteOptions, oldCierreMinuto, 'Min');

                updateHiddenFields();
            }

            // 🚀 Inicialización
            populateTimeSelects();

            if (departamentoSelect.value) {
                loadMunicipios();
            }

            // 📐 Redimensionamiento de Textareas
            direccionTextarea.addEventListener('input', autoResize);
            descripcionTextarea.addEventListener('input', autoResize);
            if (direccionTextarea.value) autoResize.call(direccionTextarea);
            if (descripcionTextarea.value) autoResize.call(descripcionTextarea);

            // 👂 Event Listeners
            departamentoSelect.addEventListener('change', loadMunicipios);
            municipioSelect.addEventListener('change', updateCodigo);
            nombreInput.addEventListener('input', updateCodigo);

            [
                horarioAperturaHoraSelect,
                horarioAperturaMinutoSelect,
                horarioCierreHoraSelect,
                horarioCierreMinutoSelect
            ].forEach(select => {
                select.addEventListener('change', updateHiddenFields);
                select.addEventListener('change', function() { clearError(this); });
            });

            document.querySelectorAll(
                'input:not([type="hidden"]):not([readonly]), select:not([id^="horario_apertura_"]):not([id^="horario_cierre_"]), textarea'
            ).forEach(field => {
                field.addEventListener('input', function() { clearError(this); });
                field.addEventListener('change', function() { clearError(this); });
            });

            // 🛑 Validación del Formulario
            terminalForm.addEventListener('submit', function(event) {
                let isValid = true;
                let firstInvalidField = null;

                updateHiddenFields();

                document.querySelectorAll(
                    'input:not([type="hidden"]):not([readonly]), select, textarea'
                ).forEach(field => clearError(field));

                const requiredFields = terminalForm.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    let message = '';
                    const value = field.value.trim();
                    const fieldId = field.id;
                    let isFieldInvalid = false;

                    let horaSelect, minutoSelect;
                    if (fieldId.startsWith('horario_')) {
                        horaSelect = document.getElementById(fieldId.startsWith('horario_apertura') ? 'horario_apertura_hora' : 'horario_cierre_hora');
                        minutoSelect = document.getElementById(fieldId.startsWith('horario_apertura') ? 'horario_apertura_minuto' : 'horario_cierre_minuto');
                    }

                    // Validación de campos de Horario
                    if (fieldId.startsWith('horario_') && (fieldId.endsWith('_hora') || fieldId.endsWith('_minuto'))) {
                        if (fieldId.endsWith('_hora')) {
                            if (!horaSelect.value || !minutoSelect.value) {
                                message = 'Debe seleccionar tanto la **hora** como el **minuto**.';
                                isFieldInvalid = true;

                                if (!horaSelect.value) showError(horaSelect, '');
                                if (!minutoSelect.value) showError(minutoSelect, message);
                            }
                        }
                    }
                    // Validación de otros campos vacíos
                    else if (!value) {
                        message = 'Este campo es **obligatorio**.';
                        isFieldInvalid = true;
                    }

                    // Validación de Teléfono
                    else if (fieldId === 'telefono' && !/^\d{8}$/.test(value)) {
                        message = 'El teléfono debe contener exactamente **8 dígitos** numéricos.';
                        isFieldInvalid = true;
                    }

                    // Validación de Correo
                    else if (fieldId === 'correo' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        message = 'Ingrese un **correo electrónico válido** (ej: nombre@dominio.com).';
                        isFieldInvalid = true;
                    }

                    // Validación Horario Cierre vs Apertura
                    const aperturaValue = horarioAperturaHidden.value;
                    const cierreValue = horarioCierreHidden.value;

                    if (fieldId.startsWith('horario_cierre_') && cierreValue && aperturaValue) {
                        if (cierreValue <= aperturaValue) {
                            message = 'El horario de cierre debe ser **posterior** al de apertura.';
                            isFieldInvalid = true;

                            showError(horarioCierreHoraSelect, '');
                            showError(horarioCierreMinutoSelect, message);
                        }
                    }

                    if (isFieldInvalid) {
                        isValid = false;
                        if (!fieldId.startsWith('horario_')) {
                            showError(field, message);
                        } else if (fieldId.endsWith('_hora')) {
                            if (!horaSelect.value) showError(field, message);
                        }

                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                    }
                }
            });

        });
    </script>
@endsection
