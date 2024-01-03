<template>
  <div>
    <div class="dashboard-content-one">
      <Breadcrumb pageTitle="Notice Board" :breadcrumbList="breadcrumbList" />

      <div class="row gutters-20">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="item-title text-center bg-secondary">
                <h3>Notice List</h3>
              </div>
              <div class="row">
                <div class="col-12 ms-5">
                  <b>
                    <label>Title :</label>
                  </b>
                  <b>{{ viewNotice_list.noticeBoard_title }}</b>
                </div>
                <div class="col-12 ms-5">
                  <b>
                    <label>Description :</label>
                  </b>
                  <b>{{ viewNotice_list.noticeBoard_description }}</b>
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
export default {
    data() {
        return {
            breadcrumbList: [
                {

                    to: { name: "admin.dashboard" },
                    name: "Home",
                },
                {
                    name: "Notice Board Detail Page",
                },
            ],
            noticeBoardId: -1,
            viewNotice_list:[]
        };
    },

    created() {
        this.noticeBoardId = this.$route.params.id;
        this.log(this.noticeBoardId);
        this.viewData();
    },
    methods: {
        async viewData() {
            this.isLoaded = false;
            const res = await this.callApi(
                "get",
                `/api/school/communicate/notice_board/${this.noticeBoardId}`,
                null,
            );
            this.log('DAAATAAA',res);
            if (res.status == 200) {
                var data = res.data;
                if (data.status == "success") {
                    this.viewNotice_list = data.viewNotice;
                }
            }
            this.isLoaded = true;
        },
    },
};
</script>

