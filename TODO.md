# TODO for Tugas Form Implementation

- [ ] Update app/Filament/Resources/Admin/Tasks/TasksResource.php:
  - Correct model import to App\Models\Tugas
  - Remove the table method to disable table functionality
  - Remove 'index' from getPages() to disable listing page
- [ ] Update app/Filament/Resources/Admin/Tasks/Schemas/TasksForm.php:
  - Add a TextInput field for 'title' to make the form functional
- [ ] Test the form in the admin panel (create and edit pages)
