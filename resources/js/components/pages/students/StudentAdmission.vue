<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb pageTitle="Student Admission " :breadcrumbList="breadcrumbList" />
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Create New Student</h3>
								</div>
							</div>

							<form class="new-added-form">
								<div class="row">
									<div Father Photodiv class="col-12 mb-3 d-flex">
										<div class="col-3">
											<label for="student_photo" class="student-photo-label">
												Student Photo
												<strong class="text-danger">*</strong>
											</label>
										</div>
										<div class="col-9">

											<div class="imageContainer">
												<img :src="selectedImage" alt />
												<input type="file" accept="image/*" @change="imageFileSelect" :class="
													errorItem.imageFilePath !=
														''
														? 'error-field'
														: ''
												" />
											</div>
                                             <span class="error-label" v-if="errorItem.imageFilePath !=
                                                    ''
                                                    " v-text="errorItem.imageFilePath"></span>
										</div>

									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Admission Number
											<strong class="text-danger">*</strong>
										</label>
										<input type="text" placeholder class="form-control"
											v-model="editItem.admission_number" :class="
												errorItem.admission_number != ''
													? 'error-field'
													: ''
											" @keyup="
	editItem.admission_number != ''
		? (errorItem.admission_number =
			'')
		: ''
" />
										<span class="error-label" v-if="
											errorItem.admission_number != ''
										" v-text="errorItem.admission_number"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Roll Number
											<strong class="text-danger">*</strong>
										</label>
										<input type="text" placeholder class="form-control"
											v-model="editItem.roll_number" />
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Class
											<strong class="text-danger">*</strong>
										</label>
										<Select2 ref="class_list" placeholder="--SELECT A CLASS--" :items="class_list"
											@change="selectClass" :class="
												errorItem.class_list != ''
													? 'error-field'
													: ''
											" />
										<span class="error-label" v-if="errorItem.class_list != ''"
											v-text="errorItem.class_list"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Section
											<strong class="text-danger">*</strong>
										</label>
										<Select2 ref="section_list" :items="section_list" @change="selectSection" :class="
											errorItem.section_list != ''
												? 'error-field'
												: ''
										" />
										<span class="error-label" v-if="errorItem.section_list != ''"
											v-text="errorItem.section_list"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											First Name
											<strong class="text-danger">*</strong>
										</label>
										<input type="text" v-model="editItem.first_name" placeholder class="form-control"
											:class="
												errorItem.first_name != ''
													? 'error-field'
													: ''
											" @keyup="
	editItem.first_name != ''
		? (errorItem.first_name =
			'')
		: ''
" />
										<span class="error-label" v-if="errorItem.first_name != ''"
											v-text="errorItem.first_name"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Middle Name
											<strong class="text-danger"></strong>
										</label>
										<input type="text" v-model="editItem.middle_name" placeholder
											class="form-control" />
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>Last Name</label>

										<input type="text" v-model="editItem.last_name" placeholder class="form-control" />
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Date Of Birth
											<strong class="text-danger">*</strong>
										</label>
										<input type="date" v-model="editItem.date_of_birth" placeholder class="form-control"
											ref="date_of_birth" :class="
												errorItem.date_of_birth != ''
													? 'error-field'
													: ''
											" @click="
	editItem.date_of_birth != ''
		? (errorItem.date_of_birth =
			'')
		: ''
" />
										<span class="error-label" v-if="errorItem.date_of_birth != ''"
											v-text="errorItem.date_of_birth"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Gender
											<strong class="text-danger">*</strong>
										</label>
										<select class="form-control" v-model="editItem.gender" :class="
											errorItem.gender != ''
												? 'error-field'
												: ''
										" @change="
	editItem.gender != ''
		? (errorItem.gender = '')
		: ''
