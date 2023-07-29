@extends('layouts.app')
@section('titulo', 'Inicio')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div> -->
        </div>
    </div>
    <br>

<div class="card-group">
    <div class="col-md-6">
    <div class="card1 shadow p-3 mb-6 rounded" style="width: 18rem;">
  <img class="card-img-top" src="img/card1.jpg" alt="Card image cap">
  <div class="card-body">
    <h5 class="card-title"><b>INDIVIDUAL</b></h5>
    <p class="card-text"><b>$400 MXN por vehículo</b></p>
    <a href="rentas" class="btn btn-primary">Duración de 1 hora y 30 minutos</a>
  </div>
</div>
</div>

<div class="col-md-6 box">
<div class="card1 shadow p-3 mb-6 rounded" style="width: 18rem;">
  <img class="card-img-top" src="img/card2.jpg" alt="Card image cap" >
  <div class="card-body">
    <h5 class="card-title"><b>2 PAX</b></h5>
    <p class="card-text"><b>$500 MXN por vehículo</b></p>
    <a href="rentas" class="btn btn-primary">Duración de 1 hora y 30 minutos</a>
  </div>
</div>
</div>
</div>
</div> <br>


<div class="container" id="cuatri">
<div>
    <Disponible></Disponible>
  </div>
  <br>
<table class="table table-striped table-responsive table-bordered">
<thead class="bg-info text-white">
    <tr>
      <th >#</th>
      <th>Marca</th>
      <th>color</th>
      <th>Placa</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="cuatri in cuatris">
      <th>@{{cuatri.id}}</th>
      <td>@{{cuatri.marca}}</td>
      <td>@{{cuatri.color}}</td>
      <td>@{{cuatri.placa}}</td>
      <td><span :class="{'badge bg-success': cuatri.estado === 'Disponible', 'badge bg-warning': cuatri.estado === 'En renta', 'badge bg-danger': cuatri.estado === 'Fuera de servicio'}">@{{cuatri.estado}}</span></td>
    </tr>

  </tbody>
</table>
</div>

</div>




@endsection

@push('scripts')
<script src="js/componente.js"></script>
<script src="js/apiCuatri.js"></script>
<script src="js/bootstrap.min.js"></script>
@endpush

