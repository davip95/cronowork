<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-info d-flex justify-content-between"
          >
            Detalles Ausencia
            <button
              type="button"
              class="btn-close align-self-end"
              aria-label="Close"
              id="close"
              @click="$emit('close')"
            ></button>
          </div>
          <div class="card-body">
            <div class="row mt-2">
              <div class="col-sm-3">
                <h6 class="mb-0">Tipo</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ ausencia.tipo }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Empleado</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ ausencia.name + " " + ausencia.apellidos }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Fecha Inicio</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ formatDate(ausencia.fecha_inicio) }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Fecha Fin</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ formatDate(ausencia.fecha_fin) }}
              </div>
            </div>
            <hr />
            <div class="row" v-if="ausencia.tipo != 'Falta'">
              <div class="col-sm-3">
                <h6 class="mb-0">Estado</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ ausencia.estado_aceptada }}
              </div>
            </div>
            <hr v-if="ausencia.tipo != 'Falta'" />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Motivos Ausencia</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                <span v-if="ausencia.motivos">{{ ausencia.motivos }}</span>
                <span v-else>-</span>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3 d-flex justify-content-end"></div>
              <div
                class="col-sm-9 text-secondary fw-bold d-block d-sm-flex"
                :class="{
                  'justify-content-between':
                    ausencia.aceptada == null && user.tipo == 'admin',
                  'justify-content-end':
                    ausencia.aceptada != null || user.tipo != 'admin',
                }"
              >
                <button
                  type="button"
                  class="btn btn-success px-4"
                  v-if="ausencia.aceptada == null && user.tipo == 'admin'"
                  @click="resolverSolicitud('aceptar')"
                >
                  Aceptar
                </button>
                <button
                  type="button"
                  class="btn btn-danger px-4"
                  v-if="ausencia.aceptada == null && user.tipo == 'admin'"
                  @click="resolverSolicitud('rechazar')"
                >
                  Rechazar
                </button>
                <button
                  type="button"
                  class="btn btn-secondary"
                  @click="$emit('close')"
                >
                  Cerrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: ["show", "ausencia", "user"],
  emits: ["close", "actualizaAusencia"],
  methods: {
    formatDate(dateString) {
      moment.locale("es");
      return moment(dateString).format("DD/MM/YYYY");
    },
    async resolverSolicitud(resolucion) {
      try {
        this.$Progress.start();
        await axios.get(
          `empresas/${this.user.empresas_id}/ausencia/${this.ausencia.id}/${resolucion}`,
          {
            baseURL: "http://127.0.0.1:8000/",
          }
        );
        this.$emit("actualizaAusencia", this.ausencia.tipo);
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Solicitud de ausencia resuelta",
        });
        document.getElementById("close").click();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo resolver la solicitud",
        });
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else {
          console.log(error.response);
        }
      }
    },
  },
};
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 80%;
  margin: 0 auto;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  overflow-y: auto;
  max-height: 90vh;
}

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>