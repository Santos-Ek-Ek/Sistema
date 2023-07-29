Vue.component('Disponible', {
  data() {
    return {
      cuatrimotos: [],
    };
  },
  mounted() {
    this.obtenerCuatrimotosDisponibles();
    // Escuchamos el evento personalizado 'rentaEliminada'
    this.$root.$on('rentaEliminada', () => {
      this.obtenerCuatrimotosDisponibles(); // Actualizamos la cantidad
    });
    this.$root.$on('actRenta', () => {
      this.obtenerCuatrimotosDisponibles(); // Actualizamos la cantidad
    });
  },
  methods: {
    obtenerCuatrimotosDisponibles() {
      fetch('api/cuatrimotos/disponibles')
        .then(response => response.json())
        .then(data => {
          this.cuatrimotos = data;
        })
        .catch(error => {
          console.error(error);
        });
    },
  },
  template: `
    <div>
      <h5 style="color: black;">Cuatrimotos Disponibles: {{ cuatrimotos }}</h5>
    </div>
  `
});
