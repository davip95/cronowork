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
              <div class="row mb-3">
                <div class="col-12">
                  <div class="d-flex justify-content-center">
                    <div class="btn-group grupoDias">
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: activeButton === 'L' }"
                        @click="activeButton = 'L'"
                      >
                        L
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: activeButton === 'M' }"
                        @click="activeButton = 'M'"
                      >
                        M
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: activeButton === 'X' }"
                        @click="activeButton = 'X'"
                      >
                        X
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: activeButton === 'J' }"
                        @click="activeButton = 'J'"
                      >
                        J
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: activeButton === 'V' }"
                        @click="activeButton = 'V'"
                      >
                        V
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: activeButton === 'S' }"
                        @click="activeButton = 'S'"
                      >
                        S
                      </button>
                      <div class="alert alert-white m-0 px-0 separadias"></div>
                      <button
                        type="button"
                        class="btn btn-light dias"
                        :class="{ active: activeButton === 'D' }"
                        @click="activeButton = 'D'"
                      >
                        D
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- AQUI ACABA CONTENIDO DE JORNADAS -->
              <div class="row">
                <div class="col-sm-3 d-flex justify-content-end"></div>
                <div
                  class="col-sm-9 text-secondary d-flex justify-content-between"
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
  props: ["show"],
  emits: ["close"],
  //   emits: ["close", "actualizaHorario"],
  data() {
    return {
      esIntensivo: false,
      activeButton: "",
      horarios: {},
      form: new Form({
        descripcion: null,
        intensivo: null,
        fecha_inicio_intensivo: null,
        fecha_fin_intensivo: null,
        dias: [],
        minutos_descanso: {},
        minutos_descanso_intensiva: {},
        hora_inicio: {},
        hora_inicio_intensiva: {},
        hora_fin: {},
        hora_fin_intensiva: {},
      }),
    };
  },
  methods: {
    async creaHorario() {
      console.log(this.form);
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