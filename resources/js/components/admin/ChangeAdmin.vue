<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-primary d-flex justify-content-between"
          >
            Cambiar Administrador
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
              <div class="alert alert-warning d-inline-block w-auto mx-auto">
                <span
                  ><strong>¡Cuidado {{ user.name }}!</strong> Vas a cambiar el
                  admin de tu empresa. Dejarás de tener privilegios de
                  administrador y serás redirigido al login.</span
                >
              </div>
            </div>
            <form @submit.prevent="changeAdmin">
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Correo Nuevo Admin</h6>
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
                  <h6 class="mb-0">Repita Correo</h6>
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
              <div class="row">
                <div class="col-sm-3 d-flex justify-content-end"></div>
                <div
                  class="col-sm-9 text-secondary d-flex justify-content-between"
                >
                  <button type="submit" class="btn btn-primary px-4">
                    Cambiar Admin
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
  props: ["show", "user"],
  emits: ["close"],
  data() {
    return {
      form: new Form({
        email: null,
        email_confirmation: null,
      }),
    };
  },
  methods: {
    async changeAdmin() {
      try {
        this.$Progress.start();
        await this.form.put(`empresas/${this.user.empresas_id}/admin`);
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Admin cambiado correctamente",
        });
        document.getElementById("close").click();
        location.reload();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo cambiar el admin",
        });
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else if (error.response && error.response.status === 404) {
          this.form.errors.set({
            email: "No existe ningún empleado con ese email",
          });
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