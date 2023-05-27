<template>
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-md-4 mb-3">
          <div class="card user-card">
            <div class="card-header">Usuario</div>
            <div class="user-card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="5rem"
                  height="5rem"
                  fill="currentColor"
                  class="bi bi-person-circle text-black-50"
                  viewBox="0 0 16 16"
                >
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                  <path
                    fill-rule="evenodd"
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"
                  />
                </svg>
                <div class="my-3">
                  <h4 class="mb-4">{{ usuario.name }}</h4>
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                  >
                    <i class="bi bi-person-x-fill me-2"></i
                    ><span class="fw-bold">Borrar Cuenta</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card user-card mb-3">
            <div class="card-header">Datos Personales</div>
            <div class="user-card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Nombre</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ usuario.name }} {{ usuario.apellidos }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Correo</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ usuario.email }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Rol</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ usuario.tipo }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Teléfono</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <span
                    v-if="
                      usuario.telefono && usuario.telefono.trim().length !== 0
                    "
                    >{{ usuario.telefono }}</span
                  >
                  <span v-else>-</span>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Dirección</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <span
                    v-if="
                      usuario.direccion && usuario.direccion.trim().length !== 0
                    "
                    >{{ usuario.direccion }}</span
                  >
                  <span v-else>-</span>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Código Postal</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <span v-if="usuario.codpostal">{{ usuario.codpostal }}</span>
                  <span v-else>-</span>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-12 text-center">
                  <button
                    type="button"
                    class="btn btn-outline-dark bg-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop"
                  >
                    <i class="bi bi-pencil-fill me-2"></i
                    ><span class="fw-bold">Editar Datos /</span>
                    <i class="bi bi-key-fill"></i>
                    <span class="fw-bold">Cambiar Contraseña</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div
            class="modal fade"
            id="deleteModal"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            tabindex="-1"
            aria-hidden="true"
          >
            <div class="container modal-dialog">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card modal-content">
                    <div
                      class="card-header text-center bg-danger d-flex justify-content-between"
                    >
                      Borrar Cuenta
                      <button
                        type="button"
                        class="btn-close align-self-end"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        id="closeDeleteModal"
                      ></button>
                    </div>
                    <div class="card-body">
                      <div class="row mb-1">
                        <div
                          class="alert alert-danger d-inline-block w-auto mx-auto"
                        >
                          <span
                            ><strong>¡Cuidado!</strong> Va a eliminar su cuenta,
                            asegúrese de que quiere hacerlo antes de
                            confirmar.</span
                          >
                        </div>
                      </div>
                      <form @submit.prevent="deleteUser">
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Nombre</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            {{ usuario.name }} {{ usuario.apellidos }}
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Correo</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            {{ usuario.email }}
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Rol</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            {{ usuario.tipo }}
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Teléfono</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <span
                              v-if="
                                usuario.telefono &&
                                usuario.telefono.trim().length !== 0
                              "
                              >{{ usuario.telefono }}</span
                            >
                            <span v-else>-</span>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Dirección</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <span
                              v-if="
                                usuario.direccion &&
                                usuario.direccion.trim().length !== 0
                              "
                              >{{ usuario.direccion }}</span
                            >
                            <span v-else>-</span>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div class="col-sm-3">
                            <h6 class="mb-0">Código Postal</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                            <span v-if="usuario.codpostal">{{
                              usuario.codpostal
                            }}</span>
                            <span v-else>-</span>
                          </div>
                        </div>
                        <hr />
                        <div class="row">
                          <div
                            class="col-sm-3 d-flex justify-content-end"
                          ></div>
                          <div
                            class="col-sm-9 text-secondary d-flex justify-content-between"
                          >
                            <button type="submit" class="btn btn-danger px-4">
                              Borrar Cuenta
                            </button>
                            <button
                              type="button"
                              class="btn btn-secondary align-self-end"
                              data-bs-dismiss="modal"
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
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div
            class="modal fade"
            id="staticBackdrop"
            data-bs-backdrop="static"
            data-bs-keyboard="false"
            tabindex="-1"
            aria-hidden="true"
          >
            <div class="container modal-dialog">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card modal-content">
                    <div
                      class="card-header text-center bg-warning d-flex justify-content-between"
                    >
                      Editar Datos Personales
                      <button
                        type="button"
                        class="btn-close align-self-end"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        id="close"
                      ></button>
                    </div>
                    <div class="card-body">
                      <div class="row mb-3">
                        <div
                          class="alert alert-secondary d-inline-block w-auto mx-auto"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            style="display: none"
                          >
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
                      <div class="row mb-1">
                        <div
                          class="alert alert-danger d-inline-block w-auto mx-auto"
                          v-if="errorGetUser"
                        >
                          <span
                            ><strong>Error</strong> No se pudo obtener los datos
                            del usuario.</span
                          >
                        </div>
                      </div>
                      <form
                        @submit.prevent="editUser"
                        v-if="errorGetUser == false"
                      >
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
                            <has-error
                              :form="form"
                              field="apellidos"
                            ></has-error>
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
                            <has-error
                              :form="form"
                              field="password"
                            ></has-error>
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
                                'is-invalid': form.errors.has(
                                  'password_confirmation'
                                ),
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
                            <has-error
                              :form="form"
                              field="telefono"
                            ></has-error>
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
                            <has-error
                              :form="form"
                              field="direccion"
                            ></has-error>
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
                            <has-error
                              :form="form"
                              field="codpostal"
                            ></has-error>
                          </div>
                        </div>
                        <div class="row">
                          <div
                            class="col-sm-3 d-flex justify-content-end"
                          ></div>
                          <div
                            class="col-sm-9 text-secondary d-flex justify-content-between"
                          >
                            <button type="submit" class="btn btn-dark px-4">
                              Editar
                            </button>
                            <button
                              type="button"
                              class="btn btn-secondary align-self-end"
                              data-bs-dismiss="modal"
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";
export default {
  props: ["user"],
  data() {
    return {
      errorGetUser: false,
      usuario: {},
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
  mounted() {
    this.getUser();
  },
  methods: {
    async getUser() {
      try {
        this.$Progress.start();
        const response = await axios.get(`/usuarios/${this.user.id}/edit`);
        this.$Progress.finish();
        this.usuario = response.data;
      } catch (error) {
        this.$Progress.fail();
        this.errorGetUser = true;
        console.error(error);
      }
    },
    async editUser() {
      try {
        this.$Progress.start();
        await this.form.put(`usuarios/${this.user.id}`);
        Toast.fire({
          icon: "success",
          title: "Datos editados correctamente",
        });
        this.$Progress.finish();
        this.getUser();
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
    async deleteUser() {
      try {
        this.$Progress.start();
        await this.form.delete(`usuarios/${this.user.id}`);
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Cuenta borrada correctamente",
          timerProgressBar: false,
        });
        document.getElementById("closeDeleteModal").click();
        location.reload();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo borrar el usuario",
        });
        console.log(error);
      }
    },
  },
};
</script>

<style scoped>
.card {
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-clip: border-box;
  border-radius: 0.25rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2), 0 1px 2px 0 rgba(0, 0, 0, 0.46);
}

@media (max-width: 576px) {
  .col-sm-3 {
    justify-content: start !important;
  }
}
</style>