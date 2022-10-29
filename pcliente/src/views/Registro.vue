<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">

      <!-- Register v1 -->
      <b-card class="mb-0">
        <b-link class="brand-logo">
          <h2 class="brand-text text-primary ml-1">
            PAYDAY
          </h2>
        </b-link>

        <b-card-title class="mb-1">
            Empieza una nueva aventura 🚀
        </b-card-title>
        <b-card-text class="mb-2">
            Pagaras servicios de manera mas facil
        </b-card-text>

        <!-- form -->
        <validation-observer ref="registerForm">
          <b-form
            class="auth-register-form mt-2"
            @submit.prevent="registro"
          >
          <b-alert v-if="error !== ''" class="alert alert-danger col-12 text-center">
           {{error}}
          </b-alert>
            <!-- username -->
            <b-form-group
              label="Nombre y Apelllido"
              label-for="nombre"
            >
              <validation-provider
                #default="{ errors }"
                name="Nombre"
                rules="required"
              >
                <b-form-input
                  id="nombre"
                  v-model="nombre"
                  :state="errors.length > 0 ? false:null"
                  name="register-nombre"
                  placeholder="Cristian"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- Documento -->
            <b-form-group
              label="Documento"
              label-for="documento"
            >
              <validation-provider
                #default="{ errors }"
                name="Documento"
                rules="required"
              >
                <b-form-input
                  id="documento"
                  v-model="documento"
                  :state="errors.length > 0 ? false:null"
                  name="register-documento"
                  placeholder="51294519"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>
            <!-- email -->
            <b-form-group
              label="Email"
              label-for="email"
            >
              <validation-provider
                #default="{ errors }"
                name="Email"
                rules="required|email"
              >
                <b-form-input
                  id="email"
                  v-model="email"
                  :state="errors.length > 0 ? false:null"
                  name="register-email"
                  placeholder="john@example.com"
                />
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <b-form-group
              label="Fecha de Nacimiento"
              label-for="password"
            >
              <b-form-input
              id="input-last_login"
              type="date"
              v-model="fechaNacimiento"
              class="mb-2"
            />
            </b-form-group>

            <!-- password -->
            <b-form-group
              label="Password"
              label-for="password"
            >
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
                    :state="errors.length > 0 ? false:null"
                    class="form-control-merge"
                    name="register-password"
                    placeholder="············"
                  />
                  <b-input-group-append is-text>
                    <feather-icon
                      :icon="passwordToggleIcon"
                      class="cursor-pointer"
                      @click="togglePasswordVisibility"
                    />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- checkbox -->
            <b-form-group>
              <b-form-checkbox
                id="register-privacy-policy"
                v-model="status"
                name="checkbox-1"
              >
                Acepto los
                <b-link>terminos y condiciones</b-link>
              </b-form-checkbox>
            </b-form-group>

            <!-- submit button -->
            <b-button v-if="registrando"
              variant="primary"
              type="submit"
              block
              :disabled="invalid"
            >
              <div class="spinner-border spinner-border-sm" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </b-button>
            <b-button
              v-else
              variant="primary"
              block
              type="submit"
            >
              Registrarme
            </b-button>
          </b-form>
        </validation-observer>

        <b-card-text class="text-center mt-2">
          <span>Ya tienes una cuenta? </span>
          <b-link :to="{name:'login'}">
            <span>Inicia sesion</span>
          </b-link>
        </b-card-text>

      </b-card>
    <!-- /Register v1 -->
    </div>
  </div>

</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import axios from 'axios'
import {
  BCard, BLink, BCardTitle, BCardText, BForm,
  BButton, BFormInput, BFormGroup, BInputGroup, BInputGroupAppend, BFormCheckbox,
} from 'bootstrap-vue'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import { useRouter } from 'vue-router';
import { isUserLoggedIn } from '@/auth/utils';

export default {
  setup() {
    const submit = async e => {
      const router = useRouter();
      const form = new FormData(e.target);
      const inputs = Object.fromEntries(form.entries());
      await axios.post('/registro', inputs);
      await router.push('/login');
    }
    return { submit }
  },

  components: {
    // BSV
    BCard,
    BLink,
    BCardTitle,
    BCardText,
    BForm,
    BButton,
    BFormInput,
    BFormGroup,
    BInputGroup,
    BInputGroupAppend,
    BFormCheckbox,
    // validations
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      username: '',
      password: '',
      nombre: '',
      documento: '',
      status: '',
      // validation rules
      required,
      email,
      registrando: false,
      error: '',
      fechaNacimiento: '',
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    registro() {
      console.log(this.nombre.split(' '));
      this.registrando = true;
      if (!this.status) {
        this.registrando = false;
        this.error = 'Debes aceptar los terminos y condiciones';
        return;
      }

      if (this.nombre.trim().length === 0) {
        this.registrando = false;
        this.error = 'Debe ingresar nombre y apellido';
        return;
      }

      if (this.documento.trim().length === 0) {
        this.registrando = false;
        this.error = 'El documento no puede estar vacio';
        return;
      }

      if (this.email.trim().length === 0) {
        this.registrando = false;
        this.error = 'El email no puede estar vacio';
        return;
      }

      if (this.password.trim().length < 6) {
        this.registrando = false;
        this.error = 'La contraseña debe tener minimo 6 caracteres';
        return;
      }

      if (this.edad(this.fechaNacimiento) < 18) {
        this.registrando = false;
        this.error = 'Debe ser mayor para registrarte en payday';
        return;
      }
      const nombres = this.nombre.split(' ');
      const nombre1 = nombres[0];
      const apellido1 = (nombres.length === 1) ? '' : nombres[1];
      const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email: this.email,
          contrasena: this.password,
          nombre: nombre1,
          apellido: apellido1,
          documento: this.documento,
          fechaNacimiento: this.fechaNacimiento,
        }),
      };
      fetch(`${this.$baseUrlApi}/user`, requestOptions)
        .then(async response => {
          const data = await response.json();
          // check for error response
          if (!response.ok) {
            this.registrando = false;
            // get error message from body or default to response status
            const error = (data && data.message) || response.status;
            return Promise.reject(error);
          }
          this.$router.push('/confirmacionRegistro');
          this.registrando = false;
          return true;
        })
        .catch(error => {
          this.registrando = false;
          this.errorMessage = error;
          console.error('There was an error!', error);
        });
    },
    edad(fecha) {
      const hoy = new Date();
      const cumpleanos = new Date(fecha);
      let edad = hoy.getFullYear() - cumpleanos.getFullYear();
      const m = hoy.getMonth() - cumpleanos.getMonth();
      if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad -= 1;
      }
      return edad;
    },
  },
  beforeCreate() {
    // invocar los métodos
    if (isUserLoggedIn()) {
      this.$router.push('/');
    }
    console.log('HOLAAAAA');
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
