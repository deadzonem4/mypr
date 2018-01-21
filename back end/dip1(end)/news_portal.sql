-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news_portal`
--

-- --------------------------------------------------------

--
-- Структура на таблица `categories`
--

CREATE TABLE `categories` (
  `idcategory` int(10) UNSIGNED NOT NULL,
  `title` varchar(80) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `categories`
--

INSERT INTO `categories` (`idcategory`, `title`, `description`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(1, 'Football', 'Football', '2017-01-25 01:05:59', 'rosen', '2017-01-25 03:05:00', 'web'),
(2, 'Fighting Sports', 'Fighting Sports', '2017-01-25 01:05:59', 'rosen', '2017-01-25 03:05:00', 'web'),
(3, 'Voleyball', 'Voleyball', '2017-01-25 01:05:59', 'rosen', '2017-01-25 03:05:00', 'web'),
(4, 'Snooker', 'Snooker', '2017-01-25 01:05:59', 'rosen', '2017-01-25 03:05:00', 'web'),
(5, 'Basketball', 'Basketball', '2017-01-25 01:05:59', 'rosen', '2017-01-25 03:05:00', 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `posts`
--

CREATE TABLE `posts` (
  `idpost` int(10) UNSIGNED NOT NULL,
  `iduser` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `body` text COLLATE utf8_bin NOT NULL,
  `image` varchar(255) COLLATE utf8_bin NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `posts`
--

INSERT INTO `posts` (`idpost`, `iduser`, `title`, `body`, `image`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(22, 5, 'Short on confidence but Wenger proud of anxious Arsenal\'s fighting spirit', 'Arsene Wenger conceded that Arsenal looked short on confidence in their hard-fought 2-1 win over Middlesbrough on Monday.\r\n\r\nGoals from Alexis Sanchez and Mesut Ozil were enough to give the Gunners all three points at the Riverside Stadium, despite Alvaro Negredo having levelled the scores shortly after half-time.\r\n\r\nThe victory ended a run of four consecutive away losses in the Premier League for the Gunners and took them back to within seven points of the top four, having played a game fewer than fourth-placed Manchester City.\r\nAlthough the Frenchman accepted that the display was far from perfect, Wenger was thrilled with the level of commitment from his players, having seen them crumble in a 3-0 loss at Crystal Palace last time out.\r\n\r\n"I felt we were focused and committed. You could see we did not play with full confidence, but overall we really wanted to win," the Arsenal manager told Sky Sports.\r\n\r\n"Second half, we missed the final ball when we could maybe have added one or two more and they created chances with crosses and set-pieces.\r\n\r\n Follow\r\n OptaJoe ✔ @OptaJoe\r\n3 - Three of Arsenal\'s last four away league wins have been against the sides currently in the relegation zone. Expectations.\r\n11:56 PM - 17 Apr 2017\r\n  222 222 Retweets   180 180 likes\r\n"Middlesbrough gave everything. It\'s one of their last chances to stay in the league.\r\n\r\n"There are still some chances where maybe we could have played better with some long balls, but the focus and commitment was there.\r\n\r\n"It was a testing point for us, mentally [at 1-1] it was a moment when I felt that \'now we\'ll see where we go\'. You could see the players have a good mentality, they wanted to win the game and they responded."\r\n\r\nAlexis helps Arsenal to goal landmark\r\n\r\nWenger experimented with a back three of Gabriel, Laurent Koscielny and Rob Holding, and the 67-year-old explained that he had grown concerned about the Gunners\' susceptibility to conceding from direct approach play.\r\n\r\n"I felt it added a bit more stability on the long balls, we\'ve recently been punished with that," he said. "We let them have the ball a bit more than we\'re used to. Against Palace and West Brom, we had 70 per cent of the possession and we lost.\r\n\r\n"We want to have the ball, but sometimes, when a team lacks confidence, a change in system can help them believe in something different."', 'c6633e50362e3435be7b3ea8856627d0.jpg', '2017-04-18 10:05:53', 'web', NULL, 'web'),
(26, 5, 'Chelsea\'s last man standing Terry will be missed more than you think', 'Terry will leave as the greatest of them all after 22 years as a Chelsea player, breaking in under Gianluca Vialli and ultimately earning 14 major honours in 713 appearances and counting. \r\n\r\nHe has more trophies than the entire Arsenal line up and he is the Premier League\'s all-time top scoring defender. He is the last defender to win the PFA Player of the Year and he is the player with the most best defender awards in Europe. \r\n\r\nMost importantly though, he is Chelsea through and through. He remained a constant fixture of a team where £20 million, £30 million and even £50 million players came and went. He was also a constant as managers changed on a regular basis - and there were a lot of managers, 15 of them, to be precise.\r\n\r\nChelsea were in flux as Roman Abramovich\'s revolution created a chaotic atmosphere. Terry provided continuity and leadership at the club in that time with each manager realising just how good he was. Only his fourteenth manager took him out of the first team as Antonio Conte looked to others as he hit the age of 35. \r\nThey now have a place at the top table of both English and European football for the foreseeable future. They even became the first club in London to win the Champions League and they will probably do it for a second time before their local rivals too. It was the most successful era in the club\'s history. \r\n\r\nHe will fall short of Ron "Chopper" Harris\' appearance record but his legacy will last as long as Chelsea exist - as he was the captain who lifted the Blues\' first league title for 50 years. The celebrations were emotional as Chelsea brought back memories of teams gone by after beating Bolton in 2005.', '00984ccce97ab874c01af0500198ed07.jpg', '2017-04-18 10:15:53', 'web', NULL, 'web'),
(27, 5, 'The stats that show why Messi is the most valuable player in La Liga', 'Lionel Messi bagged another brace in Saturday\'s win over Real Sociedad, helping Barcelona to a vital 3-2 win as the club try to run down Real Madrid and the title in La Liga. \r\n\r\nThe Argentine has now scored 29 times in the league this season, but it\'s the importance of his goals that really stands out. \r\nBarcelona\'s superstar has picked up 17 points for his team with those 29 strikes, more than any other player in Spain\'s top flight, begging the question of exactly where Barca would be without him. \r\n\r\nAnd for anybody wondering if Messi is just benefiting from the service around him, take into account that he\'s also scored more goals from outside the box than any other player in Europe\'s top five leagues this season.', '556bc217091df0ae68096511905e80b0.jpg', '2017-04-18 10:17:47', 'web', NULL, 'web'),
(28, 5, 'Dwyane Wade Attempting To Return From Elbow Injury On Saturday', 'Dwyane Wade scrimmaged during parts of the Chicago Bulls\' workout at Temple University and could return from his fractured right elbow before the end of the regular season.\r\n\r\nThe Bulls ruled Wade out for the remainder of the regular season after an MRI exam the next day, but he could now return for Saturday\'s game against the Brooklyn Nets.\r\n\r\nWade is privately eyeing Saturday for his return barring setbacks.\r\n\r\n"If he responds in a positive manner from the contact practice, we\'ll see," Fred Hoiberg told reporters. "I\'m sure we\'ll have to have a little bit of a restriction on his minutes, but hopefully (we\'ll) get him back in a rhythm these last few games."', 'a0b618ed8770eb66f21767ee63742724.jpg', '2017-04-18 10:22:32', 'web', NULL, 'web'),
(29, 5, 'EuroVolley U18 W: The trophy stays in Russia!', 'Russia was crowned European champion in Arnhem at the end of a long and amazing tournament, where the Russian butterflies flew to a remarkable 3-2 (18-25, 25-16, 26-24, 21-25, 15-10) win over Italy in a roller coaster final at the 2017 CEV U18 Volleyball European Championship – Women.\r\n\r\nThis is Russia’s third title in the competition following their gold medal performance from 1997 and 2015. Russia is the first team that could defend the title and have so far claimed 6 (3 gold, 2 silver, 1 bronze) medals in this competition. Italy were also vying for their third title after topping the charts in 1995 and 2001 but had to be content with silver.', 'fb7451291d7da5adc4f6e4ea91c323bd.jpg', '2017-04-18 10:25:09', 'web', NULL, 'web'),
(31, 5, 'World Championship 2017: Ronnie O\'Sullivan claims wrong - Shaun Murphy', 'O\'Sullivan made the claims against World Snooker on Sunday, accusing the body of using "threatening language".\r\n\r\nMurphy, who will face O\'Sullivan in the World Championship second round on Thursday, said he cannot live in a "world without consequences".\r\n\r\n"To claim he has been bullied is, in my opinion, quite inaccurate," he said.\r\n\r\n"The players\' contract is clear for all to see. He can say whatever he wants. No-one has muffled him. But you can\'t live in a world where there are no consequences; no-one lives in that world."\r\nO\'Sullivan, 41, publicly criticised a referee and swore at a photographer after his Masters win in January, which led to World Snooker referring O\'Sullivan\'s comments to snooker\'s governing body, the WPBSA.\r\n\r\nThe WPBSA took no action but O\'Sullivan was sent a letter by the organisation about his behaviour and warned he could face further sanctions, including a fine.\r\n\r\n"Ronnie can say whatever he wants about whatever he wants, but he can\'t get away with everything he says and he isn\'t right about everything he says either," Murphy said.\r\nMurphy said he was "sure" the off-table controversy would be a distraction for his opponent.\r\n\r\n"It\'s very hard to talk about lawyers and threatening the chairman and being embroiled in all of that - and focus on the snooker," he added.\r\n\r\n"I certainly couldn\'t do it. I don\'t know how he does it, but he seems to like it; he always seems to do it. He seems to court it, like he enjoys it - so let him carry on with it with it."', 'd28cf7210dfbf631e1f951c92c274751.jpg', '2017-04-18 10:32:06', 'web', NULL, 'web'),
(32, 5, 'Alexis effort sees Arsenal join Man Utd in reaching goal landmark', 'Arsenal have notched their 3,000th goal away from home in League football, with Manchester United the only other side to have achieved the feat.\r\n\r\nThe Gunners reached that landmark during a Premier League away date at Middlesbrough, with Alexis Sanchez the man to find the target.\r\nAlexis’s effort to break the deadlock at the Riverside Stadium was also notable for seeing him close the gap on the achievements of an Arsenal legend in the form of Thierry Henry.\r\nThe goal also underlined the Chilean’s threat away from Emirates Stadium, with 13 of his 19 goals this season having come on the road to make him the Premier League’s leading marksman in that department.\r\n\r\nArsenal will be hoping there are plenty more away goals to come this season, with Alexis continuing to chip in as speculation regarding his long-term future at the club rages on.', 'c16cd971d2d2052ed623f364844d09b0.jpg', '2017-04-18 11:50:21', 'web', NULL, 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `post_categories`
--

CREATE TABLE `post_categories` (
  `idpost_category` int(10) UNSIGNED NOT NULL,
  `idpost` int(10) UNSIGNED NOT NULL,
  `idcategory` int(10) UNSIGNED NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `post_categories`
--

INSERT INTO `post_categories` (`idpost_category`, `idpost`, `idcategory`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(20, 22, 1, '2017-04-18 10:05:53', '5', NULL, 'web'),
(24, 26, 1, '2017-04-18 10:15:53', '5', NULL, 'web'),
(25, 27, 1, '2017-04-18 10:17:48', '5', NULL, 'web'),
(26, 28, 5, '2017-04-18 10:22:32', '5', NULL, 'web'),
(27, 29, 3, '2017-04-18 10:25:10', '5', NULL, 'web'),
(29, 31, 4, '2017-04-18 10:32:06', '5', NULL, 'web'),
(30, 32, 1, '2017-04-18 11:50:21', '5', NULL, 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `post_tags`
--

CREATE TABLE `post_tags` (
  `idpost_tag` int(10) UNSIGNED NOT NULL,
  `idpost` int(10) UNSIGNED NOT NULL,
  `idtag` int(10) UNSIGNED NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `post_tags`
--

INSERT INTO `post_tags` (`idpost_tag`, `idpost`, `idtag`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(3, 22, 14, '2017-04-18 10:05:53', '5', NULL, 'web'),
(7, 26, 15, '2017-04-18 10:15:53', '5', NULL, 'web'),
(8, 27, 16, '2017-04-18 10:17:47', '5', NULL, 'web'),
(9, 28, 19, '2017-04-18 10:22:32', '5', NULL, 'web'),
(10, 29, 20, '2017-04-18 10:25:10', '5', NULL, 'web'),
(12, 31, 22, '2017-04-18 10:32:06', '5', NULL, 'web'),
(13, 32, 14, '2017-04-18 11:50:21', '5', NULL, 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `profiles`
--

CREATE TABLE `profiles` (
  `idprofile` int(10) UNSIGNED NOT NULL,
  `iduser` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(80) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(80) COLLATE utf8_bin DEFAULT NULL,
  `display_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Структура на таблица `tags`
