import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import Timeline from './pages/Timeline.vue'
import DailyAction from './pages/DailyAction.vue'
import OkraSetting from './pages/OkraSetting.vue'
import MyPage from './pages/MyPage.vue'
import ProfileImage from './pages/ProfileImage.vue'

// VueRouterプラグインを使用する
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/home',
        component: Timeline
    },
    {
        path: '/dailyaction',
        component: DailyAction
    },
    {
        path: '/okrasetting',
        component: OkraSetting
    },
    {
        path: '/mypage',
        component: MyPage
    },
    {
        path: '/profileimage',
        component: ProfileImage
    }

]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history', //URLの#を削除する
    routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router