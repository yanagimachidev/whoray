<template>
    <div>
        <div>
            <objective
                v-for="objective in objectives"
                :key="objective.id"
                :obj="objective"
            />
        </div>
        <transition name="mode-fade" mode="out-in">
            <div class="w-100 m-2" v-if="isObjButton" key="button">
                <button type="button" @click="isObjButton = false" class="btn border-0 bg-primary text-white">目的を追加</button>
            </div>
            <div class="okra-form card mt-2" v-else key="form">
                <div class="card-header bg-primary text-white p-2">目的</div>
                <div class="card-body p-1">
                    <form class="form" @submit.prevent="objectiveSetting">
                        <input name="name" type="text" class="form-control mb-1" v-model="oName">
                        <label for="category" class="m-0">カテゴリ</label>
                        <select name="category" class="form-control" v-model="oCategory">
                            <option value="勉強">勉強</option>
                            <option value="ボディメイク">ボディメイク</option>
                            <option value="ビジネス">ビジネス</option>
                            <option value="お金">お金</option>
                            <option value="趣味">趣味</option>
                            <option value="その他">その他</option>
                        </select>
                        <div class="w-100 mt-1 text-right">
                            <button type="submit" class="btn bg-primary text-white">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import Objective from '../components/Objective.vue'

export default {
    data () {
        return {
            oName: '',
            oCategory: '',
            objectives: [],
            isObjButton: true
        }
    },
    components: {
        Objective
    },
    methods: {
        async fetchObjectives () {
            const response = await axios.get('/okra');
            this.objectives = response.data[0].objectives;
        },

        async objectiveSetting () {
            const response = await axios.post(`/objective`, {
                name: this.oName,
                category: this.oCategory
            });

            this.oName = '';
            this.oCategory = '';

            await this.fetchObjectives();
            this.isObjButton = true;
        }
    },
    watch: {
        $route: {
            async handler () {
                await this.fetchObjectives();
            },
            immediate: true
        }
    }
}
</script>