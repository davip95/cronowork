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
        :user="user"
        :dataTable="true"
        @close="showAltaEmpleado = false"
        @altaDatatable="actualizarDatatable"
      ></alta-empleado>
      <reasignar-horariodt
        :show="showReasignar"
        :empleado="empleado"
        @close="showReasignar = false"
      ></reasignar-horariodt>
      <change-admin
        :show="showChangeAdmin"
        :user="user"
        @close="showChangeAdmin = false"
      ></change-admin>
      <detalles-empleado
        :show="showDetalles"
        :user="empleado"
        @close="showDetalles = false"
      ></detalles-empleado>
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
                <th hidden></th>
                <th hidden></th>
                <th hidden></th>
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
      showDetalles: false,
      showChangeAdmin: false,
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
          { data: "tipo", visible: false },
          { data: "name" },
          { data: "apellidos" },
          { data: "email" },
          { data: "fecha_alta" },
          { data: "codpostal", defaultContent: "-" },
          {
            // Columna adicional de acciones
            targets: -1,
            render: function (data, type, row, meta) {
              if (row.tipo === "admin") {
                return (
                  '<div class="btn-group w-100">' +
                  '<div class="col-12">' +
                  '<button class="btn btn-outline-dark bg-info btn-sm detalles" data-id="' +
                  row.id +
                  '"><i class="bi bi-eye-fill me-1"></i>Info</button>&nbsp&nbsp&nbsp' +
                  '<button class="btn btn-outline-dark bg-warning btn-sm horario" data-id="' +
                  row.id +
                  '"><i class="bi bi-calendar-heart me-1"></i>Horario</button>&nbsp&nbsp&nbsp<button class="btn btn-outline-danger bg-dark btn-sm admin" data-id="' +
                  row.id +
                  '"><i class="bi bi-person-fill-gear me-1"></i>Admin</button>' +
                  "</div>" +
                  "</div>"
                );
              } else {
                return (
                  '<div class="btn-group w-100">' +
                  '<div class="col-12">' +
                  '<button class="btn btn-outline-dark bg-info btn-sm detalles" data-id="' +
                  row.id +
                  '"><i class="bi bi-eye-fill me-1"></i>Info</button>&nbsp&nbsp&nbsp' +
                  '<button class="btn btn-outline-dark bg-warning btn-sm horario" data-id="' +
                  row.id +
                  '"><i class="bi bi-calendar-heart me-1"></i>Horario</button>&nbsp&nbsp&nbsp<button class="btn btn-outline-dark bg-danger btn-sm baja" data-id="' +
                  row.id +
                  '"><i class="bi bi-person-fill-down me-1"></i>Baja</button>' +
                  "</div>" +
                  "</div>"
                );
              }
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
            targets: 6,
            render: DataTable.render.datetime("DD/MM/YYYY"),
          },
        ],
        order: [[6, "desc"]],
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
    $("#tablaEmpleados").on("click", ".admin", (event) => {
      const employeeId = $(event.target).data("id");
      const employeeData = dataTableEmpleados
        .row($(event.target).closest("tr"))
        .data();
      this.abrirModalAdmin(employeeData);
    });
    $("#tablaEmpleados").on("click", ".detalles", (event) => {
      const employeeId = $(event.target).data("id");
      const employeeData = dataTableEmpleados
        .row($(event.target).closest("tr"))
        .data();
      this.abrirModalDetalles(employeeData);
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
    abrirModalAdmin(datos) {
      this.showChangeAdmin = true;
    },
    abrirModalDetalles(datos) {
      this.showDetalles = true;
      this.empleado = datos;
    },
    actualizarDatatable() {
      // Volver a cargar los datos de la datatable
      $("#tablaEmpleados").DataTable().ajax.reload();
    },
  },
};
</script>

<style scoped>
.admin:hover {
  color: var(--bs-gray-200) !important;
}
</style>