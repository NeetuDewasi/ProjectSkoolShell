import TransportRoutes from "../../components/pages/transport/school_routes/TransportRoutes.vue";
import TransportAssignVehicles from "../../components/pages/transport/assign_vehicles/AssignVehicles.vue";
import Vehicles from "../../components/pages/transport/vehicles/Vehicles.vue";
import TransportReport from "../../components/pages/transport/reports/TransportReport.vue";
import AddTransportRoutes from "../../components/pages/transport/school_routes/AddTransportRoutes.vue";
import RoutePoints from '../../components/pages/transport/school_routes/pickup_point/RoutePoint.vue';
import AddPoints from '../../components/pages/transport/school_routes/pickup_point/AddPoint.vue';

export default [
    {
        name: "school.transports.TransportRoutes",
        path: "/school/transports/routes",
        component: TransportRoutes,
        props: true,
    },
    {
        name: "school.transports.TransportVehicles",
        path: "/school/transports/vehicles",
        component: Vehicles,
        props: true,
    },
    {
        name: "school.transports.TransportAssignVehicles",
        path: "/school/transports/assign_vehicles",
        component: TransportAssignVehicles,
        props: true,
    },

    {
        name: "school.transports.AddTransportRoutes",
        path: "/school/transports/AddTransportRoutes",
        component: AddTransportRoutes,
        props: true,
    },
    {
        name: "school.transports.TransportReport",
        path: "/school/transports/TransportReport",
        component: TransportReport,
        props: true,
    },
    {
        name: 'school.transports.route_point',
        path: '/school/transports/route_point',
        component: RoutePoints,
        props: true,
    },
    {
        name: 'school.transports.add_point',
        path: '/school/transports/add',
        component: AddPoints,
        props: true,
    }
];
