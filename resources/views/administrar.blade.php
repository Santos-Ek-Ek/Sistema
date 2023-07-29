@extends('layouts.app')
@section('titulo', 'Administrar')
@section('content')
<div class="container">
<div class="container" id="cuatri">
<div class="card-header bg-info text-white">
        <h2>Administración <span class="btn btn-success" @click="mostrarModal()"><i class="fa-solid fa-plus"></i> Agregar cuatrimoto</span>  <a href="{{ route ('pdfCuatri')}}" target="_blank" class="btn btn-success">  <i class="fa-regular fa-file-pdf"></i> Reporte</a></h2>
    </div>  
<table class="table table-striped table-responsive table-bordered">
<thead class="bg-info text-white">
    <tr>
      <th >#</th>
      <th>Marca</th>
      <th>Color</th>
      <th>Placa</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="cuatri in cuatris">
      <th>@{{cuatri.id}}</th>
      <td>@{{cuatri.marca}}</td>
      <td>@{{cuatri.color}}</td>
      <td>@{{cuatri.placa}}</td>
      <td><span :class="{'badge bg-success': cuatri.estado === 'Disponible', 'badge bg-warning': cuatri.estado === 'En renta', 'badge bg-danger': cuatri.estado === 'Fuera de servicio'}">@{{cuatri.estado}}</span></td>
      <!-- <td v-else><span class="badge bg-warning">@{{cuatri.estado}}</span></td> -->
      <td><button class="btn" @click="editarCuatri(cuatri.id)"><i class="fa-regular fa-pen-to-square"></i></button>
      <button class="btn" @click="eliminarCuatri(cuatri.id)"><i class="fas fa-trash"></i></button>
      </td>
    </tr>

  </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modalCuatri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel" v-if="agregando==true">Agregar cuatrimoto</h1>
        <h1 class="modal-title fs-5" id="exampleModalLabel" v-if="agregando==false">Actualizar cuatrimoto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
        @csrf
      <label>Número de cuatrimoto:</label>
      <input type="number" class="form-control" placeholder="Número" v-model="num_cuatri">
 
        <label>Marca:</label>
  <input type="text" class="form-control" placeholder="Marca" v-model="marca">
  <label>Color de cuatrimoto:</label>
        <input type="text" class="form-control" placeholder="Color" v-model="color">
  <label for="end-time">Placas:</label>
  <input type="text" class="form-control" placeholder="Placas. si no tiene introduzca N/A" v-model="placa">
        <label>Estado:</label>
        <select class="form-control" v-model="estado">
          <option disabled >Estado de la cuatrimoto</option>
          <option value="Disponible">Disponible</option>
          <option value="En renta">En renta</option>
          <option value="Fuera de servicio">Fuera de servicio</option>
        </select>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" @click="guardarCuatri()" v-if="agregando==true">Guardar</button>
        <button type="button" class="btn btn-primary" @click="actualizarCuatri()" v-if="agregando==false">Guardar</button>
      </div>
    </div>
  </div>
</div>



</div>

</div>
@endsection

@push('scripts')
<script src="js/apiCuatri.js"></script>
<script src="js/bootstrap.min.js"></script>
@endpush