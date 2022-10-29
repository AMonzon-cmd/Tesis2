<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">

    </div>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BCard, BLink, BCardText, BCardTitle, BFormGroup, BFormInput, BForm, BButton,
} from 'bootstrap-vue'
import { required, email } from '@validations'

export default {
  components: {
    BCard,
    BLink,
    BCardText,
    BCardTitle,
    BFormGroup,
    BFormInput,
    BButton,
    BForm,
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      userEmail: '',
      // validation
      required,
      email,
      respuesta: '',
    }
  },
  methods: {
    validationForm() {
      this.$refs.simpleRules.validate().then(success => {
        if (success) {
          this.$router.push({ name: 'auth-reset-password-v1' })
        }
      })
    },

    recuperar() {
      console.log('entro');
      const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
      };
      fetch(`${this.$baseUrlApi}/recovery?email=${this.email}`, requestOptions)
        .then(async response => {
          const data = await response.json();
          // check for error response
          if (!response.ok) {
            const error = (data && data.message) || response.status;
            return Promise.reject(error);
          }
          this.respuesta = data.respuesta;
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
