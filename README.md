# Vernyi.est1921

E-commerce веб-приложение на Laravel + FilamentPHP с AI-интеграциями.

## Возможности

- Каталог товаров с категориями, вариантами (размер/цвет и т.д.) и изображениями
- Корзина, избранное, оформление заказов
- Админ-панель на FilamentPHP: управление товарами, категориями, заказами, пользователями
- Дашборд со статистикой и графиками (продажи, топ-товары, категории)
- AI-модуль автогенерации описаний товаров и SEO-тегов
- AI-модуль распознавания характеристик товара по фото
- AI-чат-бот для консультирования покупателей
- Генерация PDF-накладных для заказов

## Стек технологий

- **Backend:** PHP, Laravel
- **Admin panel:** FilamentPHP
- **Frontend:** Blade, Tailwind CSS
- **Database:** MySQL

## Установка

\`\`\`bash
git clone https://github.com/killerbot265-source/vernyi-est1921.git
cd vernyi-est1921
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
\`\`\`

## Автор

Темирлан Утегенов
