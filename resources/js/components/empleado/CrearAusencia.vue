<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-info d-flex justify-content-between"
          >
            {{ tipo == "Falta" ? "Notificar Falta" : "Solicitar " + tipo }}
            <button
              type="button"
              class="btn-close align-self-end"
              aria-label="Close"
              id="close"
              @click="$emit('close')"
            ></button>
          </div>
          <div class="card-body">
            <form @submit.prevent="crearAusencia">
              <div class="row text-center">
                <h4 class="mb-0">{{ tipo }}</h4>
              </div>
              <hr />
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Fecha Inicio {{ tipo }}</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.fecha_inicio"
                    type="date"
                    name="fecha_inicio"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('fecha_inicio'),
                    }"
                  />
                  <has-error :form="form" field="fecha_inicio"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Fecha Fin {{ tipo }}</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.fecha_fin"
                    type="date"
                    name="fecha_fin"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('fecha_fin'),
                    }"
                  />
                  <has-error :form="form" field="fecha_fin"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Motivos (opcional)</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.motivos"
                    type="text"
                    name="motivos"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('motivos'),
                    }"
                  />
                  <has-error :form="form" field="motivos"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 d-flex justify-content-end"></div>
                <div
                  class="col-sm-9 text-secondary d-flex justify-content-between"
                >
                  <button type="submit" class="btn btn-info px-4">
                    Enviar
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
            </form>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import Form from "vform";

export default {
  props: {
    show: {
      type: Boolean,
    },
    user: {
      type: Object,
    },
    tipo: {
      type: String,
    },
    dataTable: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["close", "actualizaAusencia"],
  data() {
    return {
      form: new Form({
        fecha_inicio: null,
        fecha_fin: null,
        motivos: null,
      }),
    };
  },
  methods: {
    async crearAusencia() {
      try {
        this.$Progress.start();
        await this.form.post(
          `empresas/${this.user.empresas_id}/empleados/${this.user.id}/ausencia/${this.tipo}`,
          {
            baseURL: "http://127.0.0.1:8000/",
          }
        );
        if (this.dataTable) {
          this.$emit("actualizaAusencia", this.tipo);
        }
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: `Ausencia enviada`,
        });
        this.form.fecha_inicio = null;
        this.form.fecha_fin = null;
        this.form.motivos = null;
        document.getElementById("close").click();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo enviar la ausencia",
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