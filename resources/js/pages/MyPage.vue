<template>
    <transition name="mode-fade" mode="out-in">
        <div class="container">
            <table>
                <tr>
                    <td>
                        <div style="height:80px; width:80px;">
                            <div v-if="!user.profile_image" class="bg-secondary rounded-circle" style="height:80px; width:80px;"></div>
                            <img v-else :src="user.profile_image" class="rounded-circle" style="height:80px; width:80px;">
                            <div class="bg-primary rounded-circle text-center" style="height:25px; width:25px; position:relative; bottom:25px; left:55px">
                                <a href="/profileimage">
                                    <v-fa :icon="['fas', 'pencil-alt']" class="align-middle text-white" />
                                </a>
                            </div>
                        </div>
                    </td>
                    <td class="">
                        <div class="pl-3">ユーザ名：{{user.name}}</div>
                        <div class="pl-3">総獲得経験値：{{user.experience}}</div>
                    </td>
                </tr>
            </table>
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
            if(!this.user.experience){
                this.user.experience = 0;
            }
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