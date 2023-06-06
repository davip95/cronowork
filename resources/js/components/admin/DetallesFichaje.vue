<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-info d-flex justify-content-between"
          >
            Detalles Fichaje
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
                {{ fichaje.tipo }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Fecha</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ formatDate(fichaje.fecha) }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Hora</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ fichaje.hora }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Empleado</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ fichaje.empleado_nombre + " " + fichaje.empleado_apellidos }}
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-sm-3">
                <h6 class="mb-0">Horario</h6>
              </div>
              <div class="col-sm-9 text-secondary fw-bold">
                {{ fichaje.horario_descripcion }}
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
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: ["show", "fichaje"],
  emits: ["close"],
  methods: {
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