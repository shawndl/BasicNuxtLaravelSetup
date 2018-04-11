<template>
    <div>
        <h1>User Page</h1>
        <b-table striped hover
                 v-if="users"
                 :items="users">
            <template slot="is_admin" slot-scope="row">
                <div class="onoffswitch">
                    <input type="checkbox"
                           name="onoffswitch"
                           class="onoffswitch-checkbox"
                           :value="row.item.id"
                           :id="'myonoffswitch_' + row.item.name"
                           :checked="row.value" @change="changeAdminStatus">
                    <label class="onoffswitch-label" :for="'myonoffswitch_' + row.item.name">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>
            </template>
            <template slot="name" slot-scope="row">
                <a :href="'/admin/users/' + row.value.toLowerCase()" class="link">{{ row.value }}</a>
            </template>
        </b-table>
        <loading v-else></loading>
        <b-col cols="6" offset="3">
            <b-pagination v-if="meta"
                          size="md"
                          :total-rows="meta.total"
                          v-model="meta.current_page"
                          :per-page="meta.perPage"
                          thead-class=""
                          @change="onPaginate"
                          @head_click="sortChange">

            </b-pagination>
        </b-col>
    </div>
</template>

<script>
    import Loading from '../../../../components/functionality/animations/Loading.vue';

    export default {
        components: {
            Loading
        },

        data : function() {
            return {
                users: null,
                links: null,
                meta: null
            }
        },

        created() {
            this.getUsers(1);
        },

        methods: {
            /**
             * get users from the database
             * @param page
             * @return void
             */
            getUsers(page = 1) {
                this.$axios.get('admin/user?page=' + page)
                    .then(response => {
                        this.users = response.data.data
                        this.links = response.data.links;
                        this.meta = response.data.meta;
                    });
            },

            /**
             * when the user clicks pagination update the users form
             * @param event
             * @return void
             */
            onPaginate(event){
                this.getUsers(event);
            },

            sortChange(event) {
                condole.log(event);
            },

            /**
             * change a users admin access
             * @param event
             * @return void
             */
            changeAdminStatus(event) {
                this.$axios.post('/admin/user/admin-access', {user_id: event.target.value, access: event.target.checked});
            }
        }
    }
</script>

<style scoped>
    .onoffswitch {
        position: relative; width: 90px;
        -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    }
    .onoffswitch-checkbox {
        display: none;
    }
    .onoffswitch-label {
        display: block; overflow: hidden; cursor: pointer;
        border: 2px solid #999999; border-radius: 20px;
    }
    .onoffswitch-inner {
        display: block; width: 200%; margin-left: -100%;
        transition: margin 0.3s ease-in 0s;
    }
    .onoffswitch-inner:before, .onoffswitch-inner:after {
        display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
        font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
        box-sizing: border-box;
    }
    .onoffswitch-inner:before {
        content: "ON";
        padding-left: 10px;
        background-color: #34A7C1; color: #FFFFFF;
    }
    .onoffswitch-inner:after {
        content: "OFF";
        padding-right: 10px;
        background-color: #EEEEEE; color: #999999;
        text-align: right;
    }
    .onoffswitch-switch {
        display: block; width: 18px; margin: 6px;
        background: #FFFFFF;
        position: absolute; top: 0; bottom: 0;
        right: 56px;
        border: 2px solid #999999; border-radius: 20px;
        transition: all 0.3s ease-in 0s;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
        margin-left: 0;
    }
    .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
        right: 0px;
    }
</style>