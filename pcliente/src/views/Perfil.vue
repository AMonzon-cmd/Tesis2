<template>
    <div class="">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="app-user-view-account">
                    <div class="row">
                        <!-- User Sidebar -->
                        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                            <!-- User Card -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="user-avatar-section">
                                        <div class="d-flex align-items-center flex-column">
                                            <img class="img-fluid rounded mt-3 mb-2" src="/img/13-small.d796bffd.png" height="110" width="110" alt="User avatar" />
                                            <div class="user-info text-center">
                                                <h4>{{usuario.nombre}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-around my-2 pt-75">
                                        <div class="d-flex align-items-start me-2">
                                            <span class="badge bg-light-primary p-75 rounded">
                                                <i data-feather="check" class="font-medium-2"></i>
                                            </span>
                                            <div class="ms-75">
                                                <h4 class="mb-0">{{usuario.pagosRealizados}}</h4>
                                                <small>Pagos realizados</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start">
                                            <span class="badge bg-light-primary p-75 rounded">
                                                <i data-feather="briefcase" class="font-medium-2"></i>
                                            </span>
                                            <div class="ms-75">
                                                <h4 class="mb-0">{{usuario.puntos}}</h4>
                                                <small>Puntos</small>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="fw-bolder border-bottom pb-50 mb-1">Detalle</h4>
                                    <div class="info-container">
                                        <ul class="list-unstyled">

                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Email:</span>
                                                <span> {{usuario.email}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Documento:</span>
                                                <span> {{usuario.documento}}</span>
                                            </li>
                                            <li class="mb-75">
                                                <span class="fw-bolder me-25">Fecha de Nacimiento:</span>
                                                <span> {{usuario.fechaNacimiento}}</span>
                                            </li>
                                        </ul>
                                        <!-- <div class="d-flex justify-content-center pt-2">
                                            <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser" data-bs-toggle="modal">
                                                Edit
                                            </a>
                                            <a href="javascript:;" class="btn btn-outline-danger suspend-user">Suspended</a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <!-- /User Card -->
                        </div>
                        <!--/ User Sidebar -->

                        <!-- User Content -->
                        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                            <!-- Project table -->
                            <div class="card">
                                <h4 class="card-header">Pagos realizados</h4>
                                <div v-if="cargando" class="col-12 text-center">
                                    <div class="spinner-border mb-3" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <!-- PAGOS REALIZADOS SI ES QUE TERMINO DE CARGAR -->
                                <div v-else>
                                    <div v-if="pagos.length == 0" class="row text-center justify-content-center">
                                        <img class="col-12 text-center" src="https://img.freepik.com/vector-premium/emoji-pago-linea-personaje-tarjeta-bancaria-verde_506604-661.jpg" style="max-width:200px;" alt="">
                                        <h3 class="col-12 text-center mb-2">NO REALIZASTE PAGOS AUN...</h3>
                                    </div>
                                    <div v-else class="table-responsive">
                                        <table class="table datatable-project">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Entidad</th>
                                                    <th class="text-nowrap">Monto</th>
                                                    <th>Fecha</th>
                                                    <th>Puntos Generados</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="pago in pagos" v-bind:key="pago.servicio_id">
                                                    <td></td>
                                                    <td>{{pago.servicio.nombre}}</td>
                                                    <td v-if="pago.moneda_id === 1">$ {{pago.monto}}</td>
                                                    <td v-else>U$S {{pago.monto}}</td>
                                                    <td>{{pago.created_at}}</td>
                                                    <td>{{pago.puntaje_generado}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <!-- /Project table -->

                            <div class="card">
                                <h4 class="card-header">Productos Canjeados</h4>
                                <div v-if="cargando" class="col-12 text-center">
                                    <div class="spinner-border mb-2" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div v-else>
                                    <div v-if="canjes.length == 0" class="row text-center justify-content-center">
                                        <h3 class="col-12 mb-3">No realizaste ningun canje aun 🥺</h3>
                                    </div>
                                    <div v-else class="table-responsive">
                                        <table class="table datatable-project">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Producto</th>
                                                    <th class="text-nowrap">Costo</th>
                                                    <th>Fecha Reclamado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="canje in canjes" v-bind:key="canje.created_at">
                                                    <td></td>
                                                    <td>{{canje.producto.nombre}}</td>
                                                    <td>{{canje.producto.costo}}</td>
                                                    <td>{{canje.created_at}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ User Content -->
                    </div>
                </section>
            </div>
        </div>
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
      usuario: {
        nombre: 'Cristian Ferreri', email: 'cliente1@hotmail.com', documento: '51294519', sexo: 'Masculino', fechaNacimiento: '13/03/1994', pagosRealizados: 32, puntos: 10,
      },
      pagos: [],
      canjes: [],
      cargando: true,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
  },
  beforeCreate() {
    if (!isUserLoggedIn()) {
      this.$router.push('login');
    }
    const requestOptions = {
      method: 'GET',
      headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${getToken()}` },
    };
    fetch(`${this.$baseUrlApi}/user/getInfo`, requestOptions)
      .then(async response => {
        const data = await response.json();
        // check for error response
        if (!response.ok) {
          const error = (data && data.message) || response.status;
          return Promise.reject(error);
        }
        this.usuario = data.usuario;
        this.pagos = data.pagos;
        this.canjes = data.canjes;
        this.cargando = false;
        return true;
      })
      .catch(error => {
        localStorage.removeItem('token');
        window.location.href = '/';
        this.errorMessage = error;
        console.error('There was an error!', error);
      })
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
