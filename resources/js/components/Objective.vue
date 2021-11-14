<template>
    <div class="card mb-2">
        <div class="card-header bg-primary text-white p-2">目的：{{obj.name}}</div>
        <div class="card-body p-1">
            <div>ステータス：{{obj.status}}</div>
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
            keyResults: [],
            isKrButton: true
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