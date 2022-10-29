<template>
  <div class="navbar-container d-flex content align-items-center">

    <!-- Nav Menu Toggler -->
    <ul class="nav navbar-nav d-xl-none">
      <li class="nav-item">
        <b-link
          class="nav-link"
          @click="toggleVerticalMenuActive"
        >
          <feather-icon
            icon="MenuIcon"
            size="21"
          />
        </b-link>
      </li>
    </ul>

    <!-- Left Col -->
    <div v-if="!logeado" class="col-12 text-right">
      <button
      v-for="language in languages"
      :key="language.locale"
      @click="changeLanguage(language.locale)">
        {{ language.title }}
    </button>
      <button @click="$router.push('login')" class="btn btn-success text-right mr-2">{{ $t('login')}}</button>
      <button @click="$router.push('registro')" class="btn btn-success">{{ $t('registro')}}</button>
    </div>

    <b-navbar-nav v-if="logeado" class="nav align-items-center ml-auto">
      <b-nav-item-dropdown
        right
        toggle-class="d-flex align-items-center dropdown-user-link"
        class="dropdown-user"
      >
        <template #button-content>
          <div class="d-sm-flex d-none user-nav">
            <p class="user-name font-weight-bolder mb-0">
              {{datos}}
            </p>
            <span class="user-status"></span>
          </div>
          <b-avatar
            size="40"
            variant="light-primary"
            badge
            :src="require('@/assets/images/avatars/13-small.png')"
            class="badge-minimal"
            badge-variant="success"
          />
        </template>

        <b-dropdown-item link-class="d-flex align-items-center" @click="$router.push('perfil')">
          <feather-icon
            size="16"
            icon="UserIcon"
            class="mr-50"
          />
          <span>Perfil</span>
        </b-dropdown-item>
        <b-dropdown-item link-class="d-flex align-items-center" @click="$router.push('pagar')">
          <feather-icon
            size="16"
            icon="CreditCardIcon"
            class="mr-50"
          />
          <span>Realizar Pagos</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center" @click="$router.push('productos')">
          <feather-icon
            size="16"
            icon="ShoppingCartIcon"
            class="mr-50"
          />
          <span>Canjear</span>
        </b-dropdown-item>

        <!-- <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="MailIcon"
            class="mr-50"
          />
          <span>Inbox</span>
        </b-dropdown-item> -->

        <!-- <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="CheckSquareIcon"
            class="mr-50"
          />
          <span>Task</span>
        </b-dropdown-item>

        <b-dropdown-item link-class="d-flex align-items-center">
          <feather-icon
            size="16"
            icon="MessageSquareIcon"
            class="mr-50"
          />
          <span>Chat</span>
        </b-dropdown-item> -->

        <b-dropdown-divider />

        <b-dropdown-item link-class="d-flex align-items-center" @click="cerrarSesion()">
          <feather-icon
            size="16"
            icon="LogOutIcon"
            class="mr-50"
          />
          <span>Cerrar sesion</span>
        </b-dropdown-item>
      </b-nav-item-dropdown>
    </b-navbar-nav>
  </div>
</template>

<script>
import {
  BLink, BNavbarNav, BNavItemDropdown, BDropdownItem, BDropdownDivider, BAvatar,
} from 'bootstrap-vue'
import { isUserLoggedIn, getUserData } from '@/auth/utils';
import i18n from '@/plugins/i18n'

export default {
  name: 'LanguageComponent',
  components: {
    BLink,
    BNavbarNav,
    BNavItemDropdown,
    BDropdownItem,
    BDropdownDivider,
    BAvatar,
  },
  data() {
    return {
      logeado: isUserLoggedIn(),
      datos: getUserData(),
      languages: [
        { locale: 'es', title: 'Español' },
        { locale: 'en', title: 'Inglés' },
      ],
    }
  },
  props: {
    toggleVerticalMenuActive: {
      type: Function,
      default: () => {},
    },
  },
  updated() {
    this.logeado = isUserLoggedIn();
  },
  methods: {
    cerrarSesion() {
      localStorage.removeItem('token');
      window.location.href = '/';
    },
    changeLanguage(locale) {
      i18n.locale = locale
    },
  },
}
</script>
