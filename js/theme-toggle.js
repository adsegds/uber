// js/theme-toggle.js
document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;
    const MODE_KEY = "uber-theme-mode";

    // 既に保存されているモードを読む（なければ light）
    const saved = localStorage.getItem(MODE_KEY) || "light";
    body.classList.add(saved);

    // トグルボタン取得
    const btn = document.getElementById("mode-toggle");
    if (!btn) return;

    // ボタンの表示アイコンを更新
    const updateIcon = (mode) => {
        btn.textContent = mode === "dark" ? "☀︎" : "🌙";
    };
    updateIcon(saved);

    // クリックで切り替え
    btn.addEventListener("click", function () {
        if (body.classList.contains("light")) {
            body.classList.remove("light");
            body.classList.add("dark");
            localStorage.setItem(MODE_KEY, "dark");
            updateIcon("dark");
        } else {
            body.classList.remove("dark");
            body.classList.add("light");
            localStorage.setItem(MODE_KEY, "light");
            updateIcon("light");
        }
    });
});
