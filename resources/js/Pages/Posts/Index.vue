<script setup>
import { ref } from "vue";
import { useIntersectionObserver } from "@vueuse/core";
import axios from "axios";

const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
});

const lastElement = ref(null);
const postsData = ref(props.posts.data);
const path = ref(props.posts.meta.path);
const next_cursor = ref(props.posts.meta.next_cursor);

const { stop } = useIntersectionObserver(
    lastElement,
    ([{ isIntersecting }]) => {
        if (!isIntersecting) {
            return;
        }

        // Fetch more posts
        axios
            .get(`${path.value}?cursor=${next_cursor.value}`)
            .then((response) => {
                postsData.value = [...postsData.value, ...response.data.data];
                next_cursor.value = response.data.meta.next_cursor;

                if (!next_cursor.value) {
                    stop();
                }
            });
    }
);
</script>

<template>
    <div class="max-w-2xl mx-auto my-12 space-y-12">
        <div v-for="post in postsData" :key="post.id">
            <h1 class="font-bold text-3xl">{{ post.id }}: {{ post.title }}</h1>
            <p class="mt-2 text-lg">{{ post.teaser }}</p>
        </div>
        <div ref="lastElement" class="-translate-y-32"></div>
    </div>
</template>
