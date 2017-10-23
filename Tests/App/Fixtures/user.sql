TRUNCATE TABLE `user`;
INSERT INTO `user` (`id`, `user_group`, `login`, `password`, `mail`, `validation_code`, `register_date`, `last_login`, `validate`) VALUES
	(1, 1, 'Test', '110812f67fa1e1f0117f6f3d70241c1a42a7b07711a93c2477cc516d9042f9db', 'test@test.com', NULL, '2017-10-23', '2017-10-23 11:05:56', 1),
	(2, 2, 'Test2', 'ec9c3a34e791bda21bbcb69ea0eb875857497e0d48c75771b3d1adb5073ce791', 'test2@test.com', '273f69e9beb590fd27a280e7d815afc6', '2017-10-23', '2017-10-23 11:06:34', 0);
