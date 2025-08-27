<div class="container-fluid py-3">
       
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10 col-xxl-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header text-white rounded-top-4"
                    style="background: linear-gradient(90deg, #0d6efd, #0dcaf0);">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Registro de Propietario</h5>
                        <div wire:loading>
                            <div class="spinner-border spinner-border-sm text-light" role="status"></div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @error('general')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <form wire:submit.prevent="save" novalidate id="form-propietario">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cédula *</label>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('cedula') is-invalid @enderror"
                                        placeholder="Cédula" aria-label="Cédula" aria-describedby="button-addon2"
                                        wire:model.lazy="cedula">
                                    <button class="btn btn-outline-success" type="button" title="Buscar"
                                        wire:click='buscarPropietario'>
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                                @error('cedula')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nombre *</label>
                                <input type="text" @if ($existePropietario) disabled @endif
                                    class="form-control text-uppercase @error('nombre') is-invalid @enderror"
                                    style="text-transform: uppercase;" wire:model.defer="nombre"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" @if ($existePropietario) disabled @endif
                                    class="form-control @error('telefono') is-invalid @enderror"
                                    wire:model.defer="telefono">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" @if ($existePropietario) disabled @endif
                                    class="form-control @error('email') is-invalid @enderror" wire:model.defer="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Dirección</label>
                                <input type="text" @if ($existePropietario) disabled @endif
                                    class="form-control text-uppercase @error('direccion') is-invalid @enderror"
                                    style="text-transform: uppercase;" wire:model.defer="direccion"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ciudad</label>
                                <input type="text" @if ($existePropietario) disabled @endif
                                    class="form-control text-uppercase @error('ciudad') is-invalid @enderror"
                                    style="text-transform: uppercase;" wire:model.defer="ciudad"
                                    oninput="this.value = this.value.toUpperCase()">
                                @error('ciudad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div wire:ignore>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Residencias</h5>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddResidencia">
                                    + Agregar Residencia
                                </button>
                            </div>

                            <div class="accordion" id="accordionResidencias"></div>

                            {{-- Campo oculto para enviar residencias como JSON --}}
                            <input type="hidden" wire:model.defer="residencias_json" id="residencias_json">

                            @if ($errors->has('residencias'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('residencias') }}
                                </div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4" wire:loading.attr="disabled"
                                wire:target='save'>
                                <span wire:loading.remove wire:target='save'>Registrar Solicitud <i class="bi bi-floppy"></i></span>
                                <span wire:loading wire:target='save'>
                                    <span class="spinner-border spinner-border-sm" role="status"></span>
                                    Registrando...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Overlay global mientras Livewire procesa --}}
            <div wire:loading.flex wire:target='save'
                style="position: fixed; inset: 0; background: rgba(255,255,255,.6); z-index: 1050;
                        align-items:center; justify-content:center;">
                <div class="spinner-border" role="status"></div>
            </div>
        </div>
    </div>
</div>

<script>
    // Residencias dinámicas en JS
    let residencias = [];
    try {
        const initial = document.getElementById('residencias_json').value;
        residencias = initial ? JSON.parse(initial) : [{
            numeropuerta: '',
            piso: '',
            calle: '',
            nrolote: '',
            manzano: '',
            notas: ''
        }];
    } catch (e) {
        residencias = [{
            numeropuerta: '',
            piso: '',
            calle: '',
            nrolote: '',
            manzano: '',
            notas: ''
        }];
    }

    function syncResidencias() {
        const input = document.getElementById('residencias_json');
        input.value = JSON.stringify(residencias);
        input.dispatchEvent(new Event('input')); // 🔑 Notificar a Livewire
    }

    function renderResidencias() {
        const container = document.getElementById('accordionResidencias');
        container.innerHTML = '';
        residencias.forEach((res, idx) => {
            container.innerHTML += `
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="heading${idx}">
                        <button class="accordion-button ${idx !== residencias.length - 1 ? 'collapsed' : ''}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse${idx}"
                                aria-expanded="${idx === residencias.length - 1 ? 'true' : 'false'}">
                            Residencia #${idx + 1}
                        </button>
                    </h2>
                    <div id="collapse${idx}" class="accordion-collapse collapse ${idx === residencias.length - 1 ? 'show' : ''}"
                         aria-labelledby="heading${idx}" data-bs-parent="#accordionResidencias">
                        <div class="accordion-body">
                            <div class="row g-3">
                                ${['numeropuerta','piso','calle','nrolote','manzano','notas'].map(field => `
                                    <div class="col-md-4">
                                        <label class="form-label">${field.charAt(0).toUpperCase()+field.slice(1)}</label>
                                        <input type="text" class="form-control" value="${res[field] || ''}"
                                            onchange="updateResidencia(${idx}, '${field}', this.value)"
                                            oninput="updateResidencia(${idx}, '${field}', this.value)">
                                    </div>
                                `).join('')}
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                ${residencias.length > 1 ? `
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                            onclick="removeResidencia(${idx})">
                                        Eliminar
                                    </button>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        syncResidencias();

        // Expandir último
        setTimeout(() => {
            residencias.forEach((_, idx) => {
                const collapse = document.getElementById('collapse' + idx);
                if (collapse) {
                    if (idx === residencias.length - 1) {
                        collapse.classList.add('show');
                    } else {
                        collapse.classList.remove('show');
                    }
                }
            });
        }, 50);
    }

    function updateResidencia(idx, field, value) {
        residencias[idx][field] = value;
        syncResidencias();
    }

    function removeResidencia(idx) {
        residencias.splice(idx, 1);
        renderResidencias();
    }

    document.getElementById('btnAddResidencia').addEventListener('click', function() {
        residencias.push({
            numeropuerta: '',
            piso: '',
            calle: '',
            nrolote: '',
            manzano: '',
            notas: ''
        });
        renderResidencias();
    });

    document.addEventListener('DOMContentLoaded', function() {
        renderResidencias();
    });

    document.getElementById('form-propietario').addEventListener('submit', function() {
        syncResidencias();
    });
</script>
