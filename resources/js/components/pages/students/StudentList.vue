<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Students" :breadcrumbList="breadcrumbList" />
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Students Data</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i
                                        class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Roll ..." class="form-control">
                            </div>
                            <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Name ..." class="form-control">
                            </div>
                            <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Class ..." class="form-control">
                            </div>
                            <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <div v-if="a==10">

                        </div>
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr >
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">Roll</label>
                                        </div>
                                    </th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Parents</th>
                                    <th>Address</th>
                                    <th>Date Of Birth</th>
                                    <th>Phone</th>
                                    <th>E-mail</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <StudentItem :student="studentItem" v-for="(studentItem, index) in students" :key="index" />
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <Footer/>
        </div>

    </div>
</template>

<script>
	import StudentItem from "./StudentListItem.vue";
	export default {
		components: {
			StudentItem,
		},
		data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "All Students",
					},
				],
				students: [
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
					{
						avatar: "/assets/img/figure/student2.png",
						name: "Mark Willy",
						gender: "Gender",
					},
				],
			};
		},
		mounted() {},
		methods: {},
	};
</script>
