<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-danger d-flex justify-content-between"
          >
            Borrar Horario
            <button
              type="button"
              class="btn-close align-self-end"
              aria-label="Close"
              id="close"
              @click="$emit('close')"
            ></button>
          </div>
          <div class="card-body" v-if="isDataLoaded">
            <div class="row mb-3">
              <div class="alert alert-danger d-inline-block w-auto mx-auto">
                <span
                  ><strong>¡Cuidado!</strong> Esta acción borrará el horario y
                  todas sus jornadas asociadas.</span
                >
              </div>
            </div>
            <form @submit.prevent="borraHorario">
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
                      horario.fecha_inicio_intensivo &&
                      horario.fecha_fin_intensivo
                    "
                  >
                    <strong>Sí</strong>
                  </span>
                  <span v-else><strong>No</strong></span>
                </div>
              </div>
              <hr
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
              />
              <div
                class="row"
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
              >
                <div class="col-sm-3">
                  <h6 class="mb-0">Fecha Inicio Intensivo</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  <span>{{ formatDate(horario.fecha_inicio_intensivo) }}</span>
                </div>
              </div>
              <hr
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
              />
              <div
                class="row"
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
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
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
              >
                <div class="col-sm-3">
                  <h6 class="mb-0">Minutos Descanso Intensivo</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  <span>{{ jornadas[0].minutos_descanso_intensiva }}</span>
                </div>
              </div>
              <hr
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
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
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
              >
                <div class="col-sm-3">
                  <h6 class="mb-0">Hora Inicio Intensivo</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  <span>{{ jornadas[0].hora_inicio_intensiva }}</span>
                </div>
              </div>
              <hr
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
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
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
              >
                <div class="col-sm-3">
                  <h6 class="mb-0">Hora Fin Intensivo</h6>
                </div>
                <div class="col-sm-9 text-secondary fw-bold">
                  <span>{{ jornadas[0].hora_fin_intensiva }}</span>
                </div>
              </div>
              <hr
                v-if="
                  horario.fecha_inicio_intensivo && horario.fecha_fin_intensivo
                "
              />
              <div class="row">
                <div class="col-sm-3 d-flex justify-content-end"></div>
                <div
                  class="col-sm-9 text-secondary fw-bold d-flex justify-content-between"
                >
                  <button type="submit" class="btn btn-danger px-4">
                    Borrar
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
          <div class="card-body" v-else>Cargando...</div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import axios from "axios";
export default {
  props: ["show", "horario"],
  emits: ["horarioBorrado", "close"],
  data() {
    return {
      isDataLoaded: false,
      jornadas: {},
    };
  },
  watch: {
    show: function (newVal) {
      if (newVal) {
        this.getJornadas(this.horario.id);
      }
    },
  },
  methods: {
    async borraHorario() {
      try {
        this.$Progress.start();
        await axios.delete(
          `/empresas/${this.horario.empresas_id}/horarios/${this.horario.id}`
        );
        this.$emit("horarioBorrado");
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Horario y Jornadas borrados",
        });
        document.getElementById("close").click();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo borrar el horario",
        });
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else {
          console.log(error);
        }
      }
    },
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
    async getJornadas($horarioId) {
      try {
        this.isDataLoaded = false;
        this.$Progress.start();
        const response = await axios.get(
          `/empresas/${this.horario.empresas_id}/horarios/${$horarioId}/jornadas/detalles`
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