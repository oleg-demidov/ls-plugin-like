CREATE TABLE `prefix_wiki` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `menu_title` varchar(100) COLLATE utf8_bin NOT NULL,
  `menu_enable` tinyint(1) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `prefix_wiki`
--
ALTER TABLE `prefix_wiki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `prefix_wiki`
--
ALTER TABLE `prefix_wiki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `prefix_wiki_page` (
  `id` int(11) NOT NULL,
  `wiki_id` int(11) NOT NULL,
  `code` varchar(500) COLLATE utf8_bin NOT NULL,
  `title` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `keywords` varchar(200) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Дамп данных таблицы `prefix_wiki_page`
--

INSERT INTO `prefix_wiki_page` (`id`, `wiki_id`, `code`, `title`, `description`, `keywords`) VALUES
(2, 1, '0', 'Знаки', 'sdfsdfsdfsd', 'fsdfsdfsdf');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `prefix_wiki_page`
--
ALTER TABLE `prefix_wiki_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `wiki_id` (`wiki_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `prefix_wiki_page`
--
ALTER TABLE `prefix_wiki_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


CREATE TABLE `prefix_wiki_punkt` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `text` varchar(2000) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `prefix_wiki_punkt`
--
ALTER TABLE `prefix_wiki_punkt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `prefix_wiki_punkt`
--
ALTER TABLE `prefix_wiki_punkt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;