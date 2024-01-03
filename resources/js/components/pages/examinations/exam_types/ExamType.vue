<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Examinations" :breadcrumbList="breadcrumbList" />
            <div class="row-gutters-20">
                <div class="12">
                    <div class="row">
                        <div class="col-md-5">
                            <ExamTypeCreate ref="ExamTypeCreate"/>
                        </div>
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="heading-layout1">
                                        <div class="item-title">
                                            <h3>Exam Type List</h3>
                                        </div>
                                    </div>
                                    <div class="table table-responsive" v-show="!noData">
                                        <Table ref="table" :tableData="tableData" :tableHead="tableHead" />
                                    </div>
                                    <NoData v-show="noData" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var toast;
import ExamTypeCreate from "./ExamTypeCreate.vue";

export default {
    components: {
        ExamTypeCreate,
    },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Exam Type",
                },
            ],
            tableHead: {
				items: {
					item1: { label: "Sr.No." },
					item2: { label: "Exam Type" },
					item3: { label: "Description " },
				},
				actions: true,
			},
            tableData: [],
            isLoaded: false,
            noData: false,
            examTypes:[],
        };
    },
    created(){
        toast = Toast.fire({
			icon: "warning",
			title: "Loading data..",
			timer: 0,
		});
    },
    mounted() {
        this.$parent.loadOtherScript();
        this.showData();
    },
    methods: {
       async showData(){
        this.isLoaded = false;
        const res = await this.callApi(
        'get',
        `/api/school/examinations/exam_type`,
        null,
        );
        if(res.status == 200){
            var data = res.data;
            this.log('DAATAAA',res);
            if(data.status == "success"){
                this.examTypes = data.examType_list;
                this.initTable();
                } else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 2500,
					});
					this.noData = true;
				}
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 2500,
				});
			}
                this.$refs.table.loadTable();
                this.isLoaded = true;
                toast.close();
            },
        initTable(){
            this.tableData = [];
            this.examTypes.forEach((element) => {
                this.tableData.push({
                    item: element,
                    data: {
                        item1: element.exam_type_id,
                        item2: element.exam_type != null ? element.exam_type : '',
                        item3: element.exam_description != null ? element.exam_description : '',
                    },
                    action: {
                        edit:true,
                        delete:true,
                    },
                });
            });
        },
        edit(item,index){
            this.$refs.ExamTypeCreate.edit(item,index);
            window.scrollTo(0, 0);
        },
         async deleteData(item, index) {
			var data = new FormData();
			data.append("status", "deleted");
			const res = await this.callApi(
				"post",
				`/api/school/academics/school_sections/delete/${item.exam_type_id}`,
				data
			);

			if (res.status == 200) {
				var data = res.data;
				if (data.status == "success") {
					this.examTypes.splice(this.examTypes.indexOf(item), 1);
					this.tableData.splice(this.examTypes.indexOf(item), 1);
					if (!this.tableData.length) {
						this.noData = true;
					}
					SwalCustomBtn.fire("Deleted!", data.message, "success");
				} else {
					toast = Toast.fire({
						icon: data.status,
						title: data.message,
						timer: 0,
					});
				}
			} else {
				toast = Toast.fire({
					icon: data.status,
					title: data.message,
					timer: 0,
				});
			}
		},
    },
};

</script>



