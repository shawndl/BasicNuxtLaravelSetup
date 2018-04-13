<template>
    <div>
        <div class="mt-3 mb-3">
            <b-row>
                <b-col>
                    <label for="search">Search by Type</label>
                    <input class="form-control"
                           type="text"
                           v-model="search"
                           placeholder="Enter a name to search">
                </b-col>
                <b-col>
                    <div class="form-group" v-if="types">
                        <label for="type">Search by Type</label>
                        <select class="form-control" id="type" v-model="type">
                            <option :value="null" selected>None</option>
                            <option v-for="type in types"
                                    v-bind:key="type.id"
                                    :value="type.id">
                                {{ type.name }}
                            </option>
                        </select>
                    </div>
                </b-col>
                <b-col>
                    <label for="type">Search Around my Location</label>
                    <br>
                    <button @click="aroundUser">Go to my location</button>
                </b-col>
            </b-row>
        </div>
        <gmap-map :center="position"
                  :zoom="zoom"
                  :options="{styles: mapStyles}"
                  map-type-id="terrain"
                  style="width: 95vw; height: 100vh">
            <gmap-marker v-if="locations"
                         v-for="location in filterResults"
                         v-bind:key="location.id"
                         :position="{lat: parseFloat(location.latitude), lng: parseFloat(location.longitude)}"
                         :clickable="true" @click="show = location.id">
                <gmap-info-window v-if="show === location.id" @closeclick="show = null">
                    <marker-card :title="location.title"
                                 :description="location.description"
                                 :image="location.image.path">

                    </marker-card>
                </gmap-info-window>
            </gmap-marker>
        </gmap-map>
    </div>
</template>

<script>
    import MarkerCard from '../../../components/maps/MarkerCard.vue';
    export default {
        components: {
            MarkerCard
        },

        data : function() {
            return {
                locations: [],
                types: [],
                mapStyles: [
                    {
                        "featureType":"administrative",
                        "elementType":"labels.text.fill",
                        "stylers":[
                            {"color":"#444444"}
                        ]
                    },{
                        "featureType":"landscape",
                        "elementType":"all",
                        "stylers":[{"color":"#f2f2f2"}]
                    }, {
                        "featureType":"poi",
                        "elementType":"all",
                        "stylers":[{"visibility":"off"}]
                    }, {
                        "featureType":"road",
                        "elementType":"all",
                        "stylers":
                            [{"saturation":-100},{"lightness":45}]},
                    {
                        "featureType":"road.highway",
                        "elementType":"all",
                        "stylers":[{"visibility":"simplified"}]},
                    {
                        "featureType":"road.arterial",
                        "elementType":"labels.icon",
                        "stylers":[{"visibility":"off"}]},
                    {
                        "featureType":"transit",
                        "elementType":"all",
                        "stylers":[{"visibility":"off"}]},
                    {
                        "featureType":"water",
                        "elementType":"all",
                        "stylers":[{"color":"#4f595d"},{"visibility":"on"}]
                    }
                ],
                show: null,
                type: null,
                search: null,
                zoom: 3,
                position: {
                    lat: 0,
                    lng: 0
                }
            }
        },

        computed: {
            filterResults: function () {
                if (this.type && this.search)
                {
                    return this.locations.filter((location) => {
                        return (location.title.includes(this.search) && location.type.id === this.type);
                    });
                }

                if (this.type) {
                    return this.locations.filter((location) => {
                        return location.type.id === this.type;
                    });
                }

                if (this.search) {
                    return this.locations.filter((location) => {
                        return location.title.includes(this.search);
                    });
                }

                return this.locations;
            }

        },

        mounted() {
            this.$axios.get('location').then(response => {
                this.locations = response.data.data;
            });
            this.$axios.get('location/types')
                .then(response => {
                    this.types = response.data.data;
                });
        },

        methods: {
            aroundUser() {
                if (navigator.geolocation) {
                    let self = this;
                    navigator.geolocation.getCurrentPosition(function(position) {
                        console.log(position);
//                        self.zoom = 5;
//                        self.position = {
//                            lat: position.coords.latitude,
//                            lng: position.coords.longitude
//                        };

                    });
                }
            }
        }
    }
</script>