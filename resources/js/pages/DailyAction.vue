<template>
    <transition name="mode-fade" mode="out-in">
        <div class="container">
            <div v-if="isDataGet">
                <form class="form" @submit.prevent="actionPost">
                    <ul class="list-group">
                        <li class="list-group-item active">
                            <table class="w-100">
                                <tr>
                                    <td class="text-left">積み上げ登録</td>
                                    <td v-if="inputFlg" class="text-right">未振り分け経験値：{{experience}}</td>
                                </tr>
                            </table>
                        </li>
                        <li class="list-group-item">
                            <input type="date" class="form-control text-center" v-model="actionDate" @change="fetchActions">
                        </li>
                        <li class="list-group-item" v-for="action in actions" :key="action.id">
                            <div>{{action.name}}</div>
                            <table>
                                <tr>
                                    <td style="width:65px" class="pr-1">
                                        <span>
                                            経験値
                                        </span>
                                    </td>
                                    <td class="text-right" style="width:100px">
                                        <span v-if="inputFlg" key="experienceInput">
                                            <input type="text" class="form-control text-right" v-model="action.experience">
                                        </span>
                                        <span v-else key="experienceOutput">
                                            {{action.experience}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="pl-1">
                                            exp
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:65px" class="pr-1">
                                        <span>
                                            積み上げ
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <span v-if="inputFlg" key="countInput">
                                            <input type="text" class="form-control text-right" v-model="action.count">
                                        </span>
                                        <span v-else key="countOutput">
                                            {{action.count}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="pl-1">
                                            {{action.unit}}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </li>
                        <li class="list-group-item">
                            <div>【本日の一言】</div>
                            <div v-if="inputFlg" key="textareaInput">
                                <textarea class="form-control" v-model="actionText"></textarea>
                            </div>
                            <div v-else key="textareaOutput">
                                <p v-html="actionText"></p>
                            </div>
                        </li>
                        <li class="list-group-item" v-if="inputFlg" key="button">
                            <div class="w-100 mt-1 text-center">
                                <button type="submit" class="btn bg-primary text-white">積み上げ</button>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data () {
        return {
            actions:[],
            actionText: '',
            actionDate: new Date().getFullYear() + '-'
                + ('00' + (new Date().getMonth()+1)).slice(-2) + '-'
                + ('00' + new Date().getDate()).slice(-2),
            inputFlg: true,
            isDataGet: false
        }
    },
    methods: {
        async fetchActions () {
            const response = await axios.get('/actionpost?postdate=' + this.actionDate);
            const tdate = new Date();
            const tdateStr = tdate.getFullYear() + '-'
                + ('00' + (tdate.getMonth()+1)).slice(-2) + '-'
                + ('00' + tdate.getDate()).slice(-2);
            const ydate = new Date();
            ydate.setDate(ydate.getDate() - 1);
            const ydateStr = ydate.getFullYear() + '-'
                + ('00' + (ydate.getMonth()+1)).slice(-2) + '-'
                + ('00' + ydate.getDate()).slice(-2);
            if(new Date(this.actionDate) < new Date(ydateStr) || new Date(this.actionDate) > new Date(tdateStr)){
                this.inputFlg = false;
            }else{
                this.inputFlg = true;
            }
            if(typeof(response.data.action_summary) != 'undefined'){
                this.inputFlg = false;
            }
            this.actions = response.data.actions;
            this.actionText = response.data.action_text;
            this.isDataGet = true;
        },

        async actionPost () {
            if(this.experience < 0){
                alert("経験値は1日100expまでしか割り振れません");
            }else{
                const response = await axios.post(`/actionpost`, {
                    actionText: this.actionText,
                    actionDate: this.actionDate,
                    actions: this.actions
                });
                this.inputFlg = false;
            }
        }
    },
    computed: {
        experience: function () {
            let inputExSum = 0;
            this.actions.forEach(action => {
                inputExSum = inputExSum + Number(action.experience);
            });
            return 100 - inputExSum;
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchActions();
            },
            immediate: true
        }
    }
}
</script>