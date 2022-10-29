<template>
    <div class="content-body">
        <section id="ApiKeyPage row">
            <div class="row mb-2">
                <h3 class="col-12 text-center">Comencemos a realizar un pago! 🚀</h3>
                <p class="col-12 text-muted text-center">Selecciona el servicio a pagar, la moneda, el monto y disfruta de pagar tus servicios y ganar puntos en el proceso.</p>
            </div>
            <!-- create API key -->
            <div class="card col-10 m-auto">
                <div class="row">
                    <div class="col-12 order-md-0 order-1">
                        <div class="card-body text-center">
                            <!-- form -->
                            <div class="row text-center justify-content-center">
                                <label for="ApiKeyType" class="form-label col-12 mt-2">Selecciona el servicio a pagar</label>
                                <select v-model="servicioSeleccionado" class="form-control col-10 col-md-4 text-center" id="cmbServicio">
                                    <option value="0" selected disabled>...</option>
                                    <option v-for="servicio in servicios" :value="servicio.id" v-bind:key="servicio.id">
                                        {{servicio.nombre}}
                                    </option>
                                </select>
                            </div>
                            <div class="row mt-2 text-center justify-content-center">
                                <label for="ApiKeyType" class="form-label col-12">Moneda y monto</label>
                                <select v-model="monedaSeleccionada" class="form-control col-2 col-md-1" name="" id="">
                                    <option v-for="moneda in monedas" :value="moneda.id" v-bind:key="moneda.id" selected>
                                        {{moneda.simbolo}}
                                    </option>
                                </select>
                                <input v-model="monto" class ="form-control col-3 col-md-2" type="text"/>
                            </div>
                                <button v-if="pagando" type="submit" class="btn btn-primary col-12 col-md-4 mt-2 mb-1">
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </button>
                            <button v-else type="submit" class="btn btn-primary col-12 col-md-4 mt-2 mb-1" @click="realizarPago()">Realizar pago</button>
                            <br/>
                            <span class="text-muted col-12">Una vez realizado el pago comunicate a <a href="mailto:soporte@payday.com">soporte@payday.com</a> si tienes algun tipo de problema.</span>
                        </div>
                    </div>
                    <div class="col-md-7 order-md-1 order-0">
                        <div class="text-center">
                            <!-- <img class="img-fluid text-center" src="<%= BASE_URL %>/public/pricing-Illustration.svg" alt="illustration" width="310" /> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>

// import {
//   BButton, BForm, BFormInput, BFormGroup, BCard, BLink, BCardTitle, BCardText, BInputGroup, BInputGroupAppend,
// } from 'bootstrap-vue'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import { isUserLoggedIn, getToken } from '@/auth/utils';

export default {
  components: {
    // BSV
    // BButton,
    // BForm,
    // BFormInput,
    // BFormGroup,
    // BCard,
    // BCardTitle,
    // BLink,
    // BCardText,
    // BInputGroup,
    // BInputGroupAppend,
    // ValidationProvider,
    // ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      servicios: [],
      monedas: [],
      servicioSeleccionado: 0,
      monedaSeleccionada: 1,
      resultado: '',
      monto: 0,
      pagando: false,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    async realizarPago() {
      const mont = Number.parseInt(this.monto, 0);
      console.log(typeof this.monto);
      if (Number.isNaN(mont) || this.monto <= 0) {
        this.$swal({
          icon: 'warning',
          title: 'Monto no valido',
          text: 'Prueba ingresar un número mayor a 0.',
          customClass: {
            confirmButton: 'btn btn-success',
          },
        });
        return;
      }
      if (this.servicioSeleccionado === 0) {
        this.$swal({
          icon: 'warning',
          title: 'No seleccionaste un servicio',
          text: 'Debes seleccionar un servicio para saber que pagar.',
          customClass: {
            confirmButton: 'btn btn-success',
          },
        });
        return;
      }
      this.pagando = true;
      const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${getToken()}` },
        body: JSON.stringify({
          idServicio: this.servicioSeleccionado,
          moneda: this.monedaSeleccionada,
          monto: this.monto,
        }),
      };

      fetch(`${this.$baseUrlApi}/pay`, requestOptions)
        .then(async response => {
          const data = await response.json();
          // check for error response
          console.log(response.status);
          if (!response.ok) {
            const error = (data && data.message) || response.status;
            return Promise.reject(error);
          }
          this.resultado = data;
          this.$router.push('/confirmacionPago');
          return true;
        })
        .catch(error => {
          this.errorMessage = error;
          console.error('There was an error!', error);
        })
    },
  },
  beforeCreate() {
    if (!isUserLoggedIn()) {
      this.$router.push('login');
    }
    const requestOptions = {
      method: 'GET',
      headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${getToken()}` },
    };
    fetch(`${this.$baseUrlApi}/service`, requestOptions)
      .then(async response => {
        const data = await response.json();
        // check for error response
        if (!response.ok) {
          const error = (data && data.message) || response.status;
          return Promise.reject(error);
        }
        this.servicios = data.servicios;
        return true;
      })
      .catch(error => {
        this.errorMessage = error;
        console.error('There was an error!', error);
      })
    fetch(`${this.$baseUrlApi}/service/currency`, requestOptions)
      .then(async response => {
        const data = await response.json();
        // check for error response
        if (!response.ok) {
          const error = (data && data.message) || response.status;
          return Promise.reject(error);
        }
        this.monedas = data.monedas;
        return true;
      })
      .catch(error => {
        this.errorMessage = error;
        console.error('There was an error!', error);
      })
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
