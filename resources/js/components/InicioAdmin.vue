<template>
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-lg-8 mb-3">
          <div class="card base-card">
            <div class="card-header">Accesos Directos</div>
            <div class="base-card-body">
              <div class="d-flex align-items-center text-center">
                <button type="button" class="btn btn-primary">
                  Alta Empleado
                </button>
                <button type="button" class="btn btn-primary">
                  Baja Empleado
                </button>
                <button type="button" class="btn btn-primary">
                  Crear Horario
                </button>
                <button type="button" class="btn btn-primary">
                  Borrar Horario
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-3">
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
                <div class="col-sm-3">
                  <h6 class="mb-0">Empresa</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  {{ empresa.nombre }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Horario</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <span v-if="usuario.horarios_id">{{
                    usuario.horarios_id
                  }}</span>
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
                    class="btn btn-outline-dark bg-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop"
                  >
                    <i class="bi bi-pencil-fill me-2"></i
                    ><span class="fw-bold">Editar Datos Empresa</span>
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
  props: ["user", "empresa", "horario"],
  data() {
    return {
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