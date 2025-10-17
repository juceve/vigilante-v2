<div>
    <div class="container text-center d-grid mt-5">
        <button
            class="btn btn-primary py-4"
            id="btn-guardar"
            data-scheduled="{{ $designacione->turno->horainicio }}"
            onclick="activarGeolocalizacion()"
        >
            <!-- guardamos el HTML original al cargar vía JS para poder restaurarlo -->
            <h4 class="text-secondary"><i class="fas fa-user-clock"></i> INICIAR TURNO</h4>
            <small class="text-secondary">
                <b>{{ $designacione->turno->horainicio }} HRS.</b>
            </small>
        </button>
        <small class="text-muted mt-2" id="marcado-status">Se solicitará su ubicación al iniciar el turno</small>
    </div>
</div>

@section('css')
<style>
    /* Forzar modo claro permanente */
    * {
        color-scheme: light !important;
    }

    html,
    body {
        background-color: #f8fafc !important;
        color: #1e293b !important;
    }
</style>
@endsection

@section('js')
    <script>
        // Guardar y restaurar HTML original, validar expiración (más de 1 hora desde la hora programada)
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('btn-guardar');
            if (btn && !btn.dataset.originalHtml) {
                btn.dataset.originalHtml = btn.innerHTML;
            }
            checkExpiration();
            // volver a comprobar cada minuto por si la página queda abierta
            setInterval(checkExpiration, 60 * 1000);
        });

        function parseTimeStringToDate(timeStr) {
            // timeStr esperado "HH:MM" (24h)
            const parts = (timeStr || '').split(':');
            if (parts.length < 2) return null;
            const d = new Date();
            d.setHours(parseInt(parts[0], 10) || 0);
            d.setMinutes(parseInt(parts[1], 10) || 0);
            d.setSeconds(0);
            d.setMilliseconds(0);
            return d;
        }

        function checkExpiration() {
            const btn = document.getElementById('btn-guardar');
            const status = document.getElementById('marcado-status');
            if (!btn) return;
            const scheduled = btn.getAttribute('data-scheduled');
            const scheduledDate = parseTimeStringToDate(scheduled);
            if (!scheduledDate) return;

            const now = new Date();
            const msDiff = now - scheduledDate; // positivo si ahora es posterior
            const expired = msDiff > (60 * 60 * 1000); // más de 1 hora

            if (expired) {
                btn.disabled = true;
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-secondary');
                btn.innerHTML = '<h4 class="text-warning"><i class="fas fa-user-clock"></i> MARCADO VENCIDO</h4><small class="text-danger"><b>Comuníquese con administración</b></small>';
                if (status) status.textContent = 'El tiempo para realizar el marcado expiró. Comuníquese con administración.';
            } else {
                // restaurar estado original si no está expirado
                if (btn.dataset.originalHtml && btn.disabled) {
                    btn.disabled = false;
                    btn.classList.remove('btn-secondary');
                    btn.classList.add('btn-primary');
                    btn.innerHTML = btn.dataset.originalHtml;
                    if (status) status.textContent = 'Se solicitará su ubicación al iniciar el turno';
                }
            }
        }

        function activarGeolocalizacion() {
            const btn = document.getElementById('btn-guardar');
            if (!btn || btn.disabled) return; // no hacer nada si está deshabilitado
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(enviar, error);
            } else {
                alert('Tu navegador no soporta geolocalizacion.');
                Livewire.emit('cargaPosicion', [null, null]);
            }
        }

        function enviar(pos) {
            let latitud = pos.coords.latitude;
            let longitud = pos.coords.longitude;
            Livewire.emit('cargaPosicion', [latitud, longitud]);
        }

        function error(err) {
            console.warn('Error de geolocalización:', err);
            Livewire.emit('cargaPosicion', [null, null]);
        }
    </script>
@endsection
