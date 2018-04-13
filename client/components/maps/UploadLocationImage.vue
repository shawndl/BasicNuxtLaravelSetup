<template>
    <div class="image-cropper">
        <vue-image-crop-upload field="img"
                   @crop-success="cropSuccess"
                   @crop-upload-success="cropUploadSuccess"
                   @crop-upload-fail="cropUploadFail"
                   lang-type="en"
                   v-model="show"
                   :width="200"
                   :height="550"
                   url="/api/upload"
                   noCircle="true"
                   :params="params"
                   :headers="headers"
                   img-format="png">

        </vue-image-crop-upload>
    </div>
</template>

<script>
//    import "babel-polyfill";
    import VueImageCropUpload from "vue-image-crop-upload";

    export default {
        props: {
            showUpload: {
                required: true,
                type: Boolean
            }
        },

        data : function() {
            return {
                show: true,
                headers: {
                    smail: '*_~'
                },
                params: {
                    token: '123456798',
                    name: 'image'
                },
                imgDataUrl: ''
            }
        },

        components: {
            VueImageCropUpload
        },

        watch: {
            showUpload: function (value) {
                this.show = value;
            },

            show: function (value) {
                this.$emit('update-show', value);
            }
        },

        mounted() {
            this.show = this.showUpload;
        },

        methods: {
            /**
             * crop success
             *
             * [param] imgDataUrl
             * [param] field
             */
            cropSuccess(imgDataUrl, field){
                console.log('-------- crop success --------');
                this.imgDataUrl = imgDataUrl;
            },
            /**
             * upload success
             *
             * [param] jsonData  server api return data, already json encode
             * [param] field
             */
            cropUploadSuccess(jsonData, field){
                console.log('-------- upload success --------');
                console.log(jsonData);
                console.log('field: ' + field);
            },
            /**
             * upload fail
             *
             * [param] status    server api return error status, like 500
             * [param] field
             */
            cropUploadFail(status, field){
                console.log('-------- upload fail --------');
                console.log(status);
                console.log('field: ' + field);
            }
        }
    }
</script>

