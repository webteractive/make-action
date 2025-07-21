# TODO

- [x] **Setup:** Initialize a new Laravel package using the `spatie/package-skeleton-laravel` template.
- [x] **Command Class:** Create the `MakeActionCommand.php` file in the `src/Commands` directory.
- [x] **Stub Creation:** Create the `action.stub` file in a `stubs` directory.
- [x] **Command Logic:** Implement the logic within the command to:
    - [x] Accept the `name` argument.
    - [x] Determine the file path and namespace.
    - [x] Read the stub file.
    - [x] Replace placeholders (`{{ namespace }}`, `{{ class }}`).
    - [x] Ensure the `app/Actions` directory exists.
    - [x] Write the new class file to the destination.
- [x] **Service Provider:** Register the acommand in the package's service provider to make it available to Laravel applications. Remove unused views and migrations, and the MakeAction class and facade.
- [x] **Testing:** Write unit and feature tests to verify the command works as expected.
- [x] **Customizable Method:** Implement logic to allow customization of the default method name (e.g., `execute` instead of `handle`) via the package's config file.
