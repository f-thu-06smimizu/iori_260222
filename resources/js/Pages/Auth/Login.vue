<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const isLoaded = ref(false);
const time = ref("");

onMounted(() => {
    setTimeout(() => { isLoaded.value = true; }, 300);
    // 時刻の更新
    const updateTime = () => {
        const now = new Date();
        time.value = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    };
    updateTime();
    setInterval(updateTime, 1000);
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="静寂への入り口" />

    <div class="auth-container">
        <div class="auth-bg" :style="{ backgroundImage: 'url(/images/nachi_forest.jpg)' }"></div>
        <div class="auth-overlay"></div>

        <main class="auth-card" :class="{ 'fade-in': isLoaded }">
            <header class="auth-header">
                <h1 class="logo">IORI</h1>
                <p class="tagline">静寂への入り口</p>
            </header>

            <form @submit.prevent="submit" class="auth-form">
                <div class="input-group">
                    <input 
                        type="email" 
                        v-model="form.email" 
                        placeholder="Email" 
                        required 
                        autocomplete="username"
                    />
                    <div v-if="form.errors.email" class="error-msg">{{ form.errors.email }}</div>
                </div>

                <div class="input-group">
                    <input 
                        type="password" 
                        v-model="form.password" 
                        placeholder="Password" 
                        required 
                        autocomplete="current-password"
                    />
                    <div v-if="form.errors.password" class="error-msg">{{ form.errors.password }}</div>
                </div>

                <button type="submit" class="submit-btn" :disabled="form.processing">
                    {{ form.processing ? '...' : '入る' }}
                </button>
            </form>

            <footer class="auth-footer">
                <Link :href="route('register')" class="footer-link">新しく、己を綴る</Link>
            </footer>
        </main>

        <aside class="metadata" v-if="isLoaded">
            <span>{{ time }}</span>
            <span class="separator">/</span>
            <span>STATIONARY</span>
        </aside>
    </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500&display=swap");

/* 基礎土台：ここが漏れると白くなります */
.auth-container {
    position: fixed;
    inset: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #000;
    font-family: "Shippori Mincho", serif;
    color: white;
    overflow: hidden;
}

.auth-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    filter: blur(25px) brightness(0.4);
    z-index: 1;
}

.auth-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle, transparent 0%, rgba(0,0,0,0.8) 100%);
    z-index: 2;
}

.auth-card {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 320px;
    padding: 0 20px;
    text-align: center;
    opacity: 0;
    transform: translateY(20px);
    transition: all 2.5s ease-out;
}

.auth-card.fade-in {
    opacity: 1;
    transform: translateY(0);
}

.logo {
    font-size: clamp(2rem, 10vw, 2.5rem);
    letter-spacing: 0.8em;
    text-indent: 0.8em;
    margin-bottom: 0.5rem;
}

.tagline {
    font-size: 0.7rem;
    letter-spacing: 0.5em;
    color: rgba(255,255,255,0.4);
    margin-bottom: 4rem;
}

.auth-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.input-group input {
    width: 100%;
    background: transparent;
    border: none;
    border-bottom: 1px solid rgba(255,255,255,0.2);
    padding: 12px 0;
    color: white;
    text-align: center;
    outline: none;
    font-size: 16px; /* iOSズーム防止 */
}

.submit-btn {
    margin-top: 2rem;
    background: transparent;
    border: 1px solid rgba(255,255,255,0.3);
    padding: 1rem;
    color: white;
    letter-spacing: 1em;
    text-indent: 1em;
    cursor: pointer;
    transition: all 0.6s;
}

.submit-btn:hover {
    background: white;
    color: black;
}

.auth-footer {
    margin-top: 5rem;
}

.footer-link {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.5);
    text-decoration: none;
    letter-spacing: 0.2em;
}

.metadata {
    position: absolute;
    bottom: 30px;
    right: 30px;
    font-size: 10px;
    letter-spacing: 0.2em;
    color: rgba(255,255,255,0.3);
}

/* スマホ用の微調整 */
@media (max-width: 640px) {
    .logo { letter-spacing: 0.5em; text-indent: 0.5em; }
    .metadata { right: 50%; transform: translateX(50%); bottom: 20px; }
}
</style>