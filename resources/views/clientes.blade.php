@extends('layouts.app')
@section('titulo', 'Clientes')
@section('content')
<div class="container">
<div class="container" id="cliente">
<div class="card-header bg-info text-white">
        <h2>clientes  <a href="{{ route ('pdfCliente')}}" target="_blank" class="btn btn-success"><i class="fa-regular fa-file-pdf"></i></a></h2>
    </div>  
<table class="table table-striped table-responsive table-bordered">
<thead class="bg-info text-white">
    <tr>
      <th >#</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Teléfono</th>
      <th>Email</th>
      <th>Documento</th>
      <!-- <th>No_cuatrimoto</th> -->
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="cliente in clientes">
      <th>@{{cliente.id}}</th>
      <td>@{{cliente.Nombre}}</td>
      <td>@{{cliente.Apellido}}</td>
      <td>@{{cliente.telefono}}</td>
      <td>@{{cliente.email}}</td>
      <td>@{{cliente.Documento}}</td>
      <!-- <td>@{{cliente.No_cuatri}}</td> -->
      <td><button class="btn"><i class="fa-regular fa-pen-to-square"></i></button>
      <button class="btn"><i class="fas fa-trash"></i></button>
      </td>
    </tr>

  </tbody>
</table>







</div>

</div>
@endsection

@push('scripts')
<script src="js/apiCliente.js"></script>
<script src="js/bootstrap.min.js"></script>
@endpush