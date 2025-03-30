<template>
    <a v-if="isExternalLink" :href="to">
        <slot></slot>
    </a>
    <router-link v-else v-bind="$props">
        <slot></slot>
    </router-link>
</template>

<script>
import { RouterLink } from 'vue-router';
export default {
    props: {
        ...RouterLink.props
    },
    computed: {
        isExternalLink() {
            return typeof this.to === 'string' && this.to.startsWith('http')
        }
    }
}
</script>