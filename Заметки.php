Перейди в папку с проектом:

cd /D H:\Programs\OSPanel\home\market.local

Запусти сборку стилей:

npm run dev



✅ 4. Проверка в модели
Если хочешь универсальный доступ в Blade, можешь добавить accessor в User.php:

    public function getBannerUrlAttribute(): string
    {
        return $this->user_banner ? asset('storage/' . $this->user_banner) : '/img/default-banner.jpg';
    }

Тогда в Blade можно будет писать просто:

blade

<img src="{{ Auth::user()->banner_url }}">


Проверка в Blade и PHP: Для модераторов:

@if(Auth::user()->role === 'moder')
    <!-- Контент только для модераторов -->
@endif

Для модераторов и админов:

@if(in_array(Auth::user()->role, ['admin', 'moder']))
    <!-- Контент для модераторов и админов -->
@endif
