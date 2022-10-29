import Vue from 'vue'
import VueI18n from 'vue-i18n'

Vue.use(VueI18n)

const messages = {
  es: {
    login: 'Iniciar Sesion',
    registro: 'Registrar',
    titulo: 'BIENVENIDO A PAYDAY',
  },
  en: {
    login: 'Login',
    registro: 'Sign-up',
    titulo: 'WELCOME TO PAYDAY',
  },
}

export default new VueI18n({
  locale: 'es',
  fallbackLocale: 'en',
  messages,
});
