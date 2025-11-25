# TODO: Fix ShiftsResource Alerts and Errors

- [ ] Update Imports: Change `use Filament\Schemas\Components\Form;` to `use Filament\Forms\Form;` and add `use Filament\Forms\Components;`.
- [ ] Fix Routes: Update `getPages()` to reference `CreateShifts::route('/create')` and `EditShifts::route('/{record}/edit')`.
- [ ] Update Form Fields: Change `Components\TextInput::make('name')` to `Components\TextInput::make('nama_shift')` and update the unique validation accordingly.
- [ ] Ensure Consistency: Verify that all references match the database schema.
