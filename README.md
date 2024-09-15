# Page Rank Metrics Collector

## Introduction

This application is designed to collect page rank metrics for specified domains on a daily basis and expose the collected data through the app's API. It utilizes the Open Page Rank API to gather information for domains listed in a file.
Make sure you have laravel installed on your computer or server before running

## Instructions

1. **Configure Database**

    - Enter your MySQL credentials in the `.env` file.
    - Run the following command to create the required database table:
      ```bash
      php artisan migrate
      ```
    - Run laravel application by:
      ```bash
      php artisan serve
      ```

2. **Obtain API Key**

    - Register at [Open Page Rank](https://www.domcop.com/openpagerank/) to get free API access.
    - Set the API key in the `.env` file under `OPEN_PAGE_RANK_API_KEY`. As of today, the key value is 'https://openpagerank.com/api/v1.0/getPageRank'.

3. **Configure API Key**

    - Ensure the `OPEN_PAGE_RANK_API_KEY` in the `.env` file is set correctly.

4. **Set Remote JSON File URL**

    - Provide the URL of the remote JSON file containing the domain list in the `.env` file under `DOMAIN_LIST_REMOTE_JSON_FILE`.
    - If your domain file is hosted on GitHub, use the raw link format, e.g., `https://raw.githubusercontent.com/user/project/branch/filename.json`.
    - The default key for domain names is set to "rootDomain". You can customize this key in the `DomainListFromRemoteJsonService` class.

5. **Schedule Data Collection**

    - The application uses Laravel's scheduler to collect page data daily. Configure the interval in Laravel's schedule.
    - Add the following command to your server’s cron job to execute it:
      ```bash
      cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
      ```
    - For manual data updates, use the URL `/manual-import`.

6. **Configure API Access**

    - Set the app's API key in the `.env` file under `APP_API_KEY`.
    - External applications must include this header in their requests to access the app's API:
      ```plaintext
      Authorization: your-api-key
      ```
    - An empty string can be used if no key is set.

7. **Access Domain Data**

    - The list of domains with ranks is accessible via the following URL: `/api/domains`.

