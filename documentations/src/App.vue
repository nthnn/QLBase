<script setup lang="ts">
import { watch } from "vue";
import { useRoute } from "vue-router";
import { RouterView } from 'vue-router';

import Footer from "./components/Footer.vue";
import NavigationColumn from "./components/NavigationColumn.vue";

const route = useRoute();

watch(
    () => route.fullPath,
    async (n, nn) => window.scrollTo(0, 0)
);
</script>

<template>
    <br/>
    <br class="desktop-only"/>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="desktop-only">
                    <NavigationColumn />
                </div>
            </div>

            <div class="col-lg-8">
                <div class="rounded container border-primary border p-4 shadow">
                    <RouterView />
                </div>

                <div class="mobile-only">
                    <br/>
                    <NavigationColumn />
                </div>

                <div class="desktop-only">
                    <br/><br/>
                </div>
            </div>
        </div>

        <Footer />
    </div>
    <br/>
</template>

<style>
    @media only screen and (max-width: 771px) {
        .desktop-only { display: none; }
        .mobile-only { display: block; }
    }

    @media only screen and (min-width: 770px) {
	    .mobile-only { display: none; }
    }
</style>