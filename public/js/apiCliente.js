var apiCliente = "http://localhost/Sistema/public/apiCliente";

new Vue({
    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },

    el :'#cliente',
    data:{
       
        clientes:[],
        nombre:'',
        apellido:'',
        edad:'',
        telefono:'',
        email:'',
        documento:'',
        email: '',
        emailError: '',
        integrante:'',
        // telefono: '',
        // telefonoError: '',
        agregando:true,
        busqueda: ''
    },

    created:function(){
        this.obtenerClientes();
    },

    methods:{
        obtenerClientes:function(){
            this.$http.get(apiCliente).then(function(json){
                this.clientes=json.data;
            }).catch(function(json){
                console.log(json);
            });
        },



        eliminarCliente:function(id){
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
                    this.$http.delete(apiCliente + '/' + id).then(function(json){
                        this.obtenerClientes();
                        Swal.fire(
                            'Eliminado!',
                            'Acción exitosa',
                            'success'
                          );
                    }).catch(function(error){
                        Swal.fire(
                            'Error!',
                            'El cliente aún cuenta con una renta activa',
                            'error'
                          );
                    });
                  
                }
              })
        },


        editarCliente:function(id){
            this.agregando=false;
            this.id=id;
            this.$http.get(apiCliente + '/' + id).then (function(json){
                console.log(json.data);
                
            
            this.id=json.data.id;
            this.nombre=json.data.Nombre;
            this.apellido=json.data.Apellido;
            this.integrante=json.data.integrante;
            this.edad=json.data.edad;
            this.email=json.data.email;
            this.telefono=json.data.telefono;
            this.documento=json.data.Documento;


            });
            $('#modalCliente').modal('show');

        },

        actualizarCliente:function(){
            var jsonCliente={
                id:this.id,
                Nombre:this.nombre, 
                Apellido:this.apellido,
                integrante:this.integrante, 
                email:this.email, 
                edad:this.edad,
                telefono:this.telefono, 
                Documento:this.documento
            };
            console.log(jsonCliente);

            this.$http.patch(apiCliente + '/' + this.id,jsonCliente).then(function(json){
                this.obtenerClientes();
            });
            $('#modalCliente').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Actualizado exitosamente',
                showConfirmButton: false,
                timer: 1500
              })
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
        //   validarTelefono: function() {
        //     // Expresión regular para validar el formato de número de teléfono celular (10 dígitos)
        //     var telefonoRegex = /^\d{10}$/;
            
        //     if (this.telefono && !telefonoRegex.test(this.telefono)) {
        //       this.telefonoError = 'Número de teléfono celular inválido (10 dígitos)';
        //     } else {
        //       this.telefonoError = '';
        //     }
        //   },
    },
    computed:{
        filtrarCliente() {
            const terminoBusqueda = this.busqueda.toLowerCase();
            return this.clientes.filter(clientes => {
              const cliente =clientes.Nombre.toLowerCase() + ' ' + clientes.Apellido.toLowerCase() ;
              return cliente.includes(terminoBusqueda) || cliente.toString().includes(terminoBusqueda) || clientes.integrante.toLowerCase().includes(terminoBusqueda);
            });
          },
    }
});