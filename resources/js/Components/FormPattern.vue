<template>
    <form class="form" @submit.prevent="handleSubmit" novalidate>
        <!-- Form grid / stacked pattern -->
        <div class="form__row">
            <label class="form__label" for="name">Full name</label>
            <div class="form__control">
                <input
                    id="name"
                    class="input"
                    type="text"
                    v-model="form.name"
                    :aria-invalid="errors.name ? 'true' : 'false'"
                    :aria-describedby="errors.name ? 'err-name' : null"
                    placeholder="e.g. Deni Putra"
                />
                <small v-if="errors.name" class="form__error" id="err-name">{{
                    errors.name
                }}</small>
            </div>
        </div>

        <!-- Floating label -->
        <div class="form__row">
            <div class="floating">
                <input
                    id="email"
                    v-model="form.email"
                    class="input floating__input"
                    type="email"
                    placeholder=" "
                    :aria-invalid="errors.email ? 'true' : 'false'"
                    :aria-describedby="errors.email ? 'err-email' : null"
                />
                <label class="floating__label" for="email">Email address</label>
            </div>
            <small v-if="errors.email" class="form__error" id="err-email">{{
                errors.email
            }}</small>
        </div>

        <!-- Inline fields (grid) -->
        <div class="form__row form__row--inline">
            <div>
                <label class="form__label" for="city">City</label>
                <input id="city" class="input" v-model="form.city" />
            </div>
            <div>
                <label class="form__label" for="zip">ZIP</label>
                <input id="zip" class="input" v-model="form.zip" />
            </div>
        </div>

        <!-- Select & textarea -->
        <div class="form__row">
            <label class="form__label" for="country">Country</label>
            <select id="country" class="select" v-model="form.country">
                <option value="">— Choose —</option>
                <option value="id">Indonesia</option>
                <option value="us">United States</option>
                <option value="sg">Singapore</option>
            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="message">Message</label>
            <textarea
                id="message"
                class="textarea"
                v-model="form.message"
                rows="4"
            ></textarea>
            <div class="form__hint">Max 500 characters</div>
        </div>

        <!-- Input group (icon / prefix / suffix) -->
        <div class="form__row">
            <label class="form__label">Price</label>
            <div class="input-group">
                <span class="input-group__addon">IDR</span>
                <input class="input" v-model="form.price" inputmode="numeric" />
                <span class="input-group__addon">.00</span>
            </div>
        </div>

        <!-- Checkbox / Radio -->
        <div class="form__row">
            <fieldset class="fieldset">
                <legend class="fieldset__legend">Preferences</legend>
                <label class="checkbox">
                    <input type="checkbox" v-model="form.newsletter" />
                    <span class="checkbox__label">Subscribe to newsletter</span>
                </label>

                <div class="radio-group">
                    <label class="radio">
                        <input
                            type="radio"
                            name="plan"
                            value="free"
                            v-model="form.plan"
                        />
                        <span class="radio__label">Free</span>
                    </label>
                    <label class="radio">
                        <input
                            type="radio"
                            name="plan"
                            value="pro"
                            v-model="form.plan"
                        />
                        <span class="radio__label">Pro</span>
                    </label>
                </div>
            </fieldset>
        </div>

        <!-- File input -->
        <div class="form__row">
            <label class="form__label" for="avatar">Avatar</label>
            <input
                id="avatar"
                class="input-file"
                type="file"
                @change="onFileChange"
            />
            <div v-if="fileName" class="form__hint">
                Selected: {{ fileName }}
            </div>
        </div>

        <!-- Disabled & loading states -->
        <div class="form__row form__row--actions">
            <button class="btn" :disabled="submitting">
                <span
                    v-if="submitting"
                    aria-hidden="true"
                    class="spinner"
                ></span>
                <span v-if="!submitting">Submit</span>
                <span v-else>Submitting…</span>
            </button>

            <button
                type="button"
                class="btn btn--ghost"
                @click="reset"
                :disabled="submitting"
            >
                Reset
            </button>
        </div>
    </form>
</template>

<script setup>
import { reactive, ref } from "vue";

const form = reactive({
    name: "",
    email: "",
    city: "",
    zip: "",
    country: "",
    message: "",
    price: "",
    newsletter: false,
    plan: "free",
});

const errors = reactive({});
const submitting = ref(false);
const fileName = ref("");

function validate() {
    errors.name = form.name.trim() ? "" : "Name is required";
    errors.email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)
        ? ""
        : "Email is invalid";
    // simple example validations
    return !errors.name && !errors.email;
}

async function handleSubmit() {
    if (!validate()) {
        // focus first invalid
        const firstErr = document.querySelector("[aria-invalid='true']");
        if (firstErr) firstErr.focus();
        return;
    }
    submitting.value = true;
    try {
        // simulate request
        await new Promise((r) => setTimeout(r, 1000));
        // emit success or reset form etc.
        alert("Submitted (demo)");
    } finally {
        submitting.value = false;
    }
}

