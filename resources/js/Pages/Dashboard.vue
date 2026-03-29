<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3"; 
import { ref, onMounted, computed } from "vue";
import Write from './Write.vue';   

const props = defineProps({ 
    monologues: { type: Array, default: () => [] } 
});

const mode = ref('home'); 
const isLoaded = ref(false);

// 🌟 初期デザインの状態（静寂）をラベルとして保持
const weatherData = ref({ temp: 22, condition: "default", label: "静寂" });

const getBgImage = computed(() => {
    const images = {
        rainy: "/images/rainy_moss.jpg",
        cloudy: "/images/misty_mountain.jpg",
        default: "/images/nachi_forest.jpg",
    };
    return images[weatherData.value.condition] || images["default"];
});

const deleteLog = (id) => {
    if (confirm("この記憶を消去しますか？")) {
        router.delete(route('monologues.destroy', { monologue: id }), {
            preserveScroll: true,
        });
    }
};

onMounted(() => {
    setTimeout(() => { isLoaded.value = true; }, 500);
});
</script>

<template>
    <Head title="聖域" />

    <AuthenticatedLayout>
        <div class="iori-dashboard">
            <div class="dynamic-bg" :style="{ backgroundImage: `url(${getBgImage})` }" :class="{ 'bg-zoom': isLoaded }"></div>
            <div class="overlay"></div>

            <div v-if="mode === 'home'" class="main-layer" :class="{ visible: isLoaded }">
                <div class="central-status">
                    <h2 class="current-label">{{ weatherData.label }}</h2>
                </div>

                <div class="central-action">
                    <p class="prompt-text">いまの、心持ちを。</p>
                    
                    <div class="action-buttons">
                        <button @click="mode = 'write'" class="circle-btn">
                            <span class="btn-label">綴る</span>
                        </button>
                        
                        <Link :href="route('explore')" class="circle-btn">
                            <span class="btn-label">辿る</span>
                        </Link>
                    </div>
                </div>

                <div class="user-history-trigger">
                    <button @click="mode = 'admin'" class="history-button">
                        過去の記憶を、見つめる
                    </button>
                </div>
            </div>

            <Write v-if="mode === 'write'" :weatherData="weatherData" @back="mode = 'home'" />

            <div v-if="mode === 'admin'" class="admin-overlay">
                <button @click="mode = 'home'" class="admin-close-fixed">/ 閉じる</button>
                <div class="admin-content">
                    <h3 class="admin-title">記憶の断片</h3>
                    <div class="log-scroll-area">
                        <div v-for="log in monologues" :key="log.id" class="log-card">
                            <div class="log-card-header">
                                <span class="log-date">{{ new Date(log.created_at).toLocaleString('ja-JP') }}</span>
                                
                                <span v-if="$page.props.auth.user.is_admin && log.user" class="log-author">
                                    / {{ log.user.name }}
                                </span>

                                <span class="log-cat">心持ち: {{ log.category_id }}</span>
                            </div>
                            <p class="log-body">{{ log.body }}</p>
                            <div class="log-card-footer">
                                <span v-if="log.water" class="stat">💧 {{ log.water }}L</span>
                                <span v-if="log.act" class="stat">👣 {{ log.act }} 歩</span>
                                <button @click="deleteLog(log.id)" class="log-delete-btn">消去</button>
                            </div>
                        </div>
                        <div v-if="!monologues.length" class="empty-msg">まだ、蓄積された記憶はありません</div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500&display=swap");

.iori-dashboard {
    position: relative; height: 100vh; width: 100vw;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; background-color: #000;
    font-family: "Shippori Mincho", serif;
}

.dynamic-bg { position: absolute; inset: 0; background-size: cover; background-position: center; filter: brightness(0.6) saturate(1.2); transition: transform 30s linear; z-index: 1; }
.bg-zoom { transform: scale(1.15); }
.overlay { position: absolute; inset: 0; background: radial-gradient(circle, transparent 20%, rgba(0, 0, 0, 0.75) 100%); z-index: 2; }

