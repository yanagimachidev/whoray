<template>
    <div class="card mb-2">
        <div v-if="isObjUpdate" class="card-header bg-primary text-white p-2">目的：
            <input name="name" type="text" class="form-control mb-1 w-50" v-model="oName">
        </div>
        <div v-else class="card-header bg-primary text-white p-2">目的：{{obj.name}}</div>
        <div class="card-body p-1">
            <div>
                <table class="w-100">
                    <tr v-if="isObjUpdate" class="w-100">
                        <td class="w-50">ステータス
                            <select name="status" class="form-control w-100" v-model="oStatus">
                                <option value="積み上げ中">積み上げ中</option>
                                <option value="休止">休止</option>
                                <option value="達成">達成</option>
                                <option value="取り下げ">取り下げ</option>
                            </select>
                        </td>
                        <td class="w-100 align-bottom text-right">
                            <button type="button" @click="objectStatusUpdate" class="btn btn-primary p-1">保存</button>
                            <button type="button" @click="toNotIsObjUpdate" class="btn btn-danger p-1">キャンセル</button>
                        </td>
                    </tr>
                    <tr v-else class="w-100">
                        <td class="w-75">ステータス：{{obj.status}}</td>
                        <td class="w-100 text-right">
                            <button type="button" @click="toIsObjUpdate" class="p-0 m-0 btn btn-link">編集</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div>カテゴリー：{{obj.category}}</div>
            <div>獲得経験値：{{obj.experience}} exp</div>
        </div>
        <div class="card-footer bg-light p-0">
            <div>
                <KeyResult
                    v-for="keyResult in keyResults"
                    :key="keyResult.id"
                    :kr="keyResult"
                />
            </div>
            <transition name="mode-fade" mode="out-in">
                <div class="w-100 mt-2" v-if="isKrButton" key="button">
                    <button type="button" @click="isKrButton = false" class="btn border-0 bg-success text-white mb-2 ml-2">目標を追加</button>
                </div>
                <div class="okra-form card mt-2" v-else key="form">
                    <div class="card-header bg-success text-white p-2">目標</div>
                    <div class="card-body p-1">
                        <form class="form" @submit.prevent="keyResultSetting">
                            <input name="name" type="text" class="form-control mb-1" v-model="kName">
                            <div class="w-100 mt-1 text-right">
                                <button type="submit" class="btn bg-success text-white">登録</button>
                            </div>
                        </form>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import KeyResult from '../components/KeyResult.vue'

export default {
    props: {
        obj: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            kName: '',
            oStatus: '',
            oName: '',
            keyResults: [],
            isKrButton: true,
            isObjUpdate: false
        }
    },
    components: {
        KeyResult
    },
    methods: {
        async fetchKeyResults () {
            if(this.obj.key_results){
                this.keyResults = this.obj.key_results;
            }
        },

        async keyResultSetting () {
            const response = await axios.post(`/keyresult`, {
                objectiveId: this.obj.id,
                name: this.kName
            });

            this.kName = '';

            this.keyResults.push(response.data);
            this.isKrButton = true;
        },

        async objectStatusUpdate () {
            const response = await axios.post(`/objectivestatusupdate`, {
                objectiveId: this.obj.id,
                name: this.oName,
                status: this.oStatus
            });

            location.reload();
        },

        toIsObjUpdate () {
            this.oName = this.obj.name;
            this.oStatus = this.obj.status;
            this.isObjUpdate = true;
        },

        toNotIsObjUpdate () {
            this.isObjUpdate = false;
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchKeyResults();
            },
            immediate: true
        }
    }
}
</script>