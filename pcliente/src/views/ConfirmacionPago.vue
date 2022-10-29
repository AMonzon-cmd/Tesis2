<template>
    <div class="content-body">
        <section id="ApiKeyPage row">
            <!-- create API key -->
            <div class="card col-10 m-auto">
                <div class="row">
                    <div class="col-12 order-md-0 order-1">
                        <div class="card-body text-center">
                            <div class="row text-center justify-content-center">
                                <img src="https://cdn-icons-png.flaticon.com/512/3699/3699516.png" class="mt-3 mb-1" style="max-width: 200px" alt="">
                                <h3 class="col-12 text-center mb-2">¡Realizaste un pago!</h3>
                                <p class="col-12 text-muted text-center mb-0">
                                    Procesamos tu pago correctamente.
                                </p>
                                <p class="col-12 text-muted text-center mt-0">
                                    Te hemos enviado el detalle a tu correo electronico.
                                </p>
                                <button type="submit" class="btn btn-primary col-12 col-md-4 mt-2 mb-1" @click="realizarPago()">← Realizar otro pago</button>
                            </div>
                            <span class="text-muted col-12">Si no recibiste el correo verifica tu casilla de spam o contactanos a <a href="mailto:soporte@payday.com">soporte@payday.com</a></span>
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
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    realizarPago() {
      this.$router.push('/pagar');
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
