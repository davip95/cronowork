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
      <change-admin
        :show="showChangeAdmin"
        :user="user"
        @close="showChangeAdmin = false"
      ></change-admin>
      <alta-empleado
        :show="showAltaEmpleado"
        :user="user"
        @close="showAltaEmpleado = false"
      ></alta-empleado>
      <baja-empleado
        :show="showBajaEmpleado"
        @close="showBajaEmpleado = false"
      ></baja-empleado>
      <reasignar-horario
        :show="showReasignar"
        :user="user"
        @close="showReasignar = false"
        @updateHorario="actualizaHorario"
      ></reasignar-horario>
      <asignar-horario
        :show="showAsignar"
        :user="user"
        @close="showAsignar = false"
        @actualizaHorario="actualizaHorario"
      ></asignar-horario>
      <div class="row">
        <div class="col-12 mb-3">
          <boton-fichar :user="user"></boton-fichar>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 mb-3">
          <div class="card base-card">
            <div class="card-header bg-white">
              <strong>Atajos Empleados</strong>
            </div>
            <div class="base-card-body">
              <div class="d-flex justify-content-center flex-column">
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="showAltaEmpleado = true"
                >
                  <i class="bi bi-person-fill-up me-2"></i><span>Dar Alta</span>
                </button>
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="showBajaEmpleado = true"
                >
                  <i class="bi bi-person-fill-down me-2"></i
                  ><span>Dar Baja</span>
                </button>
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="showReasignar = true"
                >
                  <i class="bi bi-calendar-plus me-2"></i
                  ><span>Reasignar Horario</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div
          class="col-lg-9 mb-3"
          v-if="user.horarios_id || Object.keys(horario).length !== 0"
        >
          <div class="card base-card">
            <div class="card-header bg-white">
              <strong>Jornada de {{ dayName }}</strong>
            </div>
            <div class="base-card-body">
              <div
                class="d-block align-items-center text-center"
                v-if="isDataLoaded"
              >
                <h5>
                  <i class="bi bi-calendar3-week me-2"></i
                  >{{ isIntensivo ? "Horario Intensivo" : "Horario" }}
                </h5>
                <p class="text-dark fw-bold">{{ horario.descripcion }}</p>
                <hr />
                <div class="container" v-if="jornada">
                  <div class="row">
                    <div class="col-lg">
                      <h6 class="mb-3">
                        <i class="bi bi-hourglass-top me-2"></i>Hora Inicio
                      </h6>
                      <p class="text-dark fw-bold">
                        {{
                          isIntensivo
                            ? jornada.hora_inicio_intensiva
                            : jornada.hora_inicio
                        }}
                      </p>
                    </div>
                    <div class="col-lg">
                      <h6 class="mb-3">
                        <i class="bi bi-hourglass-bottom me-2"></i>Hora Fin
                      </h6>
                      <p class="text-dark fw-bold">
                        {{
                          isIntensivo
                            ? jornada.hora_fin_intensiva
                            : jornada.hora_fin
                        }}
                      </p>
                    </div>
                    <div class="col-lg">
                      <h6 class="mb-3">
                        <i class="bi bi-pause-circle me-2"></i>Descanso
                      </h6>
                      <p class="text-dark fw-bold">
                        {{
                          isIntensivo
                            ? jornada.minutos_descanso_intensiva
                            : jornada.minutos_descanso
                        }}
                        minutos
                      </p>
                    </div>
                  </div>
                </div>
                <div class="container" v-else>
                  <div class="alert alert-dark d-inline-block w-auto mx-auto">
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
                    <span
                      ><strong>Recuerde:</strong> hoy no trabaja, por lo tanto
                      no tiene que fichar.</span
                    >
                  </div>
                </div>
              </div>
              <div class="d-block align-items-center text-center" v-else>
                <p>Cargando...</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9 mb-3" v-else>
          <div class="alert alert-warning" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
              <symbol
                id="exclamation-triangle-fill"
                fill="currentColor"
                viewBox="0 0 16 16"
              >
                <path
                  d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                />
              </symbol>
            </svg>
            <h4 class="alert-heading">
              <svg
                class="bi flex-shrink-0 me-2 mb-1"
                width="24"
                height="24"
                role="img"
                aria-label="Warning:"
              >
                <use xlink:href="#exclamation-triangle-fill" />
              </svg>
              Sin Horario
            </h4>
            <p>
              Actualmente no tienes asignado ningún horario. Si te acabas de
              registrar, puedes crear un horario nuevo y asignártelo para ver
              información de tu jornada laboral y poder fichar.
            </p>
            <hr />
            <p class="mb-0 d-flex justify-content-end">
              <button
                type="button"
                class="btn btn-outline-success bg-dark crearHorario"
                @click="showAsignar = true"
              >
                <i class="bi bi-calendar-plus me-2"></i>
                Crear Horario
              </button>
            </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 mb-3">
          <div class="card base-card">
            <div class="card-header bg-white">
              <strong>Datos Administrador</strong>
            </div>
            <div class="base-card-body" v-if="isDataLoaded">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Nombre</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  {{ usuario.name }} {{ usuario.apellidos }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Correo</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  {{ usuario.email }}
                </div>
              </div>
              <hr />
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Rol</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  {{ usuario.tipo }}
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
                <div class="col-sm-9 text-secondary fw-bold">
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
                <div class="col-sm-9 text-secondary fw-bold">
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
                    ><span class="fw-bold">Usuario / Contraseña</span>
                  </button>
                  <button
                    type="button"
                    class="btn btn-outline-dark bg-danger btn-sm my-2"
                    @click="showChangeAdmin = true"
                  >
                    <i class="bi bi-person-fill-gear me-2"></i
                    ><span class="fw-bold">Cambiar Admin</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="base-card-body" v-else>
              <p>Cargando...</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-3">
          <div class="card base-card">
            <div class="card-header bg-white">
              <strong>Datos Empresa</strong>
            </div>
            <div class="base-card-body" v-if="isDataLoaded">
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
                  <h6 class="mb-0">Cif</h6>
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
                <div class="col-sm-12 text-center">
                  <button
                    type="button"
                    class="btn btn-outline-dark bg-warning btn-sm my-2"
                    @click="showEditCompany = true"
                  >
                    <i class="bi bi-pencil-fill me-2"></i
                    ><span class="fw-bold">Datos Empresa</span>
                  </button>
                  <button
                    type="button"
                    class="btn btn-outline-dark bg-danger btn-sm my-2"
                    @click="showDeleteCompany = true"
                  >
                    <i class="bi bi-building-fill-x me-2"></i
                    ><span class="fw-bold">Borrar Empresa</span>
                  </button>
                </div>
              </div>
            </div>
            <div class="base-card-body" v-else>
              <p>Cargando...</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: ["user"],
  data() {
    return {
      dayName: "",
      isDataLoaded: false,
      isIntensivo: false,
      showReasignar: false,
      showEditAdmin: false,
      showEditCompany: false,
      showDeleteCompany: false,
      showChangeAdmin: false,
      showAltaEmpleado: false,
      showBajaEmpleado: false,
      showAsignar: false,
      empresa: {},
      usuario: {},
      horario: {},
      jornada: {},
    };
  },
  mounted() {
    this.getDayName();
    this.getUser();
    this.getEmpresa();
    if (this.user.horarios_id) {
      this.getHorario(this.user.horarios_id);
      this.getJornada(this.user.horarios_id);
    }
  },
  methods: {
    async getUser() {
      try {
        this.$Progress.start();
        const response = await axios.get(`/usuarios/${this.user.id}`);
        this.usuario = response.data.user;
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
    async getEmpresa() {
      try {
        this.$Progress.start();
        const response = await axios.get(`/empresas/${this.user.empresas_id}`);
        this.empresa = response.data;
        if (!this.user.horarios_id) {
          this.isDataLoaded = true;
        }
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
    async getHorario($horarioId) {
      try {
        this.isDataLoaded = false;
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/horarios/${$horarioId}`
        );
        this.horario = response.data.horario;
        this.isIntensivo = response.data.intensivo;
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
    async getJornada($horarioId) {
      try {
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/horarios/${$horarioId}/jornada`
        );
        if (response.status === 204) {
          this.jornada = false;
        }
        this.jornada = response.data;
        this.isDataLoaded = true;
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
    getDayName() {
      const daysOfWeek = [
        "Domingo",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
      ];

      const currentDate = new Date();
      this.dayName = daysOfWeek[currentDate.getDay()];
    },
    actualizaHorario($nuevoHorarioId) {
      this.getHorario($nuevoHorarioId);
      this.getJornada($nuevoHorarioId);
    },
  },
};
</script>

<style scoped>
.crearHorario:hover {
  color: var(--bs-gray-200) !important;
}
</style>