Get-ChildItem -Recurse -Path 'app/Filament/Resources/User' -Filter '*.php' | ForEach-Object {
    $content = Get-Content $_.FullName -Raw
    $content = $content -replace 'App\\Filament\\User\\Resources\\User\\', 'App\\Filament\\Resources\\User\\'
    Set-Content $_.FullName $content
}
