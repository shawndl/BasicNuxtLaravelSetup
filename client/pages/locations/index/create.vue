<template>
    <div class="google-maps-box">
        <div v-show="showUpload">
            <crop-image-location @close-screen="showUpload = false" @get-images="imageAdded">

            </crop-image-location>
        </div>

        <div class="google-maps-form">
            <form class="form-horizontal"
                  method="post"
                  novalidate
                  @submit.prevent="beforeSubmit">
                <slot></slot>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text"
                                   class="form-control"
                                   name="title"
                                   v-model="form.title"
                                   id="title"
                                   aria-describedby="helpTitle">
                        </div>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="types">Type: </label>
                            <select class="form-control"
                                    id="types" v-if="types"
                                    size="5" v-model="form.type">
                               <option v-for="type in types"
                                       v-bind:key="type.id" :value="type.id">{{ type.name }}</option>
                            </select>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="latitude">Latitude: </label>
                            <input type="text"
                                   class="form-control"
                                   name="latitude"
                                   id="latitude"
                                   v-model="form.latitude"
                                   readonly>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="longitude">longitude</label>
                            <input type="text"
                                   class="form-control"
                                   name="longitude"
                                   id="longitude"
                                   v-model="form.longitude"
                                   readonly>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <textarea type="text"
                                      class="form-control"
                                      rows="2"
                                      name="description"
                                      v-model="form.description"
                                      id="description"
                                      placeholder="Please write a description">
                            </textarea>
                        </div><!-- /.form-group -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
                <div class="row">
                    <button type="button" class="btn btn-primary" @click="toggleUpload">Upload Image</button>
                </div><!-- /.row -->
                <button type="submit" class="btn btn-success" style="margin-top: 20px">Submit</button>
            </form>
        </div><!-- /.col -->
        <div class="mt-3">
            <view-google-maps :lat="form.latitude"
                              :lng="form.longitude"
                              :title="form.title"
                              :description="form.description"
                              :image="form.image"
                              zoom="3"
                              @user_clicked="setLongitudeAndLatitude">

            </view-google-maps>
        </div>
    </div><!-- /.row -->
</template>

<script>
    import ViewGoogleMaps from '../../../components/maps/ViewGoogleMaps.vue';
    import CropImageLocation from '../../../components/maps/CroppLocationImage.vue';


    export default {
         middleware: ['auth'],

        components: {
            ViewGoogleMaps, CropImageLocation
        },

        data : function() {
            return {
                form: {
                    title: null,
                    description: null,
                    latitude: null,
                    longitude: null,
                    image: null,
                    file: null,
                    type: null
                },
                showUpload: false,
                types: []
            }
        },

        mounted(){
            if(this.latitude) {
                this.form.latitude = this.latitude;
                this.form.longitude = this.longitude;
                this.form.title = this.title;
                this.form.description = this.description;
            }
            this.$axios.get('location/types')
                .then(response => {
                    this.types = response.data.data;
                });
        },

        methods: {
            toggleUpload() {
                this.showUpload = !this.showUpload;
            },

            /**
             * sets longitude and latitude and creates a marker
             * @param event
             * @return void
             */
            setLongitudeAndLatitude(event) {
                this.form.latitude = event.latLng.lat();
                this.form.longitude = event.latLng.lng()
            },

            /**
             * Adds an image
             * @return {boolean}
             */
            imageAdded(event) {
                this.form.image = event.raw;
                this.form.file = event.file;
            },

            /**
             * prevents the form from being submitted unless it passes validation
             * @return {boolean}
             */
            beforeSubmit(event) {
                event.preventDefault();
                const data = new FormData();
                data.append('name', this.form.title);
                data.append('description', this.form.description);
                data.append('latitude', this.form.latitude);
                data.append('longitude', this.form.longitude);
                data.append('image', this.form.file);
                data.append('type', this.form.type);

                this.$axios.post('location', data)
                    .then((response) => this.$router.push('/locations'));
            }
        }
    }
</script>

<style scoped>
    .google-maps-box {
        position: relative;
    }

    .google-maps-form {
        position: absolute;
        top: 50px;
        left: 20px;
        border: 1px solid #000;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        border-radius: 20px;
        background-color: snow;
        z-index: 1000;
        padding: 20px;
        width: 400px;
    }

</style>