<script setup>
import { ref, onMounted, computed } from "vue";
import { Head } from "@inertiajs/vue3";
import AxisMap from "./AxisMap.vue";
import CommonFooter from "@/Components/CommonFooter.vue"; // 共通フッター

const props = defineProps({ resonance: Object });
const viewMode = ref("selection");
const isLoaded = ref(false);
const selectedSage = ref(null);

onMounted(() => { setTimeout(() => { isLoaded.value = true; }, 100); });

const sages = [
    { id: 1, name: "菅江 真澄", title: "風と土の記憶を辿る", copy: "ありのままを、綴る。", image: "/images/sages/masumi_v.jpg", lat: 40.21, lng: 140.02 },
    { id: 2, name: "岡本 太郎", title: "芸術は爆発だ。生命の歓喜へ。", copy: "自分の中に、毒を持て。", image: "/images/sages/taro_v.jpg", lat: 34.80, lng: 135.53 },
    { id: 3, name: "星野 道夫", title: "遥かなる旅人。極北の光と影。", copy: "アラスカ、その果て。", image: "/images/sages/hoshino_v.jpg", lat: 64.83, lng: -147.71 },
    { id: 4, name: "南方 熊楠", title: "粘菌と宇宙。知の巨人の森へ。", copy: "エコロジーの先駆。", image: "/images/sages/minakata_v.jpg", lat: 33.72, lng: 135.37 },
];

const selectSage = (sage) => {
    selectedSage.value = { ...sage, spots: [{ id: sage.id, name: sage.name + " ゆかりの地", latitude: sage.lat, longitude: sage.lng, monologue: sage.copy }] };
    viewMode.value = "map"; 
};
const goToDetail = () => { viewMode.value = "detail"; };

const handleViewChange = (newMode) => { viewMode.value = newMode; };
</script>

<template>
    <Head title="RESONANCE" />
    <div class="resonance-container">
        <div class="background-image" :style="{ backgroundImage: `url(${resonance?.img || '/images/nachi_forest.jpg'})`, opacity: isLoaded ? (viewMode === 'map' ? 0.2 : 0.3) : 0 }"></div>
        <div class="mist-overlay"></div>

        <div class="main-viewport">
            <main v-if="viewMode === 'selection'" class="selection-layer" :class="{ visible: isLoaded }">
                <header class="sel-header">
                    <span class="breadcrumb">RESONANCE / 導き手</span>
                    <h1 class="sel-title">どの眼差しで、地を辿りますか？</h1>
                </header>
                <div class="sage-slider">
                    <div v-for="sage in sages" :key="sage.id" class="sage-card" @click="selectSage(sage)">
                        <div class="card-visual" :style="{ backgroundImage: `url(${sage.image})` }">
                            <div class="visual-overlay"></div>
                        </div>
                        <div class="card-info">
                            <p class="s-copy">{{ sage.title }}</p>
                            <h2 class="s-name">{{ sage.name }}</h2>
                        </div>
                    </div>
                </div>
                <div class="nav-hint">左右に触れ、選ぶ</div>
            </main>

            <main v-else-if="viewMode === 'map'" class="map-layer" :class="{ visible: isLoaded }">
                <div class="map-stage">
                    <AxisMap :spots="selectedSage?.spots || []" @click="goToDetail" />
                </div>
                <button class="back-link" @click="viewMode = 'selection'">← 選び直す</button>
            </main>

            <main v-else class="content-wrapper" :class="{ visible: isLoaded }">
                <h2 class="title">{{ selectedSage?.name }}</h2>
                <p class="monologue">{{ selectedSage?.copy }}</p>
                <button class="res-button" @click="viewMode = 'map'">地図へ戻る</button>
            </main>
        </div>

        <CommonFooter :current-mode="viewMode" @change-view="handleViewChange" />
    </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500;600&display=swap");

.resonance-container { position: fixed; inset: 0; background: #000; color: #fff; overflow: hidden; font-family: "Shippori Mincho", serif; }
.background-image { position: absolute; inset: 0; background-size: cover; background-position: center; transition: 2.5s ease; z-index: 1; }
.mist-overlay { position: absolute; inset: 0; background: radial-gradient(circle, transparent 20%, rgba(0, 0, 0, 0.9) 120%); z-index: 2; pointer-events: none; }

/* フッターの高さを考慮したメイン表示領域 */
.main-viewport { position: relative; height: calc(100% - 80px); width: 100%; z-index: 10; }

.selection-layer { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; opacity: 0; transition: 1s; }
.selection-layer.visible { opacity: 1; }
.sel-header { text-align: center; margin-bottom: 3rem; }
.sel-title { font-size: 1.2rem; letter-spacing: 0.5em; font-weight: 500; text-shadow: 0 0 20px rgba(0,0,0,0.8); }
.breadcrumb { font-size: 0.65rem; letter-spacing: 0.4em; color: rgba(255,255,255,0.5); margin-bottom: 1rem; display: block; }

.sage-slider { display: flex; gap: 3rem; }
.sage-card { width: 260px; aspect-ratio: 9/13; cursor: pointer; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); transition: 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
.sage-card:hover { transform: translateY(-15px); border-color: rgba(255,255,255,0.4); }

.card-visual { position: absolute; inset: 0; background-size: cover; background-position: center; filter: grayscale(100%) brightness(0.4); transition: 1.2s; }
.sage-card:hover .card-visual { filter: grayscale(0%) brightness(0.6); transform: scale(1.05); }
.visual-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.9) 100%); }

.card-info { position: absolute; bottom: 2.5rem; width: 100%; text-align: center; padding: 0 1rem; opacity: 0.6; transition: 0.6s; text-shadow: 0 2px 10px #000; }
.sage-card:hover .card-info { opacity: 1; }
.s-name { font-size: 1.5rem; letter-spacing: 0.4em; margin-bottom: 0.5rem; }
.s-copy { font-size: 0.6rem; color: rgba(255,255,255,0.6); letter-spacing: 0.2em; }

.nav-hint { margin-top: 4rem; font-size: 0.7rem; letter-spacing: 0.4em; color: rgba(255,255,255,0.3); }

.map-layer, .content-wrapper { height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.map-stage { width: 85vw; height: 55vh; border: 1px solid rgba(255,255,255,0.1); background: #000; }
.back-link { margin-top: 2rem; background: none; border: none; color: rgba(255,255,255,0.4); font-size: 0.7rem; cursor: pointer; }
</style>