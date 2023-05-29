<template>
  <div class="row">
    <div class="col-12 mb-3">
      <div class="card base-card">
        <div class="card-header text-center d-flex justify-content-between">
          <h3 class="mb-0">Empleados {{ empresa }}</h3>
          <button
            type="button"
            class="btn btn-outline-dark bg-success btn-sm align-self-end"
            @click="showAltaEmpleado = true"
          >
            <i class="bi bi-person-fill-up me-2"></i><span>Dar Alta</span>
          </button>
        </div>
        <div class="base-card-body">
          <table
            id="tablaEmpleados"
            class="table table-striped table-hover flex-wrap"
          >
            <thead>
              <tr>
                <th hidden>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Fecha Alta</th>
                <th>Código Postal</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <!-- <tbody></tbody> -->
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
      showAltaEmpleado: false,
    };
  },
  mounted() {
    $.fn.dataTable.ext.errMode = "none";
    $.fn.DataTable.ext.pager.numbers_length = 5;
    var dataTableEmpleados;
    $(document).ready(function () {
      dataTableEmpleados = $("#tablaEmpleados").DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json",
        },
        rowReorder: {
          selector: "td:nth-child(2)",
        },
        responsive: true,
        autoWidth: false,
        ajax: {
          url: `empleados/admin/listar`,
          method: "GET",
          dataType: "json",
          error: function (xhr, error) {
            console.error("Error en la solicitud:", error);
          },
          dataSrc: "data",
        },
        columns: [
          { data: "id", visible: false },
          { data: "name" },
          { data: "apellidos" },
          { data: "email" },
          { data: "fecha_alta" },
          { data: "codpostal", defaultContent: "-" },
          {
            // Columna adicional de acciones
            targets: -1,
            render: function (data, type, row, meta) {
              return (
                '<div class="btn-group">' +
                '<div class="col col-md-6 mx-1">' +
                '<button class="btn btn-warning" data-id="' +
                row.id +
                '">Editar</button>' +
                "</div>" +
                '<div class="col col-md-6 mx-1">' +
                '<button class="btn btn-danger" data-id="' +
                row.id +
                '">Borrar</button>' +
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
        ],
        order: [[4, "asc"]],
      });
    });
    $("#tablaEmpleados").on("click", ".btn-warning", (event) => {
      const employeeId = $(event.target).data("id");
      const employeeData = dataTableEmpleados
        .row($(event.target).closest("tr"))
        .data();
      this.abrirModal(employeeData);
    });
  },
  methods: {
    abrirModal(datos) {
      console.log(datos);
    },
  },
};
</script>