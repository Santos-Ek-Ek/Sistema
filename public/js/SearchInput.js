
Vue.component('search-input', {

  template:`
  <input type="text" class="form-control" v-model="busqueda" placeholder="Buscar">
`,
data() {
  return {
    busqueda: '',
  };
}
});