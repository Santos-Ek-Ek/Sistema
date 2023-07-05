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
        telefono:'',
        email:'',
        documento:'',
        agregando:true,
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
                    }).catch(function(json){
    
                    });
                  Swal.fire(
                    'Eliminado!',
                    'Acción exitosa',
                    'success'
                  )
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
                email:this.email, 
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
        }
    }
});