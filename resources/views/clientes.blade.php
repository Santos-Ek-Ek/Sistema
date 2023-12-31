@extends('layouts.app')
@section('titulo', 'Clientes')
@section('content')
<div class="container">
<div class="container" id="cliente">
<div class="card-header bg-info text-white">
        <h2>clientes  <a href="{{ route ('pdfCliente')}}" target="_blank" class="btn btn-success"><i class="fa-regular fa-file-pdf"></i>  Reporte</a></h2>
    </div>  
    <input type="text" class="form-control" v-model="busqueda" placeholder="Buscar cliente">
<table class="table table-striped table-responsive table-bordered">
<thead class="bg-info text-white">
    <tr>
      <th >#</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Edad</th>
      <th>Teléfono</th>
      <th>Email</th>
      <th>Documento</th>
      <th>Integrantes/Edad</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="cliente in filtrarCliente">
      <th>@{{cliente.id}}</th>
      <td>@{{cliente.Nombre}}</td>
      <td>@{{cliente.Apellido}}</td>
      <td>@{{cliente.edad}}</td>
      <td>@{{cliente.telefono}}</td>
      <td>@{{cliente.email}}</td>
      <td>@{{cliente.Documento}}</td>
      <td>@{{cliente.integrante}}</td>
      <td><button class="btn btn-outline-secondary" @click="editarCliente(cliente.id)"><i class="fa-regular fa-pen-to-square"></i></button>
      <button class="btn btn-outline-danger" @click="eliminarCliente(cliente.id)"><i class="fas fa-trash" ></i></button>
      </td>
    </tr>

  </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h1 class="modal-title fs-5" id="exampleModalLabel" v-if="agregando==true">Agregar renta</h1> -->
        <h1 class="modal-title fs-5" id="exampleModalLabel" v-if="agregando==false">Actualizar Cliente</h1>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
        @csrf
       
      <div class="form-group">
      <label>Cliente:</label>
      <input type="text" class="form-control" placeholder="Nombre del cliente" v-model="nombre">
      <label>Apellido:</label>
      <input type="text" class="form-control" placeholder="Apellidos" v-model="apellido">
      <label class="col-form-label">Edad:</label>
      <input type="text" class="form-control" placeholder="Edad" v-model="edad">
      <div class="form-group">
            <label for="message-text" class="col-form-label">Integrantes/Edad:</label>
            <textarea class="form-control" id="message-text" placeholder="nombre1;edad,nombre2;edad" v-model="integrante"></textarea>
          </div>
      <div class="form-group">
    <label>Email:</label>
    <input type="email" class="form-control" v-model="email" @blur="validarEmail" placeholder="ejemplo@gmail.com">
    <small v-if="emailError" class="text-danger">@{{ emailError }}</small>
  </div>
  <div class="form-group">
    <label>Teléfono:</label>
    <input type="text" class="form-control" v-model="telefono"placeholder="1234567890">
    <!-- <small v-if="telefonoError" class="text-danger">@{{ telefonoError }}</small> -->
  </div>
      <label>Documento:</label>
      <select class="form-control" v-model="documento">
        <option disabled>Documento de verificación</option>
        <option value="DNI">DNI</option>
        <option value="PASAPORTE">PASAPORTE</option>
      </select>
      </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary" @click="guardarRenta()" v-if="agregando==true">Guardar</button> -->
        <button type="button" class="btn btn-primary" @click="actualizarCliente()" v-if="agregando==false">Guardar</button>
      </div>
    </div>
  </div>
</div>



</div>

</div>
@endsection

@push('scripts')
<script src="js/apiCliente.js"></script>
<script src="js/bootstrap.min.js"></script>
@endpush