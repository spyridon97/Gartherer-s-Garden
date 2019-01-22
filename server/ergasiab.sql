-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Φιλοξενητής: 127.0.0.1
-- Χρόνος δημιουργίας: 22 Ιαν 2019 στις 20:51:01
-- Έκδοση διακομιστή: 10.1.37-MariaDB
-- Έκδοση PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `ergasiab`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `comments`
--

CREATE TABLE `comments` (
  `Id` int(11) NOT NULL,
  `Product_Id` int(11) NOT NULL,
  `Comment_Text` varchar(600) NOT NULL,
  `Stars` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `comments`
--

INSERT INTO `comments` (`Id`, `Product_Id`, `Comment_Text`, `Stars`, `Date`) VALUES
(1, 1, 'Ό,τι καλύτερο, το προτείνω ανεπιφύλακτα.', 5, '2019-01-05'),
(2, 1, 'Ό,τι χειρότερο, μείνετε μακριά!', 1, '2019-01-07'),
(3, 1, 'Δεν το πήρα, αλλά πόσο καλό μπορεί να είναι;', 3, '2019-01-14'),
(4, 4, 'Πολύ καλό!!1!1', 4, '2019-01-15'),
(5, 14, 'Περίμενα κάτι καλύτερο :(', 2, '2019-01-20'),
(6, 10, 'Κακή αναλογία απόδοσης-τιμής.', 1, '2019-01-20'),
(7, 20, 'Ναι', 5, '2019-01-20'),
(8, 18, 'Πολύ μέτριο. Ήρθε και σε ραγισμένο μπουκαλάκι.', 2, '2019-01-21'),
(9, 8, 'Πάρτε κάποιο από τα άλλα κόκκινα καλύτερα.', 3, '2019-01-23'),
(10, 16, 'Μου στείλανε λάθος μπουκάλι κι έπρεπε να παίρνω τηλέφωνα και να στέλνω μέιλ για κάτι που φταίνε οι ίδοι!!! Δεν ξαναπαίρνω τίποτα από εδώ.', 1, '2019-01-25');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `products`
--

CREATE TABLE `products` (
  `Id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Price` int(11) NOT NULL,
  `Image` varchar(200) NOT NULL,
  `Quote` varchar(600) NOT NULL,
  `Effect` varchar(600) NOT NULL,
  `Casting_Cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Άδειασμα δεδομένων του πίνακα `products`
--

INSERT INTO `products` (`Id`, `Name`, `Price`, `Image`, `Quote`, `Effect`, `Casting_Cost`) VALUES
(1, 'Enrage', 60, 'Enrage.png', 'Developed for use in today\'s uncertain environment, ENRAGE! will make your victim forget what side he\'s on, and attack anyone nearby. Just make sure \'anyone\' isn\'t you!', 'Instantly releases a globule that homes in and bursts on the nearest target within the player\'s central field of view.', 30),
(2, 'Insect Swarm', 80, 'Insect Swarm.png', 'Nothing clears a room like swarms of stinging hornets. (Warning: not recommended for users with allergies.)', 'Instantly releases a swarm of killer bees.', 48),
(3, 'Incinerate', 60, 'Incinerate.png', 'Incineration: when it absolutely positively has to erupt in flames, don\'t wait -- Incinerate!', 'Instantly ignites a targeted enemy or object.', 48),
(4, 'Sonic Boom', 40, 'Sonic Boom.png', 'When just yelling GET BACK isn\'t working, it\'s nice to have some repelling force to back up your request. Sonic Boom -- when push comes to shove.', 'Uses sound to instantly emit a strong burst of air.', 90),
(5, 'Cyclone Trap', 80, 'Cyclone Trap.png', 'Teach your enemies a lesson they\'ll never forget with Cyclone Trap from Ryan Industries. (Ryan Industries is not liable for damage done to ceiling fans, chandeliers, or other ceiling fixtures.)', 'Instantly creates a stationary, swirling trap of wind.', 95),
(6, 'Electro Bolt', 120, 'Electro Bolt.png', 'Don\'t be a dolt -- use Electro Bolt!', 'Instantly releases a bolt of electricity that strikes a target enemy or object.', 110),
(7, 'Security Bullseye', 30, 'Security Bullseye.png', 'Are those pesky security cameras getting you down? Simply tag your enemies with our photoelectric insects and those cameras and turrets become your best friend. Splice Security Bullseye today!', 'Instantly releases a globule that homes in and bursts on the nearest target within the player\'s central field of view.', 30),
(8, 'Target Dummy', 60, 'Target Dummy.png', 'Enemies on your back? Distract their attention with a helpful decoy. They take the heat… so you don\'t have to!', 'Instantly creates a single decoy target in a single location.', 48),
(9, 'Winter Blast', 60, 'Winter Blast.png', 'Don\'t get caught without this powerful self-defense tool at the ready. Give your foes the cold shoulder with Winter Blast!', 'Instantly freezes a target enemy or object.', 80),
(10, 'Alarm Expert', 20, 'Alarm Expert.png', 'A staple in the HackSmart line of gene tonics, Alarm Expert uses your body\'s electrochemical composition to defuse circuitry alarms in secure systems. Try it today!', 'Removes Alarm Tiles while the user is hacking.', 0),
(11, 'Armored Shell', 20, 'Armored Shell.png', 'Useful in any hazardous situation, Armored Shell offers fantastic protection against life\'s bumps and bruises. Don\'t be a softie -- use Armored Shell now!', 'Prevents 15% of piercing and bludgeoning damage.', 0),
(12, 'EVE Link', 20, 'EVE Link.png', 'Get more out of your First Aid Kits with EVE Link! This revolutionary new Gene Tonic causes your body to produce EVE whenever you use First Aid Kits.', 'First Aid Kits restore a small amount of EVE in addition to Health.', 0),
(13, 'EVE Saver', 1, 'EVE Saver.png', 'In today\'s genetic wonderland, you probably feel like there\'s never enough EVE at hand. With EVE Saver, your EVE will go farther than ever before!', 'Reduces the amount of EVE consumed by Plasmids by 15%.', 0),
(14, 'Extra Nutrition', 20, 'Extra Nutrition.png', 'Extra Nutrition boosts your body\'s natural ability to turn food into renewed vitality.', 'Consumables give a small amount of extra health when consumed.', 0),
(15, 'Focused Hacker', 20, 'Focused Hacker.png', 'Another favorite in the HackSmart line of Gene Tonics, Focused Hacker defuses overload traps in secure systems. Fewer fried circuits guaranteed or your money back!', 'Removes up to two Overload Tiles while the user is hacking.', 0),
(16, 'Frozen Field', 50, 'Frozen Field.png', 'Leave your foes out in the cold with Frozen Field!', 'Reduces cold damage received by 15%. Attacks by Wrench deal an extra 10 points of cold damage and have a 10% chance of freezing anyone struck.', 0),
(17, 'Clever Inventor', 50, 'Clever Inventor.png', 'U-Invent Stations truly are a marvel of modern engineering, and now you\'ll need fewer raw materials to make what you want. It\'s not witchcraft - it\'s Clever Inventor!', 'Reduces the requirement of each crafting component by one.', 0),
(18, 'Human Inferno', 20, 'Human Inferno.png', 'Human Inferno -- the hottest Gene Tonic in Rapture!', 'Reduces heat damage received by 20%, increases heat damage inflicted by 30% and causes burning enemies to take damage at a 30% higher rate.', 0),
(19, 'Security Evasion', 20, 'Security Evasion.png', 'Has a rival faction set up Security Cameras and Turrets where you need to go? Security Evasion adjusts the thermal signature of your epidermal layer, confusing cameras and turrets and delaying their response.', 'Security Cameras and Turrets take an extra two seconds to see the player.', 0),
(20, 'Security Expert', 20, 'Security Expert.png', 'A new offering in the HackSmart line, Security Expert was designed for the hacker specializing in disabling electronic security measures. You won\'t be secure without Security Expert!', 'Removes up to two Alarm Tiles, Overload Tiles, and one Acceleration Tile, and adds one Resistor Tile. In addition, the flow speed is reduced by a half second per tile.', 0),
(21, 'Wrench Jockey', 25, 'Wrench Jockey.png', 'Wrench Jockey bulks up your upper body, allowing you to wield club-like weapons with unprecedented skill and power!', 'Increases damage dealt by the Wrench by 350%', 0),
(22, 'Wrench Lurker', 25, 'Wrench Lurker.png', 'When fighting those stronger or faster than yourself, you\'ll need every advantage possible in a scrum. Wrench Lurker allows you to make the most of your opportunities when your antagonist is caught off guard.', 'Increases Wrench damage by 150% against unaware or shocked opponents and quiets the user\'s footsteps.', 0),
(23, 'Shorten Alarms', 10, 'Shorten Alarms.png', 'What sound is more ominous than a yammering security alarm? With Shorten Alarms spliced, your personal EM signature becomes altered to interact uniquely with alarm sensors, shortening the period until you\'ll be free and clear.', 'Reduces the length of hostile security alarms by twenty seconds.', 0),
(24, 'Electric Flesh', 30, 'Electric Flesh.png', 'Supercharge your body with Electric Flesh, the ultimate in electricity enhancements. Insulate yourself from harm with the new Electric Flesh!', 'Reduces electric damage received by 75% and increases outgoing electric damage by 30%.', 0),
(25, 'Medical Expert', 10, 'Medical Expert.png', 'With Medical Expert, your First Aid Kits will go farther, healing sickness and injury at a rate you\'re sure to find astonishing. Don\'t use a First Aid Kit without your best friend, Medical Expert!', 'First Aid Kits give an extra 20% Health when used.', 0);

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`);

--
-- Ευρετήρια για πίνακα `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT για πίνακα `products`
--
ALTER TABLE `products`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
