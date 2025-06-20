@extends('layout.app')

@section('contenido')
<h1 class="text-center">Registrar nuevo predio</h1>
<hr>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('circuitos.store') }}" method="POST">
            @csrf
            <label><b>Pais:</b></label>
            <input type="text" name="pais" id="pais" placeholder="Ingrese el pais del circuito..." required class="form-control"><br>

            <label><b>Nombre:</b></label>
            <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre del circuito..." required class="form-control"><br>

            @for ($i = 1; $i <= 5; $i++)
            <div class="row">
                <div class="col-md-5">
                    <label><b>COORDENADA N°{{ $i }}</b></label><br><br>
                    <label><b>Latitud</b></label>
                    <input type="number" name="latitud{{ $i }}" id="latitud{{ $i }}" class="form-control" readonly placeholder="Seleccione la latitud en el mapa">
                    <label><b>Longitud</b></label>
                    <input type="number" name="longitud{{ $i }}" id="longitud{{ $i }}" class="form-control" readonly placeholder="Seleccione la longitud en el mapa"><br>
                </div>
                <div class="col-md-7">
                    <br>
                    <div id="mapa{{ $i }}" style="border:2px solid white; height:200px; width:100%;"></div>
                </div>
            </div>
            @endfor

            <br>
            <hr>
            <center>
                <button type="button" class="btn btn-outline-primary" onclick="graficarPredio();">
                    Graficar circuito <i class="fa fa-ruler"></i>
                </button>
            </center>            
            <hr>
            <div class="row">
              <h2 class ="text-center">Grafico del Circuito</h2>
              <hr>
                <div class="col-md-12">
                    <div id="mapa-poligono" style="height: 500px; width:100%; border:2px solid blue;"></div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="{{ route('circuitos.index') }}" class="btn btn-outline-danger">
                        <i class="fa fa-times"></i> Cancelar
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="reset" class="btn btn-outline-warning">
                        Limpiar <i class="fa fa-broom"></i>
                    </button>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-outline-success" type="submit">
                        Guardar Circuito <i class="fa fa-save"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    var mapaPoligono;

    function initMap() {
        var latlngInicial = new google.maps.LatLng(-0.9374805, -78.6161327);

        for (let i = 1; i <= 5; i++) {
            const mapa = new google.maps.Map(
                document.getElementById('mapa' + i),
                {
                    center: latlngInicial,
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
            );

            const marcador = new google.maps.Marker({
                position: latlngInicial,
                map: mapa,
                title: "Seleccione la coordenada " + i,
                draggable: true
            });

            google.maps.event.addListener(marcador, 'dragend', function () {
                const lat = this.getPosition().lat();
                const lng = this.getPosition().lng();
                document.getElementById('latitud' + i).value = lat;
                document.getElementById('longitud' + i).value = lng;
            });
        }

        mapaPoligono = new google.maps.Map(
            document.getElementById("mapa-poligono"),
            {
                zoom: 15,
                center: latlngInicial,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
        );
    }

    function graficarPredio() {
        const coordenadas = [];

        for (let i = 1; i <= 5; i++) {
            const lat = document.getElementById('latitud' + i).value;
            const lng = document.getElementById('longitud' + i).value;

            if (!lat || !lng) {
                alert("Debe seleccionar todas las coordenadas.");
                return;
            }

            coordenadas.push(new google.maps.LatLng(parseFloat(lat), parseFloat(lng)));
        }

        // cerrar polígono
        coordenadas.push(coordenadas[0]);

        const poligono = new google.maps.Polygon({
            paths: coordenadas,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#00FF00",
            fillOpacity: 0.35,
        });

        poligono.setMap(mapaPoligono);
    }
</script>

@endsection
