<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">
      <!-- Reset Password v1 -->
      <b-card v-if="this.valido" class="mb-0">

        <!-- logo -->
        <b-link class="brand-logo">
          <h2 class="brand-text text-primary ml-1">
            PAYDAY
          </h2>
        </b-link>

        <b-card-title class="mb-1">
          Resetear contraseña 🔒
        </b-card-title>
        <b-card-text class="mb-2">
          Tu nueva contraseña debe contener al menos 8 digitos y convinar numeros y letras
        </b-card-text>

        <!-- form -->
        <validation-observer ref="simpleRules">
          <b-form
            method="POST"
            class="auth-reset-password-form mt-2"
            @submit.prevent="recuperar"
          >

            <!-- password -->
            <b-form-group
              label="Nueva contraseña"
              label-for="reset-password-new"
            >
              <validation-provider
                #default="{ errors }"
                name="Password"
                vid="Password"
                rules="required|password"
              >
                <b-input-group
                  class="input-group-merge"
                  :class="errors.length > 0 ? 'is-invalid':null"
                >
                  <b-form-input
                    id="reset-password-new"
                    v-model="password"
                    :type="password1FieldType"
                    :state="errors.length > 0 ? false:null"
                    class="form-control-merge"
                    name="reset-password-new"
                    placeholder="············"
                  />
                  <b-input-group-append is-text>
                    <feather-icon
                      class="cursor-pointer"
                      :icon="password1ToggleIcon"
                      @click="togglePassword1Visibility"
                    />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- confirm password -->
            <b-form-group
              label-for="reset-password-confirm"
              label="Confirmar contraseña"
            >
              <validation-provider
                #default="{ errors }"
                name="Confirm Password"
                rules="required|confirmed:Password"
              >
                <b-input-group
                  class="input-group-merge"
                  :class="errors.length > 0 ? 'is-invalid':null"
                >
                  <b-form-input
                    id="reset-password-confirm"
                    v-model="cPassword"
                    :type="password2FieldType"
                    class="form-control-merge"
                    :state="errors.length > 0 ? false:null"
                    name="reset-password-confirm"
                    placeholder="············"
                  />
                  <b-input-group-append is-text>
                    <feather-icon
                      class="cursor-pointer"
                      :icon="password2ToggleIcon"
                      @click="togglePassword2Visibility"
                    />
                  </b-input-group-append>
                </b-input-group>
                <small class="text-danger">{{ errors[0] }}</small>
              </validation-provider>
            </b-form-group>

            <!-- submit button -->
            <b-button
              block
              type="submit"
              variant="primary"
            >
              Guardar nueva contraseña
            </b-button>
          </b-form>
        </validation-observer>

        <p class="text-center mt-2">
          <b-link :to="{name:'auth-login-v1'}">
            <feather-icon icon="ChevronLeftIcon" /> Iniciar Sesion
          </b-link>
        </p>

      </b-card>
    <!-- /Reset Password v1 -->
    </div>
  </div>

</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BCard, BCardTitle, BCardText, BForm, BFormGroup, BInputGroup, BInputGroupAppend, BLink, BFormInput, BButton,
} from 'bootstrap-vue'
import { required } from '@validations'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { isUserLoggedIn } from '@/auth/utils';

export default {
  components: {
    BCard,
    BButton,
    BCardTitle,
    BCardText,
    BForm,
    BFormGroup,
    BInputGroup,
    BLink,
    BFormInput,
    BInputGroupAppend,
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      userEmail: '',
      cPassword: '',
      password: '',
      // validation
      required,
      valido: false,
      token: '',
      // Toggle Password
      password1FieldType: 'password',
      password2FieldType: 'password',
    }
  },
  beforeCreate() {
    if (isUserLoggedIn()) {
      this.$router.push('/');
    }

    const token = window.location.search.split('=')[1];
    const requestOptions = {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' },
    };
    fetch(`${this.$baseUrlApi}/recovery/token?tk=${token}`, requestOptions)
      .then(async response => {
        const data = await response.json();
        // check for error response
        if (!response.ok) {
          const error = (data && data.message) || response.status;
          this.$router.push('/');
          return Promise.reject(error);
        }
        this.valido = true;
        this.token = token;
        return true;
      })
      .catch(error => {
        this.errorMessage = error;
        console.error('There was an error!', error);
        this.$router.push('/');
      });
  },
  computed: {
    password1ToggleIcon() {
      return this.password1FieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    password2ToggleIcon() {
      return this.password2FieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    togglePassword1Visibility() {
      this.password1FieldType = this.password1FieldType === 'password' ? 'text' : 'password'
    },
    togglePassword2Visibility() {
      this.password2FieldType = this.password2FieldType === 'password' ? 'text' : 'password'
    },
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: 'Form Submitted',
              icon: 'EditIcon',
              variant: 'success',
            },
          })
        }
      })
    },
    recuperar() {
      if (this.cPassword !== this.password) {
        this.$swal({
          icon: 'warning',
          title: 'Monto no valido',
          text: 'Prueba ingresar un número mayor a 0.',
          customClass: {
            confirmButton: 'btn btn-success',
          },
        });
      }
      const requestOptions2 = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          token: this.token,
          pass1: this.password,
          pass2: this.cPassword,
        }),
      };
      fetch(`${this.$baseUrlApi}/recovery`, requestOptions2)
        .then(async response => {
          const data = await response.json();
          // check for error response
          if (!response.ok) {
            const error = (data && data.message) || response.status;
            return Promise.reject(error);
          }
          this.valido = true;
          this.$router.push('/confirmacionCambioPass');
          return true;
        })
        .catch(error => {
          this.errorMessage = error;
          console.error('There was an error!', error);
        });
    },
  },

}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
