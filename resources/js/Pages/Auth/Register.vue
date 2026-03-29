<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const isLoaded = ref(false);
onMounted(() => {
    setTimeout(() => { isLoaded.value = true; }, 300);
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="新しく己を綴る" />

    <div class="auth-container">
        <div class="auth-bg" :style="{ backgroundImage: 'url(/images/nachi_forest.jpg)' }"></div>
        <div class="auth-overlay"></div>

        <main class="auth-card" :class="{ 'fade-in': isLoaded }">
            <header class="auth-header">
                <h1 class="logo">IORI</h1>
                <p class="tagline">新しく、己を綴る</p>
            </header>

            <form @submit.prevent="submit" class="auth-form">
                <div class="input-group">
                    <input type="text" v-model="form.name" placeholder="Name" required autofocus />
                    <div v-if="form.errors.name" class="error-msg">{{ form.errors.name }}</div>
                </div>

                <div class="input-group">
                    <input type="email" v-model="form.email" placeholder="Email" required />
                    <div v-if="form.errors.email" class="error-msg">{{ form.errors.email }}</div>
                </div>

                <div class="input-group">
                    <input type="password" v-model="form.password" placeholder="Password" required />
                    <div v-if="form.errors.password" class="error-msg">{{ form.errors.password }}</div>
                </div>

                <div class="input-group">
                    <input type="password" v-model="form.password_confirmation" placeholder="Confirm Password" required />
                </div>

                <button type="submit" class="submit-btn" :disabled="form.processing">
                    {{ form.processing ? '...' : '刻む' }}
                </button>
            </form>

            <footer class="auth-footer">
                <Link :href="route('login')" class="footer-link">既にある扉（ログイン）へ</Link>
            </footer>
        </main>
    </div>
</template>

<style scoped>
/* Login.vue と共通のスタイルです */
@import url("https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500&display=swap");

.auth-container {
    position: fixed; inset: 0; display: flex; align-items: center; justify-content: center;
    background-color: black; font-family: "Shippori Mincho", serif; color: white; overflow: hidden;
}
.auth-bg {
    position: absolute; inset: 0; background-size: cover; background-position: center;
    filter: blur(25px) brightness(0.4); z-index: 1;
}
.auth-overlay {
    position: absolute; inset: 0;
    background: radial-gradient(circle, transparent 0%, rgba(0,0,0,0.8) 100%); z-index: 2;
}
.auth-card {
    position: relative; z-index: 10; width: 100%; max-width: 320px; text-align: center;
    opacity: 0; transform: translateY(20px); transition: all 2.5s ease-out;
}
.auth-card.fade-in { opacity: 1; transform: translateY(0); }
.logo { font-size: 2.5rem; letter-spacing: 0.8em; text-indent: 0.8em; margin-bottom: 0.5rem; }
.tagline { font-size: 0.7rem; letter-spacing: 0.5em; color: rgba(255,255,255,0.4); margin-bottom: 4rem; }
.auth-form { display: flex; flex-direction: column; gap: 1.5rem; }
.input-group input {
    width: 100%; background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.15);
    padding: 0.75rem 0; color: white; text-align: center; outline: none; transition: border-color 0.8s;
}
.input-group input:focus { border-color: rgba(255,255,255,0.6); }
.error-msg { font-size: 0.6rem; color: #f87171; margin-top: 0.5rem; }
.submit-btn {
    margin-top: 2rem; background: transparent; border: 1px solid rgba(255,255,255,0.3);
    padding: 0.8rem; letter-spacing: 1em; text-indent: 1em; color: white; cursor: pointer; transition: all 0.6s;
}
.submit-btn:hover { background: white; color: black; }
.auth-footer { margin-top: 4rem; }
.footer-link { font-size: 0.65rem; color: rgba(255,255,255,0.3); text-decoration: none; letter-spacing: 0.2em; }
</style>