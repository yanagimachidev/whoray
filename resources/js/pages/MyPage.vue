<template>
    <transition name="mode-fade" mode="out-in">
        <div style="height:80px; width:80px;">
            <div v-if="!user.profile_image" class="bg-secondary rounded-circle" style="height:80px; width:80px;"></div>
            <img v-else :src="user.profile_image" class="rounded-circle" style="height:80px; width:80px;">
            <div class="bg-primary rounded-circle text-center" style="height:25px; width:25px; position:relative; bottom:25px; left:55px">
                <a href="/profileimage">
                    <v-fa :icon="['fas', 'pencil-alt']" class="align-middle text-white" />
                </a>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data () {
        return {
            user: []
        }
    },
    methods: {
        async fetchMyInfo () {
            const response = await axios.get('/mypageinfo');
            this.user = response.data;
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchMyInfo();
            },
            immediate: true
        }
    }
}
</script>