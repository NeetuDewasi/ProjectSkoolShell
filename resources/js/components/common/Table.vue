<template>
	<div>
		<table
			:class="responsive ? 'table-responsive' : ''"
			class="table display text-nowrap"
			v-show="!loading"
		>
			<thead>
				<tr>
                    <th v-if="checkbox == 'enabled'"><input type="checkbox" name="select_all" v-model="allSelected" @click="selectAll"  /> Select All</th>
					<th v-for="(item, index) in tableHead.items" :key="index">
						<i :class="item.icon" v-if="item.icon"></i>
						<span v-html="item.label"></span>
					</th>
					<th v-show="tableHead.actions">
						<span>Actions</span>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(tableItem, index) in tableData" :key="index">
                    <td v-if="checkbox == 'enabled'"><input type="checkbox" class="checkBox" name="checkbox[]"  :value="tableItem.id" @click="selectedCheck"/></td>
					<td
						v-for="(tableData, tdKey) in tableItem.data"
						:key="tdKey"
						:width="tdKey == 'item1' ? '12%' : 'auto'"
					>
						<span v-if="tdKey == 'item1'">{{ index + 1 }}</span>
						<span v-else>
							<div v-if="typeof tableData == 'object'">
								<div v-if="tableData.type === 'file'">
									<img
										v-if="
											tableData.path &&
											(tableData.path.includes('.jpg') ||
												tableData.path.includes(
													'.jpeg'
												) ||
												tableData.path.includes('.png'))
                                                                    "
                                                :src="tableData.path"
                                                :style="
											tableData.height
												? `height: ${tableData.height} !important`
												: `height: 80px !important`
										    "
                    />
                  <div v-else>VIEW FILE</div>
                </div>
                <div v-else-if="tableData.type === 'label'">
                  <div :class="tableData.options.class" :style="tableData.options.style">
                    <span v-html="tableData.options.icon"></span>
                    {{ tableData.options.label }}
                  </div>
                </div>
                <div v-else-if="tableData.type === 'action'">
                  <!-- <button @click="eventClick(tableData.options.method, index)" :class="tableData.options.class" :style="tableData.options.style"> <span v-html="tableData.options.icon"></span> {{ tableData.options.label }}</button> -->
                  <button
                    @click="tableData.options.method(tableItem.item, index)"
                    :class="tableData.options.class"
                    :style="tableData.options.style"
                  >
                    <span v-html="tableData.options.icon"></span>
                    {{ tableData.options.label }}
                  </button>
                </div>
                <div v-else-if="tableData.type === 'filter'">
                  <span v-if="
											tableData.options.filter ==
											'formatTime'">
                    {{
                    tableData.value | formatTime
                    }}
                  </span>
                  <span v-if="
											tableData.options.filter ==
											'formatDate'">
                    {{
                    tableData.value | formatDate
                    }}
                  </span>
                  <span v-if="
											tableData.options.filter ==
											'formatDateMDY'">
                    {{
                    tableData.value | formatDateMDY
                    }}
                  </span>
                </div>
                <div v-else-if="tableData.type === 'tooltip'">
                  <div style="position:relative;">
                    <span v-html="tableData.text"></span>
                    <span style="display:flex; position:absolute; bottom:0; left: 0;" v-html="tableData.tooltip">
                    </span>
                  </div>
                </div>
                <div v-else></div>
              </div>
              <div v-else>
                <span v-html="tableData"></span>
              </div>
            </span>
          </td>
          <td
            v-show="tableItem.action"
            :width="Object.keys(tableItem.action).length * 10 + '%'"
            style="min-width: 20%"
          >
            <div class="d-flex justify-content-between">
              <i
                v-if="tableItem.action.edit"
                class="fas fa-pen text-primary p-3"
                @click="editItem(tableItem.item, index)"
                title="Edit"
              ></i>
              <i
                v-if="tableItem.action.status"
                :class="
									tableItem.item.status == 'deactivated'
										? 'fa-toggle-off text-secondary'
										: 'fa-toggle-on text-success'
								"
                class="fas p-3"
                @click="deleteItem(tableItem)"
                title="Status"
              ></i>
              <i
                v-if="tableItem.action.delete"
                class="fas fa-trash text-danger p-3"
                @click="deleteItem(tableItem.item, index)"
                title="Delete"
              ></i>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <LottieAnimation v-show="loading" :width="120" :height="120" path="assets/lottie/loader.json" />
  </div>
</template>

<script>
export default {
	props: ["tableData", "tableHead", "responsive", "checkbox"],
	data() {
		return {
			loading: true,
            allSelected: false,
            selectedIds: [],
		};
	},
	mounted() {
        $(".checkBox").change(function (){

        })
    },
    watch: {
        selectedIds: function (value) {
            this.allSelected = (value.length == this.tableData.length);
        },
    },
	methods: {
		loadTable() {
			this.loading = true;
			setTimeout(() => {
				// dataTableScript();
				this.loading = false;
			}, 2000);
		},
		editItem(item, index) {
			this.$parent.edit(item, index);
		},
		updateTable(list) {
			this.tableData = list;
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
					this.$parent.deleteData(item, index);
				}
			});
		},
		eventClick(item, index) {
			this.$parent.commonFunction(item, index);
		},
        getSelectedIds() {
            // this.selectedIds = [];
            // $(".checkBox").each(function () {
            //     if (this.checked) {
            //         this.selectedIds.push($(this).val());
            //     }
            // });
            return this.selectedIds;
        },
        selectedCheck(e) {
            if(this.selectedIds.includes(e.target.value)) {
                this.selectedIds.splice(this.selectedIds.indexOf(e.target.value), 1);
                $(e.target).attr('checked', false)
            } else {
                this.selectedIds.push(e.target.value);
                $(e.target).attr('checked', true)
            }
        },
        selectAll(e) {
            if(!this.allSelected) {
                this.tableData.forEach(e => {
                    this.selectedIds.push(e.id + '');
                });
                $('.checkBox').attr('checked', true);
            } else {
                this.selectedIds = [];
                $('.checkBox').attr('checked', false);
            }
        }

		// callOtherFuction(methods , item , index){
		// 	// this.$parent.`${methods}`(item, index);
		//     this.$emit()
		// },
	},
};
var datTable = null;
function dataTableScript() {
	if ($.fn.DataTable !== undefined) {
		datTable = $(".data-table").DataTable({
			paging: true,
			searching: false,
			info: false,
			lengthChange: true,
			lengthMenu: [20],
			columnDefs: [
				{
					targets: [0, -1],
					orderable: false,
				},
			],
		});
	}
}
</script>
