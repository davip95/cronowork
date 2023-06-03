<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-danger d-flex justify-content-between"
          >
            Baja Empleado
            <button
              type="button"
              class="btn-close align-self-end"
              aria-label="Close"
              id="close"
              @click="$emit('close')"
            ></button>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Nombre</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.name }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Apellidos</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.apellidos }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Correo</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.email }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Fecha Alta</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ formatDate(empleado.fecha_alta) }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Código Postal</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ empleado.codpostal }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3 d-flex justify-content-end"></div>
              <div
                class="col-sm-9 text-secondary fw-bold d-flex justify-content-between"
              >
                <button
                  type="button"
                  class="btn btn-danger px-4"
                  @click="bajaEmpleado"
                >
                  Dar Baja
                </button>
                <button
                  type="button"
                  class="btn btn-secondary align-self-end"
                  @click="$emit('close')"
                >
                  Cancelar
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
import axios from "axios";
export default {
  props: ["show", "empleado"],
  emits: ["empleadoDadoBaja", "close"],
  methods: {
    async bajaEmpleado() {
      try {
        this.$Progress.start();
        await axios.get(`/empresas/admin/baja/empleado/${this.empleado.id}`);
        this.$emit("empleadoDadoBaja");
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Empleado dado de baja",
        });
        document.getElementById("close").click();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo dar de baja",
        });
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