<template>
  <div class="row">
    <div class="col-12">
      <edit-admin
        :show="showEditAdmin"
        :user="user"
        @close="showEditAdmin = false"
        @updateUser="getUser"
      ></edit-admin>
      <edit-company
        :show="showEditCompany"
        :user="user"
        :empresa="empresa"
        @close="showEditCompany = false"
        @updateEmpresa="getEmpresa"
      ></edit-company>
      <delete-company
        :show="showDeleteCompany"
        :user="user"
        :empresa="empresa"
        @close="showDeleteCompany = false"
      ></delete-company>
      <div class="row">
        <div class="col-lg-6 mb-3">
          <div class="card base-card">
            <div class="card-header">Accesos Directos</div>
            <div class="base-card-body">
              <div class="d-flex justify-content-center flex-wrap">
                <button type="button" class="btn btn-primary btn-sm m-1">
                  <i class="bi bi-pencil-fill me-2"></i
                  ><span class="d-none d-lg-inline">Dar Alta</span>
                </button>
                <button type="button" class="btn btn-primary btn-sm m-1">
                  <i class="bi bi-pencil-fill me-2"></i
                  ><span class="d-none d-lg-inline">Dar Baja</span>
                </button>
                <button type="button" class="btn btn-primary btn-sm m-1">
                  <i class="bi bi-pencil-fill me-2"></i
                  ><span class="d-none d-lg-inline">Crear Horario</span>
                </button>
                <button type="button" class="btn btn-primary btn-sm m-1">
                  <i class="bi bi-pencil-fill me-2"></i
                  ><span class="d-none d-lg-inline">Borrar Horario</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-3">
          <div class="card base-card">
            <div class="card-header">Jornada</div>
            <div class="base-card-body">
              <div class="d-flex align-items-center text-center">
                Info
                <button type="button" class="btn btn-primary">Fichar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 mb-3">
          <div class="card base-card">
            <div class="card-header">Datos Administrador</div>
            <div class="base-card-body">
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
                    class="btn btn-outline-dark bg-warning btn-sm my-2"
                    @click="showEditAdmin = true"
                  >
                    <i class="bi bi-pencil-fill me-2"></i
                    ><span class="fw-bold">Editar Usuario /</span>
                    <i class="bi bi-key-fill"></i>
                    <span class="fw-bold">Cambiar Contraseña</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-3">
          <div class="card base-card">
            <div class="card-header">Datos Empresa</div>
            <div class="base-card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Nombre</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ empresa.nombre }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Correo</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ empresa.correo }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Cif</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ empresa.cif }}
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
                <div class="col-sm-9 text-secondary">
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
                <div class="col-sm-9 text-secondary">
                  <span v-if="empresa.codigo_postal">{{
                    empresa.codigo_postal
                  }}</span>
                  <span v-else>-</span>
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-12 text-center">
                  <button
                    type="button"
                    class="btn btn-outline-dark bg-warning btn-sm my-2"
                    @click="showEditCompany = true"
                  >
                    <i class="bi bi-pencil-fill me-2"></i
                    ><span class="fw-bold">Editar Datos Empresa</span>
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger btn-sm my-2"
                    @click="showDeleteCompany = true"
                  >
                    <i class="bi bi-building-fill-x me-2"></i
                    ><span class="fw-bold">Borrar Empresa</span>
                  </button>
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
      showEditAdmin: false,
      showEditCompany: false,
      showDeleteCompany: false,
      empresa: {},
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
    this.getEmpresa();
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
        console.error(error);
      }
    },
    async getEmpresa() {
      try {
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/edit`
        );
        this.$Progress.finish();
        this.empresa = response.data;
      } catch (error) {
        this.$Progress.fail();
        console.error(error);
      }
    },
  },
};
</script>