function onFileChange(e) {
    const f = e.target.files?.[0];
    fileName.value = f ? f.name : "";
}

function reset() {
    Object.assign(form, {
        name: "",
        email: "",
        city: "",
        zip: "",
        country: "",
        message: "",
        price: "",
        newsletter: false,
        plan: "free",
    });
    fileName.value = "";
    Object.keys(errors).forEach((k) => (errors[k] = ""));
}
</script>

<style scoped>
/* CSS variables (theme-ready) */
:root {
    --form-bg: #fff;
    --muted: #6b7280;
    --text: #111827;
    --accent: #ff2d20;
    --accent-600: #e0241b;
    --error: #ef4444;
    --radius: 8px;
    --gap: 0.75rem;
}

/* Base layout */
.form {
    width: 100%;
    max-width: 720px;
    background: var(--form-bg);
    padding: 1.25rem;
    border-radius: calc(var(--radius) + 2px);
    box-shadow: 0 6px 18px rgba(16, 24, 40, 0.06);
    color: var(--text);
    box-sizing: border-box;
    font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI",
        Roboto, "Helvetica Neue", Arial;
}

/* Row + labels */
.form__row {
    display: block;
    margin-bottom: 0.9rem;
}

.form__row--inline {
    display: grid;
    grid-template-columns: 1fr 140px;
    gap: var(--gap);
}

.form__label {
    display: block;
    font-size: 0.875rem;
    margin-bottom: 0.35rem;
    color: var(--muted);
}

/* Controls */
.form__control {
    position: relative;
}

.input,
.select,
.textarea {
    width: 100%;
    padding: 0.55rem 0.75rem;
    border-radius: 8px;
    border: 1px solid #e6e9ef;
    background: white;
    font-size: 0.95rem;
    color: var(--text);
    outline: none;
    transition: box-shadow 0.15s ease, border-color 0.12s ease, transform 0.08s;
    box-sizing: border-box;
}

.input:focus,
.select:focus,
.textarea:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 4px rgba(255, 45, 32, 0.08);
}

/* Floating label pattern */
.floating {
    position: relative;
}
.floating__input {
    padding-top: 1.25rem;
    padding-bottom: 0.4rem;
}
.floating__label {
    position: absolute;
    left: 0.75rem;
    top: 0.6rem;
    font-size: 0.85rem;
    color: var(--muted);
    pointer-events: none;
    transform-origin: left top;
    transition: transform 0.12s ease, font-size 0.12s ease, top 0.12s ease;
}
.floating__input:placeholder-shown + .floating__label {
    transform: translateY(0) scale(1);
    font-size: 0.95rem;
    top: 0.6rem;
}
.floating__input:not(:placeholder-shown) + .floating__label,
.floating__input:focus + .floating__label {
    transform: translateY(-0.8rem) scale(0.86);
    font-size: 0.75rem;
    color: var(--accent-600);
    top: 0.14rem;
}

/* Hints and errors */
.form__hint {
    font-size: 0.8rem;
    color: var(--muted);
    margin-top: 0.35rem;
}
.form__error {
    display: block;
    color: var(--error);
    font-size: 0.82rem;
    margin-top: 0.35rem;
}

/* Input group */
.input-group {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}
.input-group__addon {
    background: #f3f4f6;
    padding: 0.45rem 0.6rem;
    border-radius: 8px;
    font-size: 0.9rem;
    color: var(--muted);
    border: 1px solid #e6e9ef;
}

/* Checkbox & radio */
.fieldset {
    border: none;
    padding: 0;
}
.checkbox,
.radio {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-right: 0.9rem;
    cursor: pointer;
    user-select: none;
    font-size: 0.95rem;
}
.checkbox input,
.radio input {
    accent-color: var(--accent);
}
.checkbox__label,
.radio__label {
    color: var(--text);
}

/* File input minimal style */
.input-file {
    font-size: 0.95rem;
}

/* Buttons */
.form__row--actions {
    display: flex;
    gap: 0.6rem;
    justify-content: flex-start;
    margin-top: 1rem;
}
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 0.9rem;
    border-radius: 8px;
    background: var(--accent);
    color: white;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: transform 0.06s ease, filter 0.08s;
}
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
.btn--ghost {
    background: transparent;
    color: var(--muted);
    border: 1px solid #e6e9ef;
}

/* Spinner small */
.spinner {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.5);
    border-top-color: white;
    animation: spin 0.8s linear infinite;
}
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Responsive */
@media (max-width: 560px) {
    .form {
        padding: 1rem;
    }
    .form__row--inline {
        grid-template-columns: 1fr;
    }
}
</style>
