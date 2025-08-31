<template>
    <label class="toggle-switch-component">
        <input type="checkbox" :checked="isActive" @change="toggleSwitch" />
        <span class="slider"></span>
    </label>
</template>

<script>
export default {
    name: "ToggleSwitch",
    props: {
        modelValue: {
            type: [Boolean, Number],
            default: 0,
        },
    },
    computed: {
        isActive() {
            return this.modelValue === 1 || this.modelValue === true;
        },
    },
    methods: {
        toggleSwitch(event) {
            this.$emit("update:modelValue", event.target.checked ? 1 : 0);
        },
    },
};
</script>

<style scoped>
.toggle-switch-component {
    position: relative;
    display: inline-block;
    width: 32px;
    height: 16px;
}
.toggle-switch-component input {
    opacity: 0;
    width: 0;
    height: 0;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 16px;
}
.slider:before {
    position: absolute;
    content: "";
    height: 12px;
    width: 12px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}
input:checked + .slider {
    background-color: #1c53c9;
}
input:checked + .slider:before {
    transform: translateX(16px);
}
</style>
