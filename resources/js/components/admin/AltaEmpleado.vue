<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-success d-flex justify-content-between"
          >
            Alta Empleado
            <button
              type="button"
              class="btn-close align-self-end"
              aria-label="Close"
              id="close"
              @click="$emit('close')"
            ></button>
          </div>
          <div class="card-body">
            <form @submit.prevent="altaEmpleado">
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Correo Empleado</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.email"
                    type="email"
                    name="email"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('email'),
                    }"
                    required
                  />
                  <has-error :form="form" field="email"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Repita Correo Empleado</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.email_confirmation"
                    type="email"
                    name="email_confirmation"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('email_confirmation'),
                    }"
                    required
                  />
                  <has-error
                    :form="form"
                    field="email_confirmation"
                  ></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Horarios Empresa</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <select
                    class="form-select"
                    name="horarios_id"
                    required
                    v-model="form.horarioId"
                    :class="{
                      'is-invalid': form.errors.has('horarioId'),
                    }"
                  >
                    <option disabled selected>Selecciona Horario</option>
                    <option
                      v-for="horario in horarios"
                      :key="horario.id"
                      v-bind:value="horario.id"
                    >
                      {{ horario.descripcion }}
                    </option>
                  </select>
                  <small
                    ><strong
                      >Debe asignar un horario para dar de alta al
                      empleado.</strong
                    ></small
                  >
                  <has-error :form="form" field="horarios_id"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 d-flex justify-content-end"></div>
                <div
                  class="col-sm-9 text-secondary d-flex justify-content-between"
                >
                  <button type="submit" class="btn btn-success px-4">
                    Dar Alta
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
    dataTable: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["close", "altaDatatable"],
  data() {
    return {
      horarios: {},
      form: new Form({
        email: null,
        email_confirmation: null,
        horarioId: null,
      }),
    };
  },
  watch: {
    show: function (newVal) {
      if (newVal) {
        this.getHorarios();
      }
    },
  },
  methods: {
    async getHorarios() {
      try {
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/horarios`
        );
        this.horarios = response.data;
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
    async altaEmpleado() {
      try {
        this.$Progress.start();
        await this.form.post(`empresas/admin/alta`);
        if (this.dataTable) {
          this.$emit("altaDatatable");
        }
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Empleado dado de alta",
        });
        this.form.email = null;
        this.form.email_confirmation = null;
        this.form.horarioId = null;
        document.getElementById("close").click();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo dar de alta",
        });
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else if (error.response && error.response.status === 404) {
          this.form.errors.set({
            email: "No existe ningún empleado con ese email",
          });
        } else if (
          error.response &&
          error.response.data.error === "Empleado ya dado de alta"
        ) {
          this.form.errors.set({
            email: "El empleado ya tiene empresa asignada",
          });
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