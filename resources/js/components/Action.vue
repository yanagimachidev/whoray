<template>
    <div class="card mt-2">
        <div class="card-header bg-danger text-white p-2">アクション：{{act.name}}</div>
        <div class="card-body p-1">
            <span>
                {{act.status}} /
            </span>
            <span>
                経験値：{{act.experience}} exp /
            </span>
            <span>
                積み上げ：{{act.count}} {{act.unit}}
            </span>
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