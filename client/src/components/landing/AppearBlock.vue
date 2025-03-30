<template>
    <div ref="block" class="animated-block" :class="{ visible: showBlock }">
        <slot></slot>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const block = ref(null)
const showBlock = ref(false)

onMounted(() => {
    const observer = new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                showBlock.value = true
                observer.disconnect()
            }, 250);

        }
    }, { threshold: 0.2 })

    observer.observe(block.value)
})
</script>

<style scoped>
.animated-block {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.animated-block.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>