">
											<option value="male">Male</option>
											<option value="female">
												Female
											</option>
											<option value="other">Other</option>
										</select>
										<span class="error-label" v-if="errorItem.gender != ''"
											v-text="errorItem.gender"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Category
											<strong class="text-danger">*</strong>
										</label>
										<Select2 ref="category_list" :items="category_list" @change="selectCategory" :class="
											errorItem.category_list != ''
												? 'error-field'
												: ''
										" />
										<span class="error-label" v-if="errorItem.category_list != ''"
											v-text="errorItem.category_list"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Religion
											<strong class="text-danger">*</strong>
										</label>
										<input type="text" v-model="editItem.religion" placeholder class="form-control"
											:class="
												errorItem.religion != ''
													? 'error-field'
													: ''
											" @keyup="
	editItem.religion != ''
		? (errorItem.religion = '')
		: ''
" />
										<span class="error-label" v-if="errorItem.religion != ''"
											v-text="errorItem.religion"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Caste
											<strong class="text-danger">*</strong>
										</label>
										<input type="text" v-model="editItem.caste" placeholder class="form-control" :class="
											errorItem.caste != ''
												? 'error-field'
												: ''
										" @keyup="
	editItem.caste != ''
		? (errorItem.caste = '')
		: ''
" />
										<span class="error-label" v-if="errorItem.caste != ''"
											v-text="errorItem.caste"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Mobile Number
											<strong class="text-danger">*</strong>
										</label>
										<input type="text" v-model="editItem.mobile" placeholder class="form-control"
											@keydown="enterValue" :class="
												errorItem.mobile || errorMobile
													? 'error-field'
													: ''
											" @keyup="
	editItem.mobile != ''
		? (errorItem.mobile = '')
		: ''
" />
										<span class="error-label" v-if="errorItem.mobile" v-text="errorItem.mobile"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Email
											<strong class="text-danger">*</strong>
										</label>
										<input type="text" v-model="editItem.email" placeholder class="form-control" :class="
											errorItem.email != ''
												? 'error-field'
												: ''
										" @keyup="
	editItem.email != ''
		? (errorItem.email = '')
		: ''
" />
										<span class="error-label" v-if="errorItem.email != ''"
											v-text="errorItem.email"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Admission Date
											<strong class="text-danger">*</strong>
										</label>
										<input type="date" v-model="editItem.admission_date" placeholder
											class="form-control" ref="admission_date" :class="
												errorItem.admission_date !== ''
													? 'error-field'
													: ''
											" @click="
	editItem.admission_date != ''
		? (errorItem.admission_date =
			'')
		: ''
" />
										<span class="error-label" v-if="
											errorItem.admission_date != ''
										" v-text="errorItem.admission_date"></span>
									</div>

									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Blood Group
											<strong class="text-danger">*</strong>
										</label>
										<select class="form-control" v-model="editItem.blood_group" :class="
											errorItem.blood_group !== ''
												? 'error-field'
												: ''
										" @change="
	editItem.blood_group != ''
		? (errorItem.blood_group =
			'')
		: ''
