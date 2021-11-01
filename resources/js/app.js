/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

//window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue'
import router from './router'
import App from './App.vue'
import store from './store'
import './bootstrap'

// 無限スクロール
import InfiniteLoading from 'vue-infinite-loading'
Vue.use(InfiniteLoading)

// FontAwesome
import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
// アイコンを読み込み
library.add(fas);
// Vueコンポーネントを作成
Vue.component('v-fa', FontAwesomeIcon);
//Vue.config.productionTip = false
dom.watch();

const app = new Vue({
    el: '#app-content',
    router, // ルーティングの定義を読み込む
    store, // ストアの定義を読み込む
    components: { App }, // ルートコンポーネントの使用を宣言する
    template: '<App />' // ルートコンポーネントを描画する
});

// バーガーメニュー
import { Slide } from 'vue-burger-menu'
Vue.component('slide', Slide);
const burger = new Vue({
    el: '#app-header'
});