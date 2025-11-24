{
        return $panel
            ->id('user')
            ->path('user')
            ->login()
=======
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default(false)
            ->id('user')
            ->path('user')
            ->login()
