DELETE FROM `accounts`;
DELETE FROM `categories`;
DELETE FROM `groups`;
DELETE FROM `proxylistitems`;
DELETE FROM `users` WHERE NOT ID = 1;