--

CREATE TABLE `tags` (
  `idtag` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) COLLATE utf8_bin DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `tags`
--

INSERT INTO `tags` (`idtag`, `title`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(11, 'fdsfdsf', '2017-01-25 01:07:52', '5', NULL, 'web'),
(12, 'da', '2017-02-11 12:00:24', '5', NULL, 'web'),
(13, 'hh', '2017-03-28 12:20:40', '5', NULL, 'web'),
(14, 'arsenal', '2017-04-18 09:34:31', '5', NULL, 'web'),
(15, 'chelsea', '2017-04-18 10:03:34', '5', NULL, 'web'),
(16, 'barcelona', '2017-04-18 10:08:05', '5', NULL, 'web'),
(17, 'ba', '2017-04-18 10:12:43', '5', NULL, 'web'),
(18, 'b', '2017-04-18 10:13:40', '5', NULL, 'web'),
(19, 'chicago bulls', '2017-04-18 10:22:32', '5', NULL, 'web'),
(20, 'nacional teams', '2017-04-18 10:25:09', '5', NULL, 'web'),
(21, 'ufc', '2017-04-18 10:29:39', '5', NULL, 'web'),
(22, 'world series', '2017-04-18 10:32:06', '5', NULL, 'web');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `iduser` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `code` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(80) CHARACTER SET latin1 NOT NULL DEFAULT 'web',
  `edit_date` datetime DEFAULT NULL,
  `edited_by` varchar(80) CHARACTER SET latin1 DEFAULT 'web'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`iduser`, `email`, `password`, `code`, `status`, `add_date`, `added_by`, `edit_date`, `edited_by`) VALUES
