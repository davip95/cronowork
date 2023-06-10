<template>
  <transition name="modal" v-if="show">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="card modal-container">
          <div
            class="card-header text-center bg-success d-flex justify-content-between"
          >
            Nuevo Horario
            <button
              type="button"
              class="btn-close align-self-end"
              aria-label="Close"
              id="close"
              @click="$emit('close')"
            ></button>
          </div>
          <div class="card-body">
            <form @submit.prevent="creaHorario">
              <div class="row text-center"><h4>Horario</h4></div>
              <hr />
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Descripción</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <input
                    v-model="form.descripcion"
                    type="text"
                    name="descripcion"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('descripcion'),
                    }"
                    required
                  />
                  <has-error :form="form" field="descripcion"></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3 d-flex justify-content-end">
                  <h6 class="mb-0">Intensivo</h6>
                </div>
                <div class="col-sm-3 text-secondary">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="intensivo"
                      value="true"
                      id="siIntensivo"
                      required
                      :class="{
                        'is-invalid': form.errors.has('intensivo'),
                      }"
                      v-model="form.intensivo"
                      @change="esIntensivo = true"
                    />
                    <label class="form-check-label" for="siIntensivo">
                      Sí
                    </label>
                  </div>
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="intensivo"
                      value="false"
                      id="noIntensivo"
                      required
                      :class="{
                        'is-invalid': form.errors.has('intensivo'),
                      }"
                      v-model="form.intensivo"
                      @change="esIntensivo = false"
                    />
                    <label class="form-check-label" for="noIntensivo">
                      No
                    </label>
                  </div>
                  <has-error :form="form" field="intensivo"></has-error>
                </div>
              </div>
              <transition name="fade" :duration="{ enter: 800, leave: 300 }">
                <div v-if="esIntensivo">
                  <div class="row mb-3" :hidden="!esIntensivo">
                    <div class="col-sm-3 d-flex justify-content-end">
                      <h6 class="mb-0">Fecha Inicio Intensivo</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        v-model="form.fecha_inicio_intensivo"
                        type="date"
                        min="2023-01-01"
                        max="2023-12-31"
                        name="fecha_inicio_intensivo"
                        class="form-control"
                        :class="{
                          'is-invalid': form.errors.has(
                            'fecha_inicio_intensivo'
                          ),
                        }"
                      />
                      <small
                        ><strong
                          >Seleccione únicamente día y mes.</strong
                        ></small
                      >
                      <has-error
                        :form="form"
                        field="fecha_inicio_intensivo"
                      ></has-error>
                    </div>
                  </div>
                  <div class="row mb-3" :hidden="!esIntensivo">
                    <div class="col-sm-3 d-flex justify-content-end">
                      <h6 class="mb-0">Fecha Fin Intensivo</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input
                        v-model="form.fecha_fin_intensivo"
                        type="date"
                        min="2023-01-01"
                        max="2023-12-31"
                        name="fecha_fin_intensivo"
                        class="form-control"
                        :class="{
                          'is-invalid': form.errors.has('fecha_fin_intensivo'),
                        }"
                      />
                      <small
                        ><strong
                          >Seleccione únicamente día y mes.</strong
                        ></small
                      >
                      <has-error
                        :form="form"
                        field="fecha_fin_intensivo"
                      ></has-error>
                    </div>
                  </div>
                </div>
              </transition>
              <div class="row text-center">
                <h4>Jornadas</h4>
              </div>
              <hr />
              <div class="row mb-4">
                <div class="col-12">
                  <h6 class="text-center fw-bold">
                    Marque los días laborables
                  </h6>
                  <div class="d-flex justify-content-center mt-1">
                    <div
                      class="btn-group grupoDias"
                      :class="{
                        'bg-danger': form.errors.has('dias'),
                      }"
                    >
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: isDaySelected(1) }"
                        @click="toggleDay(1)"
                      >
                        L
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: isDaySelected(2) }"
                        @click="toggleDay(2)"
                      >
                        M
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: isDaySelected(3) }"
                        @click="toggleDay(3)"
                      >
                        X
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: isDaySelected(4) }"
                        @click="toggleDay(4)"
                      >
                        J
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: isDaySelected(5) }"
                        @click="toggleDay(5)"
                      >
                        V
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: isDaySelected(6) }"
                        @click="toggleDay(6)"
                      >
                        S
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: isDaySelected(7) }"
                        @click="toggleDay(7)"
                      >
                        D
                      </button>
                    </div>
                  </div>
                  <h5 class="text-center">
                    <has-error :form="form" field="dias"></has-error>
                  </h5>
                </div>
              </div>
              <h6 class="text-center fw-bold">Tiempos de las jornadas</h6>
              <div class="row mb-3 mt-1">
                <div class="col-sm-2 d-flex justify-content-end">
                  <h6 class="mb-0">Minutos Descanso</h6>
                </div>
                <div class="col-sm-4 text-secondary mb-2">
                  <input
                    v-model="form.minutos_descanso"
                    type="number"
                    min="0"
                    max="720"
                    name="minutos_descanso"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('minutos_descanso'),
                    }"
                    required
                  />
                  <has-error :form="form" field="minutos_descanso"></has-error>
                </div>
                <div
                  class="col-sm-2 d-flex justify-content-end"
                  v-if="esIntensivo"
                >
                  <h6 class="mb-0">Descanso Intensivo</h6>
                </div>
                <div class="col-sm-4 text-secondary mb-2" v-if="esIntensivo">
                  <input
                    v-model="form.minutos_descanso_intensiva"
                    type="number"
                    min="0"
                    max="720"
                    name="minutos_descanso_intensiva"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has(
                        'minutos_descanso_intensiva'
                      ),
                    }"
                  />
                  <has-error
                    :form="form"
                    field="minutos_descanso_intensiva"
                  ></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-2 d-flex justify-content-end">
                  <h6 class="mb-0">Hora Inicio</h6>
                </div>
                <div class="col-sm-4 text-secondary mb-2">
                  <input
                    v-model="form.hora_inicio"
                    type="time"
                    name="hora_inicio"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('hora_inicio'),
                    }"
                    required
                  />
                  <has-error :form="form" field="hora_inicio"></has-error>
                </div>
                <div
                  class="col-sm-2 d-flex justify-content-end"
                  v-if="esIntensivo"
                >
                  <h6 class="mb-0">H. Inicio Intensivo</h6>
                </div>
                <div class="col-sm-4 text-secondary mb-2" v-if="esIntensivo">
                  <input
                    v-model="form.hora_inicio_intensiva"
                    type="time"
                    name="hora_inicio_intensiva"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('hora_inicio_intensiva'),
                    }"
                  />
                  <has-error
                    :form="form"
                    field="hora_inicio_intensiva"
                  ></has-error>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-2 d-flex justify-content-end">
                  <h6 class="mb-0">Hora Fin</h6>
                </div>
                <div class="col-sm-4 text-secondary mb-2">
                  <input
                    v-model="form.hora_fin"
                    type="time"
                    name="hora_fin"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('hora_fin'),
                    }"
                    required
                  />
                  <has-error :form="form" field="hora_fin"></has-error>
                </div>
                <div
                  class="col-sm-2 d-flex justify-content-end"
                  v-if="esIntensivo"
                >
                  <h6 class="mb-0">H. Fin Intensivo</h6>
                </div>
                <div class="col-sm-4 text-secondary mb-2" v-if="esIntensivo">
                  <input
                    v-model="form.hora_fin_intensiva"
                    type="time"
                    name="hora_fin_intensiva"
                    class="form-control"
                    :class="{
                      'is-invalid': form.errors.has('hora_fin_intensiva'),
                    }"
                  />
                  <has-error
                    :form="form"
                    field="hora_fin_intensiva"
                  ></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3 d-flex justify-content-end"></div>
                <div
                  class="col-sm-6 text-secondary d-flex justify-content-between"
                >
                  <button type="submit" class="btn btn-success px-4">
                    Crear
                  </button>
                  <button
                    type="button"
                    class="btn btn-secondary align-self-end"
                    @click="$emit('close')"
                  >
                    Cancelar
                  </button>
                </div>
                <div class="col-sm-3 d-flex justify-content-end"></div>
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
  emits: ["close", "actualizaHorario"],
  data() {
    return {
      esIntensivo: false,
      form: new Form({
        descripcion: null,
        intensivo: null,
        fecha_inicio_intensivo: null,
        fecha_fin_intensivo: null,
        dias: [],
        minutos_descanso: null,
        minutos_descanso_intensiva: null,
        hora_inicio: null,
        hora_inicio_intensiva: null,
        hora_fin: null,
        hora_fin_intensiva: null,
      }),
    };
  },
  methods: {
    async creaHorario() {
      try {
        this.$Progress.start();
        await this.form.post(
          `/empresas/${this.user.empresas_id}/empleados/${this.user.id}/admin/horario/dt`
        );
        this.$emit("actualizaHorario");
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Horario creado",
        });
        this.form.descripcion = null;
        this.form.intensivo = null;
        this.form.fecha_inicio_intensivo = null;
        this.form.fecha_fin_intensivo = null;
        this.form.dias = [];
        this.form.minutos_descanso = null;
        this.form.minutos_descanso_intensiva = null;
        this.form.hora_inicio = null;
        this.form.hora_inicio_intensiva = null;
        this.form.hora_fin = null;
        this.form.hora_fin_intensiva = null;
        document.getElementById("close").click();
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo crear horario",
        });
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else {
          console.log(error.response);
        }
      }
    },
    toggleDay(day) {
      const index = this.form.dias.indexOf(day);
      if (index > -1) {
        this.form.dias.splice(index, 1);
      } else {
        this.form.dias.push(day);
      }
    },
    isDaySelected(day) {
      return this.form.dias.includes(day);
    },
  },
};
</script>

<style scoped>
.dias {
  width: 50px;
  background: #ced4da !important;
}

.dias.active {
  background: #198754 !important;
}

.separadias {
  padding: 0 5px !important;
}

@media (max-width: 768px) {
  .separadias {
    padding: 0 1px !important;
  }
  .grupoDias {
    scale: 0.75;
  }
  .modal-container {
    margin: 0 auto !important;
    width: 95vw !important;
  }
}

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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>