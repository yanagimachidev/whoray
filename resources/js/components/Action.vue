<template>
    <div class="card">
        <div class="card-header bg-danger text-white p-2">アクション：{{act.name}}</div>
        <div class="card-body p-1">
            <div>ステータス：{{act.status}}</div>
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
    }
}
</script>