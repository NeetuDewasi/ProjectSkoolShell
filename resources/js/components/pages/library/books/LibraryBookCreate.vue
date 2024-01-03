<template>
    <div>
        <div class="dashboard-content-one">
            <Breadcrumb pageTitle="Library Book Create" :breadcrumbList="breadcrumbList" >
                <template v-slot:button>
                    <button type="submit" class="btn btn-primary btn-sm text-white"  @click="$router.push({name: 'school.library.books'})">
                        <i class="fa fa-eye"></i> View All Books
                    </button>
                </template>
            </Breadcrumb>
            <div class="row gutters-20">
                <div class="col-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Add New Book</h3>
                                </div>
                            </div>
                            <form class="new-added-form" enctype="multipart/form-data">
                                <div class="row">
                                     <div class="col-md-4 col-12 form-group">
                                        <label>Book Code *</label>
                                        <input type="text" placeholder="Enter Book Code" class="form-control" v-model="editItem.book_code"
                                            @keypress="errorItem.book_code = ''"
                                            :class="errorItem.book_code != '' ? 'error-field' : ''">
                                        <span class="error-label" v-if="errorItem.book_code != ''" v-text="errorItem.book_code"></span>
                                    </div>
                                    <div class="col-md-8 col-12">
                                        <div class="row">
                                            <div class="col-md-4 col-12 form-group">
                                                <label>Category *</label>
                                                <Select2
                                                    ref="category_list"
                                                    @change="selectCategory"
                                                    :items="category_list"
                                                    :selectedId="book_category_id"
                                                    :class="errorItem.book_category_id != '' ? 'error-field' : ''"
                                                />
                                                <span class="error-label" v-if="errorItem.book_category_id != ''" v-text="errorItem.book_category_id"></span>
                                            </div>
                                            <div class="col-md-4 col-12 form-group">
                                                <label>Reck *</label>
                                                <Select2
                                                    ref="reck_list"
                                                    @change="selectReck"
                                                    :items="reck_list"
                                                    :selectedId="book_reck_id"
                                                    :class="errorItem.book_reck_id != '' ? 'error-field' : ''"
                                                />
                                                <span class="error-label" v-if="errorItem.book_reck_id != ''" v-text="errorItem.book_reck_id"></span>
                                            </div>
                                            <div class="col-md-4 col-12 form-group">
                                                <label>Shelf Number *</label>
                                                <input type="text" placeholder="Enter Shelf Number" class="form-control" v-model="editItem.book_shelf_number"
                                                    :class="errorItem.book_shelf_number != '' ? 'error-field' : ''"
                                                      @keyup = "editItem.book_shelf_number != ''
                                                            ? (errorItem.book_shelf_number = '')
                                                            : ''">
                                                <span class="error-label" v-if="errorItem.book_shelf_number != ''" v-text="errorItem.book_shelf_number"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="rounded-1 p-2 text-center position-relative" style="border:solid 1px #00000012">
                                            <img :src="bookCoverSrc" style="height: 180px"/>
                                            <div>Book Cover</div>
                                            <input type="file" class="employee_avatar" accept=".png,.jpg,.jpeg" @change="selectBookCoverImageFile" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label>Book Title *</label>
                                                <input type="text" placeholder="Enter Book Title" class="form-control" v-model="editItem.book_title"
                                                :class="errorItem.book_title != '' ? 'error-field' : ''">
                                                <span class="error-label" v-if="errorItem.book_title != ''" v-text="errorItem.book_title"></span>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label>Author *</label>
                                                <input type="text" placeholder="Enter Book Author" class="form-control" v-model="editItem.book_author"
                                                :class="errorItem.book_author != '' ? 'error-field' : ''">
                                                <span class="error-label" v-if="errorItem.book_author != ''" v-text="errorItem.book_author"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12 form-group">
                                        <label>Book Cost *</label>
                                        <input type="text" placeholder="Enter Book Price" class="form-control" v-model="editItem.book_cost"
                                        :class="errorItem.book_cost != '' ? 'error-field' : ''"  @keyup = "editItem.book_cost != ''
                                            ? (errorItem.book_cost = '')
                                            : ''">
                                        <span class="error-label" v-if="errorItem.book_cost != ''" v-text="errorItem.book_cost"></span>
                                    </div>
                                    <div class="col-md-4 col-12 form-group">
                                        <label>Fine on Lost *</label>
                                        <input type="text" placeholder="Enter Fine amount on Lost " class="form-control" v-model="editItem.book_fine">
                                    </div>
                                    <div class="col-md-4 col-12 form-group">
                                        <label>Inventory Date</label>
                                        <DatePicker format="DD-MMM-YYYY" value-type="format" type="date"
                                            placeholder="Select a date" v-model="displayInventoryDate"
                                            :default-value="new Date()" :disabled-date="disabledAfterToday"
                                            class="form-control vue-datepicker my-0" :class="errorItem.inventoryDate != '' ? 'error-field' : ''"/>
                                        <span class="error-label" v-if="errorItem.inventoryDate != ''" v-text="errorItem.inventoryDate"></span>
                                    </div>
                                    <div class="col-md-4 col-12 form-group">
                                        <label>ISBN Number</label>
                                       <input type="text" placeholder="Enter Fine amount on Lost " class="form-control" v-model="editItem.book_isbn_number">
                                    </div>
                                    <div class="col-md-4 col-12 form-group">
                                        <label>Quantity</label>
                                       <input type="text" placeholder="Enter Fine amount on Lost " class="form-control" v-model="editItem.book_quantity">
                                    </div>
                                     <div class="col-md-4 col-12 form-group">
                                        <label>Publisher</label>
                                       <input type="text" placeholder="Enter Fine amount on Lost " class="form-control" v-model="editItem.book_publisher">
                                    </div>
                                    <div class="col-12 form-group mg-t-8 d-flex justify-content-end">
                                        <button type="submit" :class="formBtnClass" class="btn btn-lg text-white" @click.prevent="submitForm()">
                                           {{formBtn}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Staff Area End Here -->
            <Footer/>
        </div>
    </div>
</template>

<script>
    var toast;
    export default{
        data() {
			return {
				breadcrumbList: [
					{
						to: { name: "admin.dashboard" },
						name: "Home",
					},
					{
						name: "Library",
					},
                    {
						name: "Books",
					},
				],
                editedIndex: -1,
                editItem: {},
                errorItem: {
                    book_code: '',
                    book_category_id: '',
                    book_reck_id: '',
                    book_shelf_number: '',
                    book_title: '',
                    book_cost:'',
                    book_author:'',
                    inventoryDate:'',
                },
                book_category_id: -1,
                category_list: [],
                book_reck_id: -1,
                reck_list: [],
                bookCoverImagePath: null,
                bookCoverSrc: '/assets/img/book_cover.png',
                displayInventoryDate: '',
                inventoryDate: '',
		    };
        },
        computed:{
            formBtn : function(){
                return this.editedIndex != -1 ? 'Update' : 'Save';
            },
            formBtnClass: function () {
                return this.editedIndex != -1 ? 'btn-warning' : 'btn-success';
            }
        },
        created() {
            this.getDropdownList();
        },
        watch: {
            displayInventoryDate: function(val) {
                this.displayInventoryDate = val;
                this.editItem.inventoryDate = moment(new Date(val)).format('YYYY-MM-DD');
                // this.errorItem.inventoryDate = '';
                // if(val == null || val == '') this.errorItem.inventoryDate = 'Inventory Date is required'
            },

        },
        mounted() {
            this.$parent.loadOtherScript();
            if(this.$route.params.id){
                this.editedIndex = this.$route.params.id;
                this.getEditData();
            }
            this.displayInventoryDate = moment(new Date()).format('DD-MMM-YYYY');
        },
        methods: {
            disabledAfterToday(date) {
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                return date > today;
            },
            selectBookCoverImageFile(e) {
                let file = e.target.files[0];
                if (file) {
                    this.bookCoverSrc = URL.createObjectURL(file);
                    URL.revokeObjectURL(file);
                    this.bookCoverImagePath = file;
                } else {
                    this.bookCoverSrc = '/assets/img/book_cover.png';
                    this.bookCoverImagePath = null;
                }
            },
            selectCategory(val) {
                this.book_category_id = val;
                // this.errorItem.book_category_id = "";
                // if(val == null || val == '' || val == -1) this.errorItem.book_category_id = "Category ID is required";
            },
            selectReck(val) {
                this.book_reck_id = val;
                this.log('book reck id',this.book_reck_id);
                // this.errorItem.book_reck_id = "";
                // if(val == null || val == '' || val == -1) this.errorItem.book_book_reck_id = "Reck ID is required";
            },
            async getEditData() {
				const res = await this.callApi(
					"get",
					`/api/school/hr/employees/edit/${this.editedIndex}`,
					null,
				);

                this.log("RES>>>",res)

				if (res.status == 200) {
					var data = res.data;
					if (data.status == "success") {
						this.editItem = data.employee;
                        this.book_category_id = data.employee.employee_department.value;
                        this.$refs.category_list.setSelected(this.book_category_id);
                        this.selectCategory(this.book_category_id);
					}
				}
			},
            async getDropdownList() {
				const res = await this.callApi(
					"get",
					`/api/school/library/books/get_dropdown_lists`,
					null,
				);
                this.log(res);
				if (res.status == 200) {
					var data = res.data;
                    if(data.category_list && data.category_list.length) {
                        this.category_list = data.category_list;
                        this.$refs.category_list.updateList(data.category_list);
                    } else {
                        this.category_list = [];
                        this.$refs.category_list.updateList([]);
                    }
                    if(data.reck_list && data.reck_list.length) {
                        this.reck_list = data.reck_list;
                        this.$refs.reck_list.updateList(data.reck_list);
                    } else {
                        this.reck_list = [];
                        this.$refs.reck_list.updateList([]);
                    }
				}
			},

            async submitForm(){
                var isValid = await this.validBookForm();
                if (!isValid) {
                    return;
                }
                console.log("reck_id", this.book_reck_id);
                var data = new FormData();
                data.append("book_code", this.editItem.book_code);
                data.append("category_id", this.book_category_id);
                data.append("reck_id", this.book_reck_id);
                data.append("shelf_number", this.editItem.book_shelf_number);
                data.append("book_title", this.editItem.book_title);
                data.append("book_author", this.editItem.book_author);
                data.append("book_cost", this.editItem.book_cost);
                data.append("fine_on_lost", this.editItem.book_fine);
                data.append("inventory_date", this.editItem.inventoryDate);
                data.append("book_cover", this.bookCoverImagePath);
                data.append("isbn_number", this.editItem.book_isbn_number);
                data.append("quantity", this.editItem.book_quantity);
                data.append("publisher", this.editItem.book_publisher);
                let url = '';
                if(this.editedIndex != -1){
                    url = `/api/school/library/books/update/${this.editedIndex}`
                }else{
                    url = `/api/school/library/books/save`;
                }
                const res = await this.callApi(
                    "post",
                    url,
                    data,
                    'multipart'
                );
                if (res.status == 200) {
                    var data = res.data;
                    if(data.status == 'success'){
                        this.resetForm();
                            toast = Toast.fire({
                            icon : data.status,
                            title : data.message,
                            timer : 2500,
                        });
                    } else {
                        toast = Toast.fire({
                            icon : data.status,
                            title : data.message,
                            timer : 2500,
                        });
                    }
                } else {
                    toast = Toast.fire({
                        icon : warning,
                        title : 'Something Went Wrong....',
                        timer : 2500,
                    });
                }
            },
            resetForm(){
                this.editItem={};
                this.editedIndex = -1,
                this.displayInventoryDate = null;
                this.book_category_id = -1,
                this.book_reck_id = -1;
                this.bookCoverImagePath = null;
                this.bookCoverSrc = '/assets/img/book_cover.png';
            },
            validBookForm() {
                let isFormValid = true;
                if (
                    this.editItem.book_code == null ||
                    this.editItem.book_code == ""
                ) {
                    this.errorItem.book_code = "Book Code is required";
                    isFormValid = false;
                } else {
                    this.errorItem.book_code = "";
                }
                if (
                    this.book_category_id == null ||
                    this.book_category_id == -1
                ) {
                    this.errorItem.book_category_id = "Category Id is required";
                    isFormValid = false;
                } else {
                    this.errorItem.book_category_id = "";
                }
                if (
                    this.book_reck_id == null ||
                    this.book_reck_id == ""
                ) {
                    this.errorItem.book_reck_id = "Reck ID is required";
                    isFormValid = false;
                } else {
                    this.errorItem.book_reck_id = "";
                }
                if (!/^\d+$/.test(this.editItem.book_shelf_number)) {
                this.errorItem.book_shelf_number = "Please Enter Numbers only.";
                this.isFormValid = false;
                } else if (
                    this.editItem.book_shelf_number == null ||
                    this.editItem.book_shelf_number == ""
                ) {
                    this.errorItem.book_shelf_number = "Book Shelf Number is required";
                    isFormValid = false;
                } else {
                    this.errorItem.book_shelf_number = "";
                }

                if (
                    this.editItem.book_title == null ||
                    this.editItem.book_title == ""
                ) {
                    this.errorItem.book_title = "Book Title is required";
                    isFormValid = false;
                } else {
                    this.errorItem.book_title = "";
                }
                if(!/^\d+$/.test(this.editItem.book_cost)){
                    this.errorItem.book_cost = "Please Enter Valid Cost";
                    isFormValid  = false;
                }
                else if (
                    this.editItem.book_cost == null ||
                    this.editItem.book_cost == ""
                ) {
                    this.errorItem.book_cost = "Book Cost is required";
                    isFormValid = false;
                } else {
                    this.errorItem.book_cost = "";
                }

                if (
                    this.editItem.book_author == null ||
                    this.editItem.book_author == ""
                ) {
                    this.errorItem.book_author = "Book Author is required";
                    isFormValid = false;
                } else {
                    this.errorItem.book_author = "";
                }

                if (
                    this.editItem.inventoryDate == null ||
                    this.editItem.inventoryDate == ""
                ) {
                    this.errorItem.inventoryDate = "Inventory Date is required";
                    isFormValid = false;
                } else {
                    this.errorItem.inventoryDate = "";
                }
                return isFormValid;
            },
        },
    };
</script>


<style scoped>
.current-address{
    margin-left:-5px !important;
}
.employee_avatar{
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    bottom: 0;
    right: 0;
}
</style>
