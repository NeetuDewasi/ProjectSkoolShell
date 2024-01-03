<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Assign" :breadcrumbList="breadcrumbList" />
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Assign Module</h3>
                                </div>
                            </div>
                            <form>
                                <div class="row">
                                    <div
                                        class="col-xl-6 col-lg-6 col-12 mt-5 form-group"
                                    >
                                        <label>
                                            Select School Group
                                            <strong class="text-danger"
                                                >*</strong
                                            >
                                        </label>
                                        <Select2
                                            ref="group_list_select2"
                                            placeholder="--SELECT A GROUP--"
                                            :items="group_list"
                                            @change="selectGroup"
                                        />
                                    </div>
                                    <div
                                        class="col-xl-6 col-lg-6 col-12 mt-5 form-group"
                                    >
                                        <label>
                                            Select School
                                            <strong class="text-danger"
                                                >*</strong
                                            >
                                        </label>
                                        <Select2
                                            ref="school_list_select2"
                                            placeholder="--SELECT A ROLE--"
                                            :items="school_list"
                                            @change="selectSchoolId"
                                        />
                                    </div>
                                    <div class="col-lg-12 mt-4">
                                        <label>Select Module</label>
                                        <div class="row">
                                            <div
                                                class="col-lg-3 col-md-4 col-sm-6 col-12"
                                                v-for="(
                                                    menu, index
                                                ) in menuList"
                                                :key="menu.menu_id"
                                            >
                                                <div>
                                                    <span>
                                                    <input
                                                        :id="`menuChecked${index}`"
                                                        type="checkbox"
                                                        v-model="menuCheckboxes[index]"
                                                        @change.prevent="selectMenu(menu.menu_id, index)"
                                                        :value="menu.menu_id"
                                                    />
                                                    </span>
                                                    <span
                                                        @click="
                                                            selectMenu(
                                                                menu.menu_id,
                                                                index
                                                            )
                                                        "
                                                    >
                                                        {{ menu.menu_name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- {{ checkedValues }} -->
                                    <div class="row ml-3 mt-5">
                                        <div class="col-12 form-group mb-5">
                                            <button
                                                type="button"
                                                class="btn-fill-md text-light shadow-dodger-blue bg-dodger-blue"
                                                @click.prevent="submitData()"
                                            >
                                                {{ formBtn }}
                                            </button>

                                            <button
                                                type="button"
                                                class="btn-fill-md text-light shadow-dodger-blue btn-gradient-yellow"
                                                @click.prevent="resetForm()"
                                            >
                                                {{ resetButton }}
                                            </button>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox" value="student_attendence"
                                            class="form-check-input checkAll" v-model="selectedModule"
                                            id="attendence"
                                        />
                                        <label class="form-check-label">
                                            Student Attendence
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox" value="student_certificate"
                                            class="form-check-input checkAll" v-model="selectedModule"
                                            id="certificate"
                                        />
                                        <label class="form-check-label">
                                            Student Certificate
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox" value="communicate"
                                            class="form-check-input checkAll" v-model="selectedModule"
                                            id="communicate"
                                        />
                                        <label class="form-check-label">
                                            Communicate
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input checkAll"
                                            id="notice_board"
                                        />
                                        <label class="form-check-label">
                                            Notice Board
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input checkAll"
                                            id="download_center"
                                        />
                                        <label class="form-check-label">
                                            Download Center
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input checkAll"
                                            id="examinations"
                                        />
                                        <label class="form-check-label">
                                            Examinations
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input checkAll"
                                            id="expenses"
                                        />
                                        <label class="form-check-label">
                                            Expenses
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input checkAll"
                                            id="fees_collection"
                                        />
                                        <label class="form-check-label">
                                            Fees Collection
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input checkAll"
                                            id="front_office"
                                        />
                                        <label class="form-check-label">
                                            Front Office
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input checkAll"
                                            id="home_work"
                                        />
                                        <label class="form-check-label">
                                            Home Work
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input checkAll"
                                                id="hostel"
                                            />
                                            <label class="form-check-label">
                                                Hostel
                                            </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input checkAll"
                                            id="home_work"
                                        />
                                        <label class="form-check-label">
                                            Human Resource
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input checkAll"
                                                id="income"
                                            />
                                            <label class="form-check-label">
                                                Income
                                            </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input checkAll"
                                                id="inventory"
                                            />
                                            <label class="form-check-label">
                                                Inventory
                                            </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input checkAll"
                                                id="library"
                                            />
                                            <label class="form-check-label">
                                                Library
                                            </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input checkAll"
                                                id="reports"
                                            />
                                            <label class="form-check-label">
                                                Reports
                                            </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input checkAll"
                                                id="transport"
                                            />
                                            <label class="form-check-label">
                                                Transports
                                            </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input checkAll"
                                                id="system_setting"
                                            />
                                            <label class="form-check-label">
                                                System Settings
                                            </label>
                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="item-title">
                                <h3>Menu List</h3>
                            </div>
                            <div
                                class="table table-responsive"
                                v-show="!noData"
                            >
                                <Table
                                    ref="table"
                                    :tableData="tableData"
                                    :tableHead="tableHead"
                                />
                            </div>
                            <NoData v-show="noData" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var toast;
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Assign Module",
                },
            ],
            editedIndex: -1,
            group_list: [],
            group_list_select2: [],
            school_list_select2: [],
            school_list: [],
            items: [
                { label: "Student", value: "student" },
                { label: "Attendence", value: "attendence" },
                { label: "Academics", value: "academics" },
            ],
            checkedValues: [],
            role_id: -1,
            school_id: -1,
            menuList: [],
            menu_list: [],
            menu_id: -1,
            menu_Ids: [],
            editItem: {
                menu_Ids: []
            },
            isLoaded: false,
            noData: false,
            tableData: [],
            tableHead: {
                items: {
                    item1: { label: "Sr.No." },
                    item2: { label: "School" },
                    item3: { label: "Module" },
                },
                actions: true,
            },
             menuCheckboxes: []
        };
    },
    computed: {
        formBtn: function () {
            return this.editedIndex === -1 ? "Save" : "Update";
        },
        resetButton: function () {
            return this.editedIndex === -1 ? "Reset" : "Cancel";
        },
    },
    mounted() {
        this.getGroupList();
        this.getMenus();
        this.showData();
    },
    methods: {
        selectModule(item, index) {
            this.checkedValues = item;
        },
        async getGroupList() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/admin/schools/group_list`,
                null
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.group_list = data.groups;
                    this.$refs.group_list_select2.updateList(data.groups);
                }
            }
        },
        selectGroup(group_id) {
            this.group_id = group_id;
            this.log('Group Id',this.group_id);
            this.getSchools();
        },
        async getSchools() {
            this.isLoaded = false;
            var data = new FormData();
            data.append('group_id',this.group_id);
            const res = await this.callApi("post",`/api/admin/assign/school_list`,data);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.school_list = data.schools;
                    this.$refs.school_list_select2.updateList(data.schools);
                }
            }
        },

        selectSchoolId(school) {
            this.school_id = school;
        },
        async getMenus() {
            this.isLoaded = false;
            const res = await this.callApi("get", `/api/admin/menus`, null);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.menuList = data.menus;
                    console.log('menu list',this.menuList);
                //     this.editItem.menu_Ids = [];
                // } else {
                //     this.menuList = [];
                 }

            }
        },
        edit(item, index) {
            this.log('IITTEEEMMM', item);
            this.editedIndex = item.assign_id;
            this.$refs.school_list_select2.setSelected(item.school_id);
            this.selectSchoolId(item.school_id);
            this.$refs.group_list_select2.setSelected(item.assign_school_group_id);
            this.selectGroup(item.assign_school_group_id);

           this.menu_Ids = item.module_name[0].split(',').map(id => parseInt(id, 10));

            this.menuCheckboxes = new Array(this.menuList.length).fill(false);
            this.menuList.forEach((element, index) => {
                if (this.menu_Ids.includes(element.menu_id)) {
                    this.selectMenu(element.menu_id, index);
                }
            });
            console.log('menu_Ids:', this.menu_Ids);
            console.log('menuCheckboxes:', this.menuCheckboxes);
        },

        selectMenu(menu_Id, index) {
            console.log('loggggggg', this.editItem.menu_Ids);
            if (this.editItem.menu_Ids && this.editItem.menu_Ids.includes(menu_Id)) {
                this.editItem.menu_Ids.splice(this.editItem.menu_Ids.indexOf(menu_Id), 1);
                this.$set(this.menuCheckboxes, index, false);
            } else {
                this.editItem.menu_Ids.push(menu_Id);
                this.$set(this.menuCheckboxes, index, true);
            }
        },
        async submitData() {
            // this.selectModule(item,index);
            // var isVaild = await this.validGroupForm();
            // if (!isVaild) {
            //     return;
            // }
            // toast = Toast.fire({
            //     icon: "warning",
            //     title: "Please Wait!! Creating new Group",
            //     timer: 0,
            // });

            var data = new FormData();
            console.log("group_id", this.group_id);
            data.append("group_id", this.group_id ? this.group_id : "");
            data.append("school_id", this.school_id ? this.school_id : "");
            data.append(
                "selectedModules[]",
                this.editItem.menu_Ids && this.editItem.menu_Ids != null
                    ? this.editItem.menu_Ids
                    : ""
            );
            console.log("edit", data);
            let url = "";
            if (this.editedIndex == -1) {
                url = `/api/admin/assign/save`;
            } else {
                url = `/api/admin/assign/update/${this.editedIndex}`;
            }
            const res = await this.callApi("post", url, data);
            this.log("added dataa", res);
            if (res.status == 200) {
                var data = res.data;

                if (data.status == "success") {
                    this.resetForm();
                    this.showData();
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    setTimeout(()=>{
                        this.$router.push({path: `/admin/dashboard`});
                    },3000);
                }
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            } else {
                toast = Toast.fire({
                    icon: data.status,
                    title: data.message,
                    timer: 2500,
                });
            }
        },
        resetForm(){
            this.group_id = -1;
            this.school_id = -1;
            this.editItem.menu_Ids = [];
            if (!Array.isArray(this.menuCheckboxes)) {
                this.menuCheckboxes = new Array(this.menuList.length).fill(false);
            }
            this.menuCheckboxes = this.menuCheckboxes.map(() => false);
        },
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/admin/assign/get`,
                null
            );
            console.log("mmmmeeeennnnuuuusss", res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.menu_list = data.menuList;
                    // this.log('ddaatttaa', JSON.stringify(this.menu_list[0].module_name));
                    this.initTable();
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                    this.noData = true;
                }
            }
            this.$refs.table.loadTable();
            this.isLoaded = true;
        },
        initTable() {
            this.tableData = [];
            this.menu_list.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.assign_id,
                        item2: element.school.name,
                        item3: "Modules",
                    },
                    action:{
                        edit: true,
                        delete: true,
                    },
                });
            });
        },
        resetForm() {
            this.editItem.menu_Ids = {};
            this.$refs.school_list_select2.setSelected(-1);
            this.$refs.group_list_select2.setSelected(-1);
        },
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/admin/assign/delete/${item.assign_id}`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.menu_list.splice(index, 1);
                    this.tableData.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                } else {
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
            }
        },
    },
    };
</script>
