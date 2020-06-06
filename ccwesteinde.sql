-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: landstedgkccwest.mysql.db
-- Gegenereerd op: 26 jun 2019 om 09:02
-- Serverversie: 5.6.43-log
-- PHP-versie: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `landstedgkccwest`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `account`
--

CREATE TABLE `account` (
  `account_ID` int(11) NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_education` text,
  `account_email` varchar(255) NOT NULL,
  `account_password` text NOT NULL,
  `account_rights` tinyint(1) NOT NULL DEFAULT '0',
  `account_is_activated` tinyint(1) NOT NULL DEFAULT '0',
  `account_verification_token` text,
  `account_login_token` text,
  `account_failed_login` tinyint(1) NOT NULL DEFAULT '0',
  `account_is_blocked` tinyint(1) NOT NULL DEFAULT '0',
  `account_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `account`
--

INSERT INTO `account` (`account_ID`, `account_name`, `account_education`, `account_email`, `account_password`, `account_rights`, `account_is_activated`, `account_verification_token`, `account_login_token`, `account_failed_login`, `account_is_blocked`, `account_is_deleted`) VALUES
(1, 'Koen van Meijeren', NULL, 'koenvanmeijeren@gmail.com', '$2y$10$.GyMgcotjXMQ8zKuxgTUJuDod2W7J.16mqdp7Gd0zpmejTPjs/tj6', 4, 1, NULL, '04ff8ba663e45ff82929a12acd00a4abb1a73449e37f59482722153198cc24f787c1ae6cbfec502523d2252fe985078498dc6f0ec20a129a8585cd64bd74f8f11617f3518d511fc0f55c1d3d3dfaa94f7dbf869e4d7f398f518da4cc48d86b49c52577343e314bc25668c12d1b42f0b2c92e9234e950bc89738c31b3fefb4109b025a251a13488204497f3959c6828b5a4dc6b208b8aba07e07a1c30e1e421519abe0bf224cb5f702fe319244ecea396f4fffb57a242caeb6134b8a8c68e4639b8f3595c1e614821', 0, 0, 0),
(21, 'Koen', 'ICT', 'kmeijere0303@student.landstede.nl', '$2y$10$t8AH1RG49bvpEyuQGsp0FeiQBjWlbuMCmxGdEPRZnSQgktKUBTCva', 1, 1, 'abcedfghikj', '656feaed9582e66562540b5a518660caabb76fd590cddf91a043ae12d2063ee32066afda5f184c804f8319283446ebefbaf74257c084852f134459dd37b2d68a97aef8235c7f76ec3cd500cf91fc320eda81ffa8326ae3cf8ff3173f883198ead5a4d84b87e36f592789b68ca1a7667efc2250a2c6753e518ad8396fe1a0e1d20774102193265b4a53894c4bc06f3f37ac7146c2690bc8b4885eb095a96c9e617f12f3e934a3ae713e1bf5237976335e90cb6f04d568843abf6c274251ed15484b5bb677bf148089', 0, 0, 0),
(30, 'Marco', 'ICT', 'marco@student.landstede.nl', '$2y$10$es7Smlz0hriTJxhKuCMOJeW2JdVyMRW9FPmjUIg6V6VVMEIcNzP1y', 1, 1, NULL, '340ae6dd83cc1e40899490334ea8cc0f9301e16e5beb58e4cd0e7f28d45b63c9e29f5cbe6f94ad054898a291cdd6696ecad80419423f4384d562e513935ddeb058fc97b7befdf58f3be8b48aef09d425b3a26a37c9ffcacda0f699e9f93c56fe71a02f4b2d647dbda91a61a8d78aa7a02d071bf3a386c3da5f96510fda2e96d7741b5dbf6d959a694538fd33286bbbe6a09cb7026f5893a34294d1b08b6240a8cdc805cf8836664b47336e37d07d133b318ba17f2373a23ee309896a1b56a6db7a86c3f16eefc3a1', 0, 0, 0),
(31, 'Mart Postma', 'Media Vormgever', 'mpostma0398@student.landstede.nl', '$2y$10$D5MXCOjTTFVAydZlBC3iZO6w8oQ9RNAIEGxPjTeWt7RPjEQweq28W', 1, 1, '89ecf8dcce69380d427880db224445100b2dfc8337888bb8911064431e081436b6eb9e2c324d326e2aafa94d391153b45be8babf3cabbab55a8c03e2e3e81c3e562673d2c7f76583a2a19c7f14fbbc3a1e09a31466e0b45411d7d85fbd5bf45a59cfd4', '', 0, 0, 0),
(34, 'Albert Korf', NULL, 'akorf@landstede.nl', '$2y$10$jCg2SSglfsE5tk7YlyNQNuHssPf8sEPsrHS9U0GNkSEwOIW9wfQTi', 4, 1, NULL, '7bde29eb7c5457fc0f18e41242166398454d3dd9ea0fe073062bcd3ed53fd987cc98bde95676438f6479b0f94c8a7a821bf7c3543ae9e896ab26288f8549bd0fedcb16b3d5abc722469494af23c71372ca6da415da23c63e7c5bfda80bc75a628ae46668e0989316e393b4c1bddb124928243f704632238748316c2cb4a6b6ad762dabd5b313ae96c9b4e361bf3677cf2236e2060c8ce1268b2aeb14f24449540714d16cc0d87a1facf09a9c38fb4fe1283277779cf595cad915aeee289d800e4b8bb59751d28566', 0, 0, 0),
(35, 'Imre van Surksum', NULL, 'isurksum3807@student.landstede.nl', '$2y$10$EXBpcq7R4WhQC29GSPIUuOX9A2dWOiGCLYDdR3oGcZ10tKqOSB8He', 1, 1, NULL, '00072db287bbcfac44f046eb42a3b7cb28bcf864b66b6c4932e517ab608c2803f8822a85c14512311eb17fb4cd297b1a8f9cae1591a4ce855e0dc14f0f62a92262cd3d1c1b688026b841952a50bfb22fd3d9accd6dd3fba0e8e7abfebc5d8351dfa819e879319d729a63514a0229a92076302cb8639365d2d71a55f3cf58a5350731d9638b0cbe7c4a4b1d67e70359aa0dc1b1bc1945e7be5da86ff17c16e47f55f136196240876f312354324cfb5308aa94566b75b470228c7fe679cb00ffc98c7d4107ada7a539', 0, 0, 0),
(36, 'Emiel Snel', NULL, 'esnel@landstede.nl', '$2y$10$0QiZ/Vckq.60FHROZQFHUuKu26xioGd1dpV6pL0tpTFCzjXV4fbPi', 4, 1, NULL, 'ee5ca91c06853326755aa4b7446a095e2d6255e30126c00998cbc5ed4cf90d0c8f6a5dcab167762c8074c340725108bb350c458962796ca87544c35612a7ed203e7036a7bfdf6f4d81ad59365005ed7962648c419afd00873337c1f9c8b6232cfeaf1fd2c073890c36539bdcb8fe1a95a5b891fd7f8795a3d695f4d833ed0068406584c701228d818d95eccb8703e53b4788cff5233ac72093c8fe46f8a540b52b5817681e01bebd12bf85f0a48e28b4d7a161ad816fe82becbc0fff3feb97024c033e0d52658bb5', 0, 0, 0),
(39, 'daniel rijers', 'ICT', 'drijers3221@student.landstede.nl', '$2y$10$bPwY59YlQgOXHZ24k4dQFe6h1QA3GjM6AQAGIy4wdahz2QWd7dZLe', 1, 1, 'b7ffd02747fa94c06e932e4a87dcc6d961d079594e0c4557c12b2f31b53cadddeef0f258dccf5eacfab4c95facc02b754cc28955a8e1096788b1dde356f5433c4dab289bda864bb94f1c536ff322ee87d5ce24b0f499206e9afb3440da2d8d868872eb', 'a068e1ddf7cbb3b4c3b431401a288621323e4338fc06bbaafcde82d5721036555afdfa89162196e25ec5f773c09e02adcedf33c273afc6f5504ef9c88486e80d5b2b9840b17891279e0bf65983a6aa8b9edf0bc8f8ebfbc21384c2883e8289c0230dc3ebb1d699c097d2d28d6edc47f5c076b59cc8c44533b9fc1f9c3354f8e389b4851bf637b5bffbcff48566b3c99ec496e221161996649e7c5336cc421d7289d2b7dad4a0af2137bcf8cd38aed4f2e14c7f7cfff8cf55d2417698b2da0b38563aa189613f28ec', 0, 0, 0),
(40, 'Stan Nieuwmans', 'ICT', 'snieuwma3456@student.landstede.nl', '$2y$10$0Kxlo2wzFQD1ND9RMkMC4e.kqW3uUwzbtDA5Q4NC85M20mNKs9BCG', 1, 1, '37dcd07d93da80886cdfad00300cf5591a9ee5181f925bf6a279a3c1ee46c051b181c52477bab50c211a6fd69dcf8af7b6f6c425e36d5c8ed40133e5ff5c3fc185f4b05a7a75bbfa656b14834641c04956ab1df5f4672927ecca8f45a6736cf4215cd4', '9ce564a6071415c85e4b5c2c660458983fbebbf0aa96be0ee55c0696d852bdce97475c9396988c0fb9d8212d9cc2a9becc91edc35132a61d8958cf33e61db3236873815cb9b078cf80cd6874c9b903157300bc4e3f73e2372a9beb5ba14b1f31fb3096e2870b41b2e49cf0857549d9c6275daea269276c21356038c3eab35915bc061249cd3a4bcdcde6883f635a9d06660b841606ee589368dde2ba4797c24281b17307aebd5b2083e626825e95922f263aedbb1713bedc8e4f12e3ceef1e580229b9a61496cc6e', 0, 0, 0),
(41, 'Nathan', 'Ict applicatie', 'Nschuppe5102@student.landstede.nl', '$2y$10$eddU.ba8d28K8cJ2uQ7CX.a89XjA6c2GFpqGsYT0Oj0URE8/J5ZAS', 1, 0, '108d972a4812cdf6c95386ae830ea3d3e7f4ea86dd1c25197cb77efbaa754192b38b01d05af0abf333d48476fcc76421a83e573f617bb0191263ea6fbd0a71deef64f2e17b39a999539215073fa57c1432fcb4fc5b9d6f68c567fb92987aeeb8456de4', NULL, 0, 0, 0),
(42, 'Leon Bouw', 'Applicatie en Mediaontwikkelaar', 'lbouw9128@student.landstede.nl', '$2y$10$2LYWv/5qqDVQSwyV0AEKVeJ.GwC8IdUMZvgXNxQt8sAMCSBCGqOqe', 1, 1, '21c00b6045c4f188dbeda0e5a6b19eabd728c010c3f8d82a6de1267856f25ee0f7a6dd4479d51b75ca0e67b6640617dfae44d6749927a9c76d58accf52ac2fa468595e79b9ca8baf09fe04d7dcd9341a51f239ce43ea0e7b873571984508eca9e994ed', '83275af93da2aa13d7f86f2c9a5b361d92aecc67a0d3a1106069510099f4d18d9ecf3ce3196b412194a633576d2858c2594c795623d0dc32a80afc9f6aa7a3b57763610dff617b72925f0062ece0cf22f56c281d21dd0a6bfaf6bcaa62c3bf415671b0eb5689d96cd0dcb5feadb26fea1d6729ee86af355463aa2ca6ba793ddd62263164fa9aa8ec15158db0f9fbfe3e1ce8de2ce8661b4439992f3f89d738d165a2a1f6a86ab7435d1f28bd84c9790ee68dac1f2279f50d12b8732d672d3e482908d4ce947fed6d', 0, 0, 0),
(43, 'Lotte', 'Signspecialist', 'lschakel4702@student.landstede.nl', '$2y$10$G7zVEDz504N5aScomRIEdOhdhz9FlAidyN1wefXfVo9FjDJQ1Dj96', 1, 1, '2596df7617c3ed46ba3cf7e976a5869d88e3be98be9b9a2a80ea10ed4007b9a7ee5f51bb8dbcacc4c99317c31ffa4a0adb9a5aecd457c45bebe72a76ab62705f92dc9343f8576c243f078d18b0134d1ade45d9527e9f8e26e21952ef329146336517d2', '8dd0979768663867a14fde324274d7b0733610a3d26ed3a4acc378c36639ecddc01e263b2d42410749ed365371011012a52205d45dd2f5b4c3fdf73c7eebfbdf531b47cbbe38798db7b3e55d27012c43f44c63f3d10c7aea8414eddb6dd70d905273cf12ecc60996170e37be8a7407713c48e6a778075b396b2e5ba0ef0e5d8923bb4f449d131be1b5472b3ed8c277e3c5484e8bd50f9af3c39ae7527dc213d7e83178c7330266768bd85946f7a2a1ccdbb64f73a0bb402be884569bec4214c02beb822ad82bf9a6', 0, 0, 0),
(44, 'Eise', 'ICT', 'esnijder3239@student.landstede.nl', '$2y$10$N3RwJE1HlltqxdRMq2bZreg2sx2M3gaFZ8e/2Fqyh6Z.Bw0G.6bYi', 1, 1, '39c3692d6e4b6a6dbce468a055320be2d5341fda6ea904f0ac8905c662745c293535b236748bc740cdffc9d0f161089dd76b454e7f2b097f91e1189df4a40b8b14ff5122d461ef5e2fe73f4edb9d971c124f76be7ad80a1fcc00ea8949f5d044875fd9', '557d616abdc734f9fd3b3b50bd64565b7aa67cdff40eaebed55056e393f708a7f677231d783f8bba75ec3e05c1e83fb9c7e15f2b21e30c030fb11893b2579026e39f205aa0133449f2d7bb6121be9e6ff8ba884ae642e08552ac442dafed3f66997d96b22351f6abecd113725bdcb16ca2e778ea47da6f2fa29ffe979a979b2be3d177923960fbc13e6f787e600c8464849c99de2f623b9d33283bc4861a8601a12ffb212dcd9bdc34140f78967f051afddbe86a655dbfe563058594165c2ce23092d6898657a122', 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contact`
--

CREATE TABLE `contact` (
  `contact_ID` int(11) NOT NULL,
  `contact_branch_ID` int(11) NOT NULL,
  `contact_landscape_ID` int(11) NOT NULL,
  `contact_name` text NOT NULL,
  `contact_email` text NOT NULL,
  `contact_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `contact`
--

INSERT INTO `contact` (`contact_ID`, `contact_branch_ID`, `contact_landscape_ID`, `contact_name`, `contact_email`, `contact_is_deleted`) VALUES
(2, 3, 6, 'Koen van Meijeren', 'kmeijere0303@student.landstede.nl', 0),
(6, 3, 6, 'Pim Zijlstra', 'pzijlstra@landstede.nl', 0),
(7, 5, 7, 'Cees van Buuren', 'cvanbuuren@landstede.nl', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `entity`
--

CREATE TABLE `entity` (
  `entity_ID` int(11) NOT NULL,
  `entity_slug_ID` int(11) NOT NULL,
  `entity_name` text NOT NULL,
  `entity_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `entity`
--

INSERT INTO `entity` (`entity_ID`, `entity_slug_ID`, `entity_name`, `entity_is_deleted`) VALUES
(3, 18, 'Applicatie ontwikkelaar', 0),
(5, 18, 'Media vormgeving', 0),
(6, 19, 'ICT', 0),
(7, 19, 'V&amp;amp;E', 0),
(8, 18, 'ICT beheerder', 0),
(10, 18, 'Sign', 0),
(12, 18, 'ICT netwerkbeheerder', 0),
(13, 19, 'Bouw', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `event`
--

CREATE TABLE `event` (
  `event_ID` int(11) NOT NULL,
  `event_thumbnail_ID` int(11) NOT NULL,
  `event_banner_ID` int(11) NOT NULL,
  `event_title` text NOT NULL,
  `event_content` text NOT NULL,
  `event_start_datetime` datetime NOT NULL,
  `event_end_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_location` text NOT NULL,
  `event_maximum_persons` int(11) NOT NULL,
  `event_is_archived` tinyint(4) NOT NULL DEFAULT '0',
  `event_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `event`
--

INSERT INTO `event` (`event_ID`, `event_thumbnail_ID`, `event_banner_ID`, `event_title`, `event_content`, `event_start_datetime`, `event_end_datetime`, `event_location`, `event_maximum_persons`, `event_is_archived`, `event_is_deleted`) VALUES
(2, 77, 7, 'ABC leren', '&amp;lt;h3&amp;gt;Het leren van het &amp;#39;ABC&amp;#39;&amp;lt;/h3&amp;gt;\r\n&amp;lt;div id=&amp;#34;Translation&amp;#34;&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;#34;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.&amp;#34;&amp;lt;/p&amp;gt;\r\n&amp;lt;h3&amp;gt;Sectie 1.10.32 van &amp;#34;de Finibus Bonorum et Malorum&amp;#34;, geschreven door Cicero in 45 v.Chr.&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;#34;Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?&amp;#34;&amp;lt;/p&amp;gt;\r\n&amp;lt;h3&amp;gt;1914 vertaling door H. Rackham&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;#34;But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?&amp;#34;&amp;lt;/p&amp;gt;\r\n&amp;lt;h3&amp;gt;Sectie 1.10.33 van &amp;#34;de Finibus Bonorum et Malorum&amp;#34;, geschreven door Cicero in 45 v.Chr.&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;#34;At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.&amp;#34;&amp;lt;/p&amp;gt;\r\n&amp;lt;h3&amp;gt;1914 vertaling door H. Rackham&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;#34;On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains.&amp;#34;&amp;lt;/p&amp;gt;\r\n&amp;lt;/div&amp;gt;\r\n&amp;lt;hr /&amp;gt;', '2019-07-30 13:47:00', '2019-07-30 15:15:00', 'Utrecht', 2, 0, 0),
(6, 76, 4, 'Lasersnijden voor beginners', '&amp;lt;h3&amp;gt;Workshop F&amp;lt;/h3&amp;gt;', '2019-06-16 13:11:00', '2019-06-16 01:09:00', 'Utrecht', 5, 0, 0),
(8, 75, 58, 'Hoe start ik een bedrijf?', '&amp;lt;p&amp;gt;dfbndthskjrgsrjbg;lsjrglshjrglsjrgl/kwrG JKJHGKJK KJH KH H JJ LJH LH H UHJYFKkg gjyg g&amp;amp;nbsp;&amp;lt;/p&amp;gt;', '2019-06-18 09:37:00', '2019-06-18 12:08:00', 'Harderwijk', 30, 0, 0),
(11, 74, 60, 'Verfen met water', '&amp;lt;h3&amp;gt;Verfen met water&amp;lt;/h3&amp;gt;', '2019-06-14 15:00:00', '2019-06-14 16:00:00', '1p4', 15, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `file`
--

CREATE TABLE `file` (
  `file_ID` int(11) NOT NULL,
  `file_path` text NOT NULL,
  `file_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `file`
--

INSERT INTO `file` (`file_ID`, `file_path`, `file_is_deleted`) VALUES
(1, '/storage/media/677261736c656767656e2e6a7067.jpeg', 0),
(2, '/storage/media/6e696768742d766965772d323134303938325f313238302e6a7067.jpeg', 0),
(3, '/storage/media/626c617577652d7a65696c656e2e6a7067.jpeg', 0),
(4, '/storage/media/626c75652d343131393831365f313238302e6a7067.jpeg', 0),
(5, '/storage/media/6d61696e6c696e6b2d332e6a7067.jpeg', 0),
(6, '/storage/media/44534330333736372d373030783330302e6a7067.jpeg', 0),
(7, '/storage/media/63726179736964652d736563746f72732d696e647573747269616c2e6a7067.jpeg', 0),
(8, '/storage/media/3530305f465f38303539313133305f56535176453963476b6d4e565541627163653430726778786f5962384b4250672e6a7067.jpeg', 0),
(9, '/storage/media/61657269616c2d766965772d6f696c2d6761732d696e647573747269616c6f696c2d3236306e772d313039393633343936302e6a7067.jpeg', 0),
(10, '/storage/media/6865726f2d683030332d696e642d7265662d6f696c726566696e6572792d3030342e6a7067.jpeg', 0),
(11, '/storage/media/6d61702e737667.svg', 0),
(12, '/storage/media/626c6f6227df8a2d86efcd2b4674716488c41b854cdf82a954727ca7d83218eef9b36899a1ca5c204791c3a4.png', 0),
(13, '/storage/media/626c6f6220c48e210aa99712c548fdc247ace0550154688d0e04e60cde3d8990f1c4bad2360111e6956ddfcd.png', 0),
(14, '/storage/media/626c6f625a49b610cf3e5a6543421bea72aa9475b072f00eb19e94b1d9145e288cadcc01524589bbe089d44c.png', 0),
(15, '/storage/media/626c6f626a9e1e2bc9fa7b66d844d42a7bbe26a6205a047f5f579e6a88f3f4c4a32b29c968d838d421e169ca.png', 0),
(16, '/storage/media/626c6f62efb5cb2c5ce664e01c71aae97913427ac684bba564d99df659545d5817387bd6c11b5d08fe0e0eb1.png', 0),
(17, '/storage/media/626c6f6232eaf6cfb3b951186282b92a6a0a5b57e292a0d3b40543e6881c47faa9b497d5359d62f8f6225e59.png', 0),
(18, '/storage/media/626c6f62452457dcf665d71c617f6827ae968066e7350571df0a6e20a00f8bbaf6e6ac07bf89fddfb20507b6.png', 0),
(19, '/storage/media/626c6f6260b8572cacfa44a67549e228e966fede5070416549ec0e1cb1346da9242e9cf7f87da8a0f2502deb.png', 0),
(20, '/storage/media/626c6f6234b981eecbb30fb14b5b4f84975db8be8c93d0054d8ca46359c7c47c47d6db1cfd408d9e32b2390b.png', 0),
(21, '/storage/media/626c6f62026b7cca6949eafd47c1c312086969085e7135d665eb9a0ec2b10d6d9492e60fce683ca946b11ebd.png', 0),
(22, '/storage/media/626c6f62af0b4f71ab94ee65a6396e18a7e931603547dbbafa7e357ee0de98bd7b3b4f3a12aacf9de3056608.png', 0),
(23, '/storage/media/626c6f6203b195439af16d0d67de36adc46a180078d8ec13d875aa7cf0fa87200c51fb0268794acb3d2a337f.png', 0),
(24, '/storage/media/626c6f62d911ccfe841b45628386d7cfa60d383d4eb7d8ce97eecb0e660182bb477dfd6aad3562b8bf416c07.png', 0),
(25, '/storage/media/626c6f628dfa21f7a3ef3e9456ade5b9ed993df9806836efe7b83366e48e99bee64c7b70e476e293631f4424.png', 0),
(26, '/storage/media/626c6f62634ecb880b06d1ef96c63befa6eb2dbf4600819eb0fc1fd2766729e0aa15ef9e90820edcaad39a4d.png', 0),
(27, '/storage/media/626c6f620995a07a52f4e231ba2435551e74b8d867f4b7b413613f5c792bf6078c0dcf59121fe62da236e481.png', 0),
(28, '/storage/media/626c6f62839320ce1d8c03ec653a6ab9ebee211aac96eba55ed4efb05c966b1db8a3a7a883b2634b8756a53f.png', 0),
(29, '/storage/media/626c6f622c6f8c4524d0c7ebeb81452edc5bd4d87a230522f97c750308b431095743f21cd6f3edad5eaadbeb.png', 0),
(30, '/storage/media/626c6f62572e57fd06ea91b2970eb9c10afefd937bbd0d7ac09b1544769f621a979eee8f5ee96f7efe0e9053.png', 0),
(31, '/storage/media/626c6f627583d59f91417da5a6182b0f20d7a0d5a2241ea44fd3d686ff0389b5bf0c4cd15b2750b2108c4509.png', 0),
(32, '/storage/media/626c6f622bed31d41d33a6f45f0b819c8feb108822bce66d0755e32071c5633b0cd698138656f7c617431139.png', 0),
(33, '/storage/media/626c6f624069daf370d7c0e67d782a8af4c69ab51fecec74fc4a7d0ca6995cefea1afebc2e897a9edc9382d6.png', 0),
(34, '/storage/media/626c6f62c759e0a18edf028ed4b6ad85e2dbd07de6b585dba4901a1dfb117bffa875061b73281cdda7bdecf8.png', 0),
(35, '/storage/media/626c6f624d394c1f1d096abcaf89af95676188df4c610ac7928fd005ceb5eaeea1db7d9cd0669f093010d649.png', 0),
(36, '/storage/media/626c6f62496a44af653c8adb5c4f86ae01eb4eef709b4d1088bb99272c7900760b7282040804eca44e401ac9.png', 0),
(37, '/storage/media/626c6f62e5ac37ae65fba8c8a33eb879f1c6b8b5d6bf48c910ae3d1274d03fb07f13e23b943e2118045785d9.png', 0),
(38, '/storage/media/626c6f6228d25bad4a8766b72d85705f63698a1b6ae5ffdb8c915ade01d57ca57e9b6404738885634f6a78ff.png', 0),
(39, '/storage/media/626c6f62fbd8f04aad3672e9c568ef661a44a3abdd316206406888c115fdb68efc0344729c6f1d35e30393c6.png', 0),
(40, '/storage/media/626c6f62cc30bf1cfbfdde3b0412b89b0a082242cba90c03ec37a10b6522d16afa3d0cf21a04af57037dd2da.png', 0),
(41, '/storage/media/626c6f62ab7afe915be091b876942a07e2c1f0036f4ad607bdbc1d44ca84813681e4d1402e60a49d726780f3.png', 0),
(42, '/storage/media/626c6f62ec493842ac6321740b4ea5c5f3c1432eec7e0e029589243694edda31f34f5a75e6bbd7d06692d730.png', 0),
(43, '/storage/media/626c6f62ad9c553f36c764752d70086d13d2ea1db5d55bcf5472a7cfba6c53e96f16cbb93bb2c2270562f9dc.png', 0),
(44, '/storage/media/626c6f625bad3e117e6503d2032299d5195ceafc96f4d43c237a456b5bc35df2a837e46bfe2497fe16246062.png', 0),
(45, '/storage/media/626c6f627c6668df3ecb7c8c855104e448e02cc564e0d22ff8ee235a2f61fccaacd6940b1ecaee3fb08263e8.png', 0),
(46, '/storage/media/626c6f62633a9355f817b235879ac587731e3c081eb7adb2781294630e36adeca8f69494c0e7d5e106d41dec.png', 0),
(47, '/storage/media/626c6f62a8833197f680980aac1c819174719fb4ad2708c927789e1895ce3c5bdfda51fbfb4f0f5da185d02a.png', 0),
(48, '/storage/media/626c6f625490e40dcb8a1f8ba3b426574d2401d235b9e057f7d7505b7ebc71170386050c4ba9eda77e9cdc70.png', 0),
(49, '/storage/media/626c6f629d93b5af937edfc5b04e25c93e99a81f383e4f84bc1a38cb91b413ab55f0ead587bba8c97f0dd602.png', 0),
(50, '/storage/media/626c6f62b4e9bae108265c15bab0c8265149cf31870ea5b08b5fb0cd73e8e501c272462b8f9537bb14d5143c.png', 0),
(51, '/storage/media/626c6f620ff3e0dbcf7a7eb3d7b98f2df84b014cdc450fe89f1f3cd6d8390f0437ee6cf7bb27a6f8f572090b.png', 0),
(52, '/storage/media/626c6f629a237bf08b0d757245af0098868aaf7dc6421c11b0bcd59d11333828f3ca91c6c5c672fd9af8a2d0.png', 0),
(53, '/storage/media/626c6f62d28b8162e11ad4607bdc63118ef18c76c5d7945504db062c4b1fbcd3c7ffc0ea638c2bbc5b51d1a8.png', 0),
(54, '/storage/media/626c6f62bf22b7c1d52921614879f29e7b5695e6e28c603c9be8eb0b40a2db58a0874b1e30a234419f154195.png', 0),
(55, '/storage/media/626c6f62a6a118e920859f334c8f8684ce1614f0050c8f82a4bea0698884015987029bb3076737ad3d7e6a0d.png', 0),
(56, '/storage/media/626c6f62c7c5ef56a3f7bfeb8e6809a1934f46fc147787aa48404a838108c293e10b3e318c91d08f7e0173cc.png', 0),
(57, '/storage/media/626c6f6212bfa86639917e8822173887d89b7a9f1419070e2c93d973b0de896a2b6d3a73c82c46e99556076a.png', 0),
(58, '/storage/media/626c6f62f7bc5c721a5a836c547e3749fcfe63c8161307b32568942b5a5a56b1e703fd604e17fe0a1e07c245.png', 0),
(59, '/storage/media/626c6f625a237022c7a85b0499a9848dd7365415a536fa3fb941c8e59d938541a3fe889e778d3d922e7516ff.png', 0),
(60, '/storage/media/626c6f62c2be5033ab4066354b92b846243e2e828751d1c25ecc25d8bf4ccd753e0d0ecb420bd940ebe559ca.png', 0),
(61, '/storage/media/626c6f62a4f7a350112954e418d104bac922b2a7cc9620b957e83e1b4b96328fe1ad0dde261da4aea8a829ca.png', 0),
(62, '/storage/media/626c6f629df0f8db1e308f787f6290a5fb846f5578d47ff086631bb857fc42f2905e86ea85993b893c6d4076.png', 0),
(63, '/storage/media/626c6f62743f344f20657768ebedb7130f8793ddffe20a8805649194bcec758da5d4b8b8b0c02d0cd78f0c2e.png', 0),
(64, '/storage/media/626c6f620c487cfb3c8d7c23db9b3168cb86828ad19d79642965f3bdd979b88951768a52f6fe2a2e0dd426b6.png', 0),
(65, '/storage/media/626c6f62ece4464ec8b65db2c9f25c95a55f486fbf1d2f8116b9157f4f10fffe5a4bc1a9a5a1d5f4d1c4d1ad.png', 0),
(66, '/storage/media/626c6f6292c0c0fce4bfae8fb7eef7920906b9647d649ad6331f18962d179063a66d8fe6b0c46f913dd6067a.png', 0),
(67, '/storage/media/626c6f625920c648a1804ba2ab0e43f4d945bd9fd851610bcf6bf7c50675563db1466665b7c094c5e992592c.png', 0),
(68, '/storage/media/626c6f6225bcbcf59edaa14cc87679b6ed45807a2abd7a7db4588973737c12b54b52b76623f389c62b2a08fa.png', 0),
(69, '/storage/media/626c6f626baba1ffc30c6060fb7e998ef692664aa825f93ecac20cde6e17bee90c495d52cf92c077d388459f.png', 0),
(70, '/storage/media/626c6f627f60a216acea526d35b28526b46630041cde6bf6161fb98ec3c4519ecad622f2182f0c4c90e3b9d4.png', 0),
(71, '/storage/media/626c6f62d9434329f694f298003f3d01b456bfb3decf938f12577f188d28a58ba507259d142ee0a726ca1b29.png', 0),
(72, '/storage/media/626c6f62c6b327331805f4b28bf789e0b40f0dd3221da1ff3e17f1623c1edcb5b67070bdbb19fd9861949c65.png', 0),
(73, '/storage/media/626c6f62d54bec9ca2b9c18beded495e9175194881ecd3761d13fca6d973b06ed23b9c120184edeeab41f27e.png', 0),
(74, '/storage/media/626c6f62c85b20a5b552237f974c60c64902cd50796d219b7dc42dd6270a33310c2752fb5bd2b33c09120dfe.png', 0),
(75, '/storage/media/626c6f6259b15a9ee54e954bc5da4e5a59290eedcc539f8d55ecb5677c384bf0cf4218aab15188e2db12b321.png', 0),
(76, '/storage/media/626c6f62c87c2b80ec50c76d315d94611af9a6a4aae0c30d42157a8aa096a3fdaff7cd0e710722e10518727c.png', 0),
(77, '/storage/media/626c6f62840e898f861b4e8acdc32fa692d0348f24b3f331393006eac98993e82d75924791c2748aac90be7b.png', 0),
(78, '/storage/media/6c6f6e646f6e2d6d61702d302e6a706758796b097ce58d0c46de0aae67f694652b987c078ffe0acc8b4d40f2d3681f0d60d99aa923e5fb39.jpeg', 0),
(79, '/storage/media/626c6f62680fbd9355121316fd05a1e9ba1737ed3866e446e5bb0f342dbf5f2739be25b582b15ea6e1e5a334.png', 0),
(80, '/storage/media/626c6f622cc7ca43026ff77a6abca7e08005898e44f31e5690f70a1bb9639bf6476380c40d8044f04f06e88f.png', 0),
(81, '/storage/media/626c6f62271cfbbdaab2fcc991fa7b8fb43632a746732afa55aaa287ad739167f02d7ba1999d6799a1451ea4.png', 0),
(82, '/storage/media/706c6174746567726f6e642043432e737667b24533364a244a6af7ab0d0d54b32f4b838abe4a3b015b1f627dd11d3b9d516cabe070970890f1ff.svg', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `page`
--

CREATE TABLE `page` (
  `page_ID` int(11) NOT NULL,
  `page_slug_ID` int(11) NOT NULL,
  `page_title` text NOT NULL,
  `page_content` text NOT NULL,
  `page_in_menu` tinyint(1) NOT NULL DEFAULT '0',
  `page_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `page`
--

INSERT INTO `page` (`page_ID`, `page_slug_ID`, `page_title`, `page_content`, `page_in_menu`, `page_is_deleted`) VALUES
(1, 1, 'Home', '&amp;lt;h3&amp;gt;Een plek waar samen werkt!&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Cree&amp;amp;euml;ren en samenwerken! Dat zijn de vaardigheden waarmee we onze studenten willen voorbereiden op de toekomst. En wat werkt dan beter dan tijdens de opleiding al volop de gelegenheid krijgen om deze skills in de praktijk toe te passen.&amp;lt;/p&amp;gt;\r\n&amp;lt;h5&amp;gt;Welkom bij CC Westeinde!&amp;lt;/h5&amp;gt;', 3, 0),
(2, 2, 'Bedrijf', '&amp;lt;h3&amp;gt;Bedrijf&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Bedrijven pagina&amp;lt;/p&amp;gt;', 3, 0),
(3, 3, 'Student', '&amp;lt;h3&amp;gt;Student&amp;lt;/h3&amp;gt;\r\n&amp;lt;h3&amp;gt;Studenten pagina&amp;lt;/h3&amp;gt;', 3, 0),
(4, 4, 'Meet the Expert', '&amp;lt;h3&amp;gt;Meet the Expert&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;De volgende Meet the Expert-sessies zijn binnenkort mee te maken op het CC Westeinde.&amp;lt;br /&amp;gt;Schrijf je in voor de sessie waar je graag bij wilt zijn!&amp;amp;nbsp;&amp;lt;br /&amp;gt;&amp;lt;br /&amp;gt;Let op! Vanaf twee dagen van te voren kan je je niet meer afmelden.&amp;lt;/p&amp;gt;', 3, 0),
(5, 5, 'Projecten', '&amp;lt;h3&amp;gt;Projecten&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Hier vindt u alle gedraaide projecten binnen cc Westeinde.&amp;lt;/p&amp;gt;', 3, 0),
(15, 20, 'Contact formulier verzonden', '&amp;lt;h3&amp;gt;Contact formulier verzonden&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Het contact formulier is succesvol verzonden&amp;lt;/p&amp;gt;', 3, 0),
(16, 21, 'Contact', '&amp;lt;h3&amp;gt;Contact&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Neem contact op&amp;lt;/p&amp;gt;', 3, 0),
(17, 22, '404 - Pagina niet gevonden', '&amp;lt;h3&amp;gt;Pagina niet gevonden&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Deze pagina bestaat niet.&amp;lt;/p&amp;gt;', 3, 0),
(18, 24, 'Aanmelden voor MtE', '&amp;lt;h3&amp;gt;Meld je nu aan!&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;test&amp;lt;/p&amp;gt;', 3, 0),
(19, 25, 'Aanmelding verzonden', '&amp;lt;p&amp;gt;Succesvol aangemeld.&amp;lt;/p&amp;gt;', 3, 0),
(20, 26, 'Werkplek reserveren', '&amp;lt;h3&amp;gt;Werkplek reserveren&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Reserveer hier jouw werkplek&amp;lt;/p&amp;gt;', 3, 0),
(21, 27, 'Werkplek reservering verzonden', '&amp;lt;h3&amp;gt;Werkplek reservering verzonden&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Jouw werkplek is nu gereserveerd!&amp;lt;/p&amp;gt;', 3, 0),
(22, 6, 'Werkwijze/Visie', '&amp;lt;h3&amp;gt;Werkwijze&amp;lt;/h3&amp;gt;\r\n&amp;lt;div&amp;gt;Werkwijze&amp;lt;/div&amp;gt;', 1, 0),
(24, 76, 'Privacy', '&amp;lt;h3 style=&amp;#34;text-align: left;&amp;#34;&amp;gt;Privacy&amp;lt;/h3&amp;gt;\r\n&amp;lt;p&amp;gt;Privacy pagina&amp;lt;/p&amp;gt;', 5, 0),
(28, 81, 'Meet the Expert', '&amp;lt;h3 style=&amp;#34;box-sizing: border-box; margin-top: 0px; margin-bottom: 0.5rem; font-family: AauxBold; font-weight: 500; line-height: 1.2; color: #bababa; font-size: 1.75rem; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-decoration-style: initial; text-decoration-color: initial;&amp;#34;&amp;gt;Gearchiveerde Meet the Expert sessies&amp;lt;/h3&amp;gt;\r\n&amp;lt;p style=&amp;#34;box-sizing: border-box; margin-top: 0px; margin-bottom: 1rem; color: #bababa; font-family: Aaux; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: #ffffff; text-decoration-style: initial; text-decoration-color: initial;&amp;#34;&amp;gt;test&amp;lt;/p&amp;gt;', 3, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `project`
--

CREATE TABLE `project` (
  `project_ID` int(11) NOT NULL,
  `project_thumbnail_ID` int(11) NOT NULL,
  `project_banner_ID` int(11) NOT NULL,
  `project_header_ID` int(11) NOT NULL,
  `project_title` text NOT NULL,
  `project_content` text NOT NULL,
  `project_is_deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `project`
--

INSERT INTO `project` (`project_ID`, `project_thumbnail_ID`, `project_banner_ID`, `project_header_ID`, `project_title`, `project_content`, `project_is_deleted`) VALUES
(1, 67, 69, 70, 'Gamedesign  |  ICT en VE', '&amp;lt;h1&amp;gt;Gamedesign&amp;lt;/h1&amp;gt;\r\n&amp;lt;p&amp;gt;Kan je een game ontwerpen en deze viral laten gaan?&amp;lt;/p&amp;gt;\r\n&amp;lt;p&amp;gt;Met deze opdracht als uitdaging zijn studenten ICT en Mediavormgeving aan de slag gegaan. Bedenk een concept, een thema en communicatieplan en bouw vervolgens als team deze game. Binnen 10 weken moest deze game gerealiseerd zijn. Met een grote presentatie is het eindresultaat aan de klant overhandigd.&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;lt;video controls=&amp;#34;controls&amp;#34; width=&amp;#34;300&amp;#34; height=&amp;#34;150&amp;#34;&amp;gt;\r\n&amp;lt;source src=&amp;#34;https://www.facebook.com/586782101708811/videos/606886006365087/&amp;#34; /&amp;gt;&amp;lt;/video&amp;gt;&amp;lt;/p&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;', 0),
(2, 64, 65, 66, 'Maakshop  |  CC Westeinde', '&amp;lt;h1&amp;gt;Maakshop&amp;lt;/h1&amp;gt;\r\n&amp;lt;p&amp;gt;Binnenkort in CC Westeinde: De mogelijkheid voor studenten om verslagen te laten inbinden/bedrukken, items te laten vervaardigen en projecten te laten uitvoeren. Al deze mogelijkheden worden gebundeld in de Maakshop. In opdracht van CC Westeinde wordt voor het presenteren van dit idee een logo ontwikkeld en verschillende items met dit logo bedrukt. Studenten regelen het frezen van een broodplank en het bedrukken van een schort.&amp;lt;/p&amp;gt;\r\n&amp;lt;p&amp;gt;Klant: CC Westeinde&amp;lt;/p&amp;gt;', 0),
(7, 71, 72, 73, 'VE Awards  |  Diploma-uitreiking', '&amp;lt;p&amp;gt;VE Awards&amp;lt;/p&amp;gt;\r\n&amp;lt;p&amp;gt;&amp;amp;nbsp;&amp;lt;/p&amp;gt;\r\n&amp;lt;p&amp;gt;Voor de diploma-uitreiking van schooljaar 2018-2019 is een thema met daarbijhorende vormgeving gereailseerd door studenten vierdejaars.&amp;lt;/p&amp;gt;', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `setting`
--

CREATE TABLE `setting` (
  `setting_ID` int(11) NOT NULL,
  `setting_key` text NOT NULL,
  `setting_value` text NOT NULL,
  `setting_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `setting`
--

INSERT INTO `setting` (`setting_ID`, `setting_key`, `setting_value`, `setting_is_deleted`) VALUES
(1, 'companyName', 'CC Westeinde', 0),
(2, 'companyTel', '0612345678', 0),
(3, 'companyEmail', 'info@ccwesteinde.nl', 0),
(4, 'companyAddress', 'Westeinde 33', 0),
(5, 'companyPostcode', '3844DD', 0),
(6, 'companyCity', 'Harderwijk', 0),
(7, 'facebook', 'https://facebook.com/hoi', 0),
(8, 'instagram', 'https://www.instagram.com/veharderwijk/', 0),
(9, 'linkedin', '', 0),
(10, 'youtube', '', 0),
(11, 'twitter', '', 0),
(12, 'studentEmail', 'student.landstede.nl', 0),
(13, 'teacherEmail', 'landstede.nl', 0),
(14, 'workspace_image', '/storage/media/706c6174746567726f6e642043432e737667b24533364a244a6af7ab0d0d54b32f4b838abe4a3b015b1f627dd11d3b9d516cabe070970890f1ff.svg', 0),
(15, 'schoolOpeningHour', '08:30', 0),
(16, 'schoolClosingHour', '16:00', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `signup`
--

CREATE TABLE `signup` (
  `signUp_ID` int(11) NOT NULL,
  `signUp_user_ID` int(11) NOT NULL,
  `signUp_event_ID` int(11) NOT NULL,
  `signUp_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `signUp_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `signup`
--

INSERT INTO `signup` (`signUp_ID`, `signUp_user_ID`, `signUp_event_ID`, `signUp_accepted`, `signUp_is_deleted`) VALUES
(2, 21, 2, 1, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `slug`
--

CREATE TABLE `slug` (
  `slug_ID` int(11) NOT NULL,
  `slug_name` text NOT NULL,
  `slug_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `slug`
--

INSERT INTO `slug` (`slug_ID`, `slug_name`, `slug_is_deleted`) VALUES
(1, 'home', 0),
(2, 'bedrijf', 0),
(3, 'student', 0),
(4, 'meet-the-expert', 0),
(5, 'projecten', 0),
(6, 'werkwijze', 0),
(7, 'test-pagina-ingelogd', 0),
(8, 'test', 0),
(9, 'werkplek', 0),
(10, 'vergaderruimte', 0),
(11, 'fotos', 0),
(12, 'testen', 0),
(13, 'testenn', 0),
(14, 'testennnn', 0),
(15, 'uitloggen', 0),
(16, 'testvankoen', 0),
(17, 'koenie', 0),
(18, 'branch', 0),
(19, 'landscape', 0),
(20, 'contact-verzonden', 0),
(21, 'contact', 0),
(22, 'pagina-niet-gevonden', 0),
(23, 'fdas', 0),
(24, 'meet-the-expert-events-aanmelden', 0),
(25, 'meet-the-expert-aanmelding-verzonden', 0),
(26, 'werkplek-reserveren', 0),
(27, 'werkplek-reservering-verzonden', 0),
(28, 'admin/events', 0),
(29, 'admin/event', 0),
(30, 'admin/event/1/archive', 0),
(31, 'admin/meet-the-experts', 0),
(32, 'admin/event/2/archive', 0),
(33, 'meet-expert-event/1', 0),
(34, 'meet-the-expert/aanmelden/2', 0),
(35, 'meet-the-expert/aanmelden/4', 0),
(36, 'meet-the-expert-events', 0),
(37, 'maintenance/student', 0),
(38, 'account/fdadf', 0),
(39, 'aanmeldingen-reserveringen-beheren/aanmelding/0/aanmeldingen-reserveringen-beheren/docent', 0),
(40, 'aanmeldingen-reserveringen-beheren/docent', 0),
(41, 'werkplek/werkplek/reserveren/stap-2', 0),
(42, 'werkplek/stap-2', 0),
(43, 'reserveren-werkplek', 0),
(44, 'reserveren-werkplek-stap-2', 0),
(45, 'werkplek/reserveren&amp;kind=9', 0),
(46, 'werkplek/reserveren-stap-2', 0),
(47, 'werkplek/reserveren/stap-2&amp;time=', 0),
(48, 'werkplek/reserveren/stap-2', 0),
(49, 'werkplek/werkplek/gereserveerd', 0),
(50, 'werkplek//gereserveerd', 0),
(51, 'fads', 0),
(52, 'aanmeldingen-reserveringen-beheren/aanmelding/5/verwijderen/docent', 0),
(53, 'aanmeldingen-reserveringen-beheren', 0),
(54, 'aanmeldingen/beheren/docent', 0),
(55, 'reserveringen/beheren/docent', 0),
(56, 'aanmeldingen-reserveringen/beheren', 0),
(57, 'aanmeldingen-reserveringen-beheren/aanmelding/9/verwijderen', 0),
(58, 'aanmeldingen-reserveringen/beheren/aanmelding/9/verwijderen', 0),
(59, 'aanmeldingen-en-reserveringen-beheren', 0),
(60, 'aanmeldingen/beheren', 0),
(61, 'aanmeldingen-en-reserveringen/beheren', 0),
(62, 'reserveringen/beheren', 0),
(63, 'resources/assets/plugin-frameworks/bootstrap.min.js.map', 0),
(64, 'resources/assets/plugin-frameworks/bootstrap.min.css.map', 0),
(65, 'resources/assets/plugin-frameworks/maps/swiper.jquery.js.map', 0),
(66, 'storage/media/6d61696e6c696e6b2d332e6a7067.jpeg', 0),
(67, 'storage/media/626c75652d343131393831365f313238302e6a7067.jpeg', 0),
(68, 'storage/media/6e696768742d766965772d323134303938325f313238302e6a7067.jpeg', 0),
(69, 'storage/media/3530305f465f38303539313133305f56535176453963476b6d4e565541627163653430726778786f5962384b4250672e6a7067.jpeg', 0),
(70, 'storage/media/6865726f2d683030332d696e642d7265662d6f696c726566696e6572792d3030342e6a7067.jpeg', 0),
(71, 'storage/media/63726179736964652d736563746f72732d696e647573747269616c2e6a7067.jpeg', 0),
(72, 'storage/media/626c617577652d7a65696c656e2e6a7067.jpeg', 0),
(73, 'storage/media/61657269616c2d766965772d6f696c2d6761732d696e647573747269616c6f696c2d3236306e772d313039393633343936302e6a7067.jpeg', 0),
(74, 'account/bewerken', 0),
(75, 'werkplek/reserveren', 0),
(76, 'privacy', 0),
(77, 'privacy-test', 0),
(78, 'dag', 0),
(79, 'werkplek-reservering-verzonden!', 0),
(80, 'inloggen-pagina', 0),
(81, 'meet-the-expert-gearchiveerd', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `translation`
--

CREATE TABLE `translation` (
  `translation_ID` int(11) NOT NULL,
  `translation_name` text NOT NULL,
  `translation_value` text NOT NULL,
  `translation_language` varchar(2) NOT NULL DEFAULT 'nl',
  `translation_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `translation`
--

INSERT INTO `translation` (`translation_ID`, `translation_name`, `translation_value`, `translation_language`, `translation_is_deleted`) VALUES
(1, 'call_to_action_bedrijf_tekst', 'Wilt u meer weten, een project inbrengen of een afspraak plannen?', 'nl', 0),
(2, 'call_to_action_bedrijf_knop_tekst', 'Informatie &amp;gt;', 'nl', 0),
(3, 'call_to_action_student_tekst', 'Wil je informatie over lopende projecten of een werkplek reserveren?', 'nl', 0),
(4, 'call_to_action_student_knop_tekst', 'Informatie &amp;gt;', 'nl', 0),
(5, 'call_to_action_meet_the_expert_tekst', 'Inspirerende sessies waarin experts uit het vakgebied ervaringen delen!', 'nl', 0),
(6, 'project_bekijken_knop_tekst', 'Bekijken &amp;gt;', 'nl', 0),
(7, 'projecten_foto_alt_tekst', 'Projecten', 'nl', 0),
(8, 'call_to_action_bedrijf_foto_alt_tekst', 'Bedrijf', 'nl', 0),
(9, 'call_to_action_student_foto_alt_tekst', 'Student', 'nl', 0),
(10, 'call_to_action_meet_the_expert_foto_alt_tekst', 'Meet the Expert', 'nl', 0),
(11, 'call_to_action_bedrijf_contact_titel', 'Contact', 'nl', 0),
(12, 'call_to_action_bedrijf_contact_tekst', 'Bent u geïntereseerd of heeft u een project. Neem contact op!', 'nl', 0),
(13, 'call_to_action_bedrijf_contact_knop_tekst', 'Contact opnemen &amp;gt;', 'nl', 0),
(14, 'formulier_werkveld_label', 'Werkveld', 'nl', 0),
(15, 'formulier_werkveld_kiezen', 'Kies werkveld:', 'nl', 0),
(16, 'formulier_email', 'Email', 'nl', 0),
(17, 'formulier_email_placeholder', 'Typ email', 'nl', 0),
(18, 'formulier_onderwerp', 'Onderwerp', 'nl', 0),
(19, 'formulier_onderwerp_placeholder', 'Typ onderwerp', 'nl', 0),
(20, 'formulier_bericht', 'Bericht', 'nl', 0),
(21, 'formulier_bericht_placeholder', 'Typ bericht', 'nl', 0),
(22, 'formulier_verzenden_knop', 'Verzenden', 'nl', 0),
(23, 'call_to_action_werkplek_titel', 'Werkplek ', 'nl', 0),
(24, 'call_to_action_werkplek_tekst', 'Werkplek reserveren', 'nl', 0),
(25, 'call_to_action_werkplek_knop_tekst', 'Reserveren &amp;gt;', 'nl', 0),
(26, 'call_to_action_meet_the_expert_aanmelden_titel', 'Meet the Expert', 'nl', 0),
(27, 'call_to_action_meet_the_expert_aanmelden_tekst', 'Aanmelden voor hele leuke Meet the Experts', 'nl', 0),
(28, 'call_to_action_meet_the_expert_aanmelden_knop_tekst', 'Aanmelden &amp;gt;', 'nl', 0),
(29, 'call_to_action_meet_the_expert_aanmelden_overzicht_titel', 'Binnenkort bij CC Westeinde', 'nl', 0),
(30, 'call_to_action_meet_the_expert_archief_overzicht_titel', 'Wat geweest is', 'nl', 0),
(31, 'call_to_action_meet_the_expert_bekijk_alles_knop_tekst', 'Bekijk alles &amp;gt;', 'nl', 0),
(33, 'meet_the_expert_aanmelden_locatie', 'Locatie:', 'nl', 0),
(34, 'meet_the_expert_aanmelden_datum', 'Datum:', 'nl', 0),
(35, 'meet_the_expert_aanmelden_tijdstip', 'Tijdstip:', 'nl', 0),
(36, 'meet_the_expert_aanmelden_beschikbare_plekken', 'Beschikbare plekken:', 'nl', 0),
(37, 'meet_the_expert_aanmelden_ingeschreven_tekst', 'Je bent ingeschreven voor deze Meet the Expert.', 'nl', 0),
(38, 'meet_the_expert_aanmelden_is_vol_tekst', 'Deze Meet the Expert is vol', 'nl', 0),
(39, 'meet_the_expert_aanmelden_knop_tekst', 'Aanmelden &amp;gt;', 'nl', 0),
(40, 'meet_the_expert_aanmelden_is_niet_meer_mogelijk_tekst', 'Voor deze Meet the Expert kan niet meer worden aangemeld.', 'nl', 0),
(41, 'formulier_welke_werkplek_reserveren_kiezen_tekst', 'Wat wil je reserveren?', 'nl', 0),
(42, 'formulier_volgende_knop_tekst', 'Volgende', 'nl', 0),
(43, 'werkplek_reserveren_plattegrond_foto_alt_tekst', 'Plattegrond', 'nl', 0),
(44, 'formulier_datum', 'Datum', 'nl', 0),
(45, 'formulier_dagdeel', 'Dagdeel', 'nl', 0),
(46, 'formulier_vorige_knop_tekst', 'Vorige', 'nl', 0),
(47, 'formulier_werkplek', 'Werkplek', 'nl', 0),
(48, 'formulier_reserveren_knop_tekst', 'Reserveren &amp;gt;', 'nl', 0),
(49, 'formulier_tijdstip', 'Tijd', 'nl', 0),
(50, 'formulier_duur', 'Duur', 'nl', 0),
(51, 'formulier_duur_optie_half_uur', 'Half uur', 'nl', 0),
(52, 'formulier_duur_optie_uur', '1 uur', 'nl', 0),
(53, 'formulier_duur_optie_anderhalf_uur', 'Anderhalf uur', 'nl', 0),
(54, 'formulier_duur_optie_2_uur', '2 uur', 'nl', 0),
(55, 'meet_the_expert_aanmeldingen_beheren', 'Meet the Expert aanmeldingen beheren', 'nl', 0),
(56, 'werkplek_reserveringen_beheren', 'Werkplek reserveringen beheren', 'nl', 0),
(57, 'vergaderruimte_reserveringen_beheren', 'Vergaderruimte reserveringen beheren', 'nl', 0),
(58, 'menu_item_bedrijf', 'Bedrijf', 'nl', 0),
(59, 'menu_item_student', 'Student', 'nl', 0),
(60, 'menu_item_meet_the_expert', 'Meet the Expert', 'nl', 0),
(61, 'menu_item_projecten', 'Projecten', 'nl', 0),
(62, 'menu_item_werkwijze', 'Werkwijze', 'nl', 0),
(63, 'menu_item_contact', 'Contact', 'nl', 0),
(64, 'menu_item_werkplek_reserveren', 'Werkplek reserveren', 'nl', 0),
(65, 'menu_item_aanmeldingen_en_reserveringen_beheren', 'Aanmeldingen en reserveringen beheren', 'nl', 0),
(66, 'menu_item_meet_the_experts_beheren', 'Meet the Expert sessies beheren', 'nl', 0),
(67, 'menu_item_meet_the_expert_aanmeldingen_beheren', 'Meet the Expert aanmeldingen beheren', 'nl', 0),
(68, 'menu_item_werkplek_reserveringen_beheren', 'Werkplek reserveringen', 'nl', 0),
(69, 'menu_item_vergaderruimte_reserveringen_beheren', 'Vergaderruimte reserveringen', 'nl', 0),
(70, 'menu_item_aanmelden_voor_meet_the_expert', 'Aanmelden voor Meet the Expert', 'nl', 0),
(71, 'formulier_verzenden', 'Verzenden', 'nl', 0),
(72, 'meet_the_expert_aanmelden_titel', 'Aanmelden', 'nl', 0),
(73, 'meet_the_expert_aanmelden_tekst_voor_sessie_titel', 'Aanmelden voor', 'nl', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `workspace`
--

CREATE TABLE `workspace` (
  `workspace_ID` int(11) NOT NULL,
  `workspace_slug_ID` int(11) NOT NULL,
  `workspace_name` varchar(255) NOT NULL,
  `workspace_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `workspace`
--

INSERT INTO `workspace` (`workspace_ID`, `workspace_slug_ID`, `workspace_name`, `workspace_is_deleted`) VALUES
(1, 9, 'Werkplek 1', 0),
(2, 9, 'Werkplek 2', 0),
(3, 9, 'Werkplek 3', 0),
(4, 10, 'De gele bak', 0),
(7, 9, 'Werkplek 5', 0),
(8, 9, 'Werkplek 4', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `workspace_reservation`
--

CREATE TABLE `workspace_reservation` (
  `workspace_reservation_ID` int(11) NOT NULL,
  `workspace_reservation_user_ID` int(11) NOT NULL,
  `workspace_reservation_workspace_ID` int(11) NOT NULL,
  `workspace_reservation_start_datetime` datetime NOT NULL,
  `workspace_reservation_end_datetime` datetime NOT NULL,
  `workspace_reservation_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `workspace_reservation_is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `workspace_reservation`
--

INSERT INTO `workspace_reservation` (`workspace_reservation_ID`, `workspace_reservation_user_ID`, `workspace_reservation_workspace_ID`, `workspace_reservation_start_datetime`, `workspace_reservation_end_datetime`, `workspace_reservation_accepted`, `workspace_reservation_is_deleted`) VALUES
(1, 1, 4, '2019-06-19 12:00:00', '2019-06-19 12:30:00', 1, 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`account_ID`);

--
-- Indexen voor tabel `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_ID`),
  ADD KEY `contact_branch_ID` (`contact_branch_ID`),
  ADD KEY `contact_landscape_ID` (`contact_landscape_ID`) USING BTREE;

--
-- Indexen voor tabel `entity`
--
ALTER TABLE `entity`
  ADD PRIMARY KEY (`entity_ID`),
  ADD KEY `entity_slug_ID` (`entity_slug_ID`);

--
-- Indexen voor tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_ID`),
  ADD KEY `event_thumbnail_ID` (`event_thumbnail_ID`),
  ADD KEY `event_banner_ID` (`event_banner_ID`);

--
-- Indexen voor tabel `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`file_ID`);

--
-- Indexen voor tabel `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`page_ID`),
  ADD KEY `page_slug_ID` (`page_slug_ID`);

--
-- Indexen voor tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_ID`),
  ADD KEY `project_thumbnail_ID` (`project_thumbnail_ID`),
  ADD KEY `project_banner_ID` (`project_banner_ID`),
  ADD KEY `project_header_ID` (`project_header_ID`);

--
-- Indexen voor tabel `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`setting_ID`);

--
-- Indexen voor tabel `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`signUp_ID`),
  ADD KEY `signUp_user_ID` (`signUp_user_ID`),
  ADD KEY `signUp_event_ID` (`signUp_event_ID`);

--
-- Indexen voor tabel `slug`
--
ALTER TABLE `slug`
  ADD PRIMARY KEY (`slug_ID`);

--
-- Indexen voor tabel `translation`
--
ALTER TABLE `translation`
  ADD PRIMARY KEY (`translation_ID`);

--
-- Indexen voor tabel `workspace`
--
ALTER TABLE `workspace`
  ADD PRIMARY KEY (`workspace_ID`),
  ADD KEY `workspace_slug_ID` (`workspace_slug_ID`);

--
-- Indexen voor tabel `workspace_reservation`
--
ALTER TABLE `workspace_reservation`
  ADD PRIMARY KEY (`workspace_reservation_ID`),
  ADD KEY `workspace_reservation_user_ID` (`workspace_reservation_user_ID`),
  ADD KEY `workspace_reservation_workspace_ID` (`workspace_reservation_workspace_ID`) USING BTREE;

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `account`
--
ALTER TABLE `account`
  MODIFY `account_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT voor een tabel `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT voor een tabel `entity`
--
ALTER TABLE `entity`
  MODIFY `entity_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT voor een tabel `event`
--
ALTER TABLE `event`
  MODIFY `event_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT voor een tabel `file`
--
ALTER TABLE `file`
  MODIFY `file_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT voor een tabel `page`
--
ALTER TABLE `page`
  MODIFY `page_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT voor een tabel `project`
--
ALTER TABLE `project`
  MODIFY `project_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT voor een tabel `setting`
--
ALTER TABLE `setting`
  MODIFY `setting_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT voor een tabel `signup`
--
ALTER TABLE `signup`
  MODIFY `signUp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `slug`
--
ALTER TABLE `slug`
  MODIFY `slug_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT voor een tabel `translation`
--
ALTER TABLE `translation`
  MODIFY `translation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT voor een tabel `workspace`
--
ALTER TABLE `workspace`
  MODIFY `workspace_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT voor een tabel `workspace_reservation`
--
ALTER TABLE `workspace_reservation`
  MODIFY `workspace_reservation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`contact_branch_ID`) REFERENCES `entity` (`entity_ID`),
  ADD CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`contact_landscape_ID`) REFERENCES `entity` (`entity_ID`);

--
-- Beperkingen voor tabel `entity`
--
ALTER TABLE `entity`
  ADD CONSTRAINT `entity_ibfk_1` FOREIGN KEY (`entity_slug_ID`) REFERENCES `slug` (`slug_ID`);

--
-- Beperkingen voor tabel `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`event_thumbnail_ID`) REFERENCES `file` (`file_ID`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`event_banner_ID`) REFERENCES `file` (`file_ID`);

--
-- Beperkingen voor tabel `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`page_slug_ID`) REFERENCES `slug` (`slug_ID`);

--
-- Beperkingen voor tabel `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`project_thumbnail_ID`) REFERENCES `file` (`file_ID`),
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`project_banner_ID`) REFERENCES `file` (`file_ID`),
  ADD CONSTRAINT `project_ibfk_3` FOREIGN KEY (`project_header_ID`) REFERENCES `file` (`file_ID`);

--
-- Beperkingen voor tabel `signup`
--
ALTER TABLE `signup`
  ADD CONSTRAINT `signup_ibfk_1` FOREIGN KEY (`signUp_user_ID`) REFERENCES `account` (`account_ID`),
  ADD CONSTRAINT `signup_ibfk_2` FOREIGN KEY (`signUp_event_ID`) REFERENCES `event` (`event_ID`);

--
-- Beperkingen voor tabel `workspace`
--
ALTER TABLE `workspace`
  ADD CONSTRAINT `workspace_ibfk_1` FOREIGN KEY (`workspace_slug_ID`) REFERENCES `slug` (`slug_ID`);

--
-- Beperkingen voor tabel `workspace_reservation`
--
ALTER TABLE `workspace_reservation`
  ADD CONSTRAINT `workspace_reservation_ibfk_1` FOREIGN KEY (`workspace_reservation_user_ID`) REFERENCES `account` (`account_ID`),
  ADD CONSTRAINT `workspace_reservation_ibfk_2` FOREIGN KEY (`workspace_reservation_workspace_ID`) REFERENCES `workspace` (`workspace_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
