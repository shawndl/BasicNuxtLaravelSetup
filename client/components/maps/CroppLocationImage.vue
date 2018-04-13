<template>
    <div class="full-screen">
        <b-row class="mt-3 mb-3">
            <b-col :offset="1" :cols="5">
                <croppa v-model="croppa"
                        :width="200"
                        :height="300"
                        :accept="'image/*'"
                        :zoom-speed="4"
                        :placeholder-font-size="0"
                        :placeholder-color="'default'">

                </croppa>
            </b-col>
            <b-col :cols="5">
                <div style="vertical-align: center">
                    <b-card title="Modify the Image"
                            sub-title="Use the controls below to alter how the image will be displayed">
                        <div class="card-body">
                            <button @click="croppa.zoomIn()">zoom in</button>
                            <button @click="croppa.zoomOut()">zoom out</button>
                            <button @click="croppa.rotate()">rotate 90deg</button>
                            <button @click="croppa.rotate(2)">rotate 180deg</button>
                            <button @click="croppa.rotate(-1)">rotate -90deg</button>
                            <button @click="croppa.flipX()">flip horizontally</button>
                            <button @click="croppa.flipY()">flip vertically</button>

                        </div>
                        <div class="card-footer">
                            <button type="button"
                                    class="btn btn-success" @click="sendImage">Save</button>
                            <button type="button"
                                    class="btn btn-danger float-right"
                                    @click="$emit('close-screen')">Cancel</button>
                        </div>

                    </b-card>
                </div>

            </b-col>
            <b-col>
                <button type="button" @click="$emit('close-screen')">Close</button>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        data : function() {
            return {
                croppa: {},
                file: null
            }
        },

        methods: {
            sendImage() {
                this.setFile();
                setTimeout(() => {
                    this.$emit('get-images', {
                        raw: this.croppa.generateDataUrl(),
                        file: this.file
                    });
                }, 500);
                this.$emit('close-screen');
            },

            setFile(type) {
                this.croppa.generateBlob((blob) => {
                    blob.lastModifiedDate = new Date();
                    blob.name = 'uploadImage';
                    this.file = blob;
                }, type)
            }
        }
    }
</script>

<style>
    .full-screen{
        position:fixed;
        padding:0;
        margin:0;
        z-index: 10000;
        top:0;
        left:0;

        width: 100%;
        height: 100%;
        background: whitesmoke;
    }
</style>
