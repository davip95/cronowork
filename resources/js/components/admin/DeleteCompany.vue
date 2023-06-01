<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-danger d-flex justify-content-between"
          >
            Borrar Empresa
            <button
              type="button"
              class="btn-close align-self-end"
              aria-label="Close"
              id="close"
              @click="$emit('close')"
            ></button>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="alert alert-danger d-inline-block w-auto mx-auto">
                <span
                  ><strong>¡Cuidado!</strong> Va a eliminar la empresa: esta
                  acción eliminará tambien los horarios y empleados de la
                  empresa, así como sus registros asociados (fichajes, ausencias
                  y jornadas).</span
                >
              </div>
            </div>
            <form @submit.prevent="deleteEmpresa">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Nombre</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  {{ empresa.nombre }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Correo</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  {{ empresa.correo }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">CIF</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  {{ empresa.cif }}
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
                      empresa.telefono && empresa.telefono.trim().length !== 0
                    "
                    >{{ empresa.telefono }}</span
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
                      empresa.direccion && empresa.direccion.trim().length !== 0
                    "
                    >{{ empresa.direccion }}</span
                  >
                  <span v-else>-</span>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Código Postal</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  <span v-if="empresa.codigo_postal">{{
                    empresa.codigo_postal
                  }}</span>
                  <span v-else>-</span>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3 d-flex justify-content-end"></div>
                <div
                  class="col-sm-9 text-secondary fw-bold d-flex justify-content-between"
                >
                  <button type="submit" class="btn btn-danger px-4">
                    Borrar Empresa
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
  props: ["show", "user", "empresa"],
  emits: ["close"],
  data() {
    return {
      form: new Form({
        nombre: "",
        cif: "",
        correo: "",
        telefono: "",
        direccion: "",
        codigo_postal: "",
      }),
    };
  },
  watch: {
    empresa: function (newVal) {
      this.form.fill({
        nombre: newVal.nombre,
        cif: newVal.cif,
        correo: newVal.correo,
        telefono: newVal.telefono,
        direccion: newVal.direccion,
        codigo_postal: newVal.codigo_postal,
      });
    },
  },
  methods: {
    async deleteEmpresa() {
      try {
        this.$Progress.start();
        await this.form.delete(`empresas/${this.user.empresas_id}`);
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Empresa borrada correctamente",
        });
        document.getElementById("close").click();
        location.reload();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo borrar la empresa",
        });
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else {
          console.log(error);
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