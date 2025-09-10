// wp-content/themes/planit/tailwind.config.js
module.exports = {
    content: [
      "./*.php",
      "./**/*.php",     // همه فایل‌های PHP قالب
      "./src/**/*.js",  // اسکریپت‌های خودت
      "./src/**/*.html" // اگه فایل تست HTML داری
    ],
    theme: {
      extend: {
        colors: {
          brand: {
            50:  "#faf5ff",
            100: "#f3e8ff",
            500: "#8b5cf6",
            600: "#7c3aed",
            700: "#6d28d9"
          }
        },
        boxShadow: { soft: "0 10px 25px rgba(0,0,0,.06)" },
        borderRadius: { '2xl': "1rem" }
      },
    },
    plugins: [],
  };