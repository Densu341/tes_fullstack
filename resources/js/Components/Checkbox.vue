<template>
    <label class="checkbox-component">
        <input type="checkbox" v-model="checked" />
        <span class="checkmark"></span>
        <slot></slot>
    </label>
</template>

<script>
export default {
    name: "CustomCheckbox",
    props: {
        modelValue: Boolean,
    },
    emits: ["update:modelValue"],
    computed: {
        checked: {
            get() {
                return this.modelValue;
            },
            set(val) {
                this.$emit("update:modelValue", val);
            },
        },
    },
};
</script>

<style scoped>
.checkbox-component {
    display: inline-flex;
    align-items: center;
    cursor: pointer;
}
.checkbox-component input[type="checkbox"] {
    display: none;
}
.checkbox-component .checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid #333;
    border-radius: 4px;
    margin-right: 8px;
    position: relative;
}
.checkbox-component input[type="checkbox"]:checked + .checkmark {
    background-color: #333;
}
</style>
