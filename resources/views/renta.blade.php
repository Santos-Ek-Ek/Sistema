<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
 <script src="js/jquery.min.js"></script>
  <link href="css/estilos.css" rel="stylesheet">
    <script src="js/all.min.js"></script>
   
 Latest compiled and minified CSS
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

Optional theme
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

Latest compiled and minified JavaScript
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

</head>
<body> -->
  
@extends('layouts.app')
@section('titulo','Rentas')
@section('content')
<div class="container" id="renta"><br>
  <div class="card-header bg-info text-white">
        <h2>Rentas <span class="btn btn-success" @click="mostrarModal()"><i class="fa-solid fa-plus"></i> Agregar renta</span> <a href="{{ route ('pdf')}}" target="_blank" class="btn btn-success"><i class="fa-regular fa-file-pdf"></i> Reporte</a></h2>
        
    </div>  
    <input type="text" class="form-control" v-model="busqueda" placeholder="Buscar renta">

<table class="table table-striped table-hover table-responsive table-bordered">
<thead class="bg-info text-white">
    <tr>
      <th >#</th>
      <th>Cliente</th>
      <th>Tiempo inicial</th>
      <th>Tiempo final</th>
      <th>Cantidad</th>
      <th>Costo</th>
      <th>No_cuatri</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="renta in filtrarRenta">
      <th>@{{renta.id}}</th>
      <td>@{{renta.clientes.Nombre}} @{{renta.clientes.Apellido}}</td>
      <td>@{{renta.hora_inicio}}</td>
      <td>@{{renta.hora_fin}}</td>
      <td>@{{renta.cantidad}}</td>
      <td>@{{renta.costo}}</td> 
      <td>@{{renta.no_cuatri}}</td>
      <td>@{{renta.est}}</td>
      <td>
      <button class="btn btn-outline-secondary" @click="editarRenta(renta.id)"><i class="fa-regular fa-pen-to-square"></i></button>
      <button class="btn btn-outline-danger" @click="eliminarRenta(renta.id)"><i class="fas fa-trash"></i></button>
      <button class="btn btn-outline-warning" @click="finalizarRenta(renta.id)"><i class="fa-solid fa-ban "></i> Finalizar renta</button>
      <a class="btn btn-outline-success" v-on:click="showPDF(renta.id)"><i class="fa-regular fa-file-pdf"></i> Ticket</a>
    </td>
    </tr>

  </tbody>
</table>
<!-- Modal -->


<!-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="Mostrar">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade"  id="modalRenta" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel" v-if="agregando==true">Agregar renta</h1>
        <h1 class="modal-title fs-5" id="exampleModalLabel" v-if="agregando==false">Actualizar renta</h1>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form-group">
        @csrf
       
      <div class="form-group" v-if= "agregando==true">
      <label class="col-form-label">Cliente:</label>
      <input type="text" class="form-control" placeholder="Nombre del cliente" v-model="nombre">
      <label class="col-form-label">Apellido:</label>
      <input type="text" class="form-control" placeholder="Apellidos" v-model="apellido">
      <label class="col-form-label">Edad:</label>
      <input type="text" class="form-control" placeholder="Edad" v-model="edad">
      <div class="form-group">
            <label for="message-text" class="col-form-label">Integrantes/Edad:</label>
            <textarea class="form-control" id="message-text" placeholder="nombre1;edad,nombre2;edad" v-model="integrante"></textarea>
          </div>
      <div class="form-group">
    <label class="col-form-label">Email:</label>
    <input type="email" class="form-control" v-model="email" @blur="validarEmail" placeholder="ejemplo@gmail.com">
    <small v-if="emailError" class="text-danger">@{{ emailError }}</small>
  </div>
  <div class="form-group">
    <label class="col-form-label">Teléfono:</label>
    <input type="text" class="form-control" v-model="telefono" placeholder="1234567890">
    <!-- <small v-if="telefonoError" class="text-danger">@{{ telefonoError }}</small> -->
  </div>
      <label class="col-form-label">Documento:</label>
      <select class="form-control" v-model="documento">
        <option disabled>Documento de verificación</option>
        <option value="DNI">DNI</option>
        <option value="PASAPORTE">PASAPORTE</option>
      </select>
      </div>
      <label class="col-form-label">Personas por cuatrimoto:</label>
        <select class="form-control" v-model="personas_cuatris" @change="totalPagar">
          <option disabled >Personas por cuatrimoto</option>
          <option v-for="precio in precios" v-bind:value="precio.persona_cuatrimoto" >@{{precio.persona_cuatrimoto}}</option>
        </select>
        <label for="start-time" class="col-form-label">Hora de inicio:</label>
  <input type="datetime-local" class="form-control" id="start-time" v-model="startTime" @input="updateEndTime">

  <label for="end-time" class="col-form-label">Hora de fin:</label>
  <input type="datetime-local" class="form-control" id="end-time" v-model="endTime" :min="minEndTime" disabled>
  <div>
    <Disponible></Disponible>
  </div>
      <label for="cantidad" class="col-form-label">Cantidad de vehículos:</label>
        <input type="number" class="form-control" placeholder="Cantidad"  v-model="Cantidad_cuatris" @input="totalPagar">


        <div class="form-group">
    <label for="cuatrimotos" class="col-form-label">Cuatrimotos</label>
    <select class="form-control" id="cuatrimotos" name="cuatrimotos[]" multiple v-model="cuatrimotosSeleccionadas" disabled>
        <!-- Opciones de las cuatrimotos -->
        <option v-for="cuatrimoto in cuatris" v-if="cuatrimoto.estado === 'Disponible'" :value="cuatrimoto.id">@{{cuatrimoto.id}}</option>
    </select>
      </div>
        <label class="col-form-label">Total a pagar:</label>
        <input type="text" class="form-control" placeholder="total" v-model="costoTotal" disabled>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" @click="guardarRenta()" v-if="agregando==true">Guardar</button>
        <button type="button" class="btn btn-primary" @click="actualizarRenta()" v-if="agregando==false">Guardar</button>
      </div>
    </div>
  </div>
</div>
</div>



@endsection

@push('scripts')
<script src="js/componente.js"></script>




<script src="js/apiRenta.js"></script>
<!-- <script src="js/apiCuatri.js"></script> -->
<script src="js/bootstrap.min.js"></script>
@endpush

<!-- 
</body>
</html> -->
