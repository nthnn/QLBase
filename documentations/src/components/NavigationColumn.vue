<script setup lang="ts">
import { RouterLink } from 'vue-router';
</script>

<template>
    <div class="card card-body border-primary border shadow">
        <h3 class="m-0 mb-2">Getting Started</h3>
        <p>Documentations to help you get started with QLBase. A brief introduction, deployment instructions, and donations.</p>
        <div class="btn-group-vertical w-100 rounded">
            <RouterLink to="/" class="btn btn-outline-primary">What is QLBase?</RouterLink>
            <RouterLink to="/deployment" class="btn btn-outline-primary">Deployment</RouterLink>
            <RouterLink to="/firmware" class="btn btn-outline-primary">The Firmware</RouterLink>
            <RouterLink to="/contributing" class="btn btn-outline-primary">Contributing and Contributors</RouterLink>
        </div>
    </div>
    <br/>

    <div class="card card-body border-primary border shadow">
        <h3 class="m-0 mb-2">APIs and Services</h3>
        <p>Different decentralizable, scalable, and realiable services by QLBase for individuals, businesses, and enterprise companies.</p>
        <div class="btn-group-vertical w-100 rounded">
            <RouterLink to="/authentication" class="btn btn-outline-primary">Authentication</RouterLink>
            <RouterLink to="/sms-verification" class="btn btn-outline-primary">SMS Verification</RouterLink>
            <RouterLink to="/data-analytics" class="btn btn-outline-primary">Data Analytics</RouterLink>
            <RouterLink to="/database" class="btn btn-outline-primary">Database</RouterLink>
            <RouterLink to="/file-storage" class="btn btn-outline-primary">File Storage</RouterLink>
            <RouterLink to="/machine-learning" class="btn btn-outline-primary">Machine Learning</RouterLink>
        </div>
    </div>
    <br/>
</template>

<style scoped>
    .btn-outline-primary {border-bottom: 1px !important}
    .btn-group-vertical {border-bottom: solid 1px var(--bs-primary) !important}

    a {
        text-align: left;
        text-decoration: none;
    }
</style>