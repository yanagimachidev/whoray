<template>
    <div class="card">
        <div v-if="isActUpdate" class="card-header bg-danger text-white p-2">アクション：
            <input name="name" type="text" class="form-control mb-1 w-50" v-model="aName">
        </div>
        <div v-else class="card-header bg-danger text-white p-2">アクション：{{act.name}}</div>
        <div class="card-body p-1">
            <div>
                <table class="w-100">
                    <tr v-if="isActUpdate" class="w-100">
                        <td class="w-50">ステータス
                            <select name="status" class="form-control w-100" v-model="aStatus">
                                <option value="積み上げ中">積み上げ中</option>
                                <option value="休止">休止</option>
                                <option value="取り下げ">取り下げ</option>
                            </select>
                        </td>
                        <td class="w-100 align-bottom text-right">
                            <button type="button" @click="actionStatusUpdate" class="btn btn-primary p-1">保存</button>
                            <button type="button" @click="toNotIsActUpdate" class="btn btn-danger p-1">キャンセル</button>
                        </td>
                    </tr>
                    <tr v-else class="w-100">
                        <td class="w-75">ステータス：{{act.status}}</td>
                        <td class="w-100 text-right">
                            <button type="button" @click="toIsActUpdate" class="p-0 m-0 btn btn-link">編集</button>
                        </td>
                    </tr>
                </table>
            </div>
            <div>獲得経験値：{{act.experience}} exp</div>
            <div>積み上げ量：{{act.count}} {{act.unit}}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        act: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            aName: '',
            aStatus: '',
            isActUpdate: false
        }
    },
    methods: {
        async actionStatusUpdate () {
            const response = await axios.post(`/actionstatusupdate`, {
                actionId: this.act.id,
                name: this.aName,
                status: this.aStatus
            });

            location.reload();
        },

        toIsActUpdate () {
            this.aName = this.act.name;
            this.aStatus = this.act.status;
            this.isActUpdate = true;
        },

        toNotIsActUpdate () {
            this.isActUpdate = false;
        }
    }
}
</script>