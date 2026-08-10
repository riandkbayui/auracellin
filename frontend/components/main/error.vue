<template>
    <div class="card">
        <div class="card-header">
            <div class="card-title text-center text-primary fsz-16 m-0">Maaf!</div>
        </div>
        <div class="card-body">
            <div class="d-flex gap-3 justify-content-center align-items-center">
                <div class="text-center">
                    <div class="d-inline-block">
                        <div class="wd-64 ht-64 ar-1-1 rounded-circle bg-secondary d-flex justify-content-center align-items-center">
                            <i class="mdi mdi-comment-alert fsz-40 text-white"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <slot />
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
</template>
