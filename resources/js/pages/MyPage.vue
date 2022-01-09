<template>
    <transition name="mode-fade" mode="out-in">
        <div class="container">
            <div class="w-100 text-center">
                <div style="height:100px; width:100px; margin:auto;">
                    <div v-if="!user.profile_image" class="bg-secondary rounded-circle" style="height:100px; width:100px;"></div>
                    <img v-else :src="user.profile_image" class="rounded-circle" style="height:100px; width:100px;">
                    <div class="bg-primary rounded-circle text-center" style="height:25px; width:25px; position:relative; bottom:25px; left:70px">
                        <a href="/profileimage">
                            <v-fa :icon="['fas', 'pencil-alt']" class="align-middle text-white" />
                        </a>
                    </div>
                </div>
                <div class="mt-1">ユーザ名：{{user.name}}</div>
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
            if(!this.user.study_experience){
                this.user.study_experience = 0;
            }
            if(!this.user.bodymake_experience){
                this.user.bodymake_experience = 0;
            }
            if(!this.user.business_experience){
                this.user.business_experience = 0;
            }
            if(!this.user.money_experience){
                this.user.money_experience = 0;
            }
            if(!this.user.hobby_experience){
                this.user.hobby_experience = 0;
            }
            if(!this.user.life_experience){
                this.user.life_experience = 0;
            }
            if(!this.user.other_experience){
                this.user.other_experience = 0;
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