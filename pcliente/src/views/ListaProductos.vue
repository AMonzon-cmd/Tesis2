<template>
  <section class="row justify-content-center">
      <h2 class="col-12 text-center">¡Canjea tus puntos por productos!</h2>
      <p class="text-muted col-12 text-center">Los puntos acumulados por pagos de servicios pueden ser intercambiados por los productos listados a continuacion</p>
      <div v-for="item in items" v-bind:key="item.id" class="card ecommerce-card col-12 col-md-4 col-xl-2 m-1">
        <div v-if="item.stock == 0" class="item-img text-center" style="position: relative; display: inline-block; text-align:center">
          <img class="img-fluid card-img-top" v-bind:src="item.img" style="max-width:100%; opacity:15%;" alt="" />
          <div style="position:absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size:1.5rem;"><b>SIN STOCK</b></div>
        </div>

        <div v-else class="item-img text-center">
          <img class="img-fluid card-img-top" v-bind:src="item.img" style="max-width:100%;" alt="" />
        </div>
        <div class="card-body">
            <h6 class="item-name">
                <a class="text-body" href="app-ecommerce-details.html">{{item.nombre}}</a>
            </h6>
            <p class="card-text item-description">
              {{item.descripcion}}
            </p>
        </div>
        <div class="item-options text-center">
            <div class="item-wrapper">
                <div class="item-cost">
                    <h4 class="item-price">{{item.costo}} puntos</h4>
                </div>
            </div>
            <button v-if="item.stock == 0" class="btn btn-primary btn-cart mb-1 col-12" disabled>Canjear</button>
            <button v-else class="btn btn-primary btn-cart mb-1 col-12" @click="canjear(item.id, item.nombre)">Canjear</button>
        </div>
      </div>
  </section>
</template>

<script>
import { isUserLoggedIn, getRequestOptionGet } from '@/auth/utils';

export default {
  setup() {
    return {
      // UI
    }
  },
  data() {
    return {
      items: [],
      requestOptions: {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', Authorization: `Bearer ${localStorage.getItem('token')}` },
        body: JSON.stringify({
        }),
      },
    }
  },
  beforeCreate() {
    // invocar los métodos
    if (!isUserLoggedIn()) {
      this.$router.push('/login');
    }
    fetch(`${this.$baseUrlApi}/product`, getRequestOptionGet)
      .then(async response => {
        const data = await response.json();
        // check for error response
        if (!response.ok) {
          const error = (data && data.message) || response.status;
          return Promise.reject(error);
        }
        this.items = data.productos;
        return true;
      })
      .catch(error => {
        this.errorMessage = error;
        console.error('There was an error!', error);
      });
  },
  methods: {
    canjear(id, producto) {
      this.$swal({
        title: `¿Canjear ${producto}?`,
        text: 'Una vez canjeado perdera los puntos',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
        cancelButtonText: 'Cancelar',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ml-1',
        },
        buttonsStyling: false,
      }).then(result => {
        if (result.value) {
          fetch(`${this.$baseUrlApi}/product/${id}`, this.requestOptions)
            .then(async response => {
              const data = await response.json();
              if (!response.ok) {
                const error = (data && data.message) || response.status;
                if (response.status === 400) {
                  this.$swal({
                    icon: 'warning',
                    title: 'No se realizo el reclamo',
                    text: data.respuesta,
                    customClass: {
                      confirmButton: 'btn btn-success',
                    },
                  });
                  return true;
                }
                return Promise.reject(error);
              }
              this.$swal({
                icon: 'success',
                title: 'Se realizo el canje correctamente',
                text: 'Te enviamos el comprobante a tu email.',
                customClass: {
                  confirmButton: 'btn btn-success',
                },
              })
              return true;
            })
            .catch(error => {
              this.errorMessage = error;
              console.log(error);
              console.error('There was an error!', error);
              this.$swal({
                icon: 'error',
                title: 'Error al realizar el canje',
                text: 'Intente nuevamente en unos minutos',
                customClass: {
                  confirmButton: 'btn btn-success',
                },
              })
            });
        }
      })
    },
    confirmText() {
      this.$swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        customClass: {
          confirmButton: 'btn btn-primary',
          cancelButton: 'btn btn-outline-danger ml-1',
        },
        buttonsStyling: false,
      }).then(result => {
        if (result.value) {
          this.$swal({
            icon: 'success',
            title: 'Deleted!',
            text: 'Your file has been deleted.',
            customClass: {
              confirmButton: 'btn btn-success',
            },
          })
        }
      })
    },
  },
}
</script>

<style lang="scss">
@import "~@core/scss/base/pages/app-ecommerce.scss";
</style>
