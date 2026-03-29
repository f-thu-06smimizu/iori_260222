<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    currentMode: String, // 'selection', 'map', 'detail' など
});
</script>

<template>
    <footer class="fixed-footer">
        <div class="nav-items">
            <Link href="/dashboard" class="nav-item">
                <span class="nav-icon">⌂</span>
                <span class="nav-label">HOME</span>
            </Link>

            <div 
                class="nav-item" 
                :class="{ active: currentMode === 'selection' }"
                @click="$emit('change-view', 'selection')"
            >
                <span class="nav-icon">◎</span>
                <span class="nav-label">SELECT</span>
            </div>

            <div 
                class="nav-item" 
                :class="{ active: currentMode === 'map' || currentMode === 'detail' }"
                @click="$emit('change-view', 'map')"
            >
                <span class="nav-icon">⚐</span>
                <span class="nav-label">MAP</span>
            </div>
        </div>
    </footer>
</template>

<style scoped>
.fixed-footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 80px; /* 100pxから80pxへ。Dashboardのサイズ感に合わせる */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    /* 背景との境界をなじませる */
    background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 100%);
    pointer-events: none; /* 背後のクリックを邪魔しない */
}

.nav-items {
    display: flex;
    gap: 5rem; /* Dashboardのアイコン同士の間隔に合わせる */
    pointer-events: auto; /* ボタン部分はクリック可能に */
}

.nav-item {
    text-decoration: none;
    color: rgba(255, 255, 255, 0.35);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    transition: 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
    cursor: pointer;
    position: relative;
}

.nav-item:hover, .nav-item.active {
    color: #fff;
}

.nav-icon {
    font-size: 1.1rem; /* 少し小さくして繊細に */
}

.nav-label {
    font-size: 0.55rem; /* Dashboardのラベルサイズに合わせる */
    letter-spacing: 0.25em;
    font-weight: 300;
}

/* Dashboardのアクティブ表示に似た光の点 */
.nav-item.active::after {
    content: "";
    position: absolute;
    bottom: -12px;
    width: 3px;
    height: 3px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 0 8px #fff;
}
</style>