(5, 'ivo9511@abv.bg', 'e10adc3949ba59abbe56e057f20f883e', 'e9b03ac858161b178bba4be2652ef74f', 1, '2017-01-25 01:06:59', 'web', '2017-01-25 03:07:27', 'web'),
(6, 'deadzonem@abv.bg', '6d7472d0762b15232439afcf6e7695b0', 'a4901971776fcbf1b466ce41c9d21135', 0, '2017-04-22 09:35:58', 'web', NULL, 'web'),
(7, 'codeprci@gmail.com', 'bc4d84d02196873df61ecccb16a514f1', 'cbca28682b22c76113027e7495f4c552', 0, '2017-04-22 09:43:47', 'web', NULL, 'web'),
(8, 'deadzonem4@abv.bg', 'e10adc3949ba59abbe56e057f20f883e', 'b60ef2852e77a676907c3f08571b360e', 1, '2017-04-22 09:44:49', 'web', '2017-04-22 12:50:43', 'web');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idcategory`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`idpost`),
  ADD KEY `FK_posts_user` (`iduser`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`idpost_category`),
  ADD KEY `FK_post_categories_post` (`idpost`),
  ADD KEY `FK_post_categories_category` (`idcategory`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`idpost_tag`),
  ADD KEY `FK_post_tags_post` (`idpost`),
  ADD KEY `FK_post_tags_tag` (`idtag`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`idprofile`),
  ADD KEY `unique_iduser` (`iduser`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`idtag`),
  ADD UNIQUE KEY `unique_title` (`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `unique_code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `idcategory` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `idpost` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `idpost_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `idpost_tag` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `idprofile` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `idtag` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `FK_posts_user` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `FK_post_categories_category` FOREIGN KEY (`idcategory`) REFERENCES `categories` (`idcategory`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_post_categories_post` FOREIGN KEY (`idpost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `FK_post_tags_post` FOREIGN KEY (`idpost`) REFERENCES `posts` (`idpost`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_post_tags_tag` FOREIGN KEY (`idtag`) REFERENCES `tags` (`idtag`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения за таблица `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `FK_profiles_users` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
