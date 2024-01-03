<!-- <template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle=" Student Categories" :breadcrumbList="breadcrumbList" />
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Create Category</h3>
                </div>
              </div>

              <form class="new-added-form" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-xl-6 col-lg-6 col-12 form-group">
                    <label>Category *</label>
                    <input
                      type="text"
                      placeholder
                      class="form-control"
                      v-model="editItem.category_name"
                    />
                  </div>
                </div>
                 <div class="col-xl-6 col-lg-6 col-12 form-group">
                    <label>Search By Keyword *</label>
                    <input type="text" placeholder class="form-control" />
                  </div>

                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-warning btn-lg">
                    <i class="fa fa-search"></i> Search
                  </button>
                </div>
                <div class="col-lg-12 col-12 form-group mg-t-8">
                  <button
                    type="submit"
                    class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                    @click.prevent="submitData()"
                  >{{formBtn}}</button>
                  <button
                    type="reset"
                    class="btn btn-lg btn-gradient-yellow btn-hover-bluedark mx-3 text-white"
                  >Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="heading-layout1">
                <div class="item-title">
                  <h3>Category List</h3>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table display text-nowrap">
                  <thead>
                    <tr>
                      <th>Sr.No.</th>
                      <th>Category Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <CategoryTable
                      :category="category"
                      :index="index"
                      v-for="(category, index) in categoryList"
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
import CategoryTable from './CategoryTable.vue';

export default {
    components: { CategoryTable },
    data() {
        return {
            breadcrumbList: [
                {
                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Categories",
                },
            ],
            categoryList: [],
            initcategoryList:[],
            isLoaded: false,
            noData: false,
            editItem: {},
            editedIndex: -1,

        };
    },
     computed:{
        formBtn : function(){
            return this.editedIndex !== -1 ? 'Update' : 'Save';
        },

    },
     mounted() {
        this.$parent.loadOtherScript()
        this.showData();
    },
    methods: {
        editData(item){
            this.editItem = item;
            this.editedIndex = item.category_id;
        },
        async updateData() {
            var data = new FormData();
            data.append("name", this.editItem.category_name);

            const res = await this.callApi(
                "post",
                `/api/school/students/student_categories/update/${this.editedIndex}`,
                data,
            );

            if (res.status == 200) {
                var data = res.data;
                if(data.status == 'success'){
                    this.categoryList[this.editedIndex].category_name = this.editItem.category_name
                }
            }
        },
        async showData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/students/student_categories`,
                null,
                headers
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.categoryList = data.student_categories;
                } else {
                    this.noData = true;
                }
            }
            this.isLoaded = true;
            // toast.close();
        },

        submitData() {
            if (this.editedIndex !== -1 ) { // editedIndex = -1
                this.updateData();
            } else {
                this.saveData();
            }
        },
        async saveData() {
            var data = new FormData();
            data.append("name", this.editItem.category_name);
            const res = await this.callApi(
                "post",
                `/api/school/students/student_categories/save`,
                data,
                headers
            );

            if (res.status == 200) {
                var data = res.data;
                this.categoryList.unshift(data.student_categories);
            }
        },
        async deleteData(item, status) {
            var data = new FormData();
            data.append("status", status);
            const res = await this.callApi(
                "post",
                `/api/school/students/student_categories/delete/${item.category_id}`,
                data,
                headers
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.categoryList.splice(this.categoryList.indexOf(item), 1)
                } else {
                    // show toast;
                }
            }
        },
    },
};
</script>
--->
