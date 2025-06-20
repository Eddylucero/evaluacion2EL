@extends('layout.app')

@section('contenido')
<br>
<h1 class="text-center">Listado de Predios</h1>

@if(session('message'))
    <script>
        Swal.fire({
            title: "CONFIRMACIÓN",
            text: "{{ session('message') }}",
            icon: "success",
        });
    </script>
@endif

<div class="container mt-4">
    <div class="mx-auto" style="max-width: 1000px;">
        <div class="text-end mb-3">
            <a href="{{ route('circuitos.create') }}" class="btn btn-outline-success">
                <i class="fa fa-plus"></i> Agregar circuito
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Pais</th>
                        <th>Nombre</th>
                        <th>Coordenada N°1</th>
                        <th>Coordenada N°2</th>
                        <th>Coordenada N°3</th>
                        <th>Coordenada N°4</th>
                        <th>Coordenada N°5</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($circuitos as $circuitoTemporal)
                        <tr>
                            <td>{{ $circuitoTemporal->propietario }}</td>
                            <td>{{ $circuitoTemporal->clave }}</td>
                            <td>Latitud: {{ $circuitoTemporal->latitud1 }}<br>Longitud: {{ $circuitoTemporal->longitud1 }}</td>
                            <td>Latitud: {{ $circuitoTemporal->latitud2 }}<br>Longitud: {{ $circuitoTemporal->longitud2 }}</td>
                            <td>Latitud: {{ $circuitoTemporal->latitud3 }}<br>Longitud: {{ $circuitoTemporal->longitud3 }}</td>
                            <td>Latitud: {{ $circuitoTemporal->latitud4 }}<br>Longitud: {{ $circuitoTemporal->longitud4 }}</td>
                            <td class="text-center">
                                <a href="{{ route('circuitos.edit', $circuitoTemporal->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <form action="{{ route('circuitos.destroy', $circuitoTemporal->id) }}" method="POST" class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-eliminar">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay predios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-eliminar').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro de eliminar este predio?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    });
</script>
@endsection
