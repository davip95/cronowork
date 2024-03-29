<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-info d-flex justify-content-between"
          >
            Detalles Empleado
            <button
              type="button"
              class="btn-close align-self-end"
              aria-label="Close"
              id="close"
              @click="$emit('close')"
            ></button>
          </div>
          <div class="card-body" v-if="empleado.user && empleado.user.name">
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Nombre</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.user.name }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Apellidos</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.user.apellidos }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Correo</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.user.email }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Fecha Alta</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ formatDate(empleado.user.fecha_alta) }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Código Postal</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                <span v-if="empleado.user.codpostal">{{
                  empleado.user.codpostal
                }}</span>
                <span v-else>-</span>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Tipo</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.user.tipo }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Horario</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.horario }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Teléfono</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                <span
                  v-if="
                    empleado.user.telefono &&
                    empleado.user.telefono.trim().length !== 0
                  "
                  >{{ empleado.user.telefono }}</span
                >
                <span v-else>-</span>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Dirección</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                <span
                  v-if="
                    empleado.user.direccion &&
                    empleado.user.direccion.trim().length !== 0
                  "
                  >{{ empleado.user.direccion }}</span
                >
                <span v-else>-</span>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3 d-flex justify-content-end"></div>
              <div
                class="col-sm-9 text-secondary fw-bold d-flex justify-content-end"
              >
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
          <div class="card-body" v-else>Cargando...</div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import axios from "axios";
export default {
  props: ["show", "user"],
  emits: ["close"],
  data() {
    return {
      empleado: {},
    };
  },
  watch: {
    show: function (newVal) {
      if (newVal) {
        this.getUser();
      }
    },
  },
  methods: {
    async getUser() {
      try {
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/empleados/${this.user.id}`
        );
        this.empleado = response.data;
        this.$Progress.finish();
      } catch (error) {
        this.$Progress.fail();
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else {
          console.log(error);
        }
      }
    },
    formatDate(dateString) {
      moment.locale("es");
      return moment(dateString).format("DD/MM/YYYY");
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