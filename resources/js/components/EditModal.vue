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
                  <h4 class="mb-4">{{ user.name }}</h4>
                  <a role="button" href="#" class="btn btn-danger btn-sm">
                    <i class="bi bi-person-x-fill me-2"></i
                    ><span class="fw-bold">Borrar Cuenta</span>
                  </a>
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
                  {{ user.name }} {{ user.apellidos }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Correo</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ user.email }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Rol</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ user.tipo }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Teléfono</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <span
                    v-if="user.telefono && user.telefono.trim().length !== 0"
                    >{{ user.telefono }}</span
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
                    v-if="user.direccion && user.direccion.trim().length !== 0"
                    >{{ user.direccion }}</span
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
                  <span v-if="user.codpostal">{{ user.codpostal }}</span>
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
                    @click="getUser"
                  >
                    <i class="bi bi-pencil-fill me-2"></i
                    ><span class="fw-bold">Editar Datos</span>
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
                      ></button>
                    </div>
                    <div class="card-body">
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
                            <button type="button" class="btn btn-primary px-4">
                              Editar
                            </button>
                            <button
                              type="button"
                              class="btn btn-danger align-self-end"
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
      usuario: {},
      form: new Form({
        name: this.user.name,
        email: this.user.email,
        password: "",
        password_confirmation: "",
        apellidos: this.user.apellidos,
        telefono: this.user.telefono,
        direccion: this.user.direccion,
        codpostal: this.user.codpostal,
      }),
    };
  },
  // mounted() {
  //   this.getUser();
  // },
  methods: {
    async getUser() {
      try {
        const response = await axios.get(`/usuarios/${this.user.id}/edit`);
        this.usuario = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    editUser() {
      this.form.put("usuarios/2");
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