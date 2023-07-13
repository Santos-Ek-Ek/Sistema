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
        renta:[],
        precios:[],
        clientes:[],
        startTime: '',
        endTime: '',
        Cantidad_cuatris: 0,
        personas_cuatris: 1,
        costoTotal: 0,
        id:'',
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
        this.obtenerRenta();
        this.obtenerPrecio();
        this.obtenerClientes();
        this.obtenerCuatris();
    },

    methods:{
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
                // id:this.id, 
                hora_inicio:this.startTime, 
                hora_fin:this.endTime, 
                cantidad:this.Cantidad_cuatris, 
                costo:this.costoTotal,
                // nombreCliente: this.nombre + ' ' + this.apellido,
                Nombre:this.nombre,
                Apellido:this.apellido,
                telefono:this.telefono,
                email:this.email,
                Documento:this.documento,
            };
            // var cliente={
            //     Nombre:this.nombre,
            //     Apellido:this.apellido,
            //     telefono:this.telefono,
            //     email:this.email,
            //     Documento:this.documento,
            // };
            this.$http.post(apiCliente,renta).then(function(json){
                this.obtenerRenta();
                // this.id='';
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
                  .then(function(json) {
                    // Eliminación exitosa
                    this.obtenerRenta();
                    Swal.fire(
                      'Eliminado!',
                      'Acción exitosa',
                      'success'
                    );
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
                this.obtenerRenta();
            });
            $('#modalRenta').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Actualizado exitosamente',
                showConfirmButton: false,
                timer: 1500
              });
            //   this.$http.patch(apiCliente + '/' + this.id,jsonCliente).then(function(json){
            //     this.obtenerCliente();
            // });
            // $('#modalRenta').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Actualizado exitosamente',
                showConfirmButton: false,
                timer: 1500
              })
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
            if (this.Cantidad_cuatris > 0 && this.personas_cuatris > 0) {
              // Lógica para calcular el monto total
              const personas_cuatris = this.personas_cuatris === 1 ? 400 : 500;
              this.costoTotal = this.Cantidad_cuatris * personas_cuatris;
            } else {
              this.costoTotal = 0;
            }
          }

        
      }

});