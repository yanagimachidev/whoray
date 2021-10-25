<template>
    <div class="card mt-2">
        <div class="card-header bg-success text-white p-2">目標：{{kr.name}}</div>
        <div class="card-body p-1">
            <span>
                {{kr.status}} /
            </span>
            <span>
                経験値：{{kr.experience}} exp
            </span>
        </div>
        <div class="card-footer bg-light p-2">
            <div>
                <Action
                    v-for="action in actions"
                    :key="action.id"
                    :act="action"
                />
            </div>
            <transition name="mode-fade" mode="out-in">
                <div class="w-100 mt-2" v-if="isActButton" key="button">
                    <button type="button" @click="isActButton = false" class="btn border-0 bg-danger text-white">アクションを追加</button>
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
            isActButton: true
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