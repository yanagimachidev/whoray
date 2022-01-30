<template>
    <transition name="mode-fade" mode="out-in">
        <div>
            <ul class="list-group list-group-flush mb-2 border-top border-bottom" v-for="item in items" :key="item.id">
                <li class="list-group-item p-1">
                    <a :href="'/mypage?id=' + item.user.id">
                        <span class="mr-1" style="height:50px; width:50px;">
                            <span v-if="!item.user.profile_image" class="bg-secondary rounded-circle" style="height:50px; width:50px;"></span>
                            <img v-else :src="item.user.profile_image" class="rounded-circle" style="height:50px; width:50px;">
                        </span>
                        {{item.user.name}}さんの {{item.action_date}} の積み上げ
                    </a>
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
                        <p v-html="item.action_text"></p>
                    </div>
                </li>
            </ul>
            <infinite-loading @infinite="infiniteHandler" spinner="spiral">
                <!--div slot="spinner">ロード中...</div-->
                <div slot="no-more">これ以上データはありません</div>
                <div slot="no-results">データがありません</div>
            </infinite-loading>
        </div>
    </transition>
</template>

<script>
export default {
    props: {
        userId: Number
    },
    data () {
        return {
            items: [],
            pageCnt:1,
            page: 1,
        }
    },
    methods: {
        async fetchItems () {
            let queryUserId = '';
            if(this.userId != null){
                queryUserId = '&userid=' + this.userId ;
            }
            const response = await axios.get('/timeline?page=' + this.page + queryUserId);
            this.pageCnt = response.data.last_page;
            this.items = this.items.concat(response.data.data);
            this.page++;
            //console.log(this.items);
        },

        async infiniteHandler($state) {
            //console.log(this.page);
            if (this.pageCnt >= this.page) {
                await this.fetchItems();
                $state.loaded();
            } else {
                $state.complete();
            }
        }
    }
}
</script>