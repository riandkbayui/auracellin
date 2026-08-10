<template>
    <div class="text-center mb-3">
        <div class="d-inline-block mb-2">
            <div class="bg-white avatar-md rounded d-flex justify-content-center align-items-center">
                <i :class="[className, 'fsz-20 text-secondary']"></i>
            </div>
        </div>
        <div class="text-white text-nowrap">{{ label }}</div>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: {
            className: String,
            label: String
        }
    }
</script>
