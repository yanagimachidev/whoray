<template>
    <div>
        <transition name="mode-fade" mode="out-in">
            <div class="container">
                <div v-if="isDataGet">
                    <div class="w-100 text-center">
                        <div class="m-auto" style="height:100px; width:100px;">
                            <div v-if="!user.profile_image" class="bg-secondary rounded-circle" style="height:100px; width:100px;"></div>
                            <img v-else :src="user.profile_image" class="rounded-circle" style="height:100px; width:100px;">
                            <div v-if="isMyInfo" class="bg-primary rounded-circle text-center" style="height:25px; width:25px; position:relative; bottom:25px; left:70px">
                                <a href="/profileimage">
                                    <v-fa :icon="['fas', 'pencil-alt']" class="align-middle text-white" />
                                </a>
                            </div>
                        </div>
                        <div class="mt-1 text-center">
                            <table class="m-auto">
                                <tr>
                                    <td>ユーザー名：{{user.name}}</td>
                                    <td v-if="isMyInfo">
                                        <div class="ml-1 bg-primary rounded-circle text-center" style="height:25px; width:25px;">
                                            <a href="/myinfoedit">
                                                <v-fa :icon="['fas', 'pencil-alt']" class="align-middle text-white" />
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table border="1" style="border-collapse:collapse" class="w-100 mt-1">
                        <tr>
                            <td class="w-50 text-center">
                                <div>総獲得経験値</div>
                                <div class="lead">{{user.experience}}</div>
                            </td>
                            <td class="w-50 text-center">
                                <div>勉強経験値</div>
                                <div class="lead">{{user.study_experience}}</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 text-center">
                                <div>ボディメイク経験値</div>
                                <div class="lead">{{user.bodymake_experience}}</div>
                            </td>
                            <td class="w-50 text-center">
                                <div class="pl-2">ビジネス経験値</div>
                                <div class="lead">{{user.business_experience}}</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 text-center">
                                <div class="pl-2">お金経験値</div>
                                <div class="lead">{{user.money_experience}}</div>
                            </td>
                            <td class="w-50 text-center">
                                <div class="pl-2">趣味経験値</div>
                                <div class="lead">{{user.hobby_experience}}</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 text-center">
                                <div class="pl-2">生活経験値</div>
                                <div class="lead">{{user.life_experience}}</div>
                            </td>
                            <td class="w-50 text-center">
                                <div class="pl-2">その他経験値</div>
                                <div class="lead">{{user.other_experience}}</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </transition>
        <div v-if="isDataGet" class="mt-3">
            <Timeline :userId="user.id" />
        </div>
    </div>
</template>

<script>
import Timeline from '../pages/Timeline.vue'

export default {
    components: {
        Timeline
    },
    data () {
        return {
            user: [],
            isDataGet: false,
            isMyInfo: false
        }
    },
    methods: {
        async fetchMyInfo () {
            let userId = '';
            if(typeof this.$route.query.id !== 'undefined'){
                userId = '?userid=' + this.$route.query.id;
            }
            const response = await axios.get('/mypageinfo' + userId);
            this.user = response.data;
            this.isDataGet = true;
            if(this.user.id == this.user.myId){
                this.isMyInfo = true;
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