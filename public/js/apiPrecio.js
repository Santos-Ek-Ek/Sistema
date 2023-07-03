var apiPrecio = "http://localhost/Sistema/public/apiPrecio";
new Vue({
    el :'#precio',
    data:{
        precio:[],
       
    },

    created:function(){
        this.obtenerPrecio();
    },

    methods:{
        obtenerPrecio:function(){
            this.$http.get(apiPrecio).then(function(json){
                this.precio=json.data;
            }).catch(function(json){
                console.log(json);
            });
        },

        mostrarModal:function(){
            $('#modalRenta').modal('show');
        },
    }
});