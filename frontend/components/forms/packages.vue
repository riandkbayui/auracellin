<template>
    <select class="form-control" :value="value" @input="$emit('input', $event.target.value)">
        <option value="">-- Pilih Paket --</option>
        <option v-for="(item, key) in $packages()" :key="key" :value="item.id">{{ item.name }}</option>
    </select>
</template>

<script>
export default {
  props: ['value']
}
</script>