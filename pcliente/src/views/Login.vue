<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner">

      <!-- Login v1 -->
      <b-card class="mb-0">
        <b-link class="brand-logo">
          <h2 class="brand-text text-primary ml-1">
            PAYDAY
          </h2>
        </b-link>

        <b-card-title class="mb-1">
          Bienvenido a Payday👋
        </b-card-title>
        <b-card-text class="mb-2">
          Inicia sesion para comenzar a hacer tus pagos
        </b-card-text>

        <!-- form -->
        <validation-observer
          ref="loginForm"
          #default="{invalid}"
        >
          <b-alert v-if="credencialesIncorrectas" class="alert alert-danger col-12 text-center">
            Credenciales incorrectas
          </b-alert>
          <b-form
            class="auth-login-form mt-2"
            @submit.prevent="iniciarSesion"
          >
            <!-- email -->
            <b-form-group
              label-for="email"
              label="Email"
            >
              <validation-provider
                #default="{ errors }"
                name="Email"
                rules="required|email"
              >
                <b-form-input
                  id="email"
                  v-model="userEmail"
                  name="login-email"
                  :state="errors.length > 0 ? false:null"
                  placeholder="clferreri@ejemplo.com"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- password -->
            <b-form-group>
              <div class="d-flex justify-content-between">
                <label for="password">Contraseña</label>
                <b-link :to="{name:'recuperarContrasena'}">
                  <small>Olvidaste tu contraseña?</small>
                </b-link>
              </div>
              <validation-provider
                #default="{ errors }"
                name="Password"
                rules="required"
              >
                <b-input-group
                  class="input-group-merge"
                  :class="errors.length > 0 ? 'is-invalid':null"
                >
                  <b-form-input
                    id="password"
                    v-model="password"
                    :type="passwordFieldType"
                    class="form-control-merge"
                    :state="errors.length > 0 ? false:null"
                    name="login-password"
                    placeholder="Contraseña"
                  />

                  <b-input-group-append is-text>
                    <feather-icon
                      class="cursor-pointer"
                      :icon="passwordToggleIcon"
                      @click="togglePasswordVisibility"
                    />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
            <br/>

            <!-- submit button -->
            <b-button v-if="logeando"
              variant="primary"
              type="submit"
              block
              :disabled="invalid"
            >
              <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </b-button>
            <b-button v-else
              variant="primary"
              type="submit"
              block
              :disabled="invalid"
            >
              Iniciar Sesion
            </b-button>
          </b-form>
        </validation-observer>

        <b-card-text class="text-center mt-2">
          <span>Nuevo en la plataforma? </span>
          <b-link :to="{name:'registro'}">
            <span>Crea una cuenta</span>
          </b-link>
        </b-card-text>
      <br/>
      </b-card>
      <!-- /Login v1 -->
    </div>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BButton, BForm, BFormInput, BFormGroup, BCard, BLink, BCardTitle, BCardText, BInputGroup, BInputGroupAppend,
} from 'bootstrap-vue'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import { isUserLoggedIn, getToken } from '@/auth/utils';

export default {
  components: {
    // BSV
    BButton,
    BForm,
    BFormInput,
    BFormGroup,
    BCard,
    BCardTitle,
    BLink,
    BCardText,
    BInputGroup,
    BInputGroupAppend,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      userEmail: '',
      password: '',
      status: '',
      // validation rules
      required,
      email,
      credencialesIncorrectas: false,
      logeando: false,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    async iniciarSesion() {
      // const payload = {
      //   usuario: this.userEmail,
      //   pass: this.password,
      // };
      this.logeando = true;
      this.credencialesIncorrectas = false;
      const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          grant_type: 'password',
          client_id: 2,
          client_secret: 'cQdhQwWaaGfak9WvqGpguWcmqVZLrWwylkggCOt7',
          username: this.userEmail,
          password: this.password,
          scope: '',
        }),
      };
      fetch(`${this.$baseUrl}/oauth/token`, requestOptions)
        .then(async response => {
          const data = await response.json();
          // check for error response
          if (!response.ok) {
            this.credencialesIncorrectas = true;
            // get error message from body or default to response status
            const error = (data && data.message) || response.status;
            this.logeando = false;
            return Promise.reject(error);
          }
          localStorage.setItem('token', data.access_token);
          const requestOptions2 = {
            method: 'GET',
            headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${getToken()}` },
          };
          fetch(`${this.$baseUrlApi}/user/nombre`, requestOptions2)
            .then(async response2 => {
              const data2 = await response2.json();
              // check for error response
              if (!response2.ok) {
                this.credencialesIncorrectas = true;
                // get error message from body or default to response status
                const error = (data2 && data2.message) || response2.status;
                this.logeando = false;
                return Promise.reject(error);
              }
              localStorage.setItem('nombre', data2.nombre);
              this.logeando = false;
              window.location.href = '/';
              return true;
            })
            .catch(error => {
              this.logeando = false;
              this.errorMessage = error;
              console.error('There was an error', error);
            });
          return true;
        })
        .catch(error => {
          this.logeando = false;
          this.errorMessage = error;
          console.error('There was an error!', error);
        });
    },
  },
  beforeCreate() {
    if (isUserLoggedIn()) {
      this.$router.push('registro');
    }
    console.log('HOLAAAAA');
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
