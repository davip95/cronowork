require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// SweetAlert
import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    // timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.Toast = Toast;

// Vue vform
window.Vue = require('vue').default;
import Form from 'vform'
import {
    Button,
    HasError,
} from 'vform/src/components/bootstrap5'

window.Form = Form;
Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)

// Vue progressbar
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    thickness: '8px',
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Componentes Usuario
Vue.component('edit-user', require('./components/usuario/EditUser.vue').default);
// Componentes Admin
Vue.component('inicio-admin', require('./components/admin/InicioAdmin.vue').default);
Vue.component('edit-admin', require('./components/admin/EditAdmin.vue').default);
Vue.component('change-admin', require('./components/admin/ChangeAdmin.vue').default);
Vue.component('edit-company', require('./components/admin/EditCompany.vue').default);
Vue.component('delete-company', require('./components/admin/DeleteCompany.vue').default);
Vue.component('alta-empleado', require('./components/admin/AltaEmpleado.vue').default);
Vue.component('baja-empleado', require('./components/admin/BajaEmpleado.vue').default);
Vue.component('empleados-empresa', require('./components/admin/EmpleadosEmpresa.vue').default);
Vue.component('baja-datatable', require('./components/admin/BajaDatatable.vue').default);
Vue.component('reasignar-horario', require('./components/admin/ReasignarHorario.vue').default);
Vue.component('reasignar-horariodt', require('./components/admin/ReasignarHorarioDt.vue').default);
Vue.component('detalles-empleado', require('./components/admin/DetallesEmpleado.vue').default);
Vue.component('asignar-horario', require('./components/admin/AsignarHorario.vue').default);
Vue.component('horarios-empresa', require('./components/admin/HorariosEmpresa.vue').default);
Vue.component('crear-horario', require('./components/admin/CrearHorario.vue').default);
Vue.component('detalles-horario', require('./components/admin/DetallesHorario.vue').default);
Vue.component('borrar-horario', require('./components/admin/BorrarHorario.vue').default);
Vue.component('fichajes-empresa', require('./components/admin/FichajesEmpresa.vue').default);
Vue.component('detalles-fichaje', require('./components/admin/DetallesFichaje.vue').default);
// Componentes Empleado
Vue.component('mi-horario', require('./components/empleado/MiHorario.vue').default);
Vue.component('mis-fichajes', require('./components/empleado/MisFichajes.vue').default);
Vue.component('boton-fichar', require('./components/empleado/BotonFichar.vue').default);
Vue.component('crear-ausencia', require('./components/empleado/CrearAusencia.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});