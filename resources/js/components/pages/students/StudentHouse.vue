<!-- <template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Student House" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Add School House</h3>
                </div>
              </div>

              <form class="new-added-form">
                <div class="d-flex">
                  <div class="flex-grow-1 mr-5 form-group">
                    <label>Name *</label>
                    <input type="text" placeholder class="form-control" v-model="editItem.name" />
                  </div>
                  <div class="flex-grow-1 mr-5 form-group">
                    <label>Description *</label>
                    <input
                      type="text"
                      placeholder
                      class="form-control"
                      v-model="editItem.description"
                    />
                  </div>

                  <div class="flex-grow-1 mr-5 mt-5 pt-3 form-group">
                    <button
                      type="button"
                      class="btn-fill-lg text-light shadow-dodger-blue bg-dodger-blue"
                      @click.prevent="saveData()"
                    >SAVE</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive mt-5">
                <div class="heading-layout1">
                  <div class="item-title">
                    <h3>Student House List</h3>
                  </div>
                </div>
                <table class="table display text-nowrap">
                  <thead>
                    <tr>
                      <th>Sr.No.</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <HouseTableRow
                      :student_house="house"
                      :index="index"
                      v-for="(house,index) in houseList"
                      :key="index"
                    />
                  </tbody>
                </table>
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
import HouseTableRow from './HouseTableRow.vue';
var headers = {
		"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
	};
export default {
    components:{HouseTableRow},
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "admin.dashboard" },
          name: "Home",
        },
        {
          name: "Student House",
        },
      ],
      houseList :[ ],
      isLoaded: false,
      noData: false,
      editItem: {},
    };

  },
 mounted(){
     this.$parent.loadOtherScript()
     this.showData();
		},
		methods: {
			async showData() {
				this.isLoaded = false;
				const res = await this.callApi(
					"get",
					`/api/school/students/student_houses`,
					null,

				);

				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.houseList = data.student_houses;
					} else {
						this.noData = true;
					}
				}
				this.isLoaded = true;
				// toast.close();
			},

            submitData(){
                if(this.$route.params.edit_id){
                    this.updateData();
                }else{
                    this.saveData();
                }
            },
            async saveData() {
				var data = new FormData();
				data.append("name", this.editItem.name);
                data.append("description", this.editItem.description);
				const res = await this.callApi(
					"post",
					`/api/school/students/student_houses/save`,
					data,
					headers
				);

				if (res.status == 200) {
					var data = res.data;
					this.houseList.unshift(data.student_house);
				}
			},

             async deleteData(item, status) {
				var data = new FormData();
				data.append("status", status);
				const res = await this.callApi(
					"post",
					`/api/school/students/student_houses/delete/${item.id}`,
					data,

				);

				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.houseList.splice(this.houseList.indexOf(item), 1)
					}else{
                        // show toast;
                    }
				}
			},
 },
};
</script>
<style scoped>
.card{
margin-bottom: none;
}
</style> -->
