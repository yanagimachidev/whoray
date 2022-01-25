<template>
    <div class="card mb-2">
        <div v-if="isKrUpdate" class="card-header bg-success text-white p-2">目標：
            <input name="name" type="text" class="form-control mb-1 w-50" v-model="kName">
        </div>
        <div v-else class="card-header bg-success text-white p-2">目標：{{kr.name}}</div>
        <div class="card-body p-1">
            <div>
                <table class="w-100">
                    <tr v-if="isKrUpdate" class="w-100">
                        <td class="w-50">ステータス
                            <select name="status" class="form-control w-100" v-model="kStatus">
                                <option value="積み上げ中">積み上げ中</option>
                                <option value="休止">休止</option>
                                <option value="達成">達成</option>
                                <option value="取り下げ">取り下げ</option>
                            </select>
                        </td>
                        <td class="w-100 align-bottom text-right">
                            <button type="button" @click="keyResultStatusUpdate" class="btn btn-primary p-1">保存</button>
                            <button type="button" @click="toNotIsKrUpdate" class="btn btn-danger p-1">キャンセル</button>
                        </td>
                    </tr>
                    <tr v-else class="w-100">
                        <td class="w-75">ステータス：{{kr.status}}</td>
                        <td class="w-100 text-right">
                            <button type="button" @click="toIsKrUpdate" class="p-0 m-0 btn btn-link">編集</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div>獲得経験値：{{kr.experience}} exp</div>
        </div>
        <div class="card-footer bg-light p-0">
            <div>
                <Action
                    v-for="action in actions"
                    :key="action.id"
                    :act="action"
                />
            </div>
            <transition name="mode-fade" mode="out-in">
                <div class="w-100 mt-2" v-if="isActButton" key="button">
                    <button type="button" @click="isActButton = false" class="btn border-0 bg-danger text-white mb-2 ml-2">アクションを追加</button>
                </div>
                <div class="okra-form card mt-2" v-else key="form">
                    <div class="card-header bg-danger text-white p-2">アクション</div>
                    <div class="card-body p-1">
                        <form class="form" @submit.prevent="actionSetting">
                            <input name="name" type="text" class="form-control mb-1" v-model="aName">
                            <label for="category" class="m-0">単位</label>
                            <input name="name" type="text" class="form-control mb-1" v-model="aUnit">
                            <div class="w-100 mt-1 text-right">
                                <button type="submit" class="btn bg-danger text-white">登録</button>
                            </div>
                        </form>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import Action from '../components/Action.vue'

export default {
    props: {
        kr: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            aName: '',
            aUnit: '',
            actions: [],
            kName: '',
            kStatus: '',
            isActButton: true,
            isKrUpdate: false
        }
    },
    components: {
        Action
    },
    methods: {
        async fetchActions () {
            if(this.kr.actions){
                this.actions = this.kr.actions;
            }
        },

        async actionSetting () {
            const response = await axios.post(`/action`, {
                objectiveId: this.kr.objective_id,
                keyResultId: this.kr.id,
                name: this.aName,
                unit: this.aUnit
            });

            this.aName = '';
            this.aUnit = '';

            this.actions.push(response.data);
            this.isActButton = true;
        },

        async keyResultStatusUpdate () {
            const response = await axios.post(`/keyresultstatusupdate`, {
                keyResultId: this.kr.id,
                name: this.kName,
                status: this.kStatus
            });

            location.reload();
        },

        toIsKrUpdate () {
            this.kName = this.kr.name;
            this.kStatus = this.kr.status;
            this.isKrUpdate = true;
        },

        toNotIsKrUpdate () {
            this.isKrUpdate = false;
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