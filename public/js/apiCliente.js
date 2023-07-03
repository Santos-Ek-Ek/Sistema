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

        // mostrarModal:function(){
        //     $('#modalCuatri').modal('show');
        // },

        // guardarCuatri:function(){
        //     var cuatri={
        //         id_cuatri:this.num_cuatri, 
        //         color:this.color, 
        //         marca:this.marca, 
        //         placa:this.placas, 
        //         estado:this.estado
        //     };
        //     this.$http.post(apiCuatri,cuatri).then(function(json){
        //         this.obtenerCuatris();
        //         this.num_cuatri='';
        //         this.color='';
        //         this.marca='';
        //         this.placas='';
        //         this.estado='';
        //     }).catch(function(json){
        //         console.log(json);
        //     });

        //     $('#modalCuatri').modal('hide');
        //     console.log(cuatri)
        // },

        // eliminarCuatri:function(id){
        //     var confir= confirm('Esta seguro de eliminar?');
        //     if(confir){
        //         this.$http.delete(apiCuatri + '/' + id).then(function(json){
        //             this.obtenerCuatris();
        //         }).catch(function(json){

        //         });
        //     }
        // },
    }
});