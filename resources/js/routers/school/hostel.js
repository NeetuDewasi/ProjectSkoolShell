import Hostel from "../../components/pages/hostel/school_hostel/Hostel.vue";
import AddHostelForm from "../../components/pages/hostel/school_hostel/AddHostelForm.vue";
import HostelRoom from "../../components/pages/hostel/school_hostel_room/HostelRoom.vue";
import AddHostelRoom from "../../components/pages/hostel/school_hostel_room/AddHostelRoom.vue";
import RoomType from "../../components/pages/hostel/school_hostel_room_type/RoomType.vue";
import AddRoomType from "../../components/pages/hostel/school_hostel_room_type/AddRoomType.vue";


export default [{
        name: "school.hostel",
        path: "/school/hostel",
        component: Hostel,
        props: true,
    },
    {
        name: "school.hostel.add_hostel",
        path: "/school/add_hostel",
        component: AddHostelForm,
        props: true,
    },
    {
        name: "school.hostel.edit_hostel",
        path: "/school/edit_hostel/:edit_id",
        component: AddHostelForm,
        props: true,
    },
    {
        name: "school.hostel.room",
        path: "/school/hostel/room",
        component: HostelRoom,
        props: true,
    },
    {
        name: "school.hostel.add_room",
        path: "/school/hostel/add_room",
        component: AddHostelRoom,
        props: true,
    },
    {
        name: "school.hostel.edit_room",
        path: "/school/hostel/edit_room/:edit_id",
        component: AddHostelRoom,
        props: true,
    },
    {
        name: "school.hostel.room_type",
        path: "/school/hostel/room_type",
        component: RoomType,
        props: true,
    },
    {
        name: "school.hostel.add_room_type",
        path: "/school/hostel/add_room_type",
        component: AddRoomType,
        props: true,
    },
    {
        name: "school.hostel.edit_room_type",
        path: "/school/hostel/edit_room_type/:edit_id",
        component: AddRoomType,
        props: true,
    },

];
