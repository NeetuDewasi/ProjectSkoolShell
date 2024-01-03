<template>
	<div>
		<div class="dashboard-content-one">
			  <div class="d-flex justify-content-between">
				<Breadcrumb
					pageTitle="Email/SMS Log"
					:breadcrumbList="breadcrumbList"
				/>
				<span>
					<button
					 type="button"
					 class="text-white btn btn-sm btn-secondary mt-5"
					 @click="$router.push({
							 name: 'school.communicate.send_email'
						 })"
				   >+ Send New Email</button>
				</span>
			</div>
		</div>

		<div class="row gutters-20">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="heading-layout1">
							<div class="item-title">
								<h3>
									<span class="fas fa-envelope-square"></span>
									Email/SMS Log Table
								</h3>
							</div>
						</div>
						<div class="table" v-show="!noData">
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
					name: "Email/SMS/Log",
				},
			],
			tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Title" },
					item3: { label: "Email" },
					item4: { label: "SMS" },
					item5: { label: "Message For" },
				},
				actions: true,
			},
			tableData: [],
			isLoaded: false,
			noData: false,
			message_id: -1,
			editedIndex: -1,
		};
	},
	mounted() {
		this.$parent.loadOtherScript();
		toast = Toast.fire({
			icon: "warning",
			title: "Loading Data..",
			timer: 2000,
		});
		this.showData();
	},
	methods: {
		async showData() {
			this.isLoaded = false;
			const res = await this.callApi(
				"get",
				`/api/school/communicate/send_email`,
				null
			);
            this.log("table data",res);
			if (res.status == 200) {
				var data = res.data;
                this.log(data);
				if (data.status == "success") {
					this.email_sms_list = data.email_sms;
					this.initTable();
				}
			}
			this.$refs.table.loadTable();
			this.isLoaded = true;
			toast.close();
		},
		initTable() {
			this.tableData = [];
			this.email_sms_list.forEach((element) => {
				this.tableData.push({
					item: element,
					data: {
						item1:
							element.message_id != null
								? element.message_id
								: "",
						item2:
							element.message_title != null
								? `<span data-html="true" title="${element.message_content != null ? element.message_content : ''}">
                                    ${element.message_title}</span>`
								: "",
						item3:
							element.message_email == 1
								? '<i class="fas fa-check text-success"></i>'
								: '<i class="fas fa-times text-danger"></i>',
						item4:
							element.message_sms == 1
								? '<i class="fas fa-check text-success"></i>'
								: '<i class="fas fa-times text-danger"></i>',
						item5: element.message_message_for,
						// item6: {
						// 	type: "action",
						// 	options: {

						// 		style: "border:none",
						// 		// class: "btn btn-info",
						// 		icon: '<i class="fa fa-eye" aria-hidden="true"></i>',
                        //         method :this.commonFunction
						// 	},
						// },
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
				path: `/school/communicate/email/${item.message_id}`,
			});
		},
		// commonFunction(item, index) {
		// 	this.$router.push(
		// 		`/school/communicate/email_view/${item.message_id}`
		// 	);
		// },
		async deleteData(item, index) {
			var data = new FormData();
			data.append("status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/communicate/send_email/delete/${item.message_id}`,
				data
			);
			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.email_sms_list.splice(index, 1);
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

<style scoped>
button.new-message {
    font-size: 14px !important;
    padding: 5px 10px !important;
    display: inline-block;
    align-self: center;
}
</style>

