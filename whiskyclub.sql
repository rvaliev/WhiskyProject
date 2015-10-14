-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 15 jul 2015 om 12:29
-- Serverversie: 5.6.21
-- PHP-versie: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `whiskyclub`
--
CREATE DATABASE IF NOT EXISTS `whiskyclub` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `whiskyclub`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `barrels`
--

CREATE TABLE IF NOT EXISTS `barrels` (
`id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `barrels`
--

INSERT INTO `barrels` (`id`, `type`) VALUES
(1, 'unknown'),
(2, 'American Oak'),
(3, 'European Oak'),
(9, 'Regular'),
(10, 'Wood'),
(11, 'Sherry');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`id` int(11) NOT NULL,
  `whisky_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `comments`
--

INSERT INTO `comments` (`id`, `whisky_id`, `user_id`, `comment`, `time`, `date`) VALUES
(1, 1, 1, 'Whisky!!!!! :D', '08:15:00', '2015-07-01'),
(2, 1, 13, 'This whisky looks like piss!', '08:10:30', '2015-07-02'),
(3, 1, 4, 'Great whisky! A++ Would recommend.', '18:48:33', '2015-07-02'),
(4, 2, 4, 'Ik moet eerlijk toegeven dat dit veel beter is rioolwater.', '10:46:00', '2015-07-02'),
(5, 2, 2, 'Beter dan dit kan werkelijk niet!', '10:49:00', '2015-07-02'),
(7, 6, 1, 'Ga van mijn website af aub', '10:50:55', '2015-07-02'),
(8, 9, 10, 'Ik kan deze whisky niet genoeg aanraden. Dagelijks drink ik meerdere flessen.', '12:25:12', '2015-07-02'),
(9, 9, 11, 'Erg gezond.', '12:27:12', '2015-07-02'),
(10, 1, 16, 'Do you see any Teletubbies in here? Do you see a slender plastic tag clipped to my shirt with my name printed on it? Do you see a little Asian child with a blank expression on his face sitting outside on a mechanical helicopter that shakes when you put quarters in it? No? Well, that''s what you see at a toy store. And you must think you''re in a toy store, because you''re here shopping for an infant named Jeb.', '11:48:43', '2015-07-06'),
(59, 1, 1, '<p>gfdhfgdh fgdhdfghdfgg gfdhfd</p>', '15:43:56', '2015-07-10'),
(63, 1, 1, '<p>xcvb bvc bvccvb</p>', '15:47:48', '2015-07-10'),
(64, 1, 1, '<p>xcvb bvc bvccvb</p>', '15:49:17', '2015-07-10'),
(68, 1, 1, '<p>ggsfsfdfgsdfgddgsfsdfsd</p>', '15:51:37', '2015-07-10');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `distilleries`
--

CREATE TABLE IF NOT EXISTS `distilleries` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL DEFAULT '- no region -'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `distilleries`
--

INSERT INTO `distilleries` (`id`, `name`, `address`, `city`, `country`, `region`) VALUES
(1, 'Caol Ila', 'Caol Ila', 'Port Askaig', 'Scotland', 'Islay'),
(2, 'Bowmore', 'School street', 'Bowmore', 'Scotland', 'Islay'),
(3, 'Buffalo Trace', 'Great Buffalo Trace 113', 'Frankfort', 'United States', 'Kentucky'),
(4, 'Yamazaki', 'Mishima-gun, Shimamoto-cho 618-0001', 'Osaka', 'Japan', 'no region'),
(5, 'Kilbeggan', 'Lower Main St.', 'Westmeath', 'Ireland', 'no region'),
(6, 'Aberfeldy', 'Aberfeldy, Perth and Kinross', 'Aberfeldy', 'Scotland', 'Central Highlands'),
(7, 'Bushmills', ' 2 Distillery Rd', 'Bushmills', 'Northern Ireland', 'no region'),
(9, 'Laphroaig', 'Isle of Islay PA42 7DU', 'Port Ellen', 'Scotland', 'Islay'),
(10, 'Glenfiddich', '40 Church St', 'Dufftown', 'Scotland', 'Speyside'),
(11, 'Glenfarclas', 'Glenfarclas Distillery, Ballindalloch', 'Ballindalloch, Scotland', 'Scotland', 'Speyside');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  `image_path` varchar(255) NOT NULL DEFAULT 'default.jpg',
  `registration_date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `admin`, `blocked`, `image_path`, `registration_date`) VALUES
(1, 'admin', '$2y$10$NB9dAAtQJ6OZx68TSucGJ.MRfqG9ueVkH220lK1O/zRWaFn5i4Txq', 'admin@mail.com', 'John', 'Smith', 1, 0, '55a61ebf814294.19636467.gif', '2015-07-13'),
(2, 'user', '$2y$10$CGSgFgDLOJXoEHEy9TuG0uKOXYv4q6ZLqJcpwFz5hpL8qS0yaO.vS', 'user@mail.com', 'Peter', 'Jackson', 0, 0, 'default.jpg', '2015-07-22'),
(4, 'tommy', '$2y$10$oREiVM3Of3hI4fI/wcKQbuQCjvGzzDlHaaEQoQbZvbWo8ZK/9NWCS', 'cruise@tom.com', 'Tom', 'Cruise', 0, 0, 'default.jpg', '2015-07-01'),
(6, 'leo', '$2y$10$lCUF890JwdRtSt7xzb1Po.wshfEXxnL2lFIw9FbnVJWGUqyL7Wl26', 'leo@mail.com', 'Leo', 'Tolstoy', 0, 0, 'default.jpg', '2015-07-02'),
(7, 'twain', '$2y$10$JnL0wwkJ8T1dSL186s.kF.z7tFKwoW67weKbIvWQk3o/HTAQSup.e', 'twain@mail.com', 'Mark', 'Twain', 0, 0, 'default.jpg', '2015-07-02'),
(8, 'kipling', '$2y$10$GuQXOWbkLNyUEHt9c/cGlepJFUSljd.BXebtSdwoZb9h4s8Ion2Ly', 'kipling@mail.com', 'Rudyard', 'Kipling', 0, 0, 'default.jpg', '2015-07-02'),
(9, 'jobs', '$2y$10$iNtTi9JVh4hrYglLJo.pwOxqk0Nr7u2G9zG1Cx3aswvhjLmqKh1b2', 'jobs@mail.com', 'Steve', 'Jobs', 0, 0, 'default.jpg', '2015-07-02'),
(10, 'gates', '$2y$10$TDWgbTPGKvrbKlD3f5FxNOsGqyVL6bg2LagFSN3UjIxBJ/pVbbQ1e', 'gates@mail.com', 'Bill', 'Gates', 0, 0, 'default.jpg', '2015-07-02'),
(11, 'ghandi', '$2y$10$ch3DAYNLzBJmqnu3FgoRQerZrtKFsbEEm1.1wT8G0Jgd2cKIgXVCu', 'ghandi@mail.com', 'Mahatma', 'Ghandi', 0, 0, 'default.jpg', '2015-07-02'),
(12, 'smith', '$2y$10$JeuNzvpM5YGVkmR7PiZ3zOTRJi1KsmlAJi9lf6i3jhPTGz.DgOrDC', 'smith@mail.com', 'Will', 'Smith', 0, 0, 'default.jpg', '2015-07-02'),
(13, 'roger', '$2y$10$V6bDyFykDF40p.giY3MzVOb4nt9A2kEdtt2vjCuLNAlhO.od30HU.', 'roger@mail.com', 'Roger Antonio', 'Vandekerckhove', 1, 0, '559f6a9aa21260.83383843.gif', '2015-07-02'),
(14, 'cruise', '$2y$10$YgDG/yEueGwxlaiQgNGWyOcmLhhlorgw8H6IWXhdmKsMaW9vJkCnC', 'cruise@mail.com', 'Tom', 'Cruise', 0, 0, 'default.jpg', '2015-07-04'),
(16, 'Tom', '$2y$10$.a4i2spBMtdDfB1fIyfB2.u8vJF0jR4YR5JJkZOIhPNa7jfrNf6PO', 'tom@dftba.eu', 'Tom', 'Vanderheijden', 1, 0, '55a633f5acb5f5.07567515.png', '2015-07-06'),
(17, 'Username', '$2y$10$B/5XFyc4mnAEwY97BQPdfOCS5zzzn3nKNxGd7olNwbHKjK2JIFSnK', 'mail@mail.com', 'Firstname', 'Lastname', 0, 0, 'default.jpg', '2015-07-06'),
(19, 'Tonio', '$2y$10$C0cw6Wi57Jolz.UmnNTGG..h1AX.mSkbe4AIdUsemvf9OWoRXNCpe', 'email@voorbeeld.com', 'toni', 'verheyen', 0, 0, 'default.jpg', '2015-07-06'),
(22, 'brent3', '$2y$10$7dfgTeqrM5Wka2dJDxNwo.0L967UT/dvL7FlV/uPn3K6yy46RGTXW', 'brent3@mail.com', 'Brent', 'Keersmaekers', 1, 0, '55a391a30d40c9.07794315.jpg', '2015-07-10'),
(34, 'superman', '$2y$10$9jK/eD7TNKvawkhEJkKL5e/mnFYR75eJ/CZHDKdDZIAnRFJeFpzmC', 'superman@mail.com', 'Super', 'Man', 1, 0, 'default.jpg', '2015-07-13'),
(37, 'Tom2', '$2y$10$qFbjlq4X8AXymQ.fn.QHf.XacPFL9Df2VgMcWAYosbYEUSpqpQyNe', 'tom@mail.com', 'Tom', 'Vanderheijden', 0, 0, 'default.jpg', '2015-07-15'),
(38, 'jayjizzleain', '$2y$10$UvvxiEyA/MLe4BOyJGfzn./Gfia.Lj1teYoCFLv9o/XgLvJD5tehq', 'jan.janssens@telenet.be', 'Jan', 'Janssens', 0, 0, 'default.jpg', '2015-07-15'),
(39, 'jayjizzleain45', '$2y$10$7GFUxIciZEqRL7Xo0ZeXVO./d4IuZBFmRZuFdxOwJiAVqZskG7U1a', 'jan.janssens@teleyunet.be', 'Jan', 'Janssens', 0, 0, 'default.jpg', '2015-07-15'),
(40, 'jayjizzleain45f', '$2y$10$lNl/etyuRPTj/f6XRi9qB.87qHkZm1wCm3fXx/MNraki9RdNAs14q', 'jan.janssens@teleyufdsjnet.be', 'Jan', 'Janssens', 0, 1, 'default.jpg', '2015-07-15');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `whiskies`
--

CREATE TABLE IF NOT EXISTS `whiskies` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `distillery_id` int(11) NOT NULL,
  `price` decimal(11,2) NOT NULL,
  `age` int(11) NOT NULL,
  `strength` int(11) NOT NULL,
  `barrel_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `creation_date` date NOT NULL,
  `rating_aroma` int(11) NOT NULL,
  `rating_color` int(11) NOT NULL,
  `rating_taste` int(11) NOT NULL,
  `rating_aftertaste` int(11) NOT NULL,
  `text_aroma` longtext NOT NULL,
  `text_color` longtext NOT NULL,
  `text_taste` longtext NOT NULL,
  `text_aftertaste` longtext NOT NULL,
  `review` longtext NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `whiskies`
--

INSERT INTO `whiskies` (`id`, `name`, `distillery_id`, `price`, `age`, `strength`, `barrel_id`, `image_path`, `hidden`, `creation_date`, `rating_aroma`, `rating_color`, `rating_taste`, `rating_aftertaste`, `text_aroma`, `text_color`, `text_taste`, `text_aftertaste`, `review`, `user_id`) VALUES
(1, 'Caol Ila 12', 1, '32.00', 12, 43, 2, 'caol_ila_12.jpg', 0, '2015-06-30', 18, 17, 18, 18, '<p>Subdued, citric fruitiness; a whiff of bath oil and dentist&#39;s mouthwash. A fresh and appetising nose, with little or no trace of smoke.</p>', '<p>Gold with amber appearance.</p>', '<p>Smooth, pleasant mouth-feel; with water light acidity, some salt and still the sweeter notes.</p>', '<p>Sweet smokiness in the lingering, slightly sour finish.</p>', '<p>An excellent whisky! Delicious!</p>', 1),
(2, 'Caol Ila 14', 1, '72.00', 14, 59, 2, 'caol_ila_14.jpg', 0, '2015-06-30', 16, 16, 18, 17, '<p>Wonderfully concentrated pure, clean Caol Ila ? peaty and medicinal, with rich fruit, spicy and fragrant. With water, the fragrant smokiness comes singing through.</p>', '<p>Clear gold</p>', '<p>Sweetness and maltiness strike first, then are quickly overwhelmed by peat smoke and intense, clean, crisp flavours. Caol Ila?s signature smoky bonfires are here, and build to quite a size.</p>', '<p>Long, rounded, robust and multi-layered.</p>', '<p>A superb,&nbsp;richly flavoured single malt.</p>', 1),
(4, 'Caol Ila 1968 Sa', 1, '1936.00', 14, 57, 2, 'caol_ila_1968.jpg', 0, '2015-06-30', 15, 15, 16, 16, '<p>Big buttery oily peat with lots of white pepper, graphite and an underlying warm caramel sweetness. Motor oil, seashells and some grassy notes can be found as well. The sherry notes are light but become more pronounced as your nose gets accustomed to the stronger spicy peat.</p>', '<p>Amber</p>', '<p>Big buttery oily peat with lots of white pepper, graphite and an underlying warm caramel sweetness. Motor oil, seashells and some grassy notes can be found as well. The sherry notes are light but become more pronounced as your nose gets accustomed to the stronger spicy peat.</p>', '<p>Dark and bittersweet. Black licorice and coffee grinds.</p>', '<p>Great whisky! Excellent to show people just how much money you have to waste!</p>', 1),
(5, 'Bowmore 8', 2, '103.00', 8, 40, 11, 'bowmore_8.jpg', 0, '2015-06-30', 15, 16, 15, 14, '<p>Delicious dark chocolate, sun-dried fruits and a tell-tale wisp of Islay smoke.</p>', '<p>Treacle dark amber.</p>', '<p>Wonderful cedar wood and rich treacle toffee.</p>', '<p>The robust and complex finish with a hint of sherry tannin.</p>', '<p>Delicious!</p>', 1),
(6, 'Bowmore 100 Degrees Proof', 2, '50.00', 8, 57, 1, 'bowmore_100_degrees_proof.jpg', 0, '2015-06-30', 14, 16, 17, 15, '<p>Classic Bowmore smokiness, perfectly tempered with creamy caramel, chocolate and ripe fruit aromas. Yeahh</p>', '<p>Yellow mahogany</p>', '<p>Old overholt american rye william lawson&rsquo;s blenders balvenie greenore clontarf. Old smuggler balvenie monarch old times. Old virginia clontarf white horse michael collins logan&#39;s bells. Old virginia the tyrconnell black and white royal salute hundred cask Clontarf Single Malt.</p>', '<p>Beautiful soft fruit and chocolate balanced with a light smokiness - incredibly complex.</p>', '<p>The long and wonderfully balanced finish</p>', 1),
(7, 'Bowmore 12', 2, '110.00', 12, 43, 1, 'bowmore_12.jpg', 0, '2015-06-30', 15, 17, 16, 14, '<p>Subtle lemon and honey, balanced beautifully by Bowmore&#39;s trademark peaty smokiness.</p>', '<p>Warm amber</p>', '<p>Sweet and delicious heather honey and gentle peat smoke</p>', '<p>he long, mellow.</p>', '<p>Exquisite!</p>', 1),
(8, 'Blanton''s Gold Edition', 3, '67.00', 1, 51, 1, 'blantons_gold_edition.jpg', 0, '2015-07-01', 16, 16, 15, 15, 'Old overholt american rye william lawson’s blenders balvenie greenore clontarf.  Old smuggler balvenie monarch old times.  Old virginia clontarf white horse michael collins logan''s bells.  Old virginia the tyrconnell black and white royal salute hundred cask Clontarf Single Malt.', 'Uhm.Bells highland park jameson rarest vintage sandy mac tullamore dew monarch.  Clontarf Single Malt dunbar teacher’s catto''s royal salute hundred cask midleton.  Whyte & mackay old parr blenders feckin.  Mac pay old virginia the irishman the original clan greenore dalmore swing.  Balvenie cutty sark old parr bells old virginia.  The tyrconnell white horse jack daniels pinwinnie old times dunbar.', 'Highland park bagpiper dunhill old virginia power and son.  The macallan label 5 famous grouse of ye monks.  Jameson rarest vintage dailuaine merry''s the tyrconnell white horse vat 69.  Sir edward''s greenore finian''s Clontarf Single Malt old times.  Tullamore dew vat 69 bells william lawson’s old overholt american rye.  Sir edward''s john dewar''s catto''s feckin gentleman jack.', 'William lawson’s feckin swing golden king tullamore dew.  Ballantines glenfiddich old overholt american rye hankey bannister mac arthur''s mcDowell''s no.1.  Dimple pinch of ye monks black bush william lawson’s.  Laphroaig dimple pinch criadores sir edward''s john barr royal salute hundred cask.  Old times golden king clontarf black bush.  Swing black and white jameson jim beam black highland park.', 'Red breast laphroaig johnnie walker the irishman the original clan.  Dunbar original choice logan''s power and son balvenie.  Dunbar feckin glenfiddich tullamore dew 100 pipers.  Catto''s knockando dimple pinch feckin johnnie walker.  Greenore merry''s old pulteney malta tullamore dew blenders.', 1),
(9, 'Aberfeldy 12y', 6, '46.80', 12, 47, 1, 'aberfeldy_12.jpg', 1, '2015-07-01', 18, 17, 16, 17, 'Swing the tyrconnell clontarf vat 69.  Teacher’s ballantines hankey bannister old tavern.  Famous grouse dunbar logan''s clontarf hankey bannister officer''s choice.  Black bush tullamore dew old tavern 100 pipers.', 'Finian''s highland park swing old tavern dalmore dewar''s.  Mac pay feckin merry''s river queen.  Dunbar grand macnish john barr label 5.  Of ye monks balvenie label 5 jameson rarest vintage.  Sandy mac dunhill hankey bannister whyte and mackay the macallan.\r\n', 'Logan''s glenfiddich isle of jura kilbeggan whyte & mackay.  Teacher’s golden king isle of jura john barr dimple pinch tullamore dew.  J&b dalmore john barr gregson’s.  The irishman the original clan dailuaine the macallan old times.  Old virginia famous grouse royal stag black bush rob roy.', 'Isle of jura criadores dunbar finian''s.  Johnnie walker rob roy the macallan the tyrconnell.  McDowell''s no.1 hankey bannister merry''s evan william''s johnnie walker.  Something special bagpiper laphroaig hankey bannister.\r\n', 'Finian''s old virginia gregson’s john barr old overholt american rye.  Sandy mac vat 69 finian''s jack daniels mcDowell''s no.1 hankey bannister.  Dunhill gentleman jack tillers whyte & mackay sir edward''s.  Dailuaine dunhill chivas regal grant''s.  Greenore criadores bells merry''s famous grouse.', 1),
(10, 'Aberfeldy 21y', 6, '86.20', 21, 40, 1, 'aberfeldy_21.jpg', 0, '2015-07-01', 15, 14, 15, 13, 'Jameson mac pay hankey bannister laphroaig ballantines.  Ballantines old virginia the tyrconnell of ye monks evan william''s mac arthur''s.  Whyte and mackay j&b swing chivas regal.  Knockando gentleman jack dailuaine the irishman the original clan.  Knockando greenore teacher’s the tyrconnell.  Grant''s tillers dunhill bells royal stag old overholt american rye.\r\n\r\n', 'Highland park william lawson’s dunhill tillers gregson’s.  Highland park jameson rarest vintage grand macnish grant''s dalmore hankey bannister.  Midleton monarch old overholt american rye mac arthur''s old virginia royal salute hundred cask.  Officer''s choice old times teacher’s william lawson’s pinwinnie j&b.  Michael collins pinwinnie river queen balvenie.  Whyte and mackay dimple pinch greenore jim beam black.\r\n', '\r\nWhyte and mackay power and son bells original choice.  Dimple pinch something special Clontarf Single Malt bagpiper.  Glenfiddich jim beam black black and white finian''s label 5 kilbeggan.  Monarch buchanans officer''s choice dailuaine criadores.\r\n', '\r\nClontarf gentleman jack greenore buchanans highland park old virginia.  Finian''s isle of jura golden king kilbeggan whyte and mackay.  Tullamore dew logan''s gentleman jack jameson Clontarf Single Malt william lawson’s.  John dewar''s jameson grant''s grand macnish gregson’s finian''s.  Hankey bannister red breast j&b old virginia john barr dalmore.\r\n\r\n', 'Kilbeggan the tyrconnell chivas regal highland park.  Royal salute hundred cask something special knockando golden king.  Red breast power and son old virginia john barr mac arthur''s logan''s.  Jack daniels william lawson’s laphroaig finian''s kilbeggan grant''s.  Knockando midleton whyte and mackay evan william''s something special.  Cutty sark royal stag bells bagpiper john barr.', 1),
(11, 'Bushmills 16y', 7, '53.70', 16, 40, 1, 'bushmills_16.jpg', 0, '2015-07-01', 16, 17, 18, 19, 'Clontarf Single Malt dalmore bells red breast william lawson’s.  Red breast knockando 100 pipers laphroaig.  Buchanans monarch river queen dalmore dewar''s.  Catto''s balvenie dalmore whyte & mackay.  The tyrconnell john dewar''s jameson rarest vintage label 5 vat 69.\r\n', 'Royal stag laphroaig jack daniels 100 pipers white horse.  Buchanans bells old smuggler grant''s mac arthur''s.  Johnnie walker gentleman jack whyte & mackay highland park.  Tullamore dew monarch clontarf buchanans logan''s dewar''s.  White horse swing rob roy sir edward''s the tyrconnell.  Merry''s evan william''s clontarf river queen.\r\n', 'Chivas regal vat 69 the irishman the original clan old smuggler rob roy burrberrys.  Red breast hankey bannister swing tullamore dew.  Black and white mac pay rob roy finian''s john dewar''s.  Original choice michael collins catto''s 100 pipers dailuaine hankey bannister.  Old smuggler vat 69 jameson whyte & mackay old virginia bells.', 'Old tavern finian''s gregson’s golden king kilbeggan.  Mac pay royal stag chivas regal mac arthur''s laphroaig.  Criadores 100 pipers original choice dalmore burrberrys old times.  Burrberrys bells ballantines original choice mcDowell''s no.1 glenfiddich.', 'William lawson’s label 5 famous grouse jameson knockando.  Bagpiper mcDowell''s no.1 power and son tillers.  Chivas regal bells something special gentleman jack.  Old pulteney malta catto''s famous grouse john dewar''s royal salute hundred cask sandy mac.  Vat 69 dunbar something special rob roy.  Royal salute hundred cask old tavern original choice red breast.', 1),
(12, 'Bowmore 25y', 2, '597.00', 25, 43, 1, 'bowmore_25.jpg', 0, '2015-07-01', 16, 16, 16, 16, 'William lawson’s label 5 famous grouse jameson knockando.  Bagpiper mcDowell''s no.1 power and son tillers.  Chivas regal bells something special gentleman jack.  Old pulteney malta catto''s famous grouse john dewar''s royal salute hundred cask sandy mac.  Vat 69 dunbar something special rob roy.  Royal salute hundred cask old tavern original choice red breast.', 'William lawson’s label 5 famous grouse jameson knockando.  Bagpiper mcDowell''s no.1 power and son tillers.  Chivas regal bells something special gentleman jack.  Old pulteney malta catto''s famous grouse john dewar''s royal salute hundred cask sandy mac.  Vat 69 dunbar something special rob roy.  Royal salute hundred cask old tavern original choice red breast.', 'William lawson’s label 5 famous grouse jameson knockando.  Bagpiper mcDowell''s no.1 power and son tillers.  Chivas regal bells something special gentleman jack.  Old pulteney malta catto''s famous grouse john dewar''s royal salute hundred cask sandy mac.  Vat 69 dunbar something special rob roy.  Royal salute hundred cask old tavern original choice red breast.', 'William lawson’s label 5 famous grouse jameson knockando.  Bagpiper mcDowell''s no.1 power and son tillers.  Chivas regal bells something special gentleman jack.  Old pulteney malta catto''s famous grouse john dewar''s royal salute hundred cask sandy mac.  Vat 69 dunbar something special rob roy.  Royal salute hundred cask old tavern original choice red breast.', 'William lawson’s label 5 famous grouse jameson knockando.  Bagpiper mcDowell''s no.1 power and son tillers.  Chivas regal bells something special gentleman jack.  Old pulteney malta catto''s famous grouse john dewar''s royal salute hundred cask sandy mac.  Vat 69 dunbar something special rob roy.  Royal salute hundred cask old tavern original choice red breast.', 1),
(14, 'Yamazaki Single Malt', 4, '80.00', 12, 43, 1, 'yamazaki_12.jpg', 1, '2015-07-08', 16, 17, 15, 18, 'Lorem', 'Ipsum', 'Dolor', 'Sit', 'Amet', 1),
(16, 'Yamazaki Single Malt Sherry Cask', 4, '140.00', 12, 52, 11, 'yamazaki_15.jpg', 0, '2015-07-09', 14, 16, 16, 16, '<p>Raisin, dried fruit, dark chocolate</p>', '<p>Deep bronze</p>', '<p>Sweet &amp; Sour, heavy, pleasantly bitter with soft fruit notes.</p>', '<p>Lingering finish with hanging bitter chocolate and fruit notes.</p>', '<p>A very fine whisky indeed!</p>', 1),
(38, 'Laphroaig 1967 Sa', 9, '5390.00', 15, 57, 11, '55a611c3764da1.67812781.png', 0, '2015-07-15', 18, 18, 17, 17, '<p>Bang bang! It&rsquo;s this perfect kind of match between peat and oloroso indeed, you know, that third dimension of whisky that&rsquo;s so miraculous when it works. Now, you have to like whisky that&rsquo;s extremely gamy and flinty, immensely earthy and tremendously leafy. The notes of bitter chocolate, old rancio, old walnuts and old leather are fantastic, and so are all the cigars, chips of cedar wood and dried mushrooms that were infused in this whisky. What, that&rsquo;s not how they did it? Enough said.</p>', '<p>Mahogany</p>', '<p>Plain and simple, please call the anti-maltoporn brigade right now. Seriously, it&rsquo;s no classic, explosive or &lsquo;very biggish&rsquo; sherry and peat monster such as, say the famous Caol Ila Manager&rsquo;s Dram or some old sherried Port Ellens by James MacArthur, or such as the more recent Lagavulin 21 (just to give you a few examples), and it&rsquo;s not even very complex, but the balance between the sherry and the peat is just perfect. It&rsquo;s no whisky, it&rsquo;s a tightrope walker.</p>', '<p>Dry as long as a day without bread as we say over here (or as a speech by Fidel Castro as they say over there) but certainly less boring. I love these notes of smoky blackcurrants in the aftertaste, as well as the Laphroaiggy signature: a few drops of cough syrup.</p>', '<p>This was most probably from a genuine sherry cask. I think all modern bourbonites should try this kind of make one day. Everything is perfect here. Imagine this at cask strength&hellip; oh my!</p>', 22),
(39, 'Kilbeggan 21', 5, '99.00', 21, 40, 11, 'kilbeggan_21.jpg', 0, '2015-07-15', 15, 16, 14, 16, '<p>hsqmlhjzalhj</p>', '<p>jqdklmfqjdklmfjmkl</p>', '<p>JFKQDLMJFKLMJK</p>', '<p>DFJKQLMFJDKLQM</p>', '<p>fldqjklfmjdlqfmjlk</p>', 16),
(40, 'Glenfiddich Janet Sheed Roberts', 10, '58888.00', 55, 44, 10, 'glenfiddich_jsr.jpg', 0, '2015-07-15', 19, 19, 18, 19, '<p>Finely balanced with substantial oakiness matched by fruit and luscious sherry notes.</p>', '<p>A nice amber</p>', '<p>Finely balanced with substantial oakiness matched by fruit and luscious sherry notes.</p>', '<p>Exceedingly long, honeyed and warm.</p>', '<p>Superb!</p>', 16);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `barrels`
--
ALTER TABLE `barrels`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`id`), ADD KEY `whisky_id` (`whisky_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexen voor tabel `distilleries`
--
ALTER TABLE `distilleries`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `whiskies`
--
ALTER TABLE `whiskies`
 ADD PRIMARY KEY (`id`), ADD KEY `distillery_id` (`distillery_id`), ADD KEY `barrel_id` (`barrel_id`), ADD KEY `user` (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `barrels`
--
ALTER TABLE `barrels`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT voor een tabel `distilleries`
--
ALTER TABLE `distilleries`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT voor een tabel `whiskies`
--
ALTER TABLE `whiskies`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `comments`
--
ALTER TABLE `comments`
ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `whisky_id` FOREIGN KEY (`whisky_id`) REFERENCES `whiskies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `whiskies`
--
ALTER TABLE `whiskies`
ADD CONSTRAINT `barrel_id` FOREIGN KEY (`barrel_id`) REFERENCES `barrels` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `distillery_id` FOREIGN KEY (`distillery_id`) REFERENCES `distilleries` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
