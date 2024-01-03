<template>
    <div class="row pt-sm-3 p-sm-4 p-3 `V">
        <div id="main-div">
            <div class="w-100 d-sm-block mb-5" v-if="documents.imageFilePathList.length">
                <div class="row">
                    <div class="col-md-6 mb-5" v-for="(
                            imageFilePath, index
                        ) in documents.imageFilePathList" :key="index">
                        <div class="displayContainer" v-if="imageFilePath &&
                                                    imageFilePath != null &&
                                                    imageFilePath != ''
                                                    ">
                            <button style="
                                    background: none;
                                    outline: none;
                                    border: none;
                                    color: inherit;
                                    decoration: none;
                                    display: inherit;
                                " @click.prevent="
                                                                    componentRef == 'store'
                                                                        ? openDocs(imageFilePath)
                                                                        : ''
                                                                    ">
                                <div class="text-center" style="width: auto">
                                    <div>
                                        <img :src="getSrc(index, imageFilePath)" style="height:70px;width: 50px;" />
                                    </div>
                                    <span class="text-center filename">
                                        Document {{ index +1 }}
                                    </span>
                                </div>
                            </button>
                            <div>
                                <button class="btn btn-danger ml-2" @click.prevent="deleteImage(index, imageFilePath)"
                                    style="position: absolute;top: -15px;left: 0;right: 0;bottom: 0;width: 40px;height: 40px;border-radius: 50px;">
                                    <div>
                                        <i class="fa fa-trash"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["componentRef", "compLabel"],
    data() {
        return {
            documents: {
                imageFilePathList: [],
                imageFileNameList: [],
                srcImageFileList: [],
                extensions: [],
                files: [],
            },
        };
    },
    mounted() {
        console.log(this.componentRef);
    },
    methods: {
        showDocuments(docs) {
            this.documents = docs;
            console.log("docs", docs)
        },
        getLabel() {
            return this.compLabel;
        },
        openDocs(doc) {
            // this.$parent.openDocs(doc);
        },

        getExt(item) {
            if (
                item.split(".")[1] == "png" ||
                item.split(".")[1] == "jpg" ||
                item.split(".")[1] == "jpeg"
            ) {
                return "image";
            } else if (
                item.split(".")[1] == "doc" ||
                item.split(".")[1] == "docx"
            ) {
                return "doc";
            } else if (
                item.split(".")[1] == "xls" ||
                item.split(".")[1] == "xlsx"
            ) {
                return "excel";
            } else if (item.split(".")[1] == "pdf") {
                return "pdf";
            }
        },
        getSrc(index, imgName) {
            const filePath = typeof imgName == 'string' ? imgName : this.getExt(imgName.name);
            if (this.documents.extensions[index] == "image" || filePath == "image") {
                // return "/assets/img/image-icon.png";
                return typeof imgName !== 'string' ? URL.createObjectURL(imgName) : this.documents.imageFilePathList[index];
            } else if (this.documents.extensions[index] == "excel" || filePath == "excel") {
                return "/assets/img/excel-icon.png";
            } else if (this.documents.extensions[index] == "pdf" || filePath == "pdf") {
                return "/assets/img/pdf-icon.png";
            } else {
                return "/assets/img/doc-icon.png";
            }
        },
        deleteImage(index, img) {
            this.documents.imageFilePathList.splice(index, 1);
            this.documents.imageFileNameList.splice(index, 1);
            this.documents.srcImageFileList.splice(index, 1);
            //    debugger;
            this.documents.extensions.splice(index, 1);
            this.documents.files?.splice(index, 1);

            if (this.componentRef == "store") {
                this.$parent.deleteStoreImage(index, this.compLabel, img);
            } else {
                this.$parent.deleteImage(index, this.compLabel, img);
            }
        },
        getFileName(index) {
            if (
                this.documents.imageFilePathList[index] &&
                this.documents.imageFilePathList[index].name
            )
                return this.documents.imageFileNameList[index];
            console.log(
                "this.documents.imageFilePathList",
                this.documents.imageFileNameList[index]
            );
            if (this.documents.srcImageFileList[index])
                return this.documents.imageFileNameList[index];
        },
    },
};
</script>
<style scoped>
.displayContainer {
    box-shadow: 0 0 5px rgba(250, 221, 221, 0.5);
    border-radius: 3px;
    /* display: flex; */
    align-items: center;
}

.filename {
    display: inline-block;
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    align-self: left;
}
</style>
