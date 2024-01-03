<template>
  <div>
    <div class="dashboard-content-one">
      <!-- Breadcubs Area Start -->
      <Breadcrumb
        pageTitle="Homework Detail View"
        :breadcrumbList="breadcrumbList"
      >
        <template v-slot:button>
          <button
            type="submit"
            class="btn btn-success btn-sm text-white"
            @click="$router.push({ name: 'school.homework.homework' })"
          >
            <i class="fa fa-arrow-eye"></i> Back
          </button>
        </template>
      </Breadcrumb>
      <!-- End Breadcubs Area -->
      <div class="row gutters-20">
        <!-- Fees Statement List Area Start Here -->
        <div class="col-12">
          <div class="card height-auto shadow">
            <!-- <div class="heading-layout1">
              <div class="item-title">
                <h3>Homework Deatil</h3>
              </div>
            </div> -->
            <div class="card-header">
                <h2>
                    Homework Detail
                </h2>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- <div class='col-5 rounded border card shadow text-center'>
                        <img :src="homework.homework_document != null ? homework.homework_document : '' " class="mt-3" width="100%" />
                    </div> -->
                <div class="col-7 card border border-rounded">
                  <div class="item-content mt-3">
                    <div class="header-inline item-header pt-3 card-header">
                      <h3 class="text-dark-medium font-medium">
                        {{
                          homework.homework_class_id != null
                            ? homework.homework_class_id.name != null
                              ? homework.homework_class_id.name
                              : ""
                            : ""
                        }}
                        {{
                          homework.homework_section_id != null
                            ? homework.homework_section_id.name != null
                              ? homework.homework_section_id.name
                              : ""
                            : ""
                        }}
                      </h3>
                      <!-- <div class="header-elements d-flex">
                                    <div class="mr-3"><a href="#"><i class="fas fa-print"></i></a></div>
                                    <div><a href="#"><i class="fas fa-download"></i></a></div>
                                </div> -->
                    </div>
                    <div class="table table-responsive card-body">
                      <table class="table text-nowrap mt-5">
                        <tbody>
                          <tr>
                            <td width="108">
                              <strong>Homework Title : </strong>
                            </td>
                            <td width="107" class="ont-medium text-dark-medium">
                              {{ homework.homework_title }}
                            </td>
                          </tr>
                          <tr>
                            <td width="75"><strong>Subject Name</strong></td>
                            <td width="91" class="ont-medium text-dark-medium">
                              {{
                                homework.homework_subject_id != null
                                  ? homework.homework_subject_id.name != null
                                    ? homework.homework_subject_id.name
                                    : ""
                                  : ""
                              }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Published On:</strong></td>
                            <td class="font-medium text-dark-medium">
                              {{ homework.homework_issue_date }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Submission Date : </strong></td>
                            <td class="font-medium text-dark-medium">
                              {{ homework.homework_submission_date }}
                            </td>
                          </tr>
                          <tr>
                            <td class="font-weight-bold">Description</td>
                            <td
                              colspan="4"
                              class="font-medium text-dark-medium"
                            >
                              {{ homework.description }}
                            </td>
                          </tr>
                          <tr>
                            <td><strong>Homework Document:</strong></td>
                            <td class="font-medium text-dark-medium">
                              <span v-if="homework.homework_document">
                                                    <img :src="document.path" v-for="document,index in homework.homework_document" :key="index" v-show="document.type == 'image'" class="mt-3" width="100%" />
                                                </span>
                              <button
                                type="button"
                                id="showImage"
                                class="btn btn-primary"
                                @click="isShowing = true"
                              >
                                <i class="fa fa-eye"></i> View File
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-5 card border border-rounded">
                  <div class="item-content mt-3">
                    <div class="header-inline item-header pt-3 card-header">
                      <h3 class="text-dark-medium font-medium">
                        Students Name
                      </h3>
                    </div>
                    <div class="table table-responsive card-body">
                      <table
                        class="table text-nowrap mt-5"
                        v-if="
                          homework.homework_for && homework.homework_for != null
                        "
                      >
                        <tbody>
                          <tr
                            v-for="(student, index) in homework.homework_for"
                            :key="student.student_admission_id"
                          >
                            <!-- <td width="75"><strong>Subject Name</strong></td> -->
                            <td width="91">
                              {{
                                student.student_first_name != null
                                  ? student.student_first_name
                                  : ""
                              }}
                              {{
                                student.student_middle_name != null
                                  ? student.student_middle_name
                                  : ""
                              }}
                              {{
                                student.student_last_name != null
                                  ? student.student_last_name
                                  : ""
                              }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div
                  class="col-12 card border border-rounded"
                  v-show="isShowing"
                >
                  <div class="d-flex justify-content-end mt-3">
                    <form>
                      <input type="file" multiple />
                      <!-- <button type="button" multiple class="btn btn-info ml-2">
                        <i class="fa fa-plus"></i>Add More
                      </button> -->
                    </form>
                  </div>
                  <div class="row" v-if="homework.homework_document">
                    <div
                      class="col-6"
                      v-for="(document, index) in homework.homework_document"
                      :key="homework.homework_id"
                    >
                      <div
                        class="displayContainer"
                        v-if="document && document != null && document != ''"
                      >
                        <div class="ml-2">
                          <span class="filename">
                            {{ document.name }}
                          </span>
                        </div>
                        <div>
                          <!-- <button
                            class="btn btn-danger ml-2"
                            @click.prevent="deleteImage(index)"
                          >
                            <i class="fa fa-trash"></i>
                          </button> -->
                          <!-- <button
                                            class="btn btn-info ml-2"
                                            @click.prevent="addImage(index)"
                                        >
                                            <i class="fa fa-plus"></i>
                                        </button> -->
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
  </div>
</template>

<script>
var toast;
export default {
  data() {
    return {
      breadcrumbList: [
        {
          to: { name: "school.dashboard" },
          name: "Home",
        },
        {
          name: "Homework View ",
        },
      ],
      homework: [],
      homework_id: -1,
      isShowing: false,
    };
  },
  created() {
    toast = Toast.fire({
      icon: "warning",
      title: "Loading data..",
      timer: 0,
    });
  },
  mounted() {
    this.$parent.loadOtherScript();
    if (this.$route.params.homework_id) {
      this.homework_id = this.$route.params.homework_id;
      this.showData();
    } else {
      this.$router.go(-1);
    }
  },
  methods: {
    async showData() {
      this.isLoaded = false;
      const res = await this.callApi(
        "get",
        `/api/school/homework/homework/homework_view/${this.homework_id}`,
        null
      );
      console.log('hw res',res);
      if (res.status == 200) {
        var data = res.data;
        if (data.status == "success") {
          this.homework = data.homework;
        }
      }
      this.isLoaded = true;
      toast.close();
    },
    isShowimage() {
        if ($("#showImage").is(':click')) {
            this.isShowing = true;
        } else {
            this.isShowing = false;
        }
    },
  },
};
</script>

<style scoped>
.imageContainer {
  width: 100%;
  height: 150px;
  border: grey none 2px;
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
  width: 50%;
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
.student {
  box-shadow: none !important;
}
.displayContainer {
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
  border-radius: 3px;
  margin: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.displayContainer > div:first-child {
  width: 70%;
  display: flex;
  align-items: center;
}
.filename {
  display: inline-block;
  width: 80%;
  white-space: nowrap;
  overflow: hidden;
  align-self: center;
  text-overflow: ellipsis;
}
</style>
