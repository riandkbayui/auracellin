<script type="text/javascript" setup>
    import AppHeader from '@/components/main/appheader'
    import AppFooter from '@/components/main/appfooter'
</script>

<template>
    <div>
        <AppHeader />
        <div class="container-fluid">
            <div class="row justify-content-center content-area">
                <div class="col-lg-4">
                    <nuxt />
                </div>
            </div>
        </div>
        <AppFooter />
    </div>
</template>

<script type="text/javascript">
    export default {
        middleware: ["auth"],
    }
</script>