">
											<option value="A+">A+</option>
											<option value="B+">B+</option>
											<option value="A-">A-</option>
											<option value="B-">B-</option>
											<option value="AB+">AB+</option>
											<option value="AB-">AB-</option>
											<option value="O+">O+</option>
											<option value="O-">O-</option>
											<option value="K-">K-</option>
											<option value="K+">K+</option>
										</select>
										<span class="error-label" v-if="errorItem.blood_group != ''"
											v-text="errorItem.blood_group"></span>
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Height
										</label>
										<input type="text" v-model="editItem.height" placeholder class="form-control" />

									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>
											Weight
										</label>
										<input type="text" v-model="editItem.weight" placeholder class="form-control" />

									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
											">
										<label>Select House</label>

										<Select2 ref="house_list" :items="house_list" @change="selectHouse" />
									</div>
									<div class="
												col-xl-4 col-lg-6 col-12
												form-group
												mt-5
											">
										<div class="
													btn-fill-lg
													text-light
													shadow-dodger-blue
													bg-dodger-blue
												" @click="isShowClassSection">
											+ Add Sibling
										</div>
									</div>
								</div>
								<CreateSibling v-for="(i,index) in addSiblingArray" :key="index" :index="index"
									ref="siblingForm" />
								<div class="d-flex justify-content-end">
									<button type="button" class="
												btn-fill-lg
												text-light
												shadow-dodger-blue
												bg-dodger-blue
											" @click.prevent="submitData()">
										{{ formBtn }}
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
import CreateSibling from "./CreateSibling.vue";
export default {
	components: { CreateSibling },
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
					name: "Admission",
				},
				{
					name: "Basic Details",
				},
			],
			addSiblings: 0,
			addSiblingArray: [],
			isShowing: false,
			sibling_index: 1,
			class_list: [],
			isLoaded: false,
			noData: false,
			mobileError: false,
			editItem: {},
			category_list: [],
			house_list: [],
			section_list: [],
			editedIndex: -1,
			errorItem: {
				admission_number: "",
				admission_date: "",
				first_name: "",
				date_of_birth: "",
				category_list: "",
				section_list: "",
				class_list: "",
				gender: "",
				religion: "",
				caste: "",
				email: "",
				blood_group: "",
				weight: "",
				height: "",
                imageFilePath: null,
                srcImageFile: null,
			},
			imageFilePath: null,
			srcImageFile: null,
			errorMobile: false,
			sibling_classIds: [],
			sibling_sectionIds: [],
			sibling_admissionIds: [],
            emailRegex: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/,
		};
	},

	mounted() {
		this.$parent.loadOtherScript();
		this.getClass();
		this.getCategory();
		this.getHouse();
		if (this.$route.params.edit_id) {
			this.editedIndex = this.$route.params.edit_id;
			this.getEditItemData(this.$route.params.edit_id);
		}
	},
	computed: {
		selectedImage: function () {
			return this.srcImageFile != null
				? this.srcImageFile
				: "/assets/img/nb.jpg";
		},
		formBtn: function () {
			return this.editedIndex !== -1 ? "Update" : "Save";
		},
	},
	methods: {
		closeSiblingForm(index) {
			this.addSiblingArray.splice(index, 1);
			this.sibling_classIds.splice(index, 1);
			this.sibling_sectionIds.splice(index, 1);
			this.sibling_admissionIds.splice(index,
             1);
		},
		async getEditItemData(id) {
			const res = await this.callApi(
				"get",
				`/api/school/students/student_admissions/edit/${id}`,
				null
			);
			console.log('Edit Item Values',res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {

					this.editItem = {
						roll_number: data.student_admission.roll_number,
						admission_number: data.student_admission.admission_number,
						admission_date:
							data.student_admission.admission_date,
						first_name: data.student_admission.first_name,
						last_name: data.student_admission.last_name,
						middle_name: data.student_admission.middle_name,
						date_of_birth:
							data.student_admission.date_of_birth,
						gender: data.student_admission.gender,
						mobile: data.student_admission.mobile,
						religion: data.student_admission.religion,
						caste: data.student_admission.cast,
						email: data.student_admission.email,
						blood_group: data.student_admission.blood_group,
						weight: data.student_admission.weight,
						height: data.student_admission.height,
					};

					this.srcImageFile =
						data.student_admission.student_photo;
					this.imageFilePath =
						data.student_admission.student_photo;
					this.$refs.class_list.setSelected(
						data.student_admission.school_class.class_id
					);
					this.classId = data.student_admission.school_class.class_id;
					this.selectClass(
						data.student_admission.school_class.class_id
					);
					this.$refs.section_list.setSelected(
						data.student_admission.school_section.section_id
					);
					this.sectionId =
						data.student_admission.school_section.section_id;
					this.$refs.category_list.setSelected(
						data.student_admission.student_category.category_id
					);
					this.categoryId =
						data.student_admission.student_category.category_id;

						this.$refs.house_list.setSelected(
						data.student_admission.student_house.value

					);
					this.houseId = data.student_admission.student_house.value
;
					this.selectHouse(
						data.student_admission.student_house.value

					);

					await data.student_admission.student_sibling.forEach(
						(element, index) => {
							this.addSiblingArray.push(index);
						}
					);
					this.$refs.siblingForm.forEach((element, index) => {
						element.$refs.class_list.setSelected(
							data.student_admission.student_sibling[index]
								.sibling.school_class.class_id
						);
						this.sibling_classIds.push(
							data.student_admission.student_sibling[index]
								.sibling.school_class.class_id
						);
						element.selectClass(
							data.student_admission.student_sibling[index]
								.sibling.school_class.class_id
						);
						element.$refs.section_list.setSelected(
							data.student_admission.student_sibling[index]
								.sibling.school_section.section_id
						);
						this.sibling_sectionIds.push(
							data.student_admission.student_sibling[index]
								.sibling.school_section.section_id
						);
						element.selectSection(
							data.student_admission.student_sibling[index]
								.sibling.school_section.section_id
						);
						element.$refs.student_list.setSelected(
							data.student_admission.student_sibling[index]
								.sibling.student_admission_id
						);

						this.sibling_admissionIds.push(
							data.student_admission.student_sibling[index]
								.sibling.student_admission_id
						);
					});
				}
			}
		},
		getSiblingData(admissionId, classId, sectionId, index) {
			this.sibling_classIds[index] = classId;
			this.sibling_sectionIds[index] = sectionId;
			this.sibling_admissionIds[index] = admissionId;
			console.error('idss', this.sibling_admissionIds)
			console.log('Sibling Ids', this.sibling_classIds[index], this.sibling_sectionIds[index], this.sibling_admissionIds[index]);
		},

		async getClass() {
			const res = await this.callApi(
				"get",
				`/api/school/general/get_class_list`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.class_list = data.class_list;
					this.$refs.class_list.updateList(data.class_list);
				}
			}
		},

		async selectClass(val) {
			this.classId = val;
			const res = await this.callApi(
				"get",
				`/api/school/class/sections/${this.classId}`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.sections = data.school_class_sections; // class - Section
					this.$refs.section_list.updateList(data.school_class_sections);
				}
			}
		},
		selectSection(sectionId) {
			this.sectionId = sectionId;
		},
		selectCategory(categoryId) {
			this.categoryId = categoryId;
		},
		imageFileSelect(e) {
			const file = e.target.files[0];
			if (file) {
				this.srcImageFile = URL.createObjectURL(file);
				URL.revokeObjectURL(file);
				this.imageFilePath = file;
                this.errorItem.imageFilePath = "";
			} else {
				this.srcImageFile = null;
				this.imageFilePath = null;
			}
		},

		isShowClassSection() {
			this.isShowing = true;
			this.addSiblingArray.push("-1");
			this.sibling_classIds.push("-1");
			this.sibling_sectionIds.push("-1");
			this.sibling_admissionIds.push("-1");
		},
		async getCategory() {
			const res = await this.callApi(
				"get",
				`/api/school/students/student_categories/category_list`,
				null
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.category_list = data.category_list;
					this.$refs.category_list.updateList(data.category_list);
				}
			}
		},
		async getHouse() {
			const res = await this.callApi(
				"get",
				`/api/school/students/student_admissions/house_list`,
				null
			);
			this.log('HOUSES', res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.house_list = data.house_list;
					this.$refs.house_list.updateList(data.house_list);
				}
			}
		},
		selectHouse(houseId) {
			this.houseId = houseId;
			this.log('housseee',this.houseId);
		},
		async submitData() {
			var isVaild = await this.validAdmissionForm();
			if (!isVaild) {
				return;
			}
			toast = Toast.fire({
				icon: "warning",
				title: "Please Wait!! Creating new Admission",
				timer: 0,
			});
			var data = new FormData();
			data.append(
				"admission_number",
				this.editItem.admission_number != null &&
					this.editItem.admission_number != ""
					? this.editItem.admission_number
					: ""
			);
			data.append(
				"roll_number",
				this.editItem.roll_number != null &&
					this.editItem.roll_number != ""
					? this.editItem.roll_number
					: ""
			);
			data.append(
				"admission_date",
				this.editItem.admission_date != null &&
					this.editItem.admission_date != ""
					? this.editItem.admission_date
					: ""
			);
			data.append("class", this.classId);
			data.append("section", this.sectionId);
			data.append(
				"first_name",
				this.editItem.first_name != null &&
					this.editItem.first_name != ""
					? this.editItem.first_name
					: ""
			);
			data.append(
				"middle_name",
				this.editItem.middle_name != null &&
					this.editItem.middle_name != ""
					? this.editItem.middle_name
					: ""
			);
			data.append(
				"last_name",
				this.editItem.last_name != null && this.editItem.last_name != ""
					? this.editItem.last_name
					: ""
			);
			data.append(
				"date_of_birth",
				this.editItem.date_of_birth != null &&
					this.editItem.date_of_birth != ""
					? this.editItem.date_of_birth
					: ""
			);
			data.append(
				"gender",
				this.editItem.gender != null && this.editItem.gender != ""
					? this.editItem.gender
					: ""
			);
			data.append("category", this.categoryId);
			data.append("house", this.houseId);
			this.log('houseIIDD',this.houseId);
			data.append(
				"religion",
				this.editItem.religion != null && this.editItem.religion != ""
					? this.editItem.religion
					: ""
			);
			data.append(
				"caste",
				this.editItem.caste != null && this.editItem.caste != ""
					? this.editItem.caste
					: ""
			);
			data.append(
				"mobile",
				this.editItem.mobile != null && this.editItem.mobile != ""
					? this.editItem.mobile
					: ""
			);
			data.append(
				"email",
				this.editItem.email != null && this.editItem.email != ""
					? this.editItem.email
					: ""
			);
			data.append("image", this.imageFilePath ? this.imageFilePath : "");
			data.append(
				"blood_group",
				this.editItem.blood_group != null &&
					this.editItem.blood_group != ""
					? this.editItem.blood_group
					: ""
			);
			data.append(
				"height",
				this.editItem.height != null && this.editItem.height != ""
					? this.editItem.height
					: ""
			);
			data.append(
				"weight",
				this.editItem.weight != null && this.editItem.weight != ""
					? this.editItem.weight
					: ""
			);
			this.sibling_admissionIds.forEach((e, ind) => {
				data.append("admission_ids[]", e);
			});

			let url = "";
			if (this.editedIndex != -1) {
				const res = await this.callApi("post",`/api/school/students/student_details/update/${this.editedIndex}`,data,'multipart');
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						// this.resetForm();
						toast = Toast.fire({
							icon: data.status,
							title: data.message,
							timer: 2500,
						});
						setTimeout(() => {
							this.$router.push({
								path: `/school/students/${this.editedIndex}/guardian_detail`,
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
			} else{
				const res = await this.callApi("post", `/api/school/students/student_admissions/save`, data, "multipart");
				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						// this.resetForm();
						toast = Toast.fire({
							icon: data.status,
							title: data.message,
							timer: 2500,
						});
						setTimeout(() => {
							this.$router.push({
								path: `/school/students/${data.student_admission_id}/guardian_detail`,
							});
						}, 3000);
					} else {
						toast = Toast.fire({
							icon: data.status,
							title: data.message,
							timer: 2500,
						});
					}
				}
			}


		},
		enterValue(e) {
			if (
				e.which != 8 &&
				e.which != 9 &&
				e.which != 13 &&
				e.which != 46 &&
				(e.which < 37 || e.which > 40)
			) {
				if (e.target.value.length >= 10) {
					e.preventDefault();
					return;
				}
			}

			if (!this.isNumberOnly(e)) {
				e.preventDefault();
				return;
			}
		},
		isNumberOnly(e) {
			if (
				e.which != 8 &&
				e.which != 9 &&
				e.which != 13 &&
				e.which != 46 &&
				(e.which < 37 || e.which > 40) &&
				(e.which < 48 || e.which > 57) &&
				(e.which < 96 || e.which > 105)
			)
				return false;
			return true;
		},
		validAdmissionForm() {
			this.isFormValid = true;
			if (
				this.editItem.admission_number == null ||
				this.editItem.admission_number == ""
			) {
				this.errorItem.admission_number =
					"Admission Number  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.admission_number = "";
			}
			if (
				this.editItem.admission_date == null ||
				this.editItem.admission_date == ""
			) {
				this.errorItem.admission_date = "Admission Date  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.admission_date = "";
			}
			if (
				this.editItem.first_name == null ||
				this.editItem.first_name == ""
			) {
				this.errorItem.first_name = "First Name  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.first_name = "";
			}
			if (
				this.editItem.date_of_birth == null ||
				this.editItem.date_of_birth == ""
			) {
				this.errorItem.date_of_birth = "Date of birth is required";
				this.isFormValid = false;
			} else {
				this.errorItem.date_of_birth = "";
			}
			if (this.classId == -1) {
				this.errorItem.class_list = "Class  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.class_list = "";
			}
			if (this.sectionId == -1) {
				this.errorItem.section_list = " Section  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.section_list = "";
			}
			if (this.categoryId == -1) {
				this.errorItem.category_list = "Category  is required";
				this.isFormValid = false;
			} else {
				this.errorItem.category_list = "";
			}
			if (this.editItem.gender == null || this.editItem.gender == "") {
				this.errorItem.gender = "Gender is required";
				this.isFormValid = false;
			} else {
				this.errorItem.gender = "";
			}
			if (
				this.editItem.religion == null ||
				this.editItem.religion == ""
			) {
				this.errorItem.religion = "Religion is required";
				this.isFormValid = false;
			} else {
				this.errorItem.religion = "";
			}

			if (this.editItem.caste == null || this.editItem.caste == "") {
				this.errorItem.caste = "Caste is required";
				this.isFormValid = false;
			} else {
				this.errorItem.caste = "";
			}
			if (
                this.editItem.email == null ||
                this.editItem.email == ""
            ) {
                this.errorItem.email = "Email is required";
                isFormValid = false;
            } else {
                if (!this.emailRegex.test(this.editItem.email)) {
                    this.errorItem.email = "Enter valid email";
                    isFormValid = false;
                } else {
                    this.errorItem.email = "";
                }
            }
			if (
				this.editItem.blood_group == null ||
				this.editItem.blood_group == ""
			) {
				this.errorItem.blood_group = "Blood Group is required";
				this.isFormValid = false;
			} else {
				this.errorItem.blood_group = "";
			}

			if (!/^\d+$/.test(this.editItem.mobile)) {
                this.errorItem.mobile = "Please Enter Numbers only.";
                this.isFormValid = false;
            } else if (!this.editItem.mobile) {
                this.errorItem.mobile = "Mobile Number is required";
                this.isFormValid = false;
            } else {
                this.errorItem.mobile = "";
            }
			if (!this.imageFilePath || this.imageFilePath == null || this.imageFilePath == "") {
				this.errorItem.imageFilePath = "Image field is required";
				this.isFormValid = false;
			} else {
				this.errorItem.imageFilePath = " ";
			}
			return this.isFormValid;
		},
	},
};
</script>

<style scoped>
.imageContainer {
	width: 45%;
	height: 150px;
	border: grey dashed 2px;
	border-radius: 10px;
	position: relative;
	background: #ffffff;
	text-align: center;
	padding: 10px;
	margin: auto;
	margin-bottom: 40px;
	cursor: pointer;
}

.imageContainer img {
	/* width: 100%; */
	height: 100%;
}

.imageContainer input {
	width: 100%;
	height: 100%;
	opacity: 0;
	position: absolute;
	top: 0;
	left: 0;
}

.student-photo-label {
	margin-top: 6rem !important;
	margin-left: 30px;
}
</style>