.main-layer { position: relative; z-index: 10; text-align: center; opacity: 0; transform: translateY(10px); transition: 1.5s ease-out; width: 100%; }
.main-layer.visible { opacity: 1; transform: translateY(0); }

.central-status { margin-bottom: 2rem; }
.current-label { 
    font-size: 1.2rem; 
    letter-spacing: 0.8em; 
    color: rgba(255, 255, 255, 0.8); 
    text-shadow: 0 0 20px rgba(0,0,0,0.8);
    text-indent: 0.8em;
}

.prompt-text { 
    font-size: 0.85rem; letter-spacing: 0.5em; 
    color: rgba(255, 255, 255, 0.6); 
    margin-bottom: 4rem;
}

.central-action { display: flex; flex-direction: column; align-items: center; margin-bottom: 6rem; }
.action-buttons { display: flex; gap: clamp(3rem, 15vw, 6rem); }

.circle-btn { width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.4); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none; cursor: pointer; transition: 0.8s; backdrop-filter: blur(4px); }
.circle-btn:hover { border-color: #fff; background: rgba(255,255,255,0.15); transform: scale(1.08); }
.btn-label { font-size: 0.9rem; letter-spacing: 0.4em; text-indent: 0.4em; }

.user-history-trigger { margin-top: 2rem; }
.history-button {
    background: none; border: none; 
    color: rgba(255, 255, 255, 0.75); 
    font-size: 0.85rem; letter-spacing: 0.35em; cursor: pointer; padding: 15px 30px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 1); font-weight: 600;
    transition: all 0.6s ease; text-decoration: none;
}
.history-button:hover { color: rgba(255,255,255,1); transform: translateY(-2px); }

.admin-overlay { position: absolute; inset: 0; z-index: 100; background: rgba(0,0,0,0.88); backdrop-filter: blur(30px); display: flex; flex-direction: column; align-items: center; padding: 40px; color: #fff; }
.admin-close-fixed { position: absolute; top: 40px; right: 40px; background: none; border: none; color: #fff; font-size: 1rem; letter-spacing: 0.2em; cursor: pointer; opacity: 0.7; transition: 0.3s; }
.admin-close-fixed:hover { opacity: 1; }
.admin-content { width: 100%; max-width: 600px; margin-top: 60px; height: 80vh; overflow-y: auto; scrollbar-width: none; }
.admin-content::-webkit-scrollbar { display: none; }
.admin-title { font-size: 1.1rem; letter-spacing: 0.6em; margin-bottom: 3rem; text-align: center; color: rgba(255,255,255,0.9); }

.log-card { background: rgba(255,255,255,0.03); padding: 30px; border-radius: 2px; margin-bottom: 20px; border: 1px solid rgba(255,255,255,0.05); }
.log-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem; }
.log-date { font-size: 0.8rem; color: rgba(255,255,255,0.5); letter-spacing: 0.1em; }
.log-author { font-size: 0.75rem; color: rgba(255, 255, 255, 0.4); margin-left: 0.5rem; flex-grow: 1; }
.log-cat { font-size: 0.8rem; color: rgba(255,255,255,0.7); letter-spacing: 0.1em; }
.log-body { font-size: 0.95rem; line-height: 1.8; color: rgba(255,255,255,0.85); margin-bottom: 1.5rem; white-space: pre-wrap; }

.log-card-footer { display: flex; gap: 1.5rem; align-items: center; font-size: 0.8rem; color: rgba(255,255,255,0.5); }
.log-delete-btn { margin-left: auto; background: none; border: none; color: rgba(255,255,255,0.3); cursor: pointer; transition: 0.3s; }
.log-delete-btn:hover { color: #ff6b6b; }
.empty-msg { text-align: center; margin-top: 4rem; color: rgba(255,255,255,0.4); font-size: 0.85rem; letter-spacing: 0.2em; }
</style>