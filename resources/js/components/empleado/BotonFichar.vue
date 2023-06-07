<template>
  <div class="d-flex justify-content-center" v-if="jornada">
    <form @submit.prevent="fichar" v-if="fichajesHoy != 2">
      <button
        type="submit"
        class="btn btn-outline-success bg-dark fichar"
        v-if="fichajesHoy == 0"
      >
        <i class="bi bi-box-arrow-in-right me-2"></i
        ><span class="fw-bold">Fichar Entrada</span>
      </button>
      <button
        type="submit"
        class="btn btn-outline-danger bg-dark fichar"
        v-if="fichajesHoy == 1"
      >
        <i class="bi bi-box-arrow-left me-2"></i>
        <span class="fw-bold">Fichar Salida</span>
      </button>
    </form>
    <div class="alert alert-primary d-inline-block w-auto mx-auto" v-else>
      <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
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
      <span><strong>Ya ha fichado su salida del trabajo hoy.</strong></span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
    },
    dataTable: {
      type: Boolean,
      default: false,
    },
  },
  emits: ["actualizaFichajes"],
  data() {
    return {
      fichajesHoy: null,
      jornada: {},
      tipoFichaje: "",
    };
  },
  mounted() {
    this.getJornada();
    this.getFichajesHoy();
  },
  methods: {
    async getJornada() {
      try {
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/horarios/${this.user.horarios_id}/empleado/${this.user.id}/jornada`
        );
        if (response.status === 204) {
          this.jornada = false;
        }
        this.jornada = response.data;
      } catch (error) {
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else {
          console.log(error);
        }
      }
    },
    async getFichajesHoy() {
      try {
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/empleados/${this.user.id}/fichajes/info`
        );
        this.fichajesHoy = response.data;
      } catch (error) {
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else {
          console.log(error);
        }
      }
    },
    async fichar() {
      try {
        this.$Progress.start();
        if (this.fichajesHoy == 0) {
          this.tipoFichaje = "entrada";
        } else if (this.fichajesHoy == 1) {
          this.tipoFichaje = "salida";
        }
        await axios.post(
          `/empresas/${this.user.empresas_id}/empleados/${this.user.id}/fichar/${this.tipoFichaje}`
        );
        this.getJornada();
        this.getFichajesHoy();
        if (this.dataTable) {
          this.$emit("actualizaFichajes");
        }
        this.$Progress.finish();
        Toast.fire({
          icon: "success",
          title: "Ha fichado correctamente",
        });
      } catch (error) {
        this.$Progress.fail();
        Toast.fire({
          icon: "error",
          title: "No se pudo realizar el fichaje",
        });
        if (error.response && error.response.status === 403) {
          // Recargar la página para mostrar el formulario de inicio de sesión
          location.reload();
        } else {
          console.log(error);
        }
      }
    },
    // ejecutarAnimacion() {
    //   const elemento = document.querySelector(".fichar");
    //   elemento.classList.add("agitar");
    //   setTimeout(function () {
    //     elemento.classList.remove("agitar");
    //   }, 5000);
    // },
  },
};
</script>