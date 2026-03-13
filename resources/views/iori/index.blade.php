<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IORI - 聖地探査</title>
    <style>
        body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; margin: 0; background-color: #0f172a; color: white; }
        button { padding: 15px 30px; font-size: 1.2rem; cursor: pointer; border: none; border-radius: 50px; background: #38bdf8; color: #0f172a; font-weight: bold; margin-bottom: 20px; }
        #result { text-align: center; font-size: 1.2rem; line-height: 1.8; }
        .distance { font-size: 1.8rem; color: #38bdf8; }
        .weather-info { margin-top: 15px; font-size: 1rem; color: #94a3b8; }
    </style>
</head>
<body>
    <h1>IORI 聖地探査</h1>
    <button onclick="getLocation()">現在地を特定</button>
    <div id="result"></div>

    <script>
        async function getLocation() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerText = '探査中...';

            navigator.geolocation.getCurrentPosition(async (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                try {
                    const response = await fetch('/check-distance', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ lat, lng })
                    });

                    const data = await response.json();

                    // 画面の書き換え（距離・天気・気圧・気温）
                    resultDiv.innerHTML = `
                        <div>${data.name} まで</div>
                        <div class="distance">あと <strong>${data.distance} km</strong></div>
                        <div class="weather-info">
                            現在の空: <strong>${data.weather}</strong><br>
                            気圧: <strong>${data.pressure} hPa</strong> / 気温: <strong>${data.temp} ℃</strong><br>
                            <span style="color: #fbbf24; font-weight: bold;">[ ${data.atmosphere} ]</span>
                        </div>
                    `;
                } catch (error) {
                    resultDiv.innerText = '通信エラーが発生しました。';
                    console.error(error);
                }
            }, (error) => {
                resultDiv.innerText = '位置情報の取得に失敗しました。';
            });
        }
    </script>
</body>
</html>