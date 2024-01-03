<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Student Hostel"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Add Hostel</h3>
								</div>
							</div>

							<form class="new-added-form">
                                <div
                                    class="col-xl-4 col-lg-6 col-12 form-group mt-3"
                                >
                                    <label class>If Hostel Available</label>
                                    <div class="row ms-5">
                                        <input
                                            class="form-radio-input mr-3 mt-2"
                                            v-model="isHostel"
                                            type="radio"
                                            value="yes"
                                            name="hostel"

                                        />
                                        <span class="mr-5">Yes</span>
                                        <input
                                            class="form-radio-input mr-2 mt-2"
                                            v-model="isHostel"
                                            type="radio"
                                            value="no"
                                            name="hostel"

                                        />
                                        <span class="ml-3">No</span>
                                    </div>
                                </div>
								<div class="row" v-show="isHostel=='yes'">
									<div class="col-xl-3 form-group">

										<label>Hostel List</label>
										<Select2 v-show="isHostel=='yes'"
											ref="hostel_list"
											:items="hostel_list"
											@change="getHostelRoomType"
											:class="
												errorItem.hostel_list != ''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="errorItem.hostel_list != ''"
											v-text="errorItem.hostel_list"
										></span>
									</div>

									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Room type</label>

										<Select2
											ref="hostel_room_type_list_selete2"
											:items="hostel_room_type_list"
											@change="selectRoomType"
											:class="
												errorItem.hostel_room_type_list !=
												''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="
												errorItem.hostel_room_type_list !=
												''
											"
											v-text="
												errorItem.hostel_room_type_list
											"
										></span>
									</div>

									<div
										class="
											col-xl-3 col-lg-6 col-12
											form-group
										"
									>
										<label>Bed Number *</label>
										<input
											type="text"
											placeholder
											class="form-control"
											v-model="editItem.bed_number"
											@keypress="
												errorItem.bed_number = ''
											"
											:class="
												errorItem.bed_number != ''
													? 'error-field'
													: ''
											"
										/>
										<span
											class="error-label"
											v-if="errorItem.bed_number != ''"
											v-text="errorItem.bed_number"
										></span>
									</div>
								</div>
								<div class="d-flex justify-content-end mt-5">
									<button
										type="submit"
										class="
											btn
											btn-lg
											btn-gradient-yellow
											btn-hover-bluedark
											mx-3
											text-white
										"
										@click="$router.push('transports')"
									>
										Back
									</button>
									<button
										type="submit"
										class="
											btn
											btn-lg
											btn-gradient-yellow
											btn-hover-bluedark
											mx-3
											text-white
										"
                                        :class="formBtnClass"
										@click.prevent="submitData()"
									>
										{{formBtn}}
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<Footer />
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
					name: "Student",
				},
				{
					to: { name: "admin.students.admissions" },
					name: "Admission",
				},
				{
					name: "Student Hostel",
				},
			],
			isLoaded: false,
			noData: false,
			editItem: {},
			admission: "",
			hostel_list: [],
			hostel_room_type_list: [],
			hostelId: -1,
			selectedRoomTypeId: -1,
			errorItem: {
				bed_number: "",
				hostel_list: "",
				hostel_room_type_list: "",
			},
			isFormValid: false,
			editedIndex: -1,
			admission_id: -1,
            isHostel:"yes",

		};
	},
    computed: {
        formBtn: function () {
            return this.editedIndex != -1 ? "Update & Next" : "Save & Next";
        },
        formBtnClass: function () {
            return this.editedIndex != -1 ? "btn-warning" : "btn-success";
        },
    },
	mounted() {
		this.$parent.loadOtherScript();
		if (this.$route.params.student_admission_id) {
			this.admission_id = this.$route.params.student_admission_id;
            this.getEditItemData();
		}
		this.getHostel();
	},
	methods: {
		selectRoomType(val) {
			this.selectedRoomTypeId = val;
			this.errorItem.hostel_room_type_list = "";
		},

		validHostelForm() {
			this.isFormValid = true;
			if (
				this.editItem.bed_number == null ||
				this.editItem.bed_number == ""
			) {
				this.errorItem.bed_number = "Bed Number is required";
				this.isFormValid = false;
			} else {
				this.errorItem.bed_number = "";
			}
			if (this.selectedRoomTypeId == -1) {
				this.errorItem.hostel_room_type_list = "Room Type  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.hostel_room_type_list = "";
			}
			if (this.hostelId == -1) {
				this.errorItem.hostel_list = "Hostel Name  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.hostel_list = "";
			}
			return this.isFormValid;
		},
		async getHostel() {
			const res = await this.callApi(
				"get",
				`/api/school/students/student_hostels/hostel_list`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.hostel_list = data.hostel_list;
					this.$refs.hostel_list.updateList(data.hostel_list);
				}
			}
		},
		async getHostelRoomType(val) {
			// sir se puchna h eske bare me

			this.hostelId = val;
			const res = await this.callApi(
				"get",
				`/api/school/students/student_hostels/hostel_list/${this.hostelId}`,
				null
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.hostel_room_type_list = data.hostel_room_type_list;
					this.$refs.hostel_room_type_list_selete2.updateList(
						data.hostel_room_type_list
					);
				}
			}
		},
         async getEditItemData() {
            var data = new FormData();
            data.append("admission", this.admission_id);
            const res = await this.callApi(
                "post",
                `/api/school/students/student_hostels/edit`,
                data
            );
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.editItem = data.edit_hostel;
                    this.isHostel = data.edit_hostel.student_is_hostel;
                        this.editedIndex = data.edit_hostel.admission_hostel_id;
                    if(this.isHostel == 'yes'){
                        this.$refs.route_list.setSelected(
                            data.edit_hostel.school_route_id
                        );
                        this.selectedRouteId = data.edit_hostel;

                    }
                } else {
                    this.editedIndex = -1;
                }
            }
        },
		async submitData() {
            if (this.isHostel == "yes") {
			    var isVaild = await this.validHostelForm();
                if (!isVaild) {
                    return;
                }
            }
			var data = new FormData();
			data.append("admission_id", this.admission_id);
			data.append("hostel_id", this.isHostel == "yes" ? this.hostelId ? this.hostelId:'':'');
			data.append("room_type_id", this.selectedRoomTypeId != -1 ? this.selectedRoomTypeId:'');
            data.append("isHostel",this.isHostel);
			data.append("bed_number",this.isHostel == "yes" ? this.editItem.bed_number ? this.editItem.bed_number:'' :"");
			let url = "";
            if(this.editedIndex == -1 ){
                url = `/api/school/students/student_hostels/save`;
            }else{
                url = `/api/school/students/student_hostels/update/${this.editedIndex}`
            }
            const res = await this.callApi(
                "post",
                url,
                data
            );
            this.log('res' , res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
					setTimeout(() => {
						this.$router.push({
							path: `/school/students/${this.admission_id}/student_other_details`,
						});
					}, 3000);
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
				}
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 2500,
				});
			}
		},
	},
};
</script>
