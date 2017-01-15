# slack-hook-github-status

Simple PHP script that responds to a Slack outgoing webhook, fetches and retrieves GitHub status via API.

### How To Use
- clone this repository on a server with PHP and curl
- add a new slash command on your Slack (search `slash` among Apps & Integrations)
- specify the URL on your server where Slack is going to POST the request
- copy the Token and paste it on `config.php` file
- trigger the hook typing the command you choose in any of your channels
