# Denník N to RSS

This script checks the dennikn.sk for the latest short news (_Aktuálne_) and turns them into an RSS feed. Use it with IFTTT to get the news directly to your smartwatch.

## Guide

The script generates a `feed.xml` file so make sure it can write to the directory.

1. Clone the repo on your server.
2. Run `composer install` to install the dependencies.
3. Create a CRON job which periodically runs the `task.php` script.
4. Setup a new IFTTT recipe (IF "New feed item" THEN "Send a notification to android watch").
5. Set the Feed URL according to the location of your generated `feed.xml` file.
6. Set the Notification template to `N: {{EntryTitle}} - {{EntryContent}}` (or customize to your taste)
.
