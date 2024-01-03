<template>
	<div>
		<div class="dashboard-content-one">
			<Breadcrumb
				pageTitle="Employee Create"
				:breadcrumbList="breadcrumbList"
			/>
			<div class="col-12 mb-3">
				<div
					class="btn btn-outline-secondary"
					@click="
						$router.push({
							name: 'school.hr.employees.address.create',
							params: { id: $route.params.id },
						})
					"
				>
					<i class="fas fa-arrow-left" aria-hidden="true"></i> Back
				</div>
			</div>
			<div class="row gutters-20">
				<div class="col-12">
					<div class="card height-auto">
						<div class="card-body">
							<div class="heading-layout1">
								<div class="item-title">
									<h3>Upload Documents</h3>
								</div>
							</div>
							<!-- <form class="new-added-form" enctype="multipart/form-data"> -->
							<div class="row">
								<div class="col-md-6 form-group">
									<select
										class="form-control"
										v-model="editItem.document_type"
									>
										<option value="">
											--SELECT A DOCUMENT TYPE--
										</option>
										<option value="AADHAR CARD">
											AADHAR CARD
										</option>
										<option value="VOTER ID">
											VOTER ID
										</option>
										<option value="PAN CARD">
											PAN CARD
										</option>
										<option value="RESUME">RESUME</option>
										<option value="JOINING LETTER">
											JOINING LETTER
										</option>
										<option value="OTHER DOCUMENTS">
											OTHER DOCUMENTS
										</option>
									</select>
								</div>
								<div class="col-md-5 col-6 form-group">
									
									<input type="file" id="img" name="document_files[]" multiple @change="selectDocumentFile" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx" style="opacity:1;">
								</div>
								<div class="col-md-1 col-6 form-group">
									<button
										class="btn btn-success btn-lg"
										@click.prevent="submitForm()"
									>
										UPLOAD
									</button>
								</div>
							</div>
							<!-- </form> -->
							<div>
								<div>
									<div v-show="!noData">
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
					name: "Employees",
				},
				{
					name: "Documents Upload",
				},
			],
			employeeDocuments: [],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Documents" },
					item3: { label: "" },
				},
				actions: true,
			},
			editItem: {
				document_file: [],
			},
			editedIndex: -1,
			tableData: [],
			isLoaded: false,
			noData: false,
		};
	},
	mounted() {
		this.$parent.loadOtherScript();
		this.editedIndex = this.$route.params.id;
		this.showData();
	},
	methods: {
		selectDocumentFile(e) {
			const files = e.target.files;
			for (let i = 0; i < files.length; i++) {
				if (files[i]) this.editItem.document_file.push(files[i]);
				else this.editItem.document_file.push(null);
			}
		},
		async showData() {
			toast = Toast.fire({
				icon: "warning",
				title: "Loading Data..",
				timer: 0,
			});
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/hr/employees/edit/${this.editedIndex}/documents`,
				null
			);
            this.log('DAATAA',res);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.employeeDocuments = data.employee_documents;
					this.initTable();
				} else {
					toast = Toast.fire({
						icon: "error",
						title: "Something went wrong",
						timer: 0,
					});
					this.noData = true;
				}
			}
			this.$refs.table.loadTable();
			this.isLoaded = true;
			toast.close();
		},
		initTable() {
			this.tableData = [];
			this.employeeDocuments.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1: element.document_id,
						item2: element.document_type,
						item3: "VIEW FILES",
					},
					action: {
						edit: true,
						delete: true,
					},
				});
			});
		},
        edit(item, index) {
            this.$router.push({
                path: `/school/hr/employees/basic_info/create/${item.document_id}`
            });
        },
		async submitForm() {
			var data = new FormData();
			data.append("document_type", this.editItem.document_type);
			this.editItem.document_file.forEach((file) => {
				data.append("document_files[]", file);
			});

			const res = await this.callApi(
				"post",
				`/api/school/hr/employees/documents/update/${this.editedIndex}`,
				data,
				"multipart"
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.editItem = {};
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
			} else {
				toast = Toast.fire({
					icon: warning,
					title: "Something Went Wrong....",
					timer: 2500,
				});
			}
		},
	},
};
</script>

<style scoped>
.add-more {
	background: #f0f1f3;
	width: 100%;
}
.image-select {
	border-radius: 10px;
	box-shadow: 0 0 2px #aeaeae;
	position: relative;
	text-align: center;
}
.image-select .img {
	height: 160px;
	width: 100%;
	text-align: center;
}
.image-select .img img {
	height: 100%;
	text-align: center;
}
.image-select input {
	opacity: 0;
	width: 100%;
	height: 100%;
	position: absolute;
	top: 0;
	left: 0;
}

</style>
