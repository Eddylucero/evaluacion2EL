@extends('layout.app')

@section('contenido')
<h1 class="text-center">Editar Predio</h1>
<hr>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8 p-4 rounded">
        <form action="{{ route('predios.update', $predio->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label><b>Pais:</b></label>
            <input type="text" name="pais" class="form-control" required value="{{ old('pasi', $circuito->pais) }}">
            <br>

            <label><b>Nombre:</b></label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre', $circuito->nombre) }}">
            <br>

            @for($i = 1; $i <= 5; $i++)
            <div class="row mb-4">
                <div class="col-md-5">
                    <label><b>COORDENADA N°{{ $i }}</b></label><br>
                    <label>Latitud</label>
                    <input type="number" step="any" name="latitud{{ $i }}" id="latitud{{ $i }}" class="form-control" readonly value="{{ old("latitud$i", $predio->{'latitud' . $i}) }}">
                    <label>Longitud</label>
                    <input type="number" step="any" name="longitud{{ $i }}" id="longitud{{ $i }}" class="form-control" readonly value="{{ old("longitud$i", $predio->{'longitud' . $i}) }}">
                </div>
                <div class="col-md-7">
                    <label>&nbsp;</label>
                    <div id="mapa{{ $i }}" style="border:2px solid white; height:200px; width:100%"></div>
                </div>
            </div>
            @endfor

            <center>
                <hr>
                <a href="{{ route('predios.index') }}" class="btn btn-outline-danger"><i class="fa fa-times"></i> Cancelar</a>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-outline-success" type="submit">Actualizar <i class="fa fa-save"></i></button>
                &nbsp;&nbsp;&nbsp;                
                <button type="button" class="btn btn-outline-primary" onclick="graficarPredio();">Graficar Predio <i class="fa fa-ruler"></i></button>
                <hr>
            </center>
        </form>
    </div>
    <div class="col-md-2"></div>
</div>

<br>
<div class="row">
    <h2 class ="text-center">Grafico del Predio</h2>
    <hr>
    <div class="col-md-12">
        <div id="mapa-poligono" style="height: 500px; width:100%; border:2px solid blue;"></div>
    </div>
</div>

<script>
    let mapaPoligono;
    let poligonoActual = null;

    function initMap() {
        const coords = [
            { lat: {{ $predio->latitud1 }}, lng: {{ $predio->longitud1 }} },
            { lat: {{ $predio->latitud2 }}, lng: {{ $predio->longitud2 }} },
            { lat: {{ $predio->latitud3 }}, lng: {{ $predio->longitud3 }} },
            { lat: {{ $predio->latitud4 }}, lng: {{ $predio->longitud4 }} },
        ];

        coords.forEach((coor, index) => {
            const map = new google.maps.Map(document.getElementById('mapa' + (index + 1)), {
                center: coor,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            const marker = new google.maps.Marker({
                position: coor,
                map: map,
                title: `Seleccione coordenada ${index + 1}`,
                draggable: true
            });

            marker.addListener('dragend', function () {
                document.getElementById('latitud' + (index + 1)).value = this.getPosition().lat();
                document.getElementById('longitud' + (index + 1)).value = this.getPosition().lng();
            });
        });

        mapaPoligono = new google.maps.Map(document.getElementById("mapa-poligono"), {
            zoom: 15,
            center: coords[0],
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        graficarPredio(); // mostrar el polígono al cargar
    }

    function graficarPredio() {
        const coordenadas = [];

        for (let i = 1; i <= 4; i++) {
            const lat = parseFloat(document.getElementById('latitud' + i).value);
            const lng = parseFloat(document.getElementById('longitud' + i).value);
            if (!isNaN(lat) && !isNaN(lng)) {
                coordenadas.push({ lat: lat, lng: lng });
            }
        }

        if (poligonoActual) {
            poligonoActual.setMap(null);
        }

        poligonoActual = new google.maps.Polygon({
            paths: coordenadas,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#00FF00",
            fillOpacity: 0.35,
        });

        poligonoActual.setMap(mapaPoligono);
    }

    window.addEventListener('load', initMap);
</script>
@endsection
