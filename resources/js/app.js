require('./bootstrap');

// IMPORTS
import moment from 'moment';
    import { Form, HasError, AlertError } from 'vform';
    import Swal from 'sweetalert2';
    import VueRouter from 'vue-router';
    import routes from './routes';
    import VueProgressBar from 'vue-progressbar'

// CONSTANTES
    const router = new VueRouter({
        mode: 'history',
        routes
    });
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

// USES
    window.Vue = require('vue');
    Vue.use(VueRouter);
    window.Swal = Swal;
    window.Toast = Toast;
    window.Form = Form;
    Vue.use(VueProgressBar, {
        color: 'rgb(143, 255, 199)',
        failedColor: 'red',
        height: '3px'
    });

// COMPONENTS
    Vue.component(HasError.name, HasError)
    Vue.component(AlertError.name, AlertError)
    Vue.component('weather', require('./components/Weather/Weather').default);

// ESTANCIA VUE
    const app = new Vue({
        el: '#app',
        router
    });
