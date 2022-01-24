<template>
    <transition name="mode-fade" mode="out-in">
        <div class="container">
            <div v-if="isDataGet">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">ユーザー情報編集</div>

                            <div class="card-body">
                                <form @submit.prevent="myInfoUpdate">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">ユーザー名</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control" name="name" v-model="myName" required autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" v-model="myEmail" required>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">更新</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data () {
        return {
            user: [],
            myName: '',
            myEmail: '',
            isDataGet: false
        }
    },
    methods: {
        async fetchMyInfo () {
            const response = await axios.get('/mypageinfo');
            this.user = response.data;
            this.myName = this.user.name;
            this.myEmail = this.user.email;
            this.isDataGet = true;
        },

        async myInfoUpdate () {
            const response = await axios.post(`/myinfoupdate`, {
                name: this.myName,
                email: this.myEmail
            });

            this.$router.push('mypage');
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