<template>
  <div class="row">
    <div class="col-12 mb-3">
      <borrar-horario
        :show="showBorrarHorario"
        :horario="horario"
        @horarioBorrado="actualizarDatatable"
        @close="showBorrarHorario = false"
      ></borrar-horario>
      <crear-horario
        :show="showCrearHorario"
        :user="user"
        @close="showCrearHorario = false"
        @actualizaHorario="actualizarDatatable"
      ></crear-horario>
      <detalles-horario
        :show="showDetalles"
        :user="user"
        :horario="horario"
        @close="showDetalles = false"
      ></detalles-horario>
      <div class="card base-card">
        <div
          class="card-header bg-white text-center d-flex justify-content-between"
        >
          <h4 class="mb-0">
            <strong>Horarios {{ empresa }}</strong>
          </h4>
          <button
            type="button"
            class="btn btn-outline-dark bg-success btn-sm align-self-end"
            @click="showCrearHorario = true"
          >
            <i class="bi bi-person-fill-up me-2"></i><span>Crear Horario</span>
          </button>
        </div>
        <div class="base-card-body">
          <table
            id="tablaHorarios"
            class="table table-striped table-hover flex-wrap"
          >
            <thead>
              <tr>
                <th hidden></th>
                <th hidden></th>
                <th>Descripcion</th>
                <th>Fecha Inicio Intensivo</th>
                <th>Fecha Fin Intensivo</th>
                <th>Acciones</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["user", "empresa"],
  data() {
    return {
      showDetalles: false,
      showCrearHorario: false,
      showBorrarHorario: false,
      horario: {},
      asignado: null,
    };
  },
  watch: {
    asignado(newVal) {
      this.asignado = newVal;
    },
  },
  mounted() {
    $.fn.dataTable.ext.errMode = "none";
    $.fn.DataTable.ext.pager.numbers_length = 5;
    var datatableHorarios;
    $(document).ready(function () {
      datatableHorarios = $("#tablaHorarios").DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        },
        rowReorder: {
          selector: "td:nth-child(2)",
        },
        responsive: true,
        autoWidth: false,
        ajax: {
          url: "../horarios",
          method: "GET",
          dataType: "json",
          error: function (xhr, error) {
            if (error.response && error.response.status === 403) {
              // Recargar la página para mostrar el formulario de inicio de sesión
              location.reload();
            } else {
              console.log(error);
            }
          },
          dataSrc: "",
        },
        columns: [
          { data: "id", visible: false },
          { data: "empresas_id", visible: false },
          { data: "descripcion" },
          { data: "fecha_inicio_intensivo", defaultContent: "-" },
          { data: "fecha_fin_intensivo", defaultContent: "-" },
          {
            // Columna adicional de acciones
            targets: -1,
            render: function (data, type, row, meta) {
              return (
                '<div class="btn-group w-100">' +
                '<div class="col-12">' +
                '<button class="btn btn-outline-dark bg-info btn-sm detalles" data-id="' +
                row.id +
                '"><i class="bi bi-eye-fill me-1"></i>Info</button>&nbsp&nbsp&nbsp' +
                '<button class="btn btn-outline-dark bg-danger btn-sm borrar" data-id="' +
                row.id +
                '"><i class="bi bi-person-fill-down me-1"></i>Borrar</button>' +
                "</div>" +
                "</div>"
              );
            },
          },
        ],
        columnDefs: [
          {
            targets: -1,
            searchable: false,
            orderable: false,
          },
          {
            targets: 3,
            render: DataTable.render.datetime("DD/MM/YYYY"),
          },
          {
            targets: 4,
            render: DataTable.render.datetime("DD/MM/YYYY"),
          },
        ],
        order: [[0, "desc"]],
      });
    });
    $("#tablaHorarios").on("click", ".borrar", (event) => {
      let horarioData;

      if ($("#tablaHorarios").hasClass("collapsed")) {
        horarioData = datatableHorarios
          .row($(event.target).closest("tr").siblings(".parent").first())
          .data();
      } else {
        horarioData = datatableHorarios
          .row($(event.target).closest("tr"))
          .data();
      }
      this.abrirModalBorrar(horarioData);
    });
    $("#tablaHorarios").on("click", ".detalles", (event) => {
      let horarioData;

      if ($("#tablaHorarios").hasClass("collapsed")) {
        horarioData = datatableHorarios
          .row($(event.target).closest("tr").siblings(".parent").first())
          .data();
      } else {
        horarioData = datatableHorarios
          .row($(event.target).closest("tr"))
          .data();
      }
      this.abrirModalDetalles(horarioData);
    });
  },
  methods: {
    abrirModalBorrar(datos) {
      this.compruebaHorario(datos);
    },
    abrirModalDetalles(datos) {
      this.showDetalles = true;
      this.horario = datos;
    },
    actualizarDatatable() {
      // Volver a cargar los datos de la datatable
      $("#tablaHorarios").DataTable().ajax.reload();
    },
    async compruebaHorario(horario) {
      await this.getHorario(horario.id);
      // Si no tiene empleado asignado, abro el modal de borrado
      if (this.asignado === false) {
        this.showBorrarHorario = true;
      } else {
        // Si tiene empleado asignado, muestro mensaje de error
        Toast.fire({
          icon: "error",
          title: "No se puede borrar horario",
          text: "Este horario tiene empleado(s) asignado(s)",
        });
      }
    },
    async getHorario($horarioId) {
      try {
        const response = await axios.get(
          `/empresas/${this.user.empresas_id}/horarios/${$horarioId}`
        );
        this.horario = response.data.horario;
        this.asignado = response.data.asignado;
      } catch (error) {
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
.admin:hover {
  color: var(--bs-gray-200) !important;
}
</style>