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
                                <h3 class="col-12 text-center mb-2">¡Bienvenido a Payday!</h3>
                                <p class="col-12 text-muted text-center mb-0">
                                    Ya puedes iniciar sesion y comenzar a realizar pagos.
                                </p>
                                <button type="submit" class="btn btn-primary col-12 col-md-4 mt-2 mb-1" @click="realizarPago()">← Iniciar Sesion</button>
                            </div>
                            <span class="text-muted col-12">Por problemas no dudes en comunicarte a <a href="mailto:soporte@payday.com">soporte@payday.com.uy</a></span>
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
      this.$router.push('/login');
    },
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
