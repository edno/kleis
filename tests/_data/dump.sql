DELETE FROM `accounts`;
DELETE FROM `categories`;
DELETE FROM `groups`;
DELETE FROM `proxylistitems`;
DELETE FROM `users` WHERE NOT ID = 1;

INSERT INTO `groups` (`name`, `created_by`)
       VALUES        ('Montreal', 1),
                     ('Kobenhavn', 1);

INSERT INTO `categories` (`name`, `icon`, `validity`, `created_by`)
       VALUES            ('Tester', 'fa-flask', 1, 1),
                         ('Developer', 'fa-gear', 900, 1);

INSERT INTO `accounts` (`netlogin`, `netpass`, `firstname`, `lastname`, `category_id`, `group_id`, `status`, `expire`, `created_by`)
       VALUES          ('test',
                        'minus',
                        'Minus',
                        'Test',
                        (SELECT `id` FROM `categories` WHERE `name` = 'Tester'),
                        (SELECT `id` FROM `groups` WHERE `name` = 'Montreal'),
                        1,
                        DATE_ADD(NOW(), INTERVAL 10 DAY),
                        1),
                        ('dev',
                         'cortex',
                         'Cortex',
                         'Test',
                         (SELECT `id` FROM `categories` WHERE `name` = 'Developer'),
                         (SELECT `id` FROM `groups` WHERE `name` = 'Kobenhavn'),
                         0,
                         DATE_SUB(NOW(), INTERVAL 10 DAY),
                         1);

INSERT INTO `users` (`firstname`, `lastname`, `email`, `password`, `level`, `group_id`, `status`, `created_by`)
       VALUES       ('Minus',
                     'Cortex',
                     'minus.cortex@kleis.app',
                     'cortex',
                     1,
                     (SELECT `id` FROM `groups` WHERE `name` = 'Montreal'),
                     1,
                     1);
