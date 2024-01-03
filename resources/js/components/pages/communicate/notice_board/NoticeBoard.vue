<template>
  <div>
    <div class="dashboard-content-one">
      <div class="d-flex justify-content-between">
        <Breadcrumb pageTitle="Notice Board" :breadcrumbList="breadcrumbList" />
        <button
          type="button"
          class="text-white new-message btn btn-secondary"
          @click="$router.push({
                    name: 'school.communicate.notice_add'
                })"
        >+ Send New Notice</button>
      </div>
      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="col-lg-9 col-12 form-group">
                <div class="heading-layout1">
                  <div class="item-title">
                    <h3>Generate Notice Board</h3>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div
                  class="card card-body shadow mb-3 pointer
                  "
                  v-for="(notice,index) in notice_board"
                  :key="index"
                  style="border-radius: 15px;"
                >
                  <div class="row pt-2">
                    <div
                      class="col-10"
                      @click="showDescription(index)"
                    >{{ notice.noticeBoard_title }}</div>
                    <div class="col-2">
                      <i class="fas fa-pen text-primary px-3" @click="edit(notice,index)"></i>
                      <i class="fas fa-trash text-danger" @click="deleteItem(notice,index)"></i>
                    </div>
                  </div>
                  <div class="row d-flex animate_container" :id="`description${index}`">
                    <div class="col-8">
                      <div class>
                        <span v-html="notice.noticeBoard_description"></span>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class>
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                        <label>Notice Date :</label>
                        <span>{{notice.noticeBoard_notice_on}}</span>
                      </div>
                      <div class>
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                        <label>Publish Date :</label>
                        <span>{{notice.noticeBoard_publish_on}}</span>
                      </div>
                      <div v-if="notice.noticeBoard_department ">
                        <label>Message To :</label> <span v-for="(department,index) in notice.noticeBoard_department" :key="index">{{department.name}} <br /></span>
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Footer />
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
                    name: "Notice Board",
                },
            ],
            notice_board: [],
            isShowing : false,
        };
    },
    mounted() {
        toast = Toast.fire({
            icon: "warning",
            title: "Loading Data..",
            timer: 2000,
        });

        this.showData();
    },
    methods: {
        showDescription(index) {
            $('#description'+ index).toggleClass('show mt-5')
            if(!this.isShowing){
                this.isShowing = true;
            }else{
                this.isShowing = false;
            }
        },
        async showData() {
            this.isLoaded = false;
            // let formData = new FormData();
            const res = await this.callApi(
                "get",
                `/api/school/communicate/notice_board`,
                // formData,
            );
            this.log('DDDAATTAA', res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.notice_board = data.noticeBoard;
                }
            }
            this.isLoaded = true;
            toast.close();
        },
        edit(item, index) {
            this.$router.push({
                path: `/school/communicate/notice_add/${item.noticeBoard_id}`
            });
        },
        viewData(item, index) {
            this.$router.push(`/school/communicate/notice_view/${item.noticeBoard_id}`);
        },
        deleteItem(item, index) {
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
					this.deleteData(item, index);
				}
			});
		},
        async deleteData(item, index) {
            var data = new FormData();
            data.append("status", "deleted");
            const res = await this.callApi(
                "post",
                `/api/school/communicate/notice_board/delete/${item.noticeBoard_id}`,
                data
            );

            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.notice_board.splice(index, 1);
                    SwalCustomBtn.fire("Deleted!", data.message, "success");
                    toast = Toast.fire({
                        icon: data.status,
                        title: data.message,
                        timer: 2500,
                    });
                }
                else {
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
.animate_container {
	height: 0;
	transform: scale(1, 0);
	transform-origin: 0 0;
	transition: all 0.3s ease-out;
}

.animate_container.show {
	height: fit-content;
	transform: scale(1, 1);
}
</style>
