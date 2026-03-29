<script setup>
import { useForm, router } from "@inertiajs/vue3";

const props = defineProps({ weatherData: Object });
const emit = defineEmits(["back"]);

const categories = [
    { id: "calm", label: "静寂" },
    { id: "insight", label: "洞察" },
    { id: "gratitude", label: "感謝" },
    { id: "chaos", label: "混沌" },
    { id: "excitement", label: "昂揚" },
];

const form = useForm({
    body: "",
    category_id: "calm",
    weather_label: props.weatherData?.label || "静寂",
    temperature: props.weatherData?.temp || null,
    water: 0, 
    act: 0,   
});

const submit = () => {
    if (!form.body.trim()) return;
    form.post(route("monologues.store"), {
        onSuccess: () => {
            form.reset();
            emit("back");
        },
    });
};

// 管理画面へ（ルート未定義だと404になります）
const goToAdmin = () => {
    router.get(route("monologues.index"));
};
</script>

<template>
    <div class="write-overlay">
        <header class="write-header">
            <button @click="$emit('back')" class="logo-btn">
                <div class="logo-area">
                    <span class="iori-logo">I O R I</span>
                    <span class="logo-sub">SAGE GUIDE</span>
                </div>
            </button>
            
            <button @click="$emit('back')" class="back-link-btn">
                / 戻る
            </button>
        </header>

        <div class="write-content">
            <div class="textarea-container">
                <div class="text-echo" v-if="form.body">{{ form.body }}</div>
                <textarea v-model="form.body" placeholder="言葉を、置いていく..." class="iori-textarea" autofocus></textarea>
                <div class="focus-line" :class="{ 'active': form.body.length > 0 }"></div>
            </div>

            <div class="selector-container">
                <p class="section-hint">いまの、輪郭を選ぶ</p>
                <div class="chips-wrapper">
                    <button v-for="cat in categories" :key="cat.id" @click="form.category_id = cat.id" class="emotion-chip" :class="{ 'is-active': form.category_id === cat.id }">
                        {{ cat.label }}
                    </button>
                </div>
            </div>

            <div class="divider"></div>

            <div class="physical-inputs">
                <p class="section-hint body-hint">身体の渇きと、歩み（任意）</p>
                <div class="input-group">
                    <div class="label-row"><span class="label-main">水分</span><span class="label-value">{{ form.water > 0 ? form.water.toFixed(1) + ' L' : '---' }}</span></div>
                    <input type="range" v-model.number="form.water" min="0" max="3" step="0.1" class="iori-range" />
                </div>
                <div class="input-group">
                    <div class="label-row"><span class="label-main">歩み</span><span class="label-value">{{ form.act > 0 ? form.act.toLocaleString() + ' step' : '---' }}</span></div>
                    <input type="range" v-model.number="form.act" min="0" max="20000" step="500" class="iori-range" />
                </div>
            </div>

            <div class="footer-actions">
                <button @click="submit" class="submit-action-btn" :disabled="!form.body.trim() || form.processing">
                    <span v-if="form.processing" class="loading-dots">刻んでいます</span>
                    <span v-else>完了</span>
                </button>
            </div>
        </div>

        <button @click="goToAdmin" class="admin-trigger">Admin</button>
    </div>
</template>

<style scoped>
/* 共通スタイルは省略なし */
@import url("https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500;700&display=swap");

.write-overlay {
    position: fixed; inset: 0;
    background: radial-gradient(circle at center, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.85) 100%);
    backdrop-filter: blur(20px); z-index: 9999; 
    display: flex; flex-direction: column; align-items: center; justify-content: flex-start;
    padding-top: 15vh; font-family: "Shippori Mincho", serif; color: #fff;
}

.write-header { 
    position: absolute; top: 40px; left: 40px; right: 40px; 
    display: flex; justify-content: space-between; align-items: flex-start;
}

