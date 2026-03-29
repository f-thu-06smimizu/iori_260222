<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="iori-shell">
        <header class="iori-header">
            <div class="brand-logo">
                <Link :href="route('dashboard')" class="logo-link">
                    <span class="logo-text">I O R I</span>
                    <span class="logo-sub">SAGE GUIDE</span>
                </Link>
            </div>

            <div class="user-navigation">
                <span class="user-name">{{ $page.props.auth.user.name }}</span>
                <span class="nav-divider">/</span>
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="logout-btn"
                >
                    退出
                </Link>
            </div>
        </header>

        <main class="iori-content">
            <slot />
        </main>
    </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500;600&display=swap");

.iori-shell {
    min-height: 100vh;
    background-color: #000;
    color: white;
    font-family: "Shippori Mincho", serif;
    position: relative;
}

.iori-header {
    /* paddingをやめ、固定値(top/left/right)で配置をロックします。
       これによりページ遷移時の計算揺れを物理的に防ぎます。
    */
    position: fixed;
    top: 40px;
    left: 40px;
    right: 40px;
    z-index: 1000;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    pointer-events: none;
    height: 0; /* レイアウトを押し下げない */
}

/* --- ロゴ：没入感を高めるために透過率を調整 --- */
.brand-logo {
    display: flex;
    flex-direction: column;
    pointer-events: auto;
}

.logo-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
}

.logo-text {
    font-family: "Shippori Mincho", serif;
    letter-spacing: 0.3em; 
    font-size: 1.2rem;
    font-weight: 500;
    /* 存在感を背景に馴染ませる */
    color: rgba(255, 255, 255, 0.5); 
    line-height: 1;
    text-indent: 0.3em; 
    transition: color 0.8s ease;
}

.logo-text:hover {
    color: rgba(255, 255, 255, 0.9);
}

.logo-sub {
    font-family: "Shippori Mincho", serif;
    font-size: 0.45rem;
    letter-spacing: 0.2em;
    color: rgba(255, 255, 255, 0.2);
    margin-top: 8px;
    text-indent: 0.2em;
}

/* --- 右上のユーザーメニュー --- */
.user-navigation {
    pointer-events: auto;
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 0.65rem;
    letter-spacing: 0.2em;
    padding-top: 5px; 
}

.user-name {
    color: rgba(255, 255, 255, 0.3);
}

.nav-divider {
    color: rgba(255, 255, 255, 0.1);
}

.logout-btn {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.3);
    cursor: pointer;
    font-family: inherit;
    transition: color 0.4s;
}

.logout-btn:hover {
    color: rgba(255, 255, 255, 0.8);
}

.iori-content {
    min-height: 100vh;
    width: 100%;
}

/* スマホ対応：絶対座標を微調整 */
@media (max-width: 640px) {
    .iori-header {
        top: 25px;
        left: 25px;
        right: 25px;
    }
    .logo-text {
        font-size: 1rem;
    }
}
</style>