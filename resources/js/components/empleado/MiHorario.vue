<template>
  <div class="row">
    <div class="col-12">
      <div class="row">
        <div class="col-12 mb-3">
          <boton-fichar :user="user"></boton-fichar>
        </div>
      </div>
      <div
        class="card base-card mb-3"
        v-if="user.horarios_id || Object.keys(horario).length !== 0"
      >
        <div
          class="card-header bg-white text-center d-flex justify-content-between"
        >
          <h4 class="mb-0 mt-2"><strong>Horario Laboral</strong></h4>
          <h4 class="align-self-end mt-2">
            <i>{{ user.name + " " + user.apellidos }}</i>
          </h4>
        </div>
        <div class="card-body" v-if="isDataLoaded">
          <div class="row text-center"><h4>Horario</h4></div>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Descripción</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              {{ horario.descripcion }}
            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Intensivo</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              <span
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
              >
                <strong>Sí</strong>
              </span>
              <span v-else><strong>No</strong></span>
            </div>
          </div>
          <hr
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          />
          <div
            class="row"
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          >
            <div class="col-sm-3">
              <h6 class="mb-0">Fecha Inicio Intensivo</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              <span>{{ formatDate(horario.fecha_inicio_intensivo) }}</span>
            </div>
          </div>
          <hr
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          />
          <div
            class="row"
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          >
            <div class="col-sm-3">
              <h6 class="mb-0">Fecha Fin Intensivo</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              <span>{{ formatDate(horario.fecha_fin_intensivo) }}</span>
            </div>
          </div>
          <div class="row text-center my-3"><h4>Jornadas</h4></div>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Días Laborales</h6>
            </div>
            <div class="col-sm-9 fw-bold">
              <ul class="list-group list-group-horizontal-lg">
                <li
                  v-for="jornada in jornadas"
                  :key="jornada.id"
                  class="list-group-item text-secondary"
                >
                  {{ getNombreDia(jornada.dia) }}
                </li>
              </ul>
            </div>
          </div>
          <hr />
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Minutos Descanso</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              {{ jornadas[0].minutos_descanso }}
            </div>
          </div>
          <hr />
          <div
            class="row"
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          >
            <div class="col-sm-3">
              <h6 class="mb-0">Minutos Descanso Intensivo</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              <span>{{ jornadas[0].minutos_descanso_intensiva }}</span>
            </div>
          </div>
          <hr
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          />
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Hora Inicio</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              {{ jornadas[0].hora_inicio }}
            </div>
          </div>
          <hr />
          <div
            class="row"
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          >
            <div class="col-sm-3">
              <h6 class="mb-0">Hora Inicio Intensivo</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              <span>{{ jornadas[0].hora_inicio_intensiva }}</span>
            </div>
          </div>
          <hr
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          />
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Hora Fin</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              {{ jornadas[0].hora_fin }}
            </div>
          </div>
          <hr />
          <div
            class="row"
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          >
            <div class="col-sm-3">
              <h6 class="mb-0">Hora Fin Intensivo</h6>
            </div>
            <div class="col-sm-9 text-secondary fw-bold">
              <span>{{ jornadas[0].hora_fin_intensiva }}</span>
            </div>
          </div>
          <hr
            v-if="horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo"
          />
        </div>
        <div class="card-body" v-else>Cargando...</div>
      </div>
      <div
        class="alert alert-warning justify-content-center"
        role="alert"
        v-else
      >
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
        <hr />
        <p>
          Actualmente no tienes asignado ningún horario. Si te acabas de
          registrar como administrador, dirígete a la pantalla de inicio para
          crearlo.
        </p>
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
      isDataLoaded: false,
      horario: {},
      jornadas: {},
    };
  },
  mounted() {
    if (this.user.horarios_id) {
      this.getHorario(this.user.horarios_id);
      this.getJornadas(this.user.horarios_id);
    }
  },
  methods: {
    formatDate(dateString) {
      moment.locale("es");
      return moment(dateString).format("DD/MM/YYYY");
    },
    getNombreDia(dia) {
      const diasSemana = [
        "",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
        "Domingo",
      ];
      return diasSemana[dia];
    },
    async getHorario($horarioId) {
      try {
        this.isDataLoaded = false;
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/horarios/${$horarioId}/empleado/${this.user.id}`
        );
        this.horario = response.data.horario;
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
    async getJornadas($horarioId) {
      try {
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/horarios/${$horarioId}/empleado/${this.user.id}/jornadas`
        );
        this.jornadas = response.data;
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
  },
};
</script>

<style scoped>
.list-group-item {
  padding: 10px 10px !important;
}
</style>