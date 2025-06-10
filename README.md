## Setup Instructions

1. **Download the project**  
   First, clone the repository (or download it as a ZIP) and go into the project folder.

2. **Install Laravel dependencies**  
   Run `composer install` to pull in all the necessary PHP packages.

3. **Create your `.env` file**  
   Copy the default config file using:  
   `cp .env.example .env`  
   Then generate the Laravel app key with:  
   `php artisan key:generate`

4. **Add your Agora credentials**  
   Log in to your Agora page(https://console.agora.io), create a new project, and make sure the App Certificate is enabled.  
   Then open your `.env` file and add the following:
   AGORA_APP_ID=your_agora_app_id
   AGORA_APP_CERTIFICATE=your_agora_app_certificate

5. **Start the app**  
   Run `php artisan serve` and open received link in your browser.

That’s it! You can now test the video calling feature in your browser.

## Demo Screencast
️ [Watch the demo](https://www.loom.com/share/c8930c62949c4ed5be8b4ad555e26b4c?sid=62c778d0-967f-40be-8e72-5d5e98002159)
