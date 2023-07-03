var apiCuatri = "http://localhost/Sistema/public/apiCuatri";

new Vue({
    http: {
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector("#token")
                .getAttribute("value"),
        },
    },

    el :'#cuatri',
    data:{
        cuatris:[],
        id_cuatri:'',
        num_cuatri:'',
        marca:'',
        color:'',
        placa:'',
        estado:'',
        agregando:true,

    },

    created:function(){
        this.obtenerCuatris();
    },

    methods:{
        obtenerCuatris:function(){
            this.$http.get(apiCuatri).then(function(json){
                this.cuatris=json.data;
            }).catch(function(json){
                console.log(json);
            });
        },

        mostrarModal:function(){
            this.agregando=true;
            this.num_cuatri='';
            this.color='';
            this.marca='';
            this.placas='';
            this.estado='';
            $('#modalCuatri').modal('show');
        },

        guardarCuatri:function(){
            var cuatri={
                id_cuatri:this.num_cuatri, 
                color:this.color, 
                marca:this.marca, 
                placa:this.placa, 
                estado:this.estado
            };
            this.$http.post(apiCuatri,cuatri).then(function(json){
                this.obtenerCuatris();
                this.num_cuatri='';
                this.color='';
                this.marca='';
                this.placa='';
                this.estado='';
            }).catch(function(json){
                console.log(json);
            });

            $('#modalCuatri').modal('hide');
            console.log(cuatri)
        },

        eliminarCuatri:function(id){

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
                    this.$http.delete(apiCuatri + '/' + id).then(function(json){
                        this.obtenerCuatris();
                    }).catch(function(json){
    
                    });
                  Swal.fire(
                    'Eliminado!',
                    'Acción exitosa',
                    'success'
                  )
                }
              })
            
            // var confir= confirm('Esta seguro de eliminar?');
            // if(confir){
            //     this.$http.delete(apiCuatri + '/' + id).then(function(json){
            //         this.obtenerCuatris();
            //     }).catch(function(json){

            //     });
            // }
        },
        editarCuatri:function(id){
            this.agregando=false;
            this.id_cuatri=id;
            this.$http.get(apiCuatri + '/' + id).then (function(json){
                console.log(json.data);

            this.num_cuatri=json.data.id;
            this.color=json.data.color;
            this.marca=json.data.marca; 
            this.placa=json.data.placa;
            this.estado=json.data.estado;
            });
            $('#modalCuatri').modal('show');
        },
        actualizarCuatri:function(){
            var jsonCuatri={
                id_cuatri:this.num_cuatri, 
                color:this.color, 
                marca:this.marca, 
                placa:this.placa, 
                estado:this.estado
            };
            console.log(jsonCuatri);

            this.$http.patch(apiCuatri + '/' + this.id_cuatri,jsonCuatri).then(function(json){
                this.obtenerCuatris();
            });
            $('#modalCuatri').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Actualizado exitosamente',
                showConfirmButton: false,
                timer: 1500
              })
        }
    }
});