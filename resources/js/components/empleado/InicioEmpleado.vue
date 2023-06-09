<template>
  <div class="row">
    <div class="col-12">
      <edit-empleado
        :show="showEditEmpleado"
        :user="user"
        @close="showEditEmpleado = false"
        @updateUser="getUser"
      ></edit-empleado>
      <baja-empresa
        :show="showBajaEmpresa"
        :empleado="user"
        @close="showBajaEmpresa = false"
      ></baja-empresa>
      <crear-ausencia
        :show="showAusencia"
        :user="user"
        :tipo="tipoAusencia"
        @close="showAusencia = false"
      ></crear-ausencia>
      <div class="row">
        <div class="col-12 mb-3">
          <boton-fichar :user="user"></boton-fichar>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 mb-3">
          <div class="card base-card">
            <div class="card-header bg-white">
              <strong>Atajos Ausencias</strong>
            </div>
            <div class="base-card-body">
              <div class="d-flex justify-content-center flex-column">
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="
                    showAusencia = true;
                    tipoAusencia = 'Falta';
                  "
                >
                  <i class="bi bi-exclamation-circle-fill me-2"></i
                  ><span>Falta</span>
                </button>
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="
                    showAusencia = true;
                    tipoAusencia = 'Permiso';
                  "
                >
                  <i class="bi bi-question-circle-fill me-2"></i
                  ><span>Permiso</span>
                </button>
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="
                    showAusencia = true;
                    tipoAusencia = 'Vacaciones';
                  "
                >
                  <i class="bi bi-emoji-sunglasses me-2"></i
                  ><span>Vacaciones</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9 mb-3">
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
      </div>
      <div class="row">
        <div class="col-12 mb-3">
          <div class="card base-card">
            <div class="card-header bg-white">
              <strong>Datos Empleado</strong>
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
                    @click="showEditEmpleado = true"
                  >
                    <i class="bi bi-pencil-fill me-2"></i
                    ><span class="fw-bold">Usuario / Contraseña</span>
                  </button>
                  <button
                    type="button"
                    class="btn btn-outline-dark bg-danger btn-sm my-2"
                    @click="showBajaEmpresa = true"
                  >
                    <i class="bi bi-person-fill-down me-2"></i
                    ><span class="fw-bold">Dejar Empresa</span>
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
      showEditEmpleado: false,
      showBajaEmpresa: false,
      showAusencia: false,
      tipoAusencia: "",
      usuario: {},
      horario: {},
      jornada: {},
    };
  },
  mounted() {
    this.getDayName();
    this.getUser();
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
    async getHorario($horarioId) {
      try {
        this.isDataLoaded = false;
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/horarios/${$horarioId}/empleado/${this.user.id}`
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
          `/empresas/${this.user.empresas_id}/horarios/${$horarioId}/empleado/${this.user.id}/jornada`
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
  },
};
</script>