/* 🌟 ロゴボタンのスタイル追加 */
.logo-btn { background: none; border: none; padding: 0; cursor: pointer; text-align: left; }
.logo-area { display: flex; flex-direction: column; gap: 2px; }
.iori-logo { font-size: 1.2rem; letter-spacing: 0.6em; font-weight: 500; color: #fff; }
.logo-sub { font-size: 0.5rem; letter-spacing: 0.4em; color: rgba(255,255,255,0.3); margin-left: 2px; }

.back-link-btn { background: none; border: none; color: rgba(255,255,255,0.6); font-size: 0.9rem; letter-spacing: 0.2em; cursor: pointer; transition: 0.4s; }
.back-link-btn:hover { color: #fff; transform: translateX(-5px); }

/* 🌟 Adminボタン：右下に固定 */
.admin-trigger {
    position: fixed; bottom: 30px; right: 30px;
    background: none; border: none; color: rgba(255,255,255,0.1);
    font-size: 0.65rem; letter-spacing: 0.2em; cursor: pointer; transition: 0.5s;
}
.admin-trigger:hover { color: rgba(255,255,255,0.6); }

/* 以下の write-content 周りは元のデザインを維持 */
.write-content { width: 85%; max-width: 480px; text-align: center; }
.textarea-container { position: relative; margin-bottom: 3.5rem; }
.text-echo { position: absolute; inset: 0; pointer-events: none; font-size: 1.4rem; line-height: 2.2; color: rgba(255,255,255,0.08); filter: blur(10px); transform: scale(1.08); transition: 0.4s ease-out; white-space: pre-wrap; word-wrap: break-word; }
.iori-textarea { width: 100%; height: 160px; background: transparent; border: none; color: #fff; font-size: 1.4rem; line-height: 2.2; outline: none; resize: none; text-align: center; font-weight: 500; text-shadow: 0 0 20px rgba(255, 255, 255, 0.4); position: relative; z-index: 1; }
.iori-textarea::placeholder { color: rgba(255,255,255,0.2); text-shadow: none; }
.focus-line { width: 40px; height: 1px; background: rgba(255,255,255,0.2); margin: 1rem auto; transition: 0.8s ease; }
.focus-line.active { width: 140px; background: #fff; box-shadow: 0 0 15px #fff; }
.section-hint { font-size: 0.7rem; color: rgba(255, 255, 255, 0.6); margin-bottom: 1.5rem; letter-spacing: 0.3em; }
.emotion-chip { background: rgba(255,255,255,0.06); border: 1px solid rgba(255, 255, 255, 0.2); color: rgba(255, 255, 255, 0.6); padding: 10px 20px; border-radius: 30px; font-size: 0.8rem; cursor: pointer; transition: 0.4s; }
.emotion-chip.is-active { border-color: #fff; color: #fff; background: rgba(255,255,255,0.15); }
.divider { width: 20px; height: 1px; background: rgba(255,255,255,0.2); margin: 0 auto 3.5rem; }
.physical-inputs { margin-bottom: 5rem; text-align: left; }
.input-group { margin-bottom: 2.5rem; }
.label-row { display: flex; justify-content: space-between; margin-bottom: 1rem; }
.label-main { font-size: 0.9rem; color: #fff; letter-spacing: 0.2em; font-weight: 700; }
.label-value { font-size: 0.9rem; color: #fff; font-family: sans-serif; opacity: 0.9; }
.iori-range { width: 100%; appearance: none; background: rgba(255,255,255,0.25); height: 1px; outline: none; }
.iori-range::-webkit-slider-thumb { appearance: none; width: 18px; height: 18px; background: #fff; border-radius: 50%; cursor: pointer; box-shadow: 0 0 15px rgba(255,255,255,0.6); }
.submit-action-btn { background: #fff; border: 1px solid #fff; color: #000; font-size: 0.95rem; padding: 16px 60px; border-radius: 40px; cursor: pointer; transition: 0.4s; letter-spacing: 0.5em; font-weight: 700; text-indent: 0.5em; }
.submit-action-btn:hover:not(:disabled) { background: transparent; color: #fff; }
.submit-action-btn:disabled { opacity: 0.1; }
@keyframes pulse { 0% { opacity: 0.4; } 50% { opacity: 1; } 100% { opacity: 0.4; } }
.loading-dots { animation: pulse 1.5s infinite; letter-spacing: 0.2em; }
</style>