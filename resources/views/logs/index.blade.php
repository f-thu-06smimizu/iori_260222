<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイログ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">マイログ（日々の記録）</h2>

        <form action="{{ route('logs.store') }}" method="POST" class="mb-8">
            @csrf
            <textarea name="content" class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="今日の手応えは？"></textarea>
            <button type="submit" class="mt-3 px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">保存する</button>
        </form>

        <div class="space-y-4">
            <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">これまでの記録</h3>
            @foreach ($logs as $log)
                <div class="p-4 bg-gray-50 rounded border-l-4 border-blue-500">
                    <p class="text-gray-800">{{ $log->body }}</p>
                    <small class="text-gray-400 block mt-2">{{ $log->created_at->format('Y/m/d H:i') }}</small>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>