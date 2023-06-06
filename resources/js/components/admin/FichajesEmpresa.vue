<template>
  <div class="row">
    <div class="col-12 mb-3">
      <detalles-fichaje
        :show="showDetalles"
        :fichaje="fichaje"
        @close="showDetalles = false"
      ></detalles-fichaje>
      <div class="card base-card">
        <div
          class="card-header bg-white text-center d-flex justify-content-between"
        >
          <h4 class="mb-0 mt-2">
            <strong>Fichajes {{ empresa }}</strong>
          </h4>
          <h4 class="align-self-end mt-2">
            Mes: <strong>{{ mesActual() }}</strong>
          </h4>
        </div>
        <div class="base-card-body">
          <table
            id="tablaFichajes"
            class="table table-striped table-hover flex-wrap"
          >
            <thead>
              <tr>
                <th hidden></th>
                <th hidden></th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Horario</th>
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
      fichaje: {},
    };
  },
  mounted() {
    $.fn.dataTable.ext.errMode = "none";
    $.fn.DataTable.ext.pager.numbers_length = 5;
    var datatableFichajes;
    $(document).ready(function () {
      datatableFichajes = $("#tablaFichajes").DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        },
        rowReorder: {
          selector: "td:nth-child(2)",
        },
        responsive: true,
        autoWidth: false,
        lengthMenu: [5, 10, 25, 50, 100],
        pageLength: 5,
        ajax: {
          url: `../fichajes`,
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
          { data: "tipo", visible: false },
          { data: "fecha" },
          { data: "hora" },
          { data: "empleado_nombre" },
          { data: "empleado_apellidos" },
          { data: "horario_descripcion" },
          {
            // Columna adicional de acciones
            targets: -1,
            render: function (data, type, row, meta) {
              return (
                '<button class="btn btn-outline-dark bg-info btn-sm detalles" data-id="' +
                row.id +
                '"><i class="bi bi-eye-fill me-1"></i>Detalles</button>'
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
            targets: 2,
            render: DataTable.render.datetime("DD/MM/YYYY"),
          },
        ],
        order: [
          [2, "desc"],
          [3, "desc"],
        ],
      });
    });
    $("#tablaFichajes").on("click", ".detalles", (event) => {
      let fichajeData;

      if ($("#tablaFichajes").hasClass("collapsed")) {
        fichajeData = datatableFichajes
          .row($(event.target).closest("tr").siblings(".parent").first())
          .data();
      } else {
        fichajeData = datatableFichajes
          .row($(event.target).closest("tr"))
          .data();
      }
      this.abrirModalDetalles(fichajeData);
    });
  },
  methods: {
    mesActual() {
      var mesActual = new Date().toLocaleDateString("es-ES", {
        month: "long",
        timeZone: "UTC",
      });
      return mesActual.charAt(0).toUpperCase() + mesActual.slice(1);
    },
    abrirModalDetalles(datos) {
      this.showDetalles = true;
      this.fichaje = datos;
    },
    actualizarDatatable() {
      // Volver a cargar los datos de la datatable
      $("#tablaFichajes").DataTable().ajax.reload();
    },
  },
};
</script>

<style scoped>
.admin:hover {
  color: var(--bs-gray-200) !important;
}
</style>