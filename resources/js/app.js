require("./bootstrap");

window.Vue = require("vue").default;
import router from "./router";
import common from "./common";
Vue.mixin(common);

import { library } from "@fortawesome/fontawesome-svg-core";

import { faUserSecret } from "@fortawesome/free-solid-svg-icons";

import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

import DatePicker from 'vue2-datepicker';
Vue.component('DatePicker', DatePicker);

import moment from 'moment'
window.moment = moment;

import Swal from "sweetalert2";

import VueSelect2 from 'v-select2-component';

Vue.component('VueSelect2', VueSelect2);

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2500,
});
window.Toast = Toast;

const SwalCustomBtn = Swal.mixin({
    customClass: {
        confirmButton: "btn btn-success mx-1",
        cancelButton: "btn btn-danger mx-1",
    },
    buttonsStyling: false,
});

window.SwalCustomBtn = SwalCustomBtn;

library.add(faUserSecret);

import VueTrix from "vue-trix";
Vue.component("VueTrix", VueTrix);

Vue.component("font-awesome-icon", FontAwesomeIcon);

Vue.config.productionTip = false;

import Footer from "./components/common/Footer.vue";
Vue.component("Footer", Footer);

import Breadcrumb from "./components/common/Breadcrumb.vue";
Vue.component("Breadcrumb", Breadcrumb);

import Select2 from "./components/common/Select2.vue"
Vue.component("Select2", Select2);

import NoData from "./components/common/NoData.vue"
Vue.component("NoData", NoData);

import Table from "./components/common/Table.vue"
Vue.component("Table", Table);

import LottieAnimation from "lottie-vuejs/src/LottieAnimation.vue";
Vue.component('LottieAnimation', LottieAnimation);

Vue.filter('formatDate', function(value) {
    if (!value) return '';
    return moment(String(value)).format('DD MMM YYYY');
});

Vue.filter('formatDateMDY', function(value) {
    if (!value) return '';
    return moment(String(value)).format('MMM DD, YYYY')
});

Vue.filter('formatTime', function(value) {
    if (!value) return '';
    return moment("2021-12-01 " + String(value)).format('hh:mm A');
});

Vue.filter('leadingZero', function(value) {
    if (!value) return '';
    if (parseInt(value) < 10) {
        return '0' + parseInt(value);
    }
    return value;
});

Vue.component(
    "main-component",
    require("./components/MainComponent.vue").default
);
Vue.component(
    "admin-main-component",
    require("./components/AdminMainComponent.vue").default
);

const app = new Vue({
    el: "#app",
    router,
});
