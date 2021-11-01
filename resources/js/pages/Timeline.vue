<template>
    <transition name="mode-fade" mode="out-in">
        <div>
            <ul class="list-group mb-2" v-for="item in items" :key="item.id">
                <li class="list-group-item active">
                    {{item.user.name}}さんの {{item.action_date}} の積み上げ
                </li>
                <li class="list-group-item" v-for="action in item.action_summary" :key="action.id">
                    <div>{{action.name}}</div>
                    <table>
                        <tr>
                            <td style="width:65px" class="pr-1">
                                <span>
                                    経験値
                                </span>
                            </td>
                            <td class="text-right" style="width:100px">
                                <span>
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
                                <span>
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
                    <div>
                        <p>{{item.action_text}}</p>
                    </div>
                </li>
            </ul>
            <infinite-loading @infinite="infiniteHandler" spinner="spiral">
                <!--div slot="spinner">ロード中...</div-->
                <div slot="no-more">データがありません</div>
                <div slot="no-results">データがありません</div>
            </infinite-loading>
        </div>
    </transition>
</template>

<script>
export default {
    data () {
        return {
            items: [],
            itemCnt:1,
            page: 1,
        }
    },
    methods: {
        async fetchItems () {
            const response = await axios.get('/timeline?page=' + this.page);
            this.itemCnt = response.data.last_page;
            this.items.push(response.data.data[0]);
            this.page++;
            //console.log(this.items);
        },

        async infiniteHandler($state) {
            //console.log(this.page);
            if (this.itemCnt >= this.page) {
                await this.fetchItems();
                $state.loaded();
            } else {
                $state.complete();
            }
        }
    }
}
</script>