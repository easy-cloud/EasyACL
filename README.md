A advanced but simple ACL module for Zend framework 2 and Doctrine 2! 

You can set rights per group or user. Everything is loaded from Doctrine.

Navigation support added.

Add "ajanssen/acl": "dev-master" to composer.json and run update.

Then import this in MySQL:

INSERT INTO  `user` (`id` , `name` , `surname` , `email` , `password`)VALUES (NULL ,  'admin', 'admin',  'admin@admin.com',  'password');
INSERT INTO  `roles` (`id` , `user_id` , `group_id` , `name` , `allowed_all`)VALUES (NULL ,  '1', NULL ,  'Master',  'a:1:{i:0;s:6:"master";}');

You can get the password by logging in without an account in the database(it will echo itself!).