<template>
  <div class="row">
    <div class="col-12 mb-3">
      <baja-datatable
        :show="showBajaEmpleado"
        :empleado="empleado"
        @empleadoDadoBaja="actualizarDatatable"
        @close="showBajaEmpleado = false"
      ></baja-datatable>
      <alta-empleado
        :show="showAltaEmpleado"
        :dataTable="true"
        @close="showAltaEmpleado = false"
        @altaDatatable="actualizarDatatable"
      ></alta-empleado>
      <reasignar-horariodt
        :show="showReasignar"
        :empleado="empleado"
        @close="showReasignar = false"
      ></reasignar-horariodt>
      <div class="row mb-3">
        <div class="alert alert-secondary d-inline-block w-auto mx-auto">
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
          <span
            ><strong>Recuerde:</strong> usted, al ser administrador de la
            empresa, no aparece en el siguiente listado.</span
          >
        </div>
      </div>
      <div class="card base-card">
        <div
          class="card-header bg-white text-center d-flex justify-content-between"
        >
          <h4 class="mb-0">
            <strong>Empleados {{ empresa }}</strong>
          </h4>
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
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Fecha Alta</th>
                <th>Código Postal</th>
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
      showReasignar: false,
      showAltaEmpleado: false,
      showBajaEmpleado: false,
      empleado: {},
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
            if (error.response && error.response.status === 403) {
              // Recargar la página para mostrar el formulario de inicio de sesión
              location.reload();
            } else {
              console.log(error);
            }
          },
          dataSrc: "data",
        },
        columns: [
          { data: "id", visible: false },
          { data: "empresas_id", visible: false },
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
                '<div class="btn-group w-100">' +
                '<div class="col-12">' +
                '<button class="btn btn-outline-dark bg-warning btn-sm horario" data-id="' +
                row.id +
                '"><i class="bi bi-calendar-heart me-1"></i>Reasignar</button>&nbsp&nbsp&nbsp&nbsp<button class="btn btn-outline-dark bg-danger btn-sm baja" data-id="' +
                row.id +
                '"><i class="bi bi-person-fill-down me-1"></i>Baja</button>' +
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
    $("#tablaEmpleados").on("click", ".baja", (event) => {
      const employeeId = $(event.target).data("id");
      const employeeData = dataTableEmpleados
        .row($(event.target).closest("tr"))
        .data();
      this.abrirModalBaja(employeeData);
    });
    $("#tablaEmpleados").on("click", ".horario", (event) => {
      const employeeId = $(event.target).data("id");
      const employeeData = dataTableEmpleados
        .row($(event.target).closest("tr"))
        .data();
      this.abrirModalHorario(employeeData);
    });
  },
  methods: {
    abrirModalHorario(datos) {
      this.showReasignar = true;
      this.empleado = datos;
    },
    abrirModalBaja(datos) {
      this.showBajaEmpleado = true;
      this.empleado = datos;
    },
    actualizarDatatable() {
      // Volver a cargar los datos de la datatable
      $("#tablaEmpleados").DataTable().ajax.reload();
    },
  },
};
</script>