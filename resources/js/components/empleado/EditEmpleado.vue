<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-warning d-flex justify-content-between"
          >
            Editar Datos Personales
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
              <div class="alert alert-secondary d-inline-block w-auto mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
                  <symbol
                    id="info-fill"
                    fill="currentColor"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"
                    />
                  </symbol>
                </svg>
                <svg
                  class="bi flex-shrink-0 me-2"
                  width="24"
                  height="24"
                  role="img"
                  aria-label="Info:"
                >
                  <use xlink:href="#info-fill" />
                </svg>
                <span>Los campos vacíos no se modificarán.</span>
              </div>
            </div>
            <form @submit.prevent="editUser">
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Nombre</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                  />
                  <has-error :form="form" field="name"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Apellidos</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.apellidos"
                    type="text"
                    name="apellidos"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('apellidos'),
                    }"
                  />
                  <has-error :form="form" field="apellidos"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Correo</h6>
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
                  />
                  <has-error :form="form" field="email"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Contraseña</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.password"
                    type="password"
                    name="password"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('password'),
                    }"
                  />
                  <has-error :form="form" field="password"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Repita Contraseña</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('password_confirmation'),
                    }"
                  />
                  <has-error
                    :form="form"
                    field="password_confirmation"
                  ></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Teléfono</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.telefono"
                    type="text"
                    name="telefono"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('telefono'),
                    }"
                  />
                  <has-error :form="form" field="telefono"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Dirección</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.direccion"
                    type="text"
                    name="direccion"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('direccion'),
                    }"
                  />
                  <has-error :form="form" field="direccion"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Código Postal</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.codpostal"
                    type="text"
                    name="codpostal"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('codpostal'),
                    }"
                  />
                  <has-error :form="form" field="codpostal"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 d-flex justify-content-end"></div>
                <div
                  class="col-sm-9 text-secondary d-flex justify-content-between"
                >
                  <button type="submit" class="btn btn-warning px-4">
                    Editar
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
  emits: ["close", "updateUser"],
  data() {
    return {
      form: new Form({
        name: this.user.name,
        email: this.user.email,
        password: null,
        password_confirmation: null,
        apellidos: this.user.apellidos,
        telefono: this.user.telefono,
        direccion: this.user.direccion,
        codpostal: this.user.codpostal,
      }),
    };
  },
  methods: {
    async editUser() {
      try {
        this.$Progress.start();
        await this.form.put(`usuarios/${this.user.id}`);
        Toast.fire({
          icon: "success",
          title: "Datos editados correctamente",
        });
        this.$Progress.finish();
        this.$emit("updateUser");
        document.getElementById("close").click();
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