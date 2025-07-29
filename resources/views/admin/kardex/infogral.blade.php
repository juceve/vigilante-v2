  <div class="row">
      <div class="col-12 col-md-6 mb-2">
          <strong>Nombres:</strong>
          {{ $empleado->nombres }}
      </div>
      <div class="col-12 col-md-6 mb-2">
          <strong>Apellidos:</strong>
          {{ $empleado->apellidos }}
      </div>
    
      <div class="col-12 col-md-6 mb-2">
          <strong>Nacionalidad:</strong>
          {{ $empleado->nacionalidad }}
      </div>
      
    
      <div class="col-12 col-md-6 mb-2">
          <strong>Area:</strong>
          {{ $empleado->area->nombre }}
      </div>
      <div class="col-12 col-md-6 mb-2">
          <strong>Cubre Relevos:</strong>
          @if ($empleado->cubrerelevos)
              <span class="badge bg-success">SI</span>
          @else
              <span class="badge bg-secondary">NO</span>
          @endif
      </div>
      <div class="col-12 col-md-6 mb-2">
          <strong>Usuario:</strong>
          @if ($empleado->user_id)
              <span class="badge bg-success">Generado</span>
              @if ($empleado->user->status)
                  <span class="badge badge-pill badge-primary">Activo</span>
              @else
                  <span class="badge badge-pill badge-secondary">Inactivo</span>
              @endif
          @else
              <span class="badge bg-secondary">No generado</span>
          @endif
      </div>
      <div class="col-12 mb-2">
          <strong>Direccion:</strong>
          {{ $empleado->direccion }}
      </div>
  </div>
  <hr>
  <div class="row">
     
      <div class="col-12 col-md-4">
          <label>Cedula Anverso</label> <br>
          @if ($empleado->cedulaanverso)
              <img src="{{ asset('storage/' . $empleado->cedulaanverso) }}" class="img-thumbnail img-preview2">
          @else
              <img src="{{ asset('images/anverso.png') }}" class="img-thumbnail img-preview2">
          @endif

      </div>
      <div class="col-12 col-md-4">
          <label>Cedula Reverso</label> <br>
          @if ($empleado->cedulareverso)
              <img src="{{ asset('storage/' . $empleado->cedulareverso) }}" class="img-thumbnail img-preview2">
          @else
              <img src="{{ asset('images/reverso.png') }}" class="img-thumbnail img-preview2">
          @endif

      </div>
  </div>
  <hr>
  @if ($empleado->direccionlat && $empleado->direccionlng)
      <div class="form-group mt-4 ">
          <label for="mapa">Ubicación del Domicilio:</label>
          <div id="mi_mapa" class="border border-dark rounded-lg" style="width: 100%; height: 500px;">
          </div>
      </div>
  @endif
  @section('plugins.OpenStreetMap', true)
  @section('js')
        <script>
      let map = L.map('mi_mapa').setView([{{ $empleado->direccionlat }}, {{ $empleado->direccionlng }}], 17)

      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy;'
      }).addTo(map);


      var myIcon = L.icon({
          iconUrl: "{{ asset('images/punt.png') }}",
          iconSize: [35, 35],
          iconAnchor: [35, 35],
          popupAnchor: [-15, -30],
      });

      L.marker([{{ $empleado->direccionlat }}, {{ $empleado->direccionlng }}]).addTo(map);
      // map.on('click', onMapClick)

      // function onMapClick(e) {
      //     alert("Posición: " + e.latlng)
      // }
  </script>
  @endsection

  <style>
      .img-preview {
          max-height: 250px;
      }

      .img-preview2 {
          max-height: 150px;
      }
  </style>
