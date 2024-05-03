<script setup>
import { ref } from "vue";
import { useIntersectionObserver } from "@vueuse/core";

defineProps({
    posts: {
        type: Object,
        required: true,
    },
});

const lastElement = ref(null);

useIntersectionObserver(lastElement, ([{ isIntersecting }]) => {
    if (!isIntersecting) {
        return;
    }
});
</script>

<template>
    <div class="max-w-2xl mx-auto my-12 space-y-12">
        <div v-for="post in posts.data" :key="post.id">
            <h1 class="font-bold text-3xl">{{ post.id }}: {{ post.title }}</h1>
            <p class="mt-2 text-lg">{{ post.teaser }}</p>
        </div>
        <div ref="lastElement"></div>
    </div>
</template>
