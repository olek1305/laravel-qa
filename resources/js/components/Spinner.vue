<template>
    <div class="spinner">
        <i class="fa fa-spinner fa-spin" :class="sizeClass" :style="getMinWidth"></i>
    </div>
</template>
<style scoped>
    .spinner {
        color: #ddd;
        text-align: center;
    }
</style>
<script>
export default {
    props: {
        small: {
            type: Boolean,
            default: false
        },
        minWidth: {
            type: Number,
            default: 109.61
        }
    },

    computed: {
        sizeClass () {
            return this.small ? '' : 'fa-3x'
        },
        getMinWidth () {
            return {
                minWidth: this.minWidth + 'px'
            }
        }
    }
}
</script>
