<template>
  <div class="row">
    <div class="col-12">
      <detalles-ausencia
        :show="showDetalles"
        :ausencia="ausencia"
        :user="user"
        @close="showDetalles = false"
        @actualizaAusencia="actualizarDatatable"
      ></detalles-ausencia>
      <crear-ausencia
        :show="showAusencia"
        :user="user"
        :tipo="tipoAusencia"
        :dataTable="true"
        @close="showAusencia = false"
        @actualizaAusencia="actualizarDatatable"
      ></crear-ausencia>
      <div class="row">
        <div class="col-12 mb-3">
          <boton-fichar :user="user"></boton-fichar>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 mb-3">
          <div class="card base-card">
            <div class="card-header bg-white">
              <strong>Atajos Ausencias</strong>
            </div>
            <div class="base-card-body">
              <div class="d-flex justify-content-center flex-column">
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="
                    showAusencia = true;
                    tipoAusencia = 'Falta';
                  "
                >
                  <i class="bi bi-exclamation-circle-fill me-2"></i
                  ><span>Falta</span>
                </button>
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="
                    showAusencia = true;
                    tipoAusencia = 'Permiso';
                  "
                >
                  <i class="bi bi-question-circle-fill me-2"></i
                  ><span>Permiso</span>
                </button>
                <button
                  type="button"
                  class="btn btn-outline-dark bg-info btn-sm m-1"
                  @click="
                    showAusencia = true;
                    tipoAusencia = 'Vacaciones';
                  "
                >
                  <i class="bi bi-emoji-sunglasses me-2"></i
                  ><span>Vacaciones</span>
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9 mb-3">
          <div class="card base-card">
            <div
              class="card-header bg-white text-center d-flex justify-content-between"
            >
              <h4 class="mb-0 mt-2">
                <strong>Faltas</strong>
              </h4>
              <h5 class="align-self-end mt-2">
                <i>{{ empresa }}</i>
              </h5>
            </div>
            <div class="base-card-body">
              <table
                id="tablaFaltas"
                class="table table-striped table-hover flex-wrap"
              >
                <thead>
                  <tr>
                    <th hidden></th>
                    <th hidden></th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 mb-3">
          <div class="card base-card">
            <div
              class="card-header bg-white text-center d-flex justify-content-between"
            >
              <h4 class="mb-0 mt-2">
                <strong>Vacaciones</strong>
              </h4>
              <h5 class="align-self-end mt-2">
                <i>{{ empresa }}</i>
              </h5>
            </div>
            <div class="base-card-body">
              <table
                id="tablaVacaciones"
                class="table table-striped table-hover flex-wrap"
              >
                <thead>
                  <tr>
                    <th hidden></th>
                    <th hidden></th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 mb-3">
          <div class="card base-card">
            <div
              class="card-header bg-white text-center d-flex justify-content-between"
            >
              <h4 class="mb-0 mt-2">
                <strong>Permisos</strong>
              </h4>
              <h5 class="align-self-end mt-2">
                <i>{{ empresa }}</i>
              </h5>
            </div>
            <div class="base-card-body">
              <table
                id="tablaPermisos"
                class="table table-striped table-hover flex-wrap"
              >
                <thead>
                  <tr>
                    <th hidden></th>
                    <th hidden></th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Estado</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
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
      showAusencia: false,
      tipoAusencia: "",
      ausencia: {},
    };
  },
  mounted() {
    $.fn.dataTable.ext.errMode = "none";
    $.fn.DataTable.ext.pager.numbers_length = 5;
    var datatableVacaciones, datatablePermisos, datatableFaltas;
    const userId = this.user.id;
    $(document).ready(function () {
      // DATATABLE VACACIONES
      datatableVacaciones = $("#tablaVacaciones").DataTable({
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
          url: `../ausencias`,
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
          dataSrc: "vacaciones",
        },
        columns: [
          { data: "tipo", visible: false },
          { data: "motivos", visible: false },
          {
            data: "fecha_inicio",
            render: function (data, type, row) {
              if (type === "display" || type === "filter") {
                return moment(data).format("DD/MM/YYYY");
              }
              return data;
            },
          },
          {
            data: "fecha_fin",
            render: function (data, type, row) {
              if (type === "display" || type === "filter") {
                return moment(data).format("DD/MM/YYYY");
              }
              return data;
            },
          },
          { data: "estado_aceptada" },
          { data: "name" },
          { data: "apellidos" },
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
        ],
        order: [
          [2, "desc"],
          [3, "desc"],
        ],
      });

      // DATATABLE PERMISOS
      datatablePermisos = $("#tablaPermisos").DataTable({
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
          url: `../ausencias`,
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
          dataSrc: "permisos",
        },
        columns: [
          { data: "tipo", visible: false },
          { data: "motivos", visible: false },
          {
            data: "fecha_inicio",
            render: function (data, type, row) {
              if (type === "display" || type === "filter") {
                return moment(data).format("DD/MM/YYYY");
              }
              return data;
            },
          },
          {
            data: "fecha_fin",
            render: function (data, type, row) {
              if (type === "display" || type === "filter") {
                return moment(data).format("DD/MM/YYYY");
              }
              return data;
            },
          },
          { data: "estado_aceptada" },
          { data: "name" },
          { data: "apellidos" },
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
        ],
        order: [
          [2, "desc"],
          [3, "desc"],
        ],
      });

      // DATATABLE FALTAS
      datatableFaltas = $("#tablaFaltas").DataTable({
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
          url: `../ausencias`,
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
          dataSrc: "faltas",
        },
        columns: [
          { data: "tipo", visible: false },
          { data: "motivos", visible: false },
          {
            data: "fecha_inicio",
            render: function (data, type, row) {
              if (type === "display" || type === "filter") {
                return moment(data).format("DD/MM/YYYY");
              }
              return data;
            },
          },
          {
            data: "fecha_fin",
            render: function (data, type, row) {
              if (type === "display" || type === "filter") {
                return moment(data).format("DD/MM/YYYY");
              }
              return data;
            },
          },
          { data: "name" },
          { data: "apellidos" },
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
        ],
        order: [
          [2, "desc"],
          [3, "desc"],
        ],
      });
    });

    $("#tablaVacaciones").on("click", ".detalles", (event) => {
      let ausenciaData;

      if ($("#tablaVacaciones").hasClass("collapsed")) {
        ausenciaData = datatableVacaciones
          .row($(event.target).closest("tr").siblings(".parent").first())
          .data();
      } else {
        ausenciaData = datatableVacaciones
          .row($(event.target).closest("tr"))
          .data();
      }
      this.abrirModalDetalles(ausenciaData);
    });
    $("#tablaPermisos").on("click", ".detalles", (event) => {
      let ausenciaData;

      if ($("#tablaPermisos").hasClass("collapsed")) {
        ausenciaData = datatablePermisos
          .row($(event.target).closest("tr").siblings(".parent").first())
          .data();
      } else {
        ausenciaData = datatablePermisos
          .row($(event.target).closest("tr"))
          .data();
      }
      this.abrirModalDetalles(ausenciaData);
    });
    $("#tablaFaltas").on("click", ".detalles", (event) => {
      let ausenciaData;

      if ($("#tablaFaltas").hasClass("collapsed")) {
        ausenciaData = datatableFaltas
          .row($(event.target).closest("tr").siblings(".parent").first())
          .data();
      } else {
        ausenciaData = datatableFaltas
          .row($(event.target).closest("tr"))
          .data();
      }
      this.abrirModalDetalles(ausenciaData);
    });
  },
  methods: {
    abrirModalDetalles(datos) {
      this.showDetalles = true;
      this.ausencia = datos;
    },
    actualizarDatatable($tipo) {
      // Volver a cargar los datos de la datatable
      if ($tipo == "Falta") {
        $("#tablaFaltas").DataTable().ajax.reload();
      }
      if ($tipo == "Permiso") {
        $("#tablaPermisos").DataTable().ajax.reload();
      }
      if ($tipo == "Vacaciones") {
        $("#tablaVacaciones").DataTable().ajax.reload();
      }
    },
  },
};
</script>