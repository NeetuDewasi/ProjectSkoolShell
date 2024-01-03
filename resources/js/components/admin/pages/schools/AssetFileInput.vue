<template>
    <div class="row pt-sm-3 p-sm-4 pt-1 p-2">
        <div id="main-div">
            <div class="imageContainer pointer border border-2 rounded m-0">
                <i class="fas fa-upload" style="cursor: pointer" id="upload-button"></i>
                &nbsp; Choose File
                <input type="file" class="form-control" accept="image/*"
          multiple ref="files"
                    id="file" name="documents[]" @change="uploadImages"  />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["field", "compLabel"],
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
    methods: {
       uploadImages(e) {

                const inputFiles = e.target.files;
                for (let index = 0; index < inputFiles.length; index++) {
                    this.documents.srcImageFileList.push(
                        URL.createObjectURL(inputFiles[index])
                    );
                    if (
                        inputFiles[index].name.split(".")[1] == "png" ||
                        inputFiles[index].name.split(".")[1] == "jpg" ||
                        inputFiles[index].name.split(".")[1] == "jpeg"
                    ) {
                        this.documents.extensions.push("image");
                    } else if (
                        inputFiles[index].name.split(".")[1] == "doc" ||
                        inputFiles[index].name.split(".")[1] == "docx"
                    ) {
                        this.documents.extensions.push("doc");
                    } else if (
                        inputFiles[index].name.split(".")[1] == "xls" ||
                        inputFiles[index].name.split(".")[1] == "xlsx"
                    ) {
                        this.documents.extensions.push("excel");
                    } else if (inputFiles[index].name.split(".")[1] == "pdf") {
                        this.documents.extensions.push("pdf");
                    }
                    this.documents.imageFileNameList.push(
                        inputFiles[index].name
                    );
                    URL.revokeObjectURL(inputFiles[index]);
                    this.documents.imageFilePathList.push(inputFiles[index]);
                    console.log('docs',this.documents);
            }
            this.$parent.uploadImages(this.documents);
        },
        deleteInputFiles(index) {
            $("#file").val(null);
            console.log('index', index);
        },
        getLabel() {
            return this.compLabel;
        },
    },
};
</script>
<style scoped>
.imageContainer {
    width: 100%;
    cursor: pointer;
    position: relative;
    margin-top: 10px;
}

.field-document img {
    width: 100%;
    /* height: 100%; */
}

.imageContainer input {
    width: 100%;
    height: 100%;
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
}

#upload-button {
    font-size: 18px;
}
</style>
