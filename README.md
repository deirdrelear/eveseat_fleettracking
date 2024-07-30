# Fleet Tracking Plugin for EVE SeAT

This plugin adds fleet tracking capabilities to EVE SeAT, allowing fleet commanders to manage fleets and track participation.

## Features

- Automatic fleet detection and tracking
- Manual fleet creation and management
- Integration with EVE ESI for real-time fleet data
- Fleet participation tracking
- Fleet statistics and reporting

## Installation

1. Require the plugin in your SeAT installation:
composer require drlear/seat-fleet-tracking 
2. Publish the configuration:
php artisan vendor:publish --provider="drlear\FleetTracking\FleetTrackingServiceProvider" --tag=config 
3. Run the migrations: 
php artisan migrate 
4. Update your SeAT configuration to include the necessary ESI scopes.

## Configuration

Edit the `config/fleettracking.php` file to set up your ESI client details and other plugin options.

## Usage

After installation, a new "Fleet Tracking" section will be available in the SeAT menu. Fleet commanders can create and manage fleets, while regular users can join fleets and view their participation.

## Support

For support, please open an issue on the GitHub repository or contact the author.

## License

This plugin is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
