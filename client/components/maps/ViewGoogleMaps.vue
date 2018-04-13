<template>
    <gmap-map :center="{lat:0, lng:0}"
              :zoom="parseInt(zoom)"
              :options="{styles: mapStyles}"
              map-type-id="terrain"
              style="width: 95vw; height: 100vh" @click="$emit('user_clicked', $event)">
        <gmap-marker
                v-if="lat"
                :clickable="false"
                :position="{lat: parseFloat(lat), lng: parseFloat(lng)}">
            <gmap-info-window v-if="title">
                <marker-card :title="title"
                             :image="image"
                             :description="description">

                </marker-card>
            </gmap-info-window>
        </gmap-marker>
    </gmap-map>
</template>

<script>
    import MarkerCard from './MarkerCard.vue';

    export default {
        props: {
            lat: {
                required: false,
                type: Number
            },
            lng: {
                required: false,
                type: Number
            },
            title: {
                required: false,
                type: String
            },
            description: {
                required: false,
                type: String
            },
            zoom: {
                required: true,
                type: String,
            },
            image: {
                required: false
            }
        },

        components: {
            MarkerCard
        },

        data () {
            return {
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
            }
        }
    }
</script>

<style>
    .card {
        height: 270px;
        width: 550px;
        overflow: hidden;
    }
    .card-img-bottom img{
        width: 200px;
        height: auto;
    }

    .marker-image {
        max-width: 100%;
        max-height: 100%;
    }
</style>