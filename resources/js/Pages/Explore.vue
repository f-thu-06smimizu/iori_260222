<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="視座の選択" />
    <AuthenticatedLayout>
        <div class="explore-container">
            <div class="header-section">
                <p class="subtitle">RESONANCE</p>
                <h1 class="main-title">どの眼差しで、辿りますか？</h1>
            </div>

            <div class="selection-grid">
                <Link :href="route('resonance.show', { id: 1 })" class="selection-item">
                    <div class="circle-wrapper">
                        <div class="circle sage"></div>
                    </div>
                    <span class="label">賢人</span>
                </Link>

                <div class="selection-item disabled-item">
                    <div class="circle-wrapper">
                        <div class="circle festival"></div>
                    </div>
                    <span class="label">祭</span>
                </div>

                <div class="selection-item disabled-item">
                    <div class="circle-wrapper">
                        <div class="circle spa"></div>
                    </div>
                    <span class="label">湯治</span>
                </div>

                <div class="selection-item disabled-item">
                    <div class="circle-wrapper">
                        <div class="circle scene"></div>
                    </div>
                    <span class="label">原景</span>
                </div>
            </div>

            <footer class="bottom-nav">
                <Link :href="route('dashboard')" class="nav-item">
                    <span class="nav-icon">⌂</span>
                    <span class="nav-text">HOME</span>
                </Link>
                <div class="nav-item active">
                    <span class="nav-icon">◎</span>
                    <span class="nav-text">SELECT</span>
                </div>
                <div class="nav-item disabled">
                    <span class="nav-icon">⚐</span>
                    <span class="nav-text">MAP</span>
                </div>
            </footer>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500;600&display=swap");

.explore-container {
    background: #000;
    height: 100vh;
    width: 100vw;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-family: "Shippori Mincho", serif;
    position: relative;
    overflow: hidden;
}

.header-section { 
    text-align: center; 
    margin-bottom: clamp(4rem, 12vh, 8rem); 
}

.subtitle { 
    font-size: 0.7rem; 
    letter-spacing: 1.2em; 
    color: rgba(255, 255, 255, 0.5); 
    margin-bottom: 2rem; 
    text-indent: 1.2em; 
}

.main-title { 
    font-size: 1.4rem; /* ピッチ用に少し拡大 */
    letter-spacing: 0.5em; 
    font-weight: 500; 
    color: rgba(255, 255, 255, 0.95); 
}

.selection-grid { 
    display: flex; 
    gap: clamp(2rem, 10vw, 6rem); 
    z-index: 10;
}

.selection-item { 
    display: flex; 
    flex-direction: column; 
    align-items: center; 
    text-decoration: none; 
    color: inherit; 
    transition: transform 0.8s cubic-bezier(0.2, 0.8, 0.2, 1); 
}

/* --- 円の強化 --- */
.circle-wrapper {
    position: relative;
    margin-bottom: 2rem;
}

.circle {
    width: 110px; /* サイズアップ */
    height: 110px;
    border-radius: 50%;
    /* ボーダーを太くし、コントラストを強調 */
    border: 2px solid rgba(255, 255, 255, 0.35);
    transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
}

/* 中心部の色を強めたグラデーション */
.sage { background: radial-gradient(circle at center, #3b5a82 0%, #000 100%); }
.festival { background: radial-gradient(circle at center, #6d28d9 0%, #000 100%); }
.spa { background: radial-gradient(circle at center, #059669 0%, #000 100%); }
.scene { background: radial-gradient(circle at center, #b45309 0%, #000 100%); }

.selection-item:hover .circle {
    border-color: rgba(255, 255, 255, 0.9);
    transform: scale(1.1);
    box-shadow: 0 0 40px rgba(255, 255, 255, 0.2);
}

/* --- 文字（ラベル）のピッチプレゼン対応強化 --- */
.label { 
    font-size: 1rem; /* はっきりと見えるサイズ */
    letter-spacing: 0.5em; 
    color: rgba(255, 255, 255, 0.85); /* 明度を上げる */
    text-indent: 0.5em;
    font-weight: 600; /* 太くして輪郭を強調 */
    transition: all 0.6s; 
    /* 漆黒の背景で文字を際立たせるためのシャドウ */
    text-shadow: 0 0 15px rgba(0, 0, 0, 1), 0 0 5px rgba(255, 255, 255, 0.2);
}

.selection-item:hover .label { 
    color: #fff;
    text-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
}

/* --- ボトムナビ：アイコン & 小さい文字 --- */
.bottom-nav {
    position: absolute;
    bottom: 50px;
    display: flex;
    gap: clamp(3rem, 15vw, 6rem);
    justify-content: center;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: rgba(255, 255, 255, 0.4); 
    text-decoration: none;
    transition: all 0.6s;
}

.nav-icon {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.nav-text {
    font-size: 0.55rem; 
    letter-spacing: 0.2em;
    font-weight: 500;
}

.nav-item.active {
    color: #fff; /* アクティブは純白 */
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
}

.disabled { opacity: 0.15; cursor: default; }
.disabled-item { opacity: 0.45; cursor: default; }

@media (max-width: 640px) {
    .selection-grid { 
        grid-template-columns: repeat(2, 1fr); 
        display: grid;
        gap: 3.5rem; 
    }
}
</style>