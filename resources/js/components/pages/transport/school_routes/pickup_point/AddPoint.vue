<template>
    <div>
        <form class="new-added-form">
            <div class="row">
                <div class="col-12 form-group">
                    <label>Route Name
                        <span class="text-danger">*</span></label>
                    <input type="text" name="route_name" :class="errorItem.route_name != ''
                            ? 'error-field'
                            : ''
                        " v-model="editItem.route_name" placeholder="" @keyup="
        errorItem.route_name = ''
        " class="form-control" />
                    <span class="error-label" v-text="errorItem.route_name"></span>
                </div>
                <div class="col-12 form-group">
                    <label>Position
                        <span class="text-danger">*</span></label>
                    <input type="text" name="position" :class="errorItem.position != ''
                            ? 'error-field'
                            : ''
                        " v-model="editItem.position" placeholder="" @keyup="errorItem.position = ''"
                        class="form-control" />
                    <span class="error-label" v-text="errorItem.position"></span>
                </div>
                <div class="col-12 form-group">
                    <button @click.prevent="submitForm()" class="
													btn-lg
													btn
													btn-gradient-yellow
													btn-hover-bluedark
													text-white
												">
                        {{ formBtn }}
                    </button>
                    <button type="reset" class="
													btn-lg btn
													bg-blue-dark
													btn-hover-yellow
													text-white
												">
                        Reset
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "school.dashboard" },
                    name: "Home",
                },
                {
                    name: "Route Pick Points Create",
                },
            ],
            editItem: {},
            errorItem: {
                route_name: "",
                position: "",
            },
            editedIndex: -1,
        };
    },
    mounted() { },
    computed: {
        formBtn: function () {
            return this.editedIndex === -1 ? "Save" : "Update";
        },
    },
    created() { },
    methods: {
        async submitForm(){
            var data = new FormData();
            data.append('route_name',this.editItem.route_name);
            data.append('position', this.editItem.position);
            const res = await this.callApi("post",
            `/api/`)
        },
    },
};
</script>
