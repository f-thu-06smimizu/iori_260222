<script setup>
import { onMounted, ref, watch } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const props = defineProps({
    spots: {
        type: Array,
        default: () => []
    }
});

const mapContainer = ref(null);
let map = null;
let markerLayer = null;

// ピンのアイコン設定（標準アイコンが表示されない問題の対策）
const defaultIcon = L.icon({
    iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41]
});

onMounted(() => {
    // 地図の初期化（東京中心）
    map = L.map(mapContainer.value).setView([35.6812, 139.7671], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    markerLayer = L.layerGroup().addTo(map);

    // すでにデータがあればピンを立てる
    updateMarkers();
});

// spotsデータが変わるたびにピンを更新する
watch(() => props.spots, () => {
    updateMarkers();
}, { deep: true });

function updateMarkers() {
    if (!map || !markerLayer) return;

    // 一旦古いピンを消す
    markerLayer.clearLayers();

    if (props.spots.length > 0) {
        props.spots.forEach(spot => {
            if (spot.latitude && spot.longitude) {
                // ピンを立てる
                const marker = L.marker([spot.latitude, spot.longitude], { icon: defaultIcon })
                    .bindPopup(`<b>${spot.name || 'スポット'}</b><br>${spot.monologue || ''}`);
                
                markerLayer.addLayer(marker);
            }
        });

        // 最初のピンの位置に画面を移動させる
        const first = props.spots[0];
        map.setView([first.latitude, first.longitude], 14);
    }
}
</script>

<template>
    <div ref="mapContainer" class="w-full h-full min-h-[400px] z-0"></div>
</template>

<style scoped>
/* 地図が正しく表示されるための必須設定 */
:deep(.leaflet-container) {
    width: 100%;
    height: 100%;
    background: #000;
}
</style>