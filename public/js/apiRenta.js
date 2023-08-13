// var route = document.querySelector("[name=route]");
var apiRenta = "http://localhost/Sistema/public/apiRenta";
var apiPrecio = "http://localhost/Sistema/public/apiPrecio";
var apiCliente = "http://localhost/Sistema/public/apiCliente";
var apiCuatri = "http://localhost/Sistema/public/apiCuatri";
var UrlPDF = "http://localhost/Sistema/public" + "/ticket";

new Vue({
    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },
    el :'#renta',
    data:{
      integrante:'',
      busqueda: '',
      cuatrimotosDisponibles: [],
    cuatrimotosEnRenta: [],
        renta:[],
        precios:[],
        clientes:[],
        startTime: '',
        endTime: '',
        Cantidad_cuatris: 0,
        personas_cuatris: 1,
        costoTotal: 0,
        id:'',
        edad:'',
        idRenta:'',
        idCliente:'',
        nombre:'',
        apellido:'',
        telefono:'',
        email:'',
        documento:'',
        no_cuatri:'',
        nombreCliente: '',
        email: '',
        emailError: '',
        // telefono: '',
        // telefonoError: '',
        agregando:true,
        cuatris:[],
        id_cuatri:'',
        num_cuatri:'',
        marca:'',
        color:'',
        placa:'',
        estado:'',
    },

    created:function(){
      this.obtenerCuatrimotosDisponibles();
        this.obtenerRenta();
        this.obtenerPrecio();
        this.obtenerClientes();
        this.obtenerCuatris();
        this.actualizarIdsSeleccionados();
    },
    watch: {
      Cantidad_cuatris: function (nuevoValor) {
        this.actualizarIdsSeleccionados(); // Llamamos a la función cuando cambia Cantidad_cuatris
      },
    },
 

    methods:{
      obtenerCuatrimotosDisponibles() {
        this.$http.get('cuatrimotos/dis')
          .then((response) => {
            this.cuatris = response.data.dis;
            this.obtenerCuatrimotosEnRenta(); // Llamamos a esta función para obtener las cuatrimotos en renta después de obtener las disponibles
          })
          .catch((error) => {
            console.error(error);
          });
      },
  
      obtenerCuatrimotosEnRenta() {
        // Realiza una petición HTTP para obtener los cuatrimotos en renta
        this.$http.get('cuatrimotos/en_renta')
          .then((response) => {
            this.cuatrimotosEnRenta = response.data; // Asigna la lista de cuatrimotos en renta
            this.actualizarIdsSeleccionados(); // Llamamos a esta función para actualizar las opciones seleccionadas
          })
          .catch((error) => {
            console.error(error);
          });
      },
      actualizarIdsSeleccionados() {
        // Verificamos que cuatrimotosEnRenta y cuatris sean arreglos válidos
        if (Array.isArray(this.cuatris) && Array.isArray(this.cuatrimotosEnRenta)) {
          // Filtramos las IDs de las cuatrimotos en renta
          const idsEnRenta = this.cuatrimotosEnRenta.map(cuatrimoto => cuatrimoto.id);
  
          // Filtramos las cuatrimotos disponibles excluyendo las en renta
          this.cuatris = this.cuatris.filter(cuatrimoto => !idsEnRenta.includes(cuatrimoto.id));
  
          // Actualizamos las opciones seleccionadas en el select
          this.cuatrimotosSeleccionadas = this.cuatris.slice(0, this.Cantidad_cuatris).map(cuatrimoto => cuatrimoto.id);
        }
      },
        obtenerRenta:function(){
            this.$http.get(apiRenta).then(function(json){
                this.renta=json.data;
            }).catch(function(json){
                console.log(json);
            });
        },
        obtenerPrecio:function(){
            this.$http.get(apiPrecio).then(function(json){
                this.precios=json.data;
            }).catch(function(json){
                console.log(json);
            });
        },
        obtenerClientes:function(){
            this.$http.get(apiCliente).then(function(json){
                this.clientes=json.data;
            }).catch(function(json){
                console.log(json);
            });
        },
        guardarRenta:function(){
            var renta={
                edad:this.edad, 
                hora_inicio:this.startTime, 
                hora_fin:this.endTime, 
                cantidad:this.Cantidad_cuatris, 
                costo:this.costoTotal,
               no_cuatri:this.cuatrimotosSeleccionadas.join(','),
                Nombre:this.nombre,
                Apellido:this.apellido,
                telefono:this.telefono,
                email:this.email,
                Documento:this.documento,
                integrante:this.integrante,
            };
            // var cliente={
            //     Nombre:this.nombre,
            //     Apellido:this.apellido,
            //     telefono:this.telefono,
            //     email:this.email,
            //     Documento:this.documento,
            // };
            this.$http.post(apiCliente,renta).then(function(json){
              window.location.reload()
                this.obtenerRenta();
                this.obtenerCuatrimotosEnRenta();
                this.edad='';
                this.startTime='';
                this.endTime='';
                this.Cantidad_cuatris='';
                this.costoTotal='';
                // this.nombreCliente = '';
                this.nombre='';
                this.apellido='';
                this.telefono='';
                this.email='';
                this.documento='';
                this.no_cuatri='';
                this.integrante='';
            }).catch(function(json){
                console.log(json);
            });
            // this.$http.post(apiCliente,cliente).then(function(json){
            //     this.nombre='';
            //     this.apellido='';
            //     this.telefono='';
            //     this.email='';
            //     this.documento='';
            //     this.no_cuatri='';
            // }).catch(function(json){
            //     console.log(json);
            // });

            $('#modalRenta').modal('hide');
            console.log(renta)
        },

        finalizarRenta(id) {
              Swal.fire({
                title: 'Seguro que desea finalizar la renta?',
                text: "Esta acción no será revertible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, finalizar!'
              }).then((result) => {
                if (result.isConfirmed) {
                  this.$http.put(`rentas/${id}/finalizar`)
                  // window.location.reload()
                    .then(function(json) {
                      Swal.fire(
                        'Finalizado!',
                        'Acción exitosa',
                        'success'
                      );
                      window.location.reload()
                    })
                    .catch(function(error) {
                      // Error al finalizar
                      Swal.fire(
                        'Error!',
                        'Ocurrió un error al finalizar la renta',
                        'error'
                      );
                    });
                }
              });
      },


        showPDF: function (id) {
            var url = UrlPDF + "?id=" + id;
            window.open(url, this.id, "_blank");
        },

        
        eliminarRenta: function(id) {
            Swal.fire({
              title: 'Seguro que desea eliminar?',
              text: "Esta acción no será revertible!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, eliminar!'
            }).then((result) => {
              if (result.isConfirmed) {
                this.$http.delete(apiRenta + '/' + id)
                // window.location.reload()
                  .then(function(json) {
                    // Eliminación exitosa
                    this.obtenerRenta();
                      this.obtenerCuatrimotosEnRenta();
                      this.$root.$emit('rentaEliminada');
                    Swal.fire(
                      'Eliminado!',
                      'Acción exitosa',
                      'success'
                    );
                    window.location.reload()
                  }) 
                  .catch(function(error) {
                    // Error al eliminar
                    Swal.fire(
                      'Error!',
                      'Ocurrió un error al eliminar la renta',
                      'error'
                    );
                  });
              }
            });
           
          },
          

        editarRenta:function(id){
            this.agregando=false;
            this.id=id;
            this.$http.get(apiRenta + '/' + id).then (function(json){
                console.log(json.data);
                
            this.cuatrimotosSeleccionadas=json.data.no_cuatri;
            this.id=json.data.id;
            this.startTime=json.data.hora_inicio;
            this.endTime=json.data.hora_fin;
            this.Cantidad_cuatris=json.data.cantidad;
            this.costoTotal=json.data.costo;

            });
            $('#modalRenta').modal('show');

        },

        //     this.$http.get(apiCliente + '/' + id).then(function(json){
        //         this.id=json.data.id;
        //         this.nombre=json.data.Nombre;
        //         this.apellido=json.data.Apellido; 
        //         this.telefono=json.data.telefono;
        //         this.email=json.data.email;
        //         this.documento=json.data.Documento;
        //     });
        //     $('#modalRenta').modal('show');





        actualizarRenta:function(){
            var jsonRenta={
            id:this.id,
            hora_inicio:this.startTime,
            hora_fin:this.endTime,
            cantidad:this.Cantidad_cuatris,
            costo:this.costoTotal,
            no_cuatri:this.cuatrimotosSeleccionadas.join(',')
            };
            // var jsonCliente={
            // id:this.id,
            // nombre:this.Nombre,
            // apellido:this.Apellido,
            // telefono:this.telefono,
            // email:this.email,
            // documento:this.Documento,
            // };
            console.log(jsonRenta);

            this.$http.patch(apiRenta + '/' + this.id,jsonRenta).then(function(json){
              this.$root.$emit('actRenta');
              
                this.obtenerRenta();
            });
            $('#modalRenta').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Actualizado exitosamente',
                showConfirmButton: false,
                timer: 1500
              });
              window.location.reload()
            
            //   this.$http.patch(apiCliente + '/' + this.id,jsonCliente).then(function(json){
            //     this.obtenerCliente();
            // });
            // $('#modalRenta').modal('hide');
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Actualizado exitosamente',
            //     showConfirmButton: false,
            //     timer: 1500
            //   })
        },

        updateEndTime() {
            if (this.startTime) {
              const start = moment(this.startTime, 'YYYY-MM-DDTHH:mm').format('YYYY-MM-DD HH:mm');
              const end = moment(start).add(90, 'minutes').format('YYYY-MM-DD HH:mm');
              this.endTime = end;
            } else {
              this.endTime = '';
            }
          },
        
    mostrarModal:function(){
        this.agregando=true;
        this.startTime= '';
        this.endTime= '';
        this.Cantidad_cuatris= 0;
        this.personas_cuatris= 1;
        this.costoTotal= 0;
        this.nombre='';
        this.apellido='';
        this.telefono='';
        this.email='';
        this.documento='';
        $('#modalRenta').modal('show');
    },
    validarEmail: function() {
      // Expresión regular para validar el formato de correo electrónico
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      
      if (this.email && !emailRegex.test(this.email)) {
        this.emailError = 'Formato de correo electrónico inválido';
      } else {
        this.emailError = '';
      }
    },

    obtenerCuatris:function(){
      this.$http.get(apiCuatri).then(function(json){
          this.cuatris=json.data;
      }).catch(function(json){
          console.log(json);
      });
  },
    // validarTelefono: function() {
    //   // Expresión regular para validar el formato de número de teléfono celular (10 dígitos)
    //   var telefonoRegex = /^\d{10}$/;
      
    //   if (this.telefono && !telefonoRegex.test(this.telefono)) {
    //     this.telefonoError = 'Número de teléfono celular inválido (10 dígitos)';
    //   } else {
    //     this.telefonoError = '';
    //   }
    // },
    },

    computed: {
        minEndTime() {
            if (this.startTime) {
              const start = moment(this.startTime, 'YYYY-MM-DDTHH:mm').format('YYYY-MM-DD HH:mm');
              const minEnd = moment(start).add(90, 'minutes').format('YYYY-MM-DD HH:mm');
              return minEnd;
            } else {
              return '';
            }
          },
          totalPagar() {
            if (Array.isArray(this.cuatris) && this.cuatris.length > 0) {
              // Filtrar las cuatrimotos disponibles según la cantidad ingresada
              const cuatrimotosDisponibles = this.cuatris.filter(cuatrimoto => cuatrimoto.estado === 'Disponible');
              if (this.Cantidad_cuatris > 0) {
                this.cuatrimotosSeleccionadas = cuatrimotosDisponibles.slice(0, this.Cantidad_cuatris).map(cuatrimoto => cuatrimoto.id);
              } else {
                this.cuatrimotosSeleccionadas = []; // Si la cantidad es cero, limpiar las selecciones
              }
        
              // Almacenar las cuatrimotos disponibles en el nuevo array
              this.cuatrimotosDisponibles = cuatrimotosDisponibles;
              
              // Lógica para calcular el monto total
              const personas_cuatris = this.personas_cuatris === 1 ? 400 : 500;
              this.costoTotal = this.Cantidad_cuatris * personas_cuatris;
            } else {
              this.cuatrimotosSeleccionadas = []; // Si no hay cuatrimotos disponibles, limpiar las selecciones
              this.costoTotal = 0; // El costo total será cero si no hay cuatrimotos disponibles
            }
          },
          filtrarRenta() {
            const terminoBusqueda = this.busqueda.toLowerCase();
            return this.renta.filter(renta => {
              const cliente = renta.clientes.Nombre.toLowerCase() + ' ' + renta.clientes.Apellido.toLowerCase();
              return cliente.includes(terminoBusqueda) || renta.cantidad.toString().includes(terminoBusqueda);
            });
          },
          
          

        
      },

})