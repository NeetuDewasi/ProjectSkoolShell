<template>
    <tr>
        <td>
            <div class="form-check">
                <input type="checkbox" class="form-check-input">
                <label class="form-check-label">{{index+1}}</label>
            </div>
        </td>
        <td>{{ leaveTypes.leave_type_name }}</td>
        <td>{{ leaveTypes.leave_type_status }}</td>
        <td>
           <div class="form-group">
                <button type="submit" class="btn btn-success btn-hover-bluedark mx-2" @click="edit(leaveTypes)">
                    <i class="fas fa-pen text-white"></i>
                </button>
                <button type="submit" class="btn btn-danger btn-hover-bluedark" @click="deleteItem()">
                    <i class="fas fa-trash text-white"></i>
                </button>
            </div>
        </td>
    </tr>
</template>

<script>
	export default {
		props: ["leaveTypes", 'index'],
        data() {
			return {};
		},
        methods:{
            edit(){
                this.$parent.editData(this.leaveTypes, this.index);
            },
            deleteItem() {
                SwalCustomBtn.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$parent.deleteData(this.leaveTypes, 'deleted');
                    }
			    });
		    },
        },
	};
</script>
