<script setup>
import { ref } from "vue";
import { useIntersectionObserver } from "@vueuse/core";
import { router, usePage } from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
});

const lastElement = ref(null);
const postsData = ref(props.posts.data);

useIntersectionObserver(lastElement, ([{ isIntersecting }]) => {
    if (!isIntersecting) {
        return;
    }

    // Fetch more posts
    axios.get(props.posts.links.next).then((response) => {
        console.log(response.data);
        postsData.value = [...postsData.value, ...response.data.data];
    });
    // router.reload({
    //     data: {
    //         page: props.posts.meta.current_page + 1,
    //     },
    //     onSuccess: () => {
    //         postsData.value = [...postsData.value, ...props.posts.data];
    //     },
    // });
});
</script>

<template>
    <div class="max-w-2xl mx-auto my-12 space-y-12">
        <div v-for="post in postsData" :key="post.id">
            <h1 class="font-bold text-3xl">{{ post.id }}: {{ post.title }}</h1>
            <p class="mt-2 text-lg">{{ post.teaser }}</p>
        </div>
        <div ref="lastElement"></div>
    </div>
</template>
