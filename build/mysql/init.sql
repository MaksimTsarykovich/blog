CREATE TABLE categories
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO `categories` (`id`, `name`) VALUES (NULL, 'Мой опыт');
INSERT INTO `categories` (`id`, `name`) VALUES (NULL, 'Разработка');
INSERT INTO `categories` (`id`, `name`) VALUES (NULL, 'PHP');
INSERT INTO `categories` (`id`, `name`) VALUES (NULL, 'Фриланс');

CREATE TABLE posts
(
    `id`          INT          NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(255) NOT NULL,
    `text`        TEXT         NOT NULL,
    `category_id` INT          NOT NULL,
    `views`       INT          NOT NULL,
    `status`      TINYINT(1) NOT NULL DEFAULT '1',
    `image`       VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`) REFERENCES categories (`id`)
);

INSERT INTO `posts` (`id`, `name`, `text`, `category_id`, `views`, `status`, `image`)
VALUES (NULL, 'Мой путь в PHP: от новичка до Senior Developer',
        'Делюсь своей историей — как я начинал с PHP, с какими трудностями столкнулись и какие шаги помогли мне стать Senior Developer. Советы и рекомендации для начинающих разработчиков.',
        1, 83, 1, '/images/image-1.jpg');

INSERT INTO `posts` (`id`, `name`, `text`, `category_id`, `views`, `status`, `image`)
VALUES (NULL, '5 ошибок, которые я совершал в начале своего пути в PHP',
        'Никто не идеален, и я — не исключение. Рассказываю о типичных ошибках, которые я совершал в начале своей карьеры PHP-разработчика, и как их можно избежать.',
        2, 129, 0, '/images/image-2.jpg');

INSERT INTO `posts` (`id`, `name`, `text`, `category_id`, `views`, `status`, `image`)
VALUES (NULL, 'Мой любимый инструментарий PHP-разработчика',
        'Делюсь своим набором инструментов — IDE, фреймворки, библиотеки, сервисы, — которые помогают мне быть более продуктивным и эффективным в работе.',
        3, 322, 0, '/images/image-3.jpg');

INSERT INTO `posts` (`id`, `name`, `text`, `category_id`, `views`, `status`, `image`)
VALUES (NULL, 'Как я справился с самым сложным проектом на PHP',
        'Рассказываю о самом запоминающемся и сложном проекте в моей карьере PHP-разработчика. Какие проблемы возникли, какие решения были найдены и какие уроки я извлек из этого опыта.',
        4, 218, 1, '/images/image-4.jpg');