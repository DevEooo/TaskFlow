Get-ChildItem -Recurse -Path 'app/Filament/Resources/Admin' -Filter '*.php' | ForEach-Object {
    $content = Get-Content $_.FullName -Raw
    $content = $content -replace 'App\\Filament\\Resources\\Admin\\Admin\\', 'App\\Filament\\Resources\\Admin\\'
    Set-Content $_.FullName $content
}
