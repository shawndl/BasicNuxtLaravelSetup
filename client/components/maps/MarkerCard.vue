<template>
    <div class="card">
        <div class="row">
            <div class="col-md-4">
                <div class="card-img-bottom">
                    <img :src="image"
                         alt="Image of the location"
                         style='height: 100%; width: 100%; object-fit: contain'>
                </div>
            </div>
            <div class="col-md-6 offset-md-1">
                <div class="card-block">
                    <h4 class="card-title">
                        {{ title }}
                    </h4>
                    <p class="card-text">
                        {{ description }}
                    </p>
                    <h6>
                        <a class="pull-right" href="#" style="margin-right: 20px">More  <i class="fa fa-angle-right"></i></a>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'description', 'image']
    